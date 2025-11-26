@extends('layouts.admin')

@section('title', 'Manajemen Buku')

@section('content')

<h2 class="text-2xl font-bold text-[#2B3467] mb-6"></h2>

<div class="bg-white p-6 rounded-xl shadow-lg">

    {{-- HEADER DAN JUMLAH DATA --}}
    <div class="flex justify-between items-center mb-5 border-b pb-4 border-[#BAD7E9]">
        <h3 class="text-xl font-semibold text-[#2B3467] uppercase tracking-wider">DAFTAR BUKU</h3>
        {{-- Total data diupdate menjadi 7 --}}
        <span class="text-sm font-medium text-[#EB455F] bg-[#BAD7E9]/30 px-3 py-1 rounded-full">Total: 7 Judul</span>
    </div>

    {{-- SEARCH DAN TAMBAH BUKU --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 items-end">
        
        {{-- Tombol Tambah Buku (Posisi di samping) --}}
        <div class="md:col-span-1 order-2 md:order-1">
            <a href="#" class="inline-flex items-center justify-center w-full md:w-auto py-2 px-4 bg-[#EB455F] text-white rounded-md font-semibold hover:bg-[#2B3467] transition duration-150 shadow-md">
                <i class="fas fa-plus mr-2"></i> Tambah Buku Baru
            </a>
        </div>

        {{-- Form Pencarian --}}
        <div class="md:col-span-3 flex gap-2 order-1 md:order-2">
            <input type="text" class="form-input w-full py-2 px-4 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F] transition" placeholder="Cari Judul, Penulis, atau Kategori..." disabled>
            <button class="py-2 px-4 bg-[#2B3467] text-white rounded-md font-semibold hover:bg-[#EB455F] transition duration-150" disabled>
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </div>

    {{-- BOOK LIST TABLE --}}
    <div class="overflow-x-auto rounded-xl border border-[#BAD7E9]">
        <table class="min-w-full bg-white text-sm">
            <thead>
                <tr class="bg-[#2B3467] text-white uppercase text-xs tracking-wider">
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Penulis</th>
                    <th class="px-4 py-3 text-left hidden sm:table-cell">Penerbit</th>
                    <th class="px-4 py-3 text-center hidden md:table-cell">Tahun Terbit</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                
                {{-- BUKU ASLI 1 --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Sejarah Dunia</td>
                    <td class="px-4 py-3">Siti A.</td>
                    <td class="px-4 py-3 hidden sm:table-cell">ABC Publisher</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">2020</td>
                    <td class="px-4 py-3"><span class="bg-[#BAD7E9] text-[#2B3467] px-2 py-0.5 rounded-full text-xs font-semibold">Sejarah</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>
                
                {{-- BUKU ASLI 2 --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Fisika Modern</td>
                    <td class="px-4 py-3">Budi S.</td>
                    <td class="px-4 py-3 hidden sm:table-cell">XYZ Publisher</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">2018</td>
                    <td class="px-4 py-3"><span class="bg-[#BAD7E9] text-[#2B3467] px-2 py-0.5 rounded-full text-xs font-semibold">Fisika</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>

                {{-- BUKU BARU 1 --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Kisah Para Nabi</td>
                    <td class="px-4 py-3">Ahmad Z.</td>
                    <td class="px-4 py-3 hidden sm:table-cell">Muslim Media</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">2022</td>
                    <td class="px-4 py-3"><span class="bg-teal-200 text-teal-800 px-2 py-0.5 rounded-full text-xs font-semibold">Agama</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>

                {{-- BUKU BARU 2 --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Struktur Data Lanjut</td>
                    <td class="px-4 py-3">Cahya N.</td>
                    <td class="px-4 py-3 hidden sm:table-cell">IT Press</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">2023</td>
                    <td class="px-4 py-3"><span class="bg-indigo-200 text-indigo-800 px-2 py-0.5 rounded-full text-xs font-semibold">Komputer</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>
                
                {{-- BUKU BARU 3 --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Menguasai Grammar</td>
                    <td class="px-4 py-3">Devi R.</td>
                    <td class="px-4 py-3 hidden sm:table-cell">Language Pub.</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">2021</td>
                    <td class="px-4 py-3"><span class="bg-pink-200 text-pink-800 px-2 py-0.5 rounded-full text-xs font-semibold">Bahasa</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>

                {{-- BUKU BARU 4 --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Novel Senja</td>
                    <td class="px-4 py-3">Faisal G.</td>
                    <td class="px-4 py-3 hidden sm:table-cell">Sastra Indah</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">2019</td>
                    <td class="px-4 py-3"><span class="bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded-full text-xs font-semibold">Fiksi</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <a href="#" class="py-1 px-3 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600 transition" disabled>Edit</a>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                    </td>
                </tr>
                
                {{-- BUKU BARU 5 --}}
                <tr class="hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Ekonomi Makro</td>
                    <td class="px-4 py-3">Indra L.</td>
                    <td class="px-4 py-3 hidden sm:table-cell">Econ Publishers</td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">2017</td>
                    <td class="px-4 py-3"><span class="bg-lime-200 text-lime-800 px-2 py-0.5 rounded-full text-xs font-semibold">Ekonomi</span></td>
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
            Showing 1 to 7 of 7 entries
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