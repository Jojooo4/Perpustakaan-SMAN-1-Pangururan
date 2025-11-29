<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\{Hash, Storage};

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,petugas,pengunjung',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);
        
        $validated = $request->validate([
            'username' => 'required|unique:users,username,' . $id_user . ',id_user',
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|unique:users,email,' . $id_user . ',id_user',
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,petugas,pengunjung',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) Storage::disk('public')->delete($user->foto_profil);
            $validated['foto_profil'] = $request->file('foto_profil')->store('profiles', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user);
        if ($user->foto_profil) Storage::disk('public')->delete($user->foto_profil);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
