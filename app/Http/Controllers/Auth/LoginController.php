<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $identifier = $data['identifier'];
        $password = $data['password'];
        $remember = $request->filled('remember');

        // Try possible identifier column names in users table
        // User said NIP/NISN are stored in the `username` column, so try that first.
        $possibleColumns = ['username', 'email'];
        $authenticated = false;

        foreach ($possibleColumns as $col) {
            if (! Schema::hasColumn('users', $col)) {
                continue;
            }

            $credentials = [$col => $identifier, 'password' => $password];
            if (Auth::attempt($credentials, $remember)) {
                $authenticated = true;
                break;
            }
        }

        if ($authenticated) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Determine role/level from common column names if present
            $role = null;
            if (Schema::hasColumn('users', 'role')) {
                $role = $user->role;
            } elseif (Schema::hasColumn('users', 'level')) {
                $role = $user->level;
            } elseif (Schema::hasColumn('users', 'is_admin')) {
                $role = $user->is_admin ? 'admin' : 'user';
            }

            // Normalize role to string for comparisons
            $roleStr = is_null($role) ? '' : strtolower((string) $role);

            // Routing based on role value
            if ($roleStr === 'admin' || $roleStr === 'superadmin' || $role === 1 || $role === '1') {
                return redirect()->intended('/admin');
            }

            if ($roleStr === 'petugas') {
                return redirect()->intended('/petugas');
            }

            if ($roleStr === 'pengunjung' || $roleStr === 'visitor') {
                // Increment today's pengunjung counter (stored in cache) so homepage can show today's total.
                $key = 'pengunjung:' . date('Y-m-d');
                // Ensure key exists with initial 0 and TTL ~2 days to survive day boundary briefly
                if (! Cache::has($key)) {
                    Cache::put($key, 0, 60 * 60 * 48);
                }
                try {
                    Cache::increment($key);
                } catch (\Exception $e) {
                    // If increment fails for any reason, ensure at least a put
                    $current = (int) Cache::get($key, 0);
                    Cache::put($key, $current + 1, 60 * 60 * 48);
                }

                return redirect()->intended('/pengunjung');
            }

            // default for regular users
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'identifier' => 'NIP/NISN atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
