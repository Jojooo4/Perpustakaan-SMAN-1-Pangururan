<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <<< INI YANG DIBUTUHKAN
use Illuminate\Http\Request;

class BukuController extends Controller // Sekarang mewarisi dari base Controller yang benar
{
    public function index()
    {
        // Pastikan view dipanggil dengan nama yang benar:
        // Jika file ada di resources/views/manajemen_buku.blade.php
        return view('Admin.manajemen_buku'); 
    }
}