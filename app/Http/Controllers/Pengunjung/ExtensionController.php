<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\{Peminjaman, RequestPerpanjangan};
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExtensionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get active loans
        $activeLoans = Peminjaman::with(['asetBuku.buku', 'requestPerpanjangan'])
            ->where('id_user', auth()->user()->id_user)
            ->where('status_peminjaman', 'Dipinjam')
            ->get();
        
        // Get extension request history
        $extensionRequests = RequestPerpanjangan::with(['peminjaman.asetBuku.buku'])
            ->whereHas('peminjaman', function($q) use ($user) {
                $q->where('id_user', auth()->user()->id_user);
            })
            ->latest('tanggal_request')
            ->get();
        
        return view('pengunjung.extensions', compact('activeLoans', 'extensionRequests'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'hari_perpanjangan' => 'required|integer|min:1|max:7',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        $peminjaman = Peminjaman::findOrFail($validated['id_peminjaman']);
        
        // Verify ownership
        if ($peminjaman->id_user != auth()->user()->id_user) {
            return back()->withErrors(['error' => 'Unauthorized!']);
        }
        
        // Check if overdue
        if ($peminjaman->isTerlambat()) {
            return back()->withErrors(['error' => 'Tidak dapat mengajukan perpanjangan karena sudah terlambat!']);
        }
        
        // Check if already has pending request
        if ($peminjaman->requestPerpanjangan()->where('status', 'pending')->exists()) {
            return back()->withErrors(['error' => 'Anda sudah mengajukan perpanjangan untuk buku ini!']);
        }
        
        // Validate due date exists
        if (!$peminjaman->tanggal_jatuh_tempo) {
            return back()->withErrors(['error' => 'Data tanggal jatuh tempo tidak valid!']);
        }
        
        // Calculate new due date - ensure integer casting
        $hariPerpanjangan = (int) $validated['hari_perpanjangan'];
        $tanggalKembaliBaru = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->addDays($hariPerpanjangan);
        
        // Create extension request
        RequestPerpanjangan::create([
            'id_peminjaman' => $validated['id_peminjaman'],
            'tanggal_request' => now(),
            'tanggal_perpanjangan_baru' => $tanggalKembaliBaru,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending'
        ]);
        
        return redirect()->route('pengunjung.extensions')
            ->with('success', 'Permintaan perpanjangan berhasil diajukan!');
    }
}
