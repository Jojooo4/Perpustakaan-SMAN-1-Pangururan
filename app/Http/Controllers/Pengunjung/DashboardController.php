<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\{Buku, Peminjaman, RequestPeminjaman};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistics
        $peminjamanAktif = Peminjaman::where('id_user', auth()->user()->id_user)
            ->where('status_peminjaman', 'Dipinjam')
            ->count();
            
        $totalPeminjaman = Peminjaman::where('id_user', auth()->user()->id_user)->count();
        
        $dendaBelumLunas = Peminjaman::where('id_user', auth()->user()->id_user)
            ->where('denda', '>', 0)
            // Fixed: denda_lunas column doesn't exist
            ->sum('denda');
        
        // Active loans
        $peminjamanAktifList = Peminjaman::with(['asetBuku.buku'])
            ->where('id_user', auth()->user()->id_user)
            ->where('status_peminjaman', 'Dipinjam')
            ->latest('tanggal_pinjam')
            ->get();
        
        // Loan history
        $riwayatPeminjaman = Peminjaman::with(['asetBuku.buku'])
            ->where('id_user', auth()->user()->id_user)
            ->whereIn('status_peminjaman', ['Dikembalikan', 'Terlambat'])
            ->latest('tanggal_kembali')
            ->limit(10)
            ->get();

        // Popular book recommendations (by borrow count)
        $borrowCounts = DB::table('aset_buku')
            ->select('aset_buku.id_buku', DB::raw('COUNT(peminjaman.id_peminjaman) as borrow_count'))
            ->leftJoin('peminjaman', 'peminjaman.id_aset_buku', '=', 'aset_buku.id_aset')
            ->groupBy('aset_buku.id_buku');

        $popularBooks = Buku::query()
            ->leftJoinSub($borrowCounts, 'borrow_counts', function ($join) {
                $join->on('buku.id_buku', '=', 'borrow_counts.id_buku');
            })
            ->select('buku.*')
            ->selectRaw('COALESCE(borrow_counts.borrow_count, 0) as borrow_count')
            ->orderByDesc('borrow_count')
            ->orderByDesc('stok_tersedia')
            ->limit(8)
            ->get();
        
        return view('pengunjung.dashboard', compact(
            'peminjamanAktif',
            'totalPeminjaman',
            'dendaBelumLunas',
            'peminjamanAktifList',
            'riwayatPeminjaman',
            'popularBooks'
        ));
    }
    
    public function myRequests()
    {
        $requests = RequestPeminjaman::with(['buku'])
            ->where('id_user', auth()->user()->id_user)
            ->latest('tanggal_request')
            ->paginate(10);
        
        return view('pengunjung.my_requests', compact('requests'));
    }
    
    public function cancelRequest($id_request)
    {
        $request = RequestPeminjaman::where('id_user', auth()->user()->id_user)
            ->where('id_request', $id_request)
            ->where('status', 'pending')
            ->firstOrFail();
        
        $request->delete();
        
        return redirect()->route('pengunjung.my-requests')
            ->with('success', 'Request peminjaman berhasil dibatalkan.');
    }
}
