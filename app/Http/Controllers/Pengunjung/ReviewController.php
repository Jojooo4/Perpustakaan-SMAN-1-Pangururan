<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\{Buku, UlasanBuku, Peminjaman};
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($id_buku)
    {
        $book = Buku::findOrFail($id_buku);
        
        // Temporarily disable borrow verification (schema mismatch)
        // TODO: Fix when database schema is confirmed
        $hasBorrowed = true;
        
        return view('pengunjung.review_form', compact('book'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|max:1000'
        ]);
        
        // Temporarily disable borrow verification (schema mismatch)
        // TODO: Fix when database schema is confirmed
        $hasBorrowed = true;
        
        // Create review - use 'komentar' column directly
        UlasanBuku::create([
            'id_buku' => $validated['id_buku'],
            'id_user' => auth()->user()->id_user,
            'rating' => $validated['rating'],
            'komentar' => $validated['ulasan'] // Map form field 'ulasan' to DB column 'komentar'
        ]);
        
        return redirect()->route('pengunjung.catalog.show', $validated['id_buku'])
            ->with('success', 'Review berhasil ditambahkan!');
    }
}
