<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Buku, Genre, AsetBuku};
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    private function indexRouteName(Request $request): string
    {
        return $request->routeIs('petugas.*') ? 'petugas.buku.index' : 'buku.index';
    }

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
        
        // DataTables on the view is client-side, so we must not paginate here.
        // Otherwise, newly created books can end up on another page and appear “missing”.
        $bukus = $query->latest('id_buku')->get();
        $genres = Genre::all();
        
        $view = request()->routeIs('petugas.*') ? 'petugas.manajemen_buku' : 'admin.manajemen_buku';
        return view($view, compact('bukus', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'nama_pengarang' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer',
            'jumlah_halaman' => 'nullable|integer',
            'stok_tersedia' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:51200',
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

        // AUTO-CREATE ASET BUKU based on stok_tersedia
        $stok = $validated['stok_tersedia'];
        if ($stok > 0) {
            for ($i = 1; $i <= $stok; $i++) {
                // Generate nomor inventaris: BK-{id_buku}-{nomor_urut}
                $nomorInventaris = sprintf('BK-%03d-%03d', $buku->id_buku, $i);
                
                AsetBuku::create([
                    'id_buku' => $buku->id_buku,
                    'nomor_inventaris' => $nomorInventaris,
                    'kondisi_buku' => 'Baik',
                    'catatan' => 'Auto-generated from stok awal'
                ]);
            }
        }

        return redirect()->route($this->indexRouteName($request))
            ->with('success', "Buku berhasil ditambahkan! $stok aset buku telah dibuat otomatis.");
    }

    public function show($id_buku)
    {
        $buku = Buku::with(['genres', 'asetBuku'])->findOrFail($id_buku);
        return view('admin.detail_buku', compact('buku'));
    }

    public function update(Request $request, $id_buku)
    {
        $buku = Buku::findOrFail($id_buku);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'nama_pengarang' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer',
            'jumlah_halaman' => 'nullable|integer',
            'stok_tersedia' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:51200',
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

        return redirect()->route($this->indexRouteName($request))
            ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id_buku)
    {
        $buku = Buku::findOrFail($id_buku);
        
        // Delete image if exists
        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }
        
        // Delete book
        $buku->delete();

        return redirect()->route($this->indexRouteName(request()))
            ->with('success', 'Buku berhasil dihapus!');
    }
}