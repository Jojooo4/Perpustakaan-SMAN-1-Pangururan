<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{RequestPeminjaman, Peminjaman, AsetBuku, Buku, LogAktivitas};
use Illuminate\Http\Request;
use Carbon\Carbon;

class RequestPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = RequestPeminjaman::with(['user', 'buku']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $requests = $query->latest('tanggal_request')->paginate(15);
        $pendingCount = RequestPeminjaman::where('status', 'pending')->count();
        
        return view('admin.request_peminjaman', compact('requests', 'pendingCount'));
    }
    
    public function approve($id_request)
    {
        $request = RequestPeminjaman::with(['user', 'buku'])->findOrFail($id_request);
        
        // Validate request is still pending
        if ($request->status !== 'pending') {
            return back()->withErrors(['error' => 'Request sudah diproses!']);
        }
        
        // Check book stock availability
        $book = $request->buku;
        if ($book->stok_tersedia <= 0) {
            return back()->withErrors(['error' => 'Stok buku tidak tersedia!']);
        }
        
        // Get first available asset for this book
        $borrowedAsetIds = Peminjaman::where('status_peminjaman', 'Dipinjam')
            ->pluck('id_aset_buku')
            ->toArray();
        
        $availableAset = AsetBuku::where('id_buku', $book->id_buku)
            ->whereNotIn('id_aset', $borrowedAsetIds)
            ->first();
        
        if (!$availableAset) {
            return back()->withErrors(['error' => 'Tidak ada aset buku yang tersedia!']);
        }
        
        // Create peminjaman record
        $tanggalPinjam = now();
        $tanggalJatuhTempo = now()->addDays(7); // 7 days borrowing period
        
        Peminjaman::create([
            'id_user' => $request->id_user,
            'id_aset_buku' => $availableAset->id_aset,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
            'status_peminjaman' => 'Dipinjam',
            'denda' => 0
        ]);
        
        // Decrement book stock
        $book->decrement('stok_tersedia');
        
        // Update request status
        $request->update([
            'status' => 'disetujui',
            'diproses_oleh' => auth()->id(),
            'tanggal_diproses' => now()
        ]);
        
        // Log activity
        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'username' => auth()->user()->username ?? auth()->user()->nama,
            'nama_tabel' => 'request_peminjaman',
            'operasi' => 'update',
            'deskripsi' => "Approve request peminjaman #{$id_request} - User: {$request->user->nama}, Buku: {$book->judul}",
            'id_terkait' => $id_request
        ]);
        
        return redirect()->route('admin.request-peminjaman.index')
            ->with('success', "Request peminjaman dari {$request->user->nama} untuk buku '{$book->judul}' berhasil disetujui!");
    }
    
    public function reject(Request $request, $id_request)
    {
        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ]);
        
        $requestPeminjaman = RequestPeminjaman::with(['user', 'buku'])->findOrFail($id_request);
        
        // Validate request is still pending
        if ($requestPeminjaman->status !== 'pending') {
            return back()->withErrors(['error' => 'Request sudah diproses!']);
        }
        
        // Update request status
        $requestPeminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'],
            'diproses_oleh' => auth()->id(),
            'tanggal_diproses' => now()
        ]);
        
        // Log activity
        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'username' => auth()->user()->username ?? auth()->user()->nama,
            'nama_tabel' => 'request_peminjaman',
            'operasi' => 'update',
            'deskripsi' => "Reject request peminjaman #{$id_request} - User: {$requestPeminjaman->user->nama}, Alasan: {$validated['catatan_admin']}",
            'id_terkait' => $id_request
        ]);
        
        return redirect()->route('admin.request-peminjaman.index')
            ->with('success', "Request peminjaman dari {$requestPeminjaman->user->nama} berhasil ditolak.");
    }
}
