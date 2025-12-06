<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

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
            ->where('denda_lunas', false)
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
        
        return view('pengunjung.dashboard', compact(
            'peminjamanAktif',
            'totalPeminjaman',
            'dendaBelumLunas',
            'peminjamanAktifList',
            'riwayatPeminjaman'
        ));
    }
}
