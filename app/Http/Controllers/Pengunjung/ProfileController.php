<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Storage};

class ProfileController extends Controller
{
    public function index()
    {
        return view('pengunjung.profile');
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:51200',
            'password_lama' => 'nullable|required_with:password_baru',
            'password_baru' => 'nullable|min:6|confirmed'
        ]);
        
        // Update nama
        $user->nama = $validated['nama'];
        
        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = $request->file('foto_profil')->store('profiles', 'public');
        }
        
        // Update password if provided
        if ($request->filled('password_lama')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->withErrors(['password_lama' => 'Password lama tidak sesuai!']);
            }
            $user->password = Hash::make($request->password_baru);
        }
        
        $user->save();
        
        return redirect()->route('pengunjung.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }
}
