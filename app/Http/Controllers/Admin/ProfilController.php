<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // METHOD UNTUK MENAMPILKAN FORMULIR PROFIL (UR 13 - Melihat)
    public function index()
    {
        return view('admin.pengaturan_profil');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|unique:users,email,' . $user->id_user . ',id_user',
            'password_lama' => 'nullable|required_with:password_baru',
            'password_baru' => 'nullable|min:6|confirmed',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        $data = ['nama' => $validated['nama']];
        if ($request->filled('email')) {
            $data['email'] = $validated['email'];
        }

        if ($request->filled('password_baru')) {
            if (!Hash::check($request->password_lama ?? '', $user->password)) {
                return back()->withErrors(['password_lama' => 'Password lama salah!']);
            }
            $data['password'] = Hash::make($validated['password_baru']);
        }

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}