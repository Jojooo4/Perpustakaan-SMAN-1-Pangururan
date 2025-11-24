<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PasswordRequestsController extends Controller
{
    public function index()
    {
        $path = 'password_requests.json';
        $requests = [];
        if (Storage::exists($path)) {
            $raw = Storage::get($path);
            $requests = json_decode($raw, true) ?: [];
        }

        return view('admin.password_requests', ['requests' => $requests]);
    }
}
