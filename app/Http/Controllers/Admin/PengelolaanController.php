<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, UlasanBuku};
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
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        
        $users = $query->paginate(10);
        
        return view('admin.manajemen_pengguna', compact('users'));
    }

    public function storeUser(Request $request)
    {
        // Fixed: Match ACTUAL database schema (from phpMyAdmin screenshot)
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6',
            'tipe_anggota' => 'required|in:Siswa,Guru,Kepala Sekolah,Staf,Umum,Admin,Petugas',
            'kelas' => 'nullable|string|max:20',
            'status_keanggotaan' => 'nullable|in:Aktif,Tidak Aktif,Dibekukan',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);
        
        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        // Set default status if not provided
        $validated['status_keanggotaan'] = $validated['status_keanggotaan'] ?? 'Aktif';

        // Database users table columns: id_user, username, password, nama, tipe_anggota, kelas, status_keanggotaan, foto_profil
        \DB::table('users')->insert([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'password' => $validated['password'],
            'tipe_anggota' => $validated['tipe_anggota'],
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
            'role' => 'required|in:admin,petugas,pengunjung',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
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
        
        return view('admin.review_ulasan', compact('booksWithReviews'));
    }
    
    // API: Get reviews for specific book
    public function getBookReviews($id_buku)
    {
        // Fixed: ulasan_buku uses id_buku not kode_buku
        $reviews = UlasanBuku::where('id_buku', $id_buku)
            ->with(['buku'])
            ->latest('created_at')
            ->get();
            
        return response()->json($reviews);
    }

    public function destroyReview($id_ulasan)
    {
        UlasanBuku::findOrFail($id_ulasan)->delete();
        return redirect()->route('pengelolaan.review')->with('success', 'Review berhasil dihapus!');
    }
}