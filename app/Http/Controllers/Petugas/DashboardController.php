<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Optionally: $this->middleware('is_petugas');
    }

    public function index()
    {
        return view('petugas.dashboard');
    }
}
