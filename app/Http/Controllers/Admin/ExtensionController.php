<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestPerpanjangan;

class ExtensionController extends Controller
{
    public function index(Request $request)
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

        return redirect()->route('admin.extensions.index')->with('success', 'Perpanjangan disetujui!');
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

        return redirect()->route('admin.extensions.index')->with('success', 'Perpanjangan ditolak!');
    }
}
