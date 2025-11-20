<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $role = null;
        if (Schema::hasColumn('users', 'role')) {
            $role = strtolower((string) $user->role);
        } elseif (Schema::hasColumn('users', 'level')) {
            $role = strtolower((string) $user->level);
        } elseif (Schema::hasColumn('users', 'is_admin')) {
            $role = $user->is_admin ? 'admin' : 'user';
        }

        if ($role === 'admin' || $role === 'superadmin' || $role === '1' || $role === 1) {
            return $next($request);
        }

        abort(403);
    }
}
