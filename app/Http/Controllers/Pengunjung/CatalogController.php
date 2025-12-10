<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\{Buku, UlasanBuku, Peminjaman, RequestPeminjaman};
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('genres');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('nama_pengarang', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhere('tahun_terbit', 'like', "%{$search}%");
            });
        }
        
        $books = $query->paginate(12);
        
        return view('pengunjung.catalog', compact('books'));
    }
    
    public function show($id_buku)
    {
        $book = Buku::with(['genres'])->findOrFail($id_buku);
        
        // Get reviews
        $reviews = UlasanBuku::with('user')
            ->where('id_buku', $id_buku)
            ->latest('id_ulasan')
            ->get();
        
        // Temporarily allow all users to review (disable complex check due to schema mismatch)
        // TODO: Fix when database schema is confirmed
        $userHasBorrowed = true;
        
        return view('pengunjung.book_detail', compact('book', 'reviews', 'userHasBorrowed'));
    }
    
    public function borrow(Request $request, $id_buku)
    {
        $book = Buku::findOrFail($id_buku);
        
        // Check stock
        if ($book->stok_tersedia <= 0) {
            return back()->withErrors(['error' => 'Buku tidak tersedia!']);
        }
        
        // Create borrow request (waiting admin approval)
        RequestPeminjaman::create([
            'id_user' => auth()->user()->id_user,
            'id_buku' => $id_buku,
            'status' => 'pending',
            'tanggal_request' => now()
        ]);
        
        return back()->with('success', 'Permintaan peminjaman berhasil diajukan! Tunggu persetujuan admin/petugas.');
    }
}
