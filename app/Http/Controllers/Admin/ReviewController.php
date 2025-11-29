<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UlasanBuku;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = UlasanBuku::with(['user', 'buku']);
        
        if ($request->filled('search')) {
            $query->whereHas('buku', function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%");
            });
        }
        
        $reviews = $query->latest('tanggal_ulasan')->paginate(10);
        
        return view('admin.review_ulasan', compact('reviews'));
    }

    public function destroy($id_ulasan)
    {
        UlasanBuku::findOrFail($id_ulasan)->delete();
        return back()->with('success', 'Review berhasil dihapus!');
    }
}
