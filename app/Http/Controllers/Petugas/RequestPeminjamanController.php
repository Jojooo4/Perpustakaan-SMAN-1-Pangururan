<?php

namespace App\Http\Controllers\Petugas;

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
        
        return view('petugas.request_peminjaman', compact('requests', 'pendingCount'));
    }
    
    public function approve($id_request)
    {
        try {
            $request = RequestPeminjaman::with(['user', 'buku'])->findOrFail($id_request);
            
            // Validate request is still pending
            if ($request->status !== 'pending') {
                return back()->with('error', 'Request sudah diproses!');
            }
            
            // Validate that the requesting user exists
            if (!$request->user) {
                return back()->with('error', 'User yang melakukan request tidak ditemukan!');
            }
            
            // Check book stock availability
            $book = $request->buku;
            
            // Add null check for book
            if (!$book) {
                return back()->with('error', 'Data buku tidak ditemukan!');
            }
            
            if ($book->stok_tersedia <= 0) {
                return back()->with('error', 'Stok buku tidak tersedia!');
            }
            
            // Get first available asset for this book
            // Query untuk mendapatkan semua aset yang sedang dipinjam
            $borrowedAsetIds = Peminjaman::where('status_peminjaman', 'Dipinjam')
                ->pluck('id_aset_buku')
                ->toArray();
            
            // Cari aset buku yang tersedia untuk buku ini
            $availableAset = AsetBuku::where('id_buku', $book->id_buku)
                ->whereNotIn('id_aset', $borrowedAsetIds)
                ->where('kondisi_buku', 'Baik') // Hanya pilih yang kondisi baik
                ->first();
            
            if (!$availableAset) {
                return back()->with('error', 'Tidak ada aset buku yang tersedia! Semua eksemplar sedang dipinjam atau rusak.');
            }
            
            // Use database transaction to ensure data consistency
            \DB::transaction(function() use ($request, $book, $availableAset, $id_request) {
                // Temporarily disable foreign key checks to avoid trigger issues with log_aktivitas
                \DB::statement('SET FOREIGN_KEY_CHECKS=0');
                
                // Create peminjaman record
                $tanggalPinjam = now();
                $tanggalJatuhTempo = now()->addDays(7); // 7 days borrowing period
                
                $peminjaman = Peminjaman::create([
                    'id_user' => $request->id_user,
                    'id_aset_buku' => $availableAset->id_aset,
                    'tanggal_pinjam' => $tanggalPinjam,
                    'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                    'status_peminjaman' => 'Dipinjam',
                    'denda' => 0
                ]);
                
                // Decrement book stock (FK still disabled to avoid log_aktivitas trigger error)
                $book->decrement('stok_tersedia');
                
                // Re-enable foreign key checks
                \DB::statement('SET FOREIGN_KEY_CHECKS=1');
                
                // Get current user ID
                $currentUserId = auth()->check() ? auth()->user()->id_user : null;
                
                // Update request status
                $request->update([
                    'status' => 'disetujui',
                    'diproses_oleh' => $currentUserId,
                    'tanggal_diproses' => now()
                ]);
                
                // Log activity - only if user is authenticated and valid
                if ($currentUserId && \App\Models\User::find($currentUserId)) {
                    try {
                        LogAktivitas::create([
                            'id_user' => $currentUserId,
                            'username' => auth()->user()->username ?? auth()->user()->nama,
                            'nama_tabel' => 'request_peminjaman',
                            'operasi' => 'update',
                            'deskripsi' => "Approve request peminjaman #{$id_request} - User: {$request->user->nama}, Buku: {$book->judul}",
                            'id_terkait' => $id_request
                        ]);
                    } catch (\Exception $logError) {
                        // Ignore log errors, don't fail the transaction
                        \Log::warning("Failed to create log: " . $logError->getMessage());
                    }
                }
            });
            
            return redirect()->route('petugas.request-peminjaman.index')
                ->with('success', "Request peminjaman dari {$request->user->nama} untuk buku '{$book->judul}' berhasil disetujui!");
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function reject(Request $request, $id_request)
    {
        try {
            $validated = $request->validate([
                'catatan_admin' => 'required|string|max:500'
            ]);
            
            $requestPeminjaman = RequestPeminjaman::with(['user', 'buku'])->findOrFail($id_request);
            
            // Validate request is still pending
            if ($requestPeminjaman->status !== 'pending') {
                return back()->with('error', 'Request sudah diproses!');
            }
            
            // FIX: Use auth()->user()->id_user instead of auth()->id()
            $currentUserId = auth()->check() ? auth()->user()->id_user : null;
            
            // Update request status
            $requestPeminjaman->update([
                'status' => 'ditolak',
                'catatan_admin' => $validated['catatan_admin'],
                'diproses_oleh' => $currentUserId,
                'tanggal_diproses' => now()
            ]);
            
            // Log activity - only if user is authenticated
            if ($currentUserId) {
                LogAktivitas::create([
                    'id_user' => $currentUserId,
                    'username' => auth()->user()->username ?? auth()->user()->nama,
                    'nama_tabel' => 'request_peminjaman',
                    'operasi' => 'update',
                    'deskripsi' => "Reject request peminjaman #{$id_request} - User: {$requestPeminjaman->user->nama}, Alasan: {$validated['catatan_admin']}",
                    'id_terkait' => $id_request
                ]);
            }
            
            return redirect()->route('petugas.request-peminjaman.index')
                ->with('success', "Request peminjaman dari {$requestPeminjaman->user->nama} berhasil ditolak.");
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
