<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengelolaanController extends Controller
{
    public function pengguna()
    {
        return view('admin.manajemen_pengguna'); 
    }
    
    public function review()
    {
        return view('admin.review_ulasan'); 
    }
}