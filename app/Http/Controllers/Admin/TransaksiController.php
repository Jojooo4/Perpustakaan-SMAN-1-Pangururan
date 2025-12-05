<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Peminjaman, User, AsetBuku, RequestPerpanjangan};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FineExport;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // PEMINJAMAN & PENGEMBALIAN
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku']);
        
        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }
        
        $peminjaman = $query->latest('tanggal_pinjam')->paginate(10);
        $users = User::where('role', 'pengunjung')->get();
        
        // Get all available book assets (without status check since column may not exist)
        $asetTersedia = AsetBuku::with('buku')->get();
        
        return view('admin.pinjam_kembali', compact('peminjaman', 'users', 'asetTersedia'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_aset' => 'required|exists:aset_buku,id_aset', // FIX: id_aset not id_aset_buku
            'tanggal_pinjam' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1|max:14'
        ]);

        $aset = AsetBuku::findOrFail($validated['id_aset']);
        
        // Note: Add status check here if your database has status column
        // if ($aset->status_buku !== 'Tersedia') {
        //     return back()->withErrors(['id_aset' => 'Buku tidak tersedia!']);
        // }

        // Calculate due date
        $tanggalJatuhTempo = Carbon::parse($validated['tanggal_pinjam'])->addDays($validated['lama_pinjam']);

        // Create loan
        Peminjaman::create([
            'id_user' => $validated['id_user'],
            'id_aset' => $validated['id_aset'], // FIX
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
            'status_peminjaman' => 'Dipinjam',
            'denda' => 0
        ]);

        // Update book status and stock (comment if no status column)
        // $aset->update(['status_buku' => 'Dipinjam']);
        $aset->buku->decrement('stok_tersedia');

        return redirect()->route('transaksi.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    public function return($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        
        // Calculate fine
        $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);
        $kembali = now();
        $hariTerlambat = max(0, $kembali->diffInDays($jatuhTempo, false) * -1);
        $denda = $hariTerlambat * 1000; // Rp 1000 per hari
        
        // Update loan
        $peminjaman->update([
            'tanggal_kembali' => $kembali,
            'status_peminjaman' => $denda > 0 ? 'Terlambat' : 'Dikembalikan',
            'denda' => $denda,
            'denda_lunas' => $denda == 0
        ]);

        // Update book status and stock (comment if no status column)
        // $peminjaman->asetBuku->update(['status_buku' => 'Tersedia']);
        $peminjaman->asetBuku->buku->increment('stok_tersedia');

        $message = $denda > 0 
            ? "Buku dikembalikan! Denda: Rp " . number_format($denda, 0, ',', '.')
            : "Buku berhasil dikembalikan!";

        return redirect()->route('transaksi.index')->with('success', $message);
    }

    public function destroy($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        
        // If still on loan, return stock
        if ($peminjaman->status_peminjaman === 'Dipinjam') {
            // $peminjaman->asetBuku->update(['status_buku' => 'Tersedia']);
            $peminjaman->asetBuku->buku->increment('stok_tersedia');
        }
        
        $peminjaman->delete();

        return redirect()->route('transaksi.index')->with('success', 'Peminjaman berhasil dihapus!');
    }

    // PERPANJANGAN
    public function perpanjangan(Request $request)
    {
        $query = RequestPerpanjangan::with(['peminjaman.user', 'peminjaman.asetBuku.buku']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $requests = $query->latest('tanggal_request')->paginate(10);
        
        return view('admin.permintaan_perpanjangan', compact('requests'));
    }

    public function approve($id_request)
    {
        $request = RequestPerpanjangan::with('peminjaman')->findOrFail($id_request);
        
        if ($request->status !== 'pending') {
            return back()->withErrors(['error' => 'Request sudah diproses!']);
        }
        
        $request->update([
            'status' => 'disetujui',
            'diproses_oleh' => auth()->id()
        ]);
        
        $request->peminjaman->update([
            'tanggal_jatuh_tempo' => $request->tanggal_kembali_baru
        ]);

        return redirect()->route('perpanjangan.index')->with('success', 'Perpanjangan disetujui!');
    }

    public function reject(Request $request, $id_request)
    {
        $reqPerpanjangan = RequestPerpanjangan::findOrFail($id_request);
        
        if ($reqPerpanjangan->status !== 'pending') {
            return back()->withErrors(['error' => 'Request sudah diproses!']);
        }
        
        $reqPerpanjangan->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin ?? 'Ditolak',
            'diproses_oleh' => auth()->id()
        ]);

        return redirect()->route('perpanjangan.index')->with('success', 'Perpanjangan ditolak!');
    }

    // LAPORAN DENDA
    public function laporanDenda(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku'])->where('denda', '>', 0);
        
        if ($request->filled('status')) {
            if ($request->status === 'lunas') {
                $query->where('denda_lunas', true);
            } else {
                $query->where('denda_lunas', false);
            }
        }
        
        $denda = $query->latest('tanggal_kembali')->paginate(10);
        $totalDendaBelumLunas = Peminjaman::where('denda', '>', 0)->where('denda_lunas', false)->sum('denda');
        
        return view('admin.laporan_denda', compact('denda', 'totalDendaBelumLunas'));
    }

    public function markPaid($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        $peminjaman->update(['denda_lunas' => true]);

        return back()->with('success', 'Denda ditandai lunas!');
    }

    public function exportDenda(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku'])->where('denda', '>', 0);
        
        if ($request->filled('status')) {
            $query->where('denda_lunas', $request->status === 'lunas');
        }
        
        return Excel::download(new FineExport($query->get()), 'laporan_denda_' . date('YmdHis') . '.xlsx');
    }
}
