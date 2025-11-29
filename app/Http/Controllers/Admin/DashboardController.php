<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Buku, Peminjaman, User, RequestPerpanjangan, UlasanBuku};

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stok_tersedia');
        $peminjamanAktif = Peminjaman::where('status_peminjaman', 'Dipinjam')->count();
        $totalDenda = Peminjaman::where('denda', '>', 0)->sum('denda');
        $anggotaAktif = User::where('role', 'pengunjung')->count();
        
        // Temporary: Comment karena tabel request_perpanjangan mungkin belum ada
        // $requestPending = RequestPerpanjangan::with(['peminjaman.user', 'peminjaman.asetBuku.buku'])
        //                                      ->where('status', 'pending')
        //                                      ->latest('tanggal_request')
        //                                      ->take(5)
        //                                      ->get();
        $requestPending = collect(); // Empty collection sementara
        
        // Temporary: Comment dulu ulasan buku
        // $reviewTerbaru = UlasanBuku::with(['user', 'buku'])
        //                            ->latest('tanggal_ulasan')
        //                            ->take(5)
        //                            ->get();
        $reviewTerbaru = collect(); // Empty collection sementara
        
        return view('admin.dashboard', compact(
            'totalBuku', 'totalStok', 'peminjamanAktif', 
            'totalDenda', 'anggotaAktif', 'requestPending', 'reviewTerbaru'
        ));
    }
}
