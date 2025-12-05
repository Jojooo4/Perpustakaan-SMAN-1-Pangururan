<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Buku, Genre};
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['genres']);
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nama_pengarang', 'like', "%{$request->search}%")
                  ->orWhere('penerbit', 'like', "%{$request->search}%");
            });
        }
        
        $bukus = $query->paginate(10);
        $genres = Genre::all();
        
        return view('admin.manajemen_buku', compact('bukus', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:buku,kode_buku',
            'judul' => 'required|string|max:255',
            'nama_pengarang' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer',
            'jumlah_halaman' => 'nullable|integer',
            'stok_tersedia' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|max:2048',
            'genres' => 'nullable|array'
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('books', 'public');
        }

        // Set default stok if not provided
        $validated['stok_tersedia'] = $validated['stok_tersedia'] ?? 0;

        // Create book
        $buku = Buku::create($validated);
        
        // Attach genres if provided
        if ($request->filled('genres')) {
            $buku->genres()->sync($request->genres);
        }

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show($kode_buku)
    {
        $buku = Buku::with(['genres', 'asetBuku'])->findOrFail($kode_buku);
        return view('admin.detail_buku', compact('buku'));
    }

    public function update(Request $request, $kode_buku)
    {
        $buku = Buku::findOrFail($kode_buku);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'nama_pengarang' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer',
            'jumlah_halaman' => 'nullable|integer',
            'stok_tersedia' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|max:2048',
            'genres' => 'nullable|array'
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('books', 'public');
        }

        // Update book
        $buku->update($validated);
        
        // Update genres
        if ($request->has('genres')) {
            $buku->genres()->sync($request->genres);
        }

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($kode_buku)
    {
        $buku = Buku::findOrFail($kode_buku);
        
        // Delete image if exists
        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }
        
        // Delete book
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}