<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, UlasanBuku, Buku};
use Illuminate\Support\Facades\{Hash, Storage};

class PengelolaanController extends Controller
{
    // USER MANAGEMENT
    public function pengguna(Request $request)
    {
        $query = User::query();
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Search (DB doesn't have email column)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Sort
        $allowedSorts = ['username','nama','role','tipe_anggota','created_at'];
        $sort = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'username';
        $dir = strtolower($request->get('dir')) === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sort, $dir);
        
        $users = $query->paginate(10)->appends($request->query());
        
        return view('admin.manajemen_pengguna', [
            'users' => $users,
            'currentRole' => $request->get('role',''),
            'currentSearch' => $request->get('search',''),
            'currentSort' => $sort,
            'currentDir' => $dir,
        ]);
    }

    public function storeUser(Request $request)
    {
        // Validate incoming fields
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6',
            'role' => 'required|in:petugas,pengunjung',
            'tipe_anggota' => 'nullable|in:Siswa,Guru,Kepala Sekolah,Staf',
            'kelas' => 'nullable|string|max:20',
            'status_keanggotaan' => 'nullable|in:Aktif,Tidak Aktif,Dibekukan',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        // Derive tipe_anggota from role if not provided
        if ($validated['role'] === 'petugas') {
            $validated['tipe_anggota'] = 'Petugas';
        } else {
            // pengunjung must provide one of the allowed categories
            if (empty($validated['tipe_anggota'])) {
                return back()->withErrors(['tipe_anggota' => 'Tipe anggota wajib diisi untuk role Pengguna.'])->withInput();
            }
        }

        // Hash password
        $validated['password'] = Hash::make($validated['password']);
        
        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        // Set default status if not provided
        $validated['status_keanggotaan'] = $validated['status_keanggotaan'] ?? 'Aktif';

        // Database users table columns: id_user, username, password, nama, tipe_anggota, role, kelas, status_keanggotaan, foto_profil
        \DB::table('users')->insert([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'password' => $validated['password'],
            'tipe_anggota' => $validated['tipe_anggota'],
            'role' => $validated['role'],
            'kelas' => $validated['kelas'] ?? null,
            'status_keanggotaan' => $validated['status_keanggotaan'],
            'foto_profil' => $validated['foto_profil'] ?? null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('pengelolaan.pengguna')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);
        
        $validated = $request->validate([
            'username' => 'required|unique:users,username,' . $id_user . ',id_user',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:6',
            'role' => 'required|in:petugas,pengunjung,admin',
            'tipe_anggota' => 'nullable|in:Siswa,Guru,Kepala Sekolah,Staf,Umum',
            'kelas' => 'nullable|string|max:20',
            'status_keanggotaan' => 'nullable|in:Aktif,Tidak Aktif,Dibekukan',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        // Normalize tipe_anggota based on role
        if ($validated['role'] === 'petugas') {
            // Set NULL karena enum tipe_anggota tidak memiliki 'Petugas'
            $validated['tipe_anggota'] = null;
        } else if ($validated['role'] === 'pengunjung') {
            if (empty($validated['tipe_anggota'])) {
                return back()->withErrors(['tipe_anggota' => 'Tipe anggota wajib diisi untuk role Pengguna.'])->withInput();
            }
        }
        
        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        $user->update($validated);

        return redirect()->route('pengelolaan.pengguna')->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroyUser($id_user)
    {
        $user = User::findOrFail($id_user);
        
        // Delete photo if exists
        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        
        $user->delete();
        return redirect()->route('pengelolaan.pengguna')->with('success', 'Pengguna berhasil dihapus!');
    }

    // REVIEW MANAGEMENT - Grouped by Book
    public function review(Request $request)
    {
        // Get books that have reviews with review count and average rating
        // Fixed: ulasan_buku uses id_buku not kode_buku
        $booksWithReviews = \DB::table('ulasan_buku')
            ->join('buku', 'ulasan_buku.id_buku', '=', 'buku.id_buku')
            ->select(
                'buku.id_buku',
                'buku.judul',
                'buku.nama_pengarang',
                'buku.gambar',
                \DB::raw('COUNT(ulasan_buku.id_ulasan) as total_reviews'),
                \DB::raw('ROUND(AVG(ulasan_buku.rating), 1) as avg_rating')
            )
            ->groupBy('buku.id_buku', 'buku.judul', 'buku.nama_pengarang', 'buku.gambar')
            ->paginate(10);
        
        $view = request()->routeIs('petugas.*') ? 'petugas.review_ulasan' : 'admin.review_ulasan';
        return view($view, compact('booksWithReviews'));
    }
    
    // API: Get reviews for specific book
    public function getBookReviews($id_buku)
    {
        // Fixed: Load user relationship for reviewer info
        $reviews = UlasanBuku::where('id_buku', $id_buku)
            ->with(['buku', 'user'])  // Added user
            ->latest('id_ulasan')  // Changed from created_at
            ->get();
            
        return response()->json($reviews);
    }

    // Show detailed reviews for a specific book
    public function showBookReviews(Request $request, $id_buku)
    {
        $book = Buku::with(['ulasanBuku.user'])->findOrFail($id_buku);
        
        $query = UlasanBuku::where('id_buku', $id_buku)->with('user');
        
        // Filter by rating if provided
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Search by reviewer name
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%");
            });
        }
        
        $reviews = $query->latest('id_ulasan')->paginate(10);  // Changed from created_at
        
        // Calculate stats
        $avgRating = $book->ulasanBuku()->avg('rating');
        $totalReviews = $book->ulasanBuku()->count();
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $book->ulasanBuku()->where('rating', $i)->count();
        }
        
        $view = request()->routeIs('petugas.*') ? 'petugas.book_reviews' : 'admin.book_reviews';
        return view($view, compact('book', 'reviews', 'avgRating', 'totalReviews', 'ratingDistribution'));
    }

    public function destroyReview($id_ulasan)
    {
        UlasanBuku::findOrFail($id_ulasan)->delete();
        
        // Dynamic routing based on current route prefix
        $routePrefix = request()->routeIs('petugas.*') ? 'petugas.' : '';
        
        return redirect()->route($routePrefix . 'pengelolaan.review')->with('success', 'Review berhasil dihapus!');
    }
    
    /**
     * Helper to get route prefix based on current route
     */
    protected function getRoutePrefix()
    {
        return request()->routeIs('petugas.*') ? 'petugas.' : '';
    }
}