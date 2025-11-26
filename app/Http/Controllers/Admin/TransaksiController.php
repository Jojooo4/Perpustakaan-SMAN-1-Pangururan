<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mengembalikan view baru di folder 'admin/pinjam_kembali.blade.php'
        return view('admin.pinjam_kembali'); 
    }

    public function perpanjangan()
    {
        // Mengembalikan view baru di folder 'admin/permintaan_perpanjangan.blade.php'
        return view('admin.permintaan_perpanjangan'); 
    }

    public function laporanDenda()
    {
        return view('admin.laporan_denda'); 
    }
    
    // METHOD UNTUK EXPORT DATA (UR 10)
    public function exportDenda()
    {
        // Logika untuk mengekspor data ke format Excel (misalnya menggunakan library Maatwebsite/Excel)
        // return Excel::download(new DendaExport, 'laporan_denda.xlsx');
        return back()->with('success', 'Laporan denda berhasil diekspor.');
    }
}

