<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    // METHOD UNTUK MENAMPILKAN FORMULIR PROFIL (UR 13 - Melihat)
    public function index()
    {
        return view('admin.pengaturan_profil'); 
    }
    
    // METHOD UNTUK MEMPERBARUI PROFIL (UR 13 - Memperbarui)
    public function update(Request $request)
    {
        // Logika untuk validasi dan menyimpan data profil ke database
        
        // Contoh:
        // $request->validate([...]);
        // auth()->user()->update([...]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}