<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Import Auth untuk mendapatkan pengguna yang sedang login

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya petugas yang sudah login yang bisa mengakses
    }

    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();  // Ambil data pengguna yang sedang login

        // Pass data ke view 'petugas.profile'
        return view('petugas.profile', compact('user'));  // Mengirim data user ke view
    }
}
