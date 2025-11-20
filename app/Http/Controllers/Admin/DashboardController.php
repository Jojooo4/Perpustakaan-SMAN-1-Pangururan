<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // If you register the is_admin middleware, you can enable it here:
        // $this->middleware('is_admin');
    }

    public function index()
    {
        // Pass any data required by admin dashboard here
        return view('admin.dashboard');
    }
}
