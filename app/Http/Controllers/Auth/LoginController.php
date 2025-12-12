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
        // If user is already authenticated and navigates to login (e.g., via browser navigation),
        // force logout so the session cannot be reused by pressing back/forward.
        if (\Illuminate\Support\Facades\Auth::check()) {
            \Illuminate\Support\Facades\Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        $response = response()->view('auth.login');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
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

            // Determine role from tipe_anggota since database doesn't have 'role' column
            $role = null;
            if (Schema::hasColumn('users', 'role')) {
                $role = $user->role;
            } elseif (Schema::hasColumn('users', 'tipe_anggota')) {
                // Map tipe_anggota to roles
                $tipe = strtolower($user->tipe_anggota ?? '');
                if ($tipe === 'admin') {
                    $role = 'admin';
                } elseif ($tipe === 'petugas') {
                    $role = 'petugas'; 
                } else {
                    // Siswa, Guru, Kepala Sekolah, Staf, Umum = pengunjung
                    $role = 'pengunjung';
                }
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
                // Mark just-logged-in for one-time overdue popup on dashboard
                $request->session()->put('just_logged_in', true);
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
        // Reset one-time flags on logout
        $request->session()->forget('just_logged_in');
        $request->session()->forget('overdue_shown');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
