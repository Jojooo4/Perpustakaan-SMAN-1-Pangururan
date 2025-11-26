@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')

<h2 class="text-2xl font-bold text-[#2B3467] mb-6"></h2>

<div class="bg-white p-6 rounded-xl shadow-lg">

    <div class="flex justify-between items-center mb-5 border-b pb-4 border-[#BAD7E9]">
        <h3 class="text-xl font-semibold text-[#2B3467] uppercase tracking-wider">DAFTAR AKUN</h3>
        <span class="text-sm font-medium text-[#EB455F] bg-[#BAD7E9]/30 px-3 py-1 rounded-full">Total Akun: 850</span>
    </div>

    {{-- SEARCH DAN TAMBAH PENGGUNA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 items-end">
        
        {{-- Tombol Tambah Pengguna --}}
        <div class="md:col-span-1">
            <a href="#" class="inline-flex items-center justify-center w-full py-2 px-4 bg-[#EB455F] text-white rounded-md font-semibold hover:bg-[#2B3467] transition duration-150 shadow-md">
                <i class="fas fa-user-plus mr-2"></i> Tambah Akun Baru (UR 7)
            </a>
        </div>

        {{-- Form Pencarian --}}
        <div class="md:col-span-1 flex gap-2">
            <input type="text" class="form-input w-full py-2 px-4 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F] transition" placeholder="Cari Nama atau Role Pengguna..." disabled>
            <button class="py-2 px-4 bg-[#2B3467] text-white rounded-md font-semibold hover:bg-[#EB455F] transition duration-150" disabled>
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </div>

    {{-- USERS TABLE --}}
    <div class="overflow-x-auto rounded-xl border border-[#BAD7E9]">
        <table class="min-w-full bg-white text-sm">
            <thead>
                <tr class="bg-[#2B3467] text-white uppercase text-xs tracking-wider">
                    <th class="px-4 py-3 text-left">ID / Username</th>
                    <th class="px-4 py-3 text-left">Nama Lengkap</th>
                    <th class="px-4 py-3 text-center">Role</th>
                    <th class="px-4 py-3 text-center">Status Akun</th>
                    <th class="px-4 py-3 text-center">Aksi (UR 7)</th>
                </tr>
            </thead>
            <tbody>
                {{-- Admin Utama --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100 bg-green-50/50">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">ADM001</td>
                    <td class="px-4 py-3">Admin Perpustakaan</td>
                    <td class="px-4 py-3 text-center"><span class="bg-red-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Admin Utama</span></td>
                    <td class="px-4 py-3 text-center"><span class="bg-green-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Aktif</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-gray-400 text-white rounded-md text-xs disabled" disabled>Hapus</button>
                    </td>
                </tr>

                {{-- Petugas Biasa --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">PTG005</td>
                    <td class="px-4 py-3">Rudi Hartono</td>
                    <td class="px-4 py-3 text-center"><span class="bg-blue-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Petugas</span></td>
                    <td class="px-4 py-3 text-center"><span class="bg-green-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Aktif</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>
                
                {{-- Pengunjung/Anggota --}}
                <tr class="hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">P0001</td>
                    <td class="px-4 py-3">Siti A.</td>
                    <td class="px-4 py-3 text-center"><span class="bg-gray-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Pengunjung</span></td>
                    <td class="px-4 py-3 text-center"><span class="bg-green-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Aktif</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="flex justify-between items-center mt-5 text-sm">
        <div class="text-[#2B3467]">
            Showing 1 to 3 of 850 accounts
        </div>
        <div class="flex space-x-2">
            <button class="py-2 px-4 bg-[#BAD7E9] text-[#2B3467] rounded-md font-medium hover:bg-[#BAD7E9]/70 transition" disabled>
                <i class="fas fa-chevron-left"></i> Prev
            </button>
            <span class="py-2 px-4 bg-[#EB455F] text-white rounded-md font-bold">1</span>
            <button class="py-2 px-4 bg-[#BAD7E9] text-[#2B3467] rounded-md font-medium hover:bg-[#BAD7E9]/70 transition" disabled>
                Next <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

</div>
@endsection