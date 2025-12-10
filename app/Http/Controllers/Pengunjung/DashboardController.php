<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\{Peminjaman, RequestPeminjaman};

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
        
        return view('pengunjung.dashboard', compact(
            'peminjamanAktif',
            'totalPeminjaman',
            'dendaBelumLunas',
            'peminjamanAktifList',
            'riwayatPeminjaman'
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
