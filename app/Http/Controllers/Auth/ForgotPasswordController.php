<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function show()
    {
        return view('auth.forgot');
    }

    /**
     * Handle the form submission and attempt to send a reset link.
     * We intentionally return a generic response to avoid account enumeration.
     */
    public function sendReset(Request $request)
    {
        $request->validate([
            'identifier' => ['required','string']
        ]);

        $identifier = $request->input('identifier');

        // Try to find a user by username or nisn only (no email input supported)
        $user = User::where('username', $identifier)
            ->orWhere('nisn', $identifier)
            ->first();

        // If user exists and has an email, try to send reset link via email
        if ($user && ! empty($user->email)) {
            try {
                Password::broker()->sendResetLink(['email' => $user->email]);
                // Redirect to sent page
                return redirect()->route('password.sent');
            } catch (\Exception $e) {
                Log::error('Failed to send password reset: ' . $e->getMessage());
                // fallthrough to saving a request for admin
            }
        }

        // If no email is available (typical for students), save a password-reset request
        // to storage so admin can process it. This avoids changing DB schema.
        try {
            $path = 'password_requests.json';
            $existing = [];
            if (Storage::exists($path)) {
                $raw = Storage::get($path);
                $existing = json_decode($raw, true) ?: [];
            }

            $existing[] = [
                'identifier' => $identifier,
                'user_id' => $user ? $user->id : null,
                'created_at' => Carbon::now()->toDateTimeString(),
            ];

            Storage::put($path, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } catch (\Exception $e) {
            Log::error('Failed to save password request: ' . $e->getMessage());
        }

        return redirect()->route('password.sent');
    }

    /**
     * Show a generic confirmation page.
     */
    public function sent()
    {
        return view('auth.password_sent');
    }
}
