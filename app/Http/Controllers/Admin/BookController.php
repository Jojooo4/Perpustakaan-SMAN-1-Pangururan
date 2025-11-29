<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Buku, AsetBuku, Genre};
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['genres', 'asetBuku']);
        
        if ($request->filled('search')) {
            $query->search($request->search);
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
            'gambar' => 'nullable|image|max:2048',
            'genres' => 'nullable|array'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('books', 'public');
        }

        $buku = Buku::create($validated);
        
        if ($request->filled('genres')) {
            $buku->genres()->sync($request->genres);
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
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
            'gambar' => 'nullable|image|max:2048',
            'genres' => 'nullable|array'
        ]);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar) Storage::disk('public')->delete($buku->gambar);
            $validated['gambar'] = $request->file('gambar')->store('books', 'public');
        }

        $buku->update($validated);
        
        if ($request->has('genres')) {
            $buku->genres()->sync($request->genres);
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($kode_buku)
    {
        $buku = Buku::findOrFail($kode_buku);
        if ($buku->gambar) Storage::disk('public')->delete($buku->gambar);
        $buku->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function storeItem(Request $request, $kode_buku)
    {
        $validated = $request->validate([
            'nomor_inventaris' => 'required|unique:aset_buku,nomor_inventaris',
            'status_buku' => 'required|in:Tersedia,Dipinjam,Rusak,Hilang',
            'kondisi_buku' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan' => 'nullable|string'
        ]);

        $validated['kode_buku'] = $kode_buku;
        AsetBuku::create($validated);
        
        $buku = Buku::find($kode_buku);
        if ($validated['status_buku'] === 'Tersedia') {
            $buku->increment('stok_tersedia');
        }

        return back()->with('success', 'Eksemplar berhasil ditambahkan!');
    }

    public function updateItem(Request $request, $id_aset_buku)
    {
        $aset = AsetBuku::findOrFail($id_aset_buku);
        $oldStatus = $aset->status_buku;
        
        $validated = $request->validate([
            'nomor_inventaris' => 'required|unique:aset_buku,nomor_inventaris,' . $id_aset_buku . ',id_aset_buku',
            'status_buku' => 'required|in:Tersedia,Dipinjam,Rusak,Hilang',
            'kondisi_buku' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan' => 'nullable|string'
        ]);

        $aset->update($validated);
        
        if ($oldStatus !== $validated['status_buku']) {
            $buku = $aset->buku;
            if ($oldStatus === 'Tersedia') $buku->decrement('stok_tersedia');
            if ($validated['status_buku'] === 'Tersedia') $buku->increment('stok_tersedia');
        }

        return back()->with('success', 'Eksemplar berhasil diperbarui!');
    }

    public function destroyItem($id_aset_buku)
    {
        $aset = AsetBuku::findOrFail($id_aset_buku);
        if ($aset->status_buku === 'Tersedia') {
            $aset->buku->decrement('stok_tersedia');
        }
        $aset->delete();

        return back()->with('success', 'Eksemplar berhasil dihapus!');
    }
}
