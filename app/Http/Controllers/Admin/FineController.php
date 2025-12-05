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

    public function exportExcel(Request $request)
    {
        $query = Peminjaman::with(['user', 'asetBuku.buku'])->where('denda', '>', 0);
        
        if ($request->filled('status')) {
            $query->where('denda_lunas', $request->status === 'lunas');
        }
        
        return Excel::download(new FineExport($query->get()), 'laporan_denda_' . date('YmdHis') . '.xlsx');
    }
}
