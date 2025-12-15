<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Peminjaman, User, AsetBuku, Buku, RequestPerpanjangan, LogAktivitas};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FineExport;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        // Get all books for 2-step selection (title -> inventory)
        $bukus = Buku::where('stok_tersedia', '>', 0)->get();
        
        $view = request()->routeIs('petugas.*') ? 'petugas.pinjam_kembali' : 'admin.pinjam_kembali';
        return view($view, compact('peminjaman', 'users', 'bukus'));
    }
    
    // API: Get available assets by book (exclude borrowed ones)
    public function getAsetByBuku($id_buku)
    {
        // Get IDs of currently borrowed assets
        $borrowedAsetIds = Peminjaman::where('status_peminjaman', 'Dipinjam')
            ->pluck('id_aset_buku')
            ->toArray();
        
        // Get assets that are NOT currently borrowed
        $asets = AsetBuku::where('id_buku', $id_buku)
            ->whereNotIn('id_aset', $borrowedAsetIds)
            ->get();
            
        return response()->json($asets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_aset' => 'required|exists:aset_buku,id_aset', // Form sends id_aset
            'tanggal_pinjam' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1|max:14'
        ]);

        $aset = AsetBuku::findOrFail($validated['id_aset']);
        
        // Note: Add status check here if your database has status column
        // if ($aset->status_buku !== 'Tersedia') {
        //     return back()->withErrors(['id_aset' => 'Buku tidak tersedia!']);
        // }

        // Calculate due date - cast to int for Carbon
        $tanggalJatuhTempo = Carbon::parse($validated['tanggal_pinjam'])->addDays((int)$validated['lama_pinjam']);

        // Create loan - map id_aset from form to id_aset_buku in database
        Peminjaman::create([
            'id_user' => $validated['id_user'],
            'id_aset_buku' => $validated['id_aset'], // Map form field to DB column
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
            'status_peminjaman' => 'Dipinjam',
            'denda' => 0
        ]);

        // Update book status and stock (comment if no status column)
        // $aset->update(['status_buku' => 'Dipinjam']);
        $aset->buku->decrement('stok_tersedia');
        
        // Log activity
        $user = User::find($validated['id_user']);
        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'username' => auth()->user()->username ?? auth()->user()->nama,
            'nama_tabel' => 'peminjaman',
            'operasi' => 'insert',
            'deskripsi' => "Create peminjaman - User: {$user->nama}, Buku: {$aset->buku->judul}",
            'id_terkait' => $validated['id_aset']
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    public function return($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        
        // Calculate fine - get rate from aturan_perpustakaan
        $dendaPerHari = \DB::table('aturan_perpustakaan')
            ->where('nama_aturan', 'denda_per_hari')
            ->value('isi_aturan') ?? 500;
        
        $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);
        $kembali = now();
        
        // Only charge fine if returned AFTER due date
        $denda = 0;
        if ($kembali->isAfter($jatuhTempo)) {
            $hariTerlambat = $kembali->diffInDays($jatuhTempo);
            $denda = $hariTerlambat * $dendaPerHari;
        }
        
        // Use transaction and disable FK checks to avoid trigger errors
        \DB::transaction(function() use ($peminjaman, $kembali, $denda, $id_peminjaman) {
            // Disable foreign key checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Update loan
            $peminjaman->update([
                'tanggal_kembali' => $kembali,
                'status_peminjaman' => $denda > 0 ? 'Terlambat' : 'Dikembalikan',
                'denda' => $denda,
            ]);

            // Update book stock
            $peminjaman->asetBuku->buku->increment('stok_tersedia');
            
            // Re-enable foreign key checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            // Log activity
            try {
                LogAktivitas::create([
                    'id_user' => auth()->user()->id_user,
                    'username' => auth()->user()->username ?? auth()->user()->nama,
                    'nama_tabel' => 'peminjaman',
                    'operasi' => 'update',
                    'deskripsi' => "Return buku - Peminjaman #{$id_peminjaman}, Buku: {$peminjaman->asetBuku->buku->judul}, Denda: Rp " . number_format($denda, 0, ',', '.'),
                    'id_terkait' => $id_peminjaman
                ]);
            } catch (\Exception $e) {
                // Ignore log errors
                \Log::warning("Failed to create log: " . $e->getMessage());
            }
        });
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
        
        $view = request()->routeIs('petugas.*') ? 'petugas.permintaan_perpanjangan' : 'admin.permintaan_perpanjangan';
        return view($view, compact('requests'));
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
            'tanggal_jatuh_tempo' => $request->tanggal_perpanjangan_baru
        ]);
        
        // Log activity
        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'username' => auth()->user()->username ?? auth()->user()->nama,
            'nama_tabel' => 'request_perpanjangan',
            'operasi' => 'update',
            'deskripsi' => "Approve perpanjangan #{$id_request} - User: {$request->peminjaman->user->nama}, Buku: {$request->peminjaman->asetBuku->buku->judul}",
            'id_terkait' => $id_request
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
        
        // Log activity
        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'username' => auth()->user()->username ?? auth()->user()->nama,
            'nama_tabel' => 'request_perpanjangan',
            'operasi' => 'update',
            'deskripsi' => "Reject perpanjangan #{$id_request} - Alasan: " . ($request->catatan_admin ?? 'Ditolak'),
            'id_terkait' => $id_request
        ]);

        return redirect()->route('perpanjangan.index')->with('success', 'Perpanjangan ditolak!');
    }

    // LAPORAN DENDA
    public function laporanDenda(Request $request)
    {
        // Fixed: denda_lunas column doesn't exist in database
        $query = Peminjaman::with(['user', 'asetBuku.buku'])->where('denda', '>', 0);
        
        // Note: Cannot filter by lunas status since denda_lunas column doesn't exist
        // All records with denda > 0 will be shown
        
        $denda = $query->latest('tanggal_kembali')->paginate(10);
        $totalDendaBelumLunas = Peminjaman::where('denda', '>', 0)->sum('denda');
        
        $view = request()->routeIs('petugas.*') ? 'petugas.laporan_denda' : 'admin.laporan_denda';
        return view($view, compact('denda', 'totalDendaBelumLunas'));
    }

    public function markPaid($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        // Fixed: denda_lunas column doesn't exist - just set denda to 0 to mark as paid
        $peminjaman->update(['denda' => 0]);

        return back()->with('success', 'Denda ditandai lunas!');
    }

    public function exportDenda(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku'])->where('denda', '>', 0);
        
        // Fixed: denda_lunas column doesn't exist - export all
        
        return Excel::download(new FineExport($query->get()), 'laporan_denda_' . date('YmdHis') . '.xlsx');
    }
    
    public function exportDendaPdf()
    {
        $denda = Peminjaman::with(['user', 'asetBuku.buku'])
            ->where('denda', '>', 0)
            ->latest('tanggal_kembali')
            ->get();
        
        $totalDenda = $denda->sum('denda');
        
        $pdf = Pdf::loadView('admin.pdf.laporan_denda', compact('denda', 'totalDenda'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan_denda_' . date('Ymd_His') . '.pdf');
    }
}
