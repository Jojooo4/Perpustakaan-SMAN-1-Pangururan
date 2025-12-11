<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Catat login user ke tabel login_event
        Event::listen(Login::class, function ($event) {
            try {
                $user = $event->user;
                // Hanya catat untuk role 'pengunjung'
                $role = null;
                if (is_object($user)) {
                    $role = method_exists($user, 'getAttribute') ? $user->getAttribute('role') : ($user->role ?? null);
                }
                if ($role !== 'pengunjung') {
                    return; // abaikan admin/petugas/non aktif
                }
                $id = method_exists($user, 'getAttribute')
                    ? ($user->getAttribute('id_user') ?? $user->getKey())
                    : ($user->id_user ?? null);

                if ($id) {
                    DB::table('login_event')->insert([
                        'id_user' => $id,
                        'waktu_login' => now(),
                        'sumber' => 'web',
                    ]);
                }
            } catch (\Throwable $e) {
                // Hindari memblokir login bila pencatatan gagal
            }
        });

        // Opsional: catat waktu logout terakhir (jika diperlukan)
        Event::listen(Logout::class, function ($event) {
            try {
                $user = $event->user;
                if (!$user) return;

                // Bila bukan pengunjung, cukup keluar (tidak perlu update logout)
                $role = method_exists($user, 'getAttribute') ? $user->getAttribute('role') : ($user->role ?? null);
                if ($role !== 'pengunjung') {
                    return;
                }

                $id = method_exists($user, 'getAttribute')
                    ? ($user->getAttribute('id_user') ?? $user->getKey())
                    : ($user->id_user ?? null);

                if ($id) {
                    $last = DB::table('login_event')
                        ->where('id_user', $id)
                        ->whereNull('waktu_logout')
                        ->orderByDesc('id_login')
                        ->first();

                    if ($last) {
                        DB::table('login_event')
                            ->where('id_login', $last->id_login)
                            ->update(['waktu_logout' => now()]);
                    }
                }
            } catch (\Throwable $e) {
                // Lewati bila gagal, tidak memblokir logout
            }
        });
    }
}
