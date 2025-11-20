<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required','string','max:100','unique:users,username'],
            'nama' => ['required','string','max:255'],
            'email' => ['nullable','email','max:255'],
            'nip' => ['nullable','string','max:100'],
            'nisn' => ['nullable','string','max:100'],
            'password' => ['required','string','min:6','confirmed'],
            'role' => ['required','in:admin,petugas,pengunjung'],
        ]);

        $user = new User();

        // Get actual columns in users table so we don't attempt to write missing columns
        $columns = Schema::getColumnListing('users');

        // set username column (required)
        if (in_array('username', $columns)) {
            $user->username = $data['username'];
        } elseif (in_array('name', $columns)) {
            $user->name = $data['username'];
        }

        // set display name / nama
        if (in_array('nama', $columns)) {
            $user->nama = $data['nama'];
        } elseif (in_array('name', $columns)) {
            $user->name = $data['nama'];
        } else {
            foreach (['full_name', 'fullname'] as $col) {
                if (in_array($col, $columns)) {
                    $user->{$col} = $data['nama'];
                    break;
                }
            }
        }

        if (! empty($data['email']) && in_array('email', $columns)) {
            $user->email = $data['email'];
        }

        if (! empty($data['nip']) && in_array('nip', $columns)) {
            $user->nip = $data['nip'];
        }

        if (! empty($data['nisn']) && in_array('nisn', $columns)) {
            $user->nisn = $data['nisn'];
        }

        if (in_array('role', $columns)) {
            $user->role = $data['role'];
        }

        // password must exist in table
        if (! in_array('password', $columns)) {
            return back()->withErrors(['password' => 'Kolom password tidak ditemukan di tabel users.'])->withInput();
        }

        $user->password = Hash::make($data['password']);

        try {
            $user->save();
        } catch (\Exception $e) {
            return back()->withErrors(['database' => 'Gagal menyimpan pengguna: ' . $e->getMessage()])->withInput();
        }

        return redirect()->route('login')->with('status', 'Akun berhasil dibuat. Silakan login.');
    }
}
