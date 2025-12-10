<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FineExport;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku'])->where('denda', '>', 0);
        
        // Fixed: denda_lunas column doesn't exist - cannot filter by status
        
        $denda = $query->latest('tanggal_kembali')->paginate(10);
        $totalDendaBelumLunas = Peminjaman::where('denda', '>', 0)->sum('denda');
        
        return view('admin.laporan_denda', compact('denda', 'totalDendaBelumLunas'));
    }

    public function markPaid($id_peminjaman)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        // Fixed: denda_lunas column doesn't exist - set denda to 0
        $peminjaman->update(['denda' => 0]);

        return back()->with('success', 'Denda ditandai lunas!');
    }

    public function exportExcel(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku'])->where('denda', '>', 0);
        
        // Fixed: denda_lunas column doesn't exist - export all fines
        
        return Excel::download(new FineExport($query->get()), 'laporan_denda_' . date('YmdHis') . '.xlsx');
    }
}
