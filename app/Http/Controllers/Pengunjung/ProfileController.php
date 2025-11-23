<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pengunjung.profile');
    }
}

