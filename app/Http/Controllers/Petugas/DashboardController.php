<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\{Buku, Peminjaman, User};

class DashboardController extends Controller
{
    public function index()
    {
        $peminjamanAktif = Peminjaman::where('status_peminjaman', 'Dipinjam')->count();
        $totalBuku = Buku::count();
        $pengunjungAktif = User::where('role', 'pengunjung')->count();
        
        return view('petugas.dashboard', compact('peminjamanAktif', 'totalBuku', 'pengunjungAktif'));
    }
}
