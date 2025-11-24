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
        // Registration has been disabled. Return 404 to hide the page.
        abort(404);
    }

    public function register(Request $request)
    {
        // Registration disabled: do not process any registration requests
        abort(404);
    }
}
