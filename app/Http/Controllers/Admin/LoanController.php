<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Peminjaman, AsetBuku, User};
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku']);
        
        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%");
            });
        }
        
        $peminjaman = $query->latest('tanggal_pinjam')->paginate(10);
        $users = User::where('role', 'pengunjung')->get();
        $asetTersedia = AsetBuku::with('buku')->tersedia()->get();
        
        return view('admin.pinjam_kembali', compact('peminjaman', 'users', 'asetTersedia'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_aset_buku' => 'required|exists:aset_buku,id_aset_buku',
            'tanggal_pinjam' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1|max:14'
        ]);

        $aset = AsetBuku::findOrFail($validated['id_aset_buku']);
        
        if ($aset->status_buku !== 'Tersedia') {
            return back()->withErrors(['id_aset_buku' => 'Buku tidak tersedia!']);
        }

        $tanggalJatuhTempo = Carbon::parse($validated['tanggal_pinjam'])->addDays($validated['lama_pinjam']);

        Peminjaman::create([
            'id_user' => $validated['id_user'],
            'id_aset_buku' => $validated['id_aset_buku'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
            'status_peminjaman' => 'Dipinjam',
            'denda' => 0
        ]);

        $aset->update(['status_buku' => 'Dipinjam']);
        $aset->buku->decrement('stok_tersedia');

        return redirect()->route('admin.loans.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    public function return($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        
        $denda = $peminjaman->hitungDenda();
        
        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status_peminjaman' => $denda > 0 ? 'Terlambat' : 'Dikembalikan',
            'denda' => $denda,
            'denda_lunas' => $denda == 0
        ]);

        $peminjaman->asetBuku->update(['status_buku' => 'Tersedia']);
        $peminjaman->asetBuku->buku->increment('stok_tersedia');

        $message = $denda > 0 
            ? "Buku dikembalikan! Denda: Rp " . number_format($denda, 0, ',', '.')
            : "Buku berhasil dikembalikan!";

        return redirect()->route('admin.loans.index')->with('success', $message);
    }

    public function destroy($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        
        if ($peminjaman->status_peminjaman === 'Dipinjam') {
            $peminjaman->asetBuku->update(['status_buku' => 'Tersedia']);
            $peminjaman->asetBuku->buku->increment('stok_tersedia');
        }
        
        $peminjaman->delete();

        return redirect()->route('admin.loans.index')->with('success', 'Peminjaman berhasil dihapus!');
    }
}
