<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Optionally: $this->middleware('is_pengunjung');
    }

    public function index()
    {
        return view('pengunjung.dashboard');
    }
}
