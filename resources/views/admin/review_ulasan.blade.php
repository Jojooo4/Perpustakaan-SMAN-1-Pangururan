@extends('layouts.admin')

@section('title', 'Review & Ulasan')

@section('content')

<h2 class="text-2xl font-bold text-[#2B3467] mb-6"></h2>

<div class="bg-white p-6 rounded-xl shadow-lg">

    <div class="flex justify-between items-center mb-5 border-b pb-4 border-[#BAD7E9]">
        <h3 class="text-xl font-semibold text-[#2B3467] uppercase tracking-wider">DAFTAR ULASAN TERBARU</h3>
        <span class="text-sm font-medium text-[#EB455F] bg-[#BAD7E9]/30 px-3 py-1 rounded-full">50 Ulasan Baru</span>
    </div>

    {{-- FILTER DAN SEARCH --}}
    <div class="mb-6 flex justify-between gap-4">
        <input type="text" placeholder="Cari Judul Buku atau Penulis Ulasan..." class="py-2 px-3 border border-[#BAD7E9] rounded-md text-sm w-1/3 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
        
        <select class="py-2 px-3 border border-[#BAD7E9] rounded-md text-sm text-[#2B3467]" disabled>
            <option>Semua Rating</option>
            <option>⭐️⭐️⭐️⭐️⭐️ (5)</option>
            <option>⭐️⭐️⭐️⭐️ (4)</option>
            <option>⭐️⭐️⭐️ (3)</option>
            <option>⭐️⭐️ (2)</option>
            <option>⭐️ (1)</option>
        </select>
    </div>
    
    {{-- REVIEWS LIST --}}
    <div class="space-y-4">
        
        {{-- ULASAN 1 (5 Bintang) --}}
        <div class="p-4 border border-[#BAD7E9] rounded-lg bg-[#FCFFE7]/50 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="text-lg font-bold text-yellow-500">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </span>
                    <p class="text-sm font-semibold text-[#2B3467]">Buku: Sejarah Dunia</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Oleh: Siti A.</p>
                    <p class="text-xs text-gray-500">Tanggal: 24 Nov 2025</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 italic border-l-4 border-green-500 pl-3">
                "Ulasan yang sangat mendalam dan informatif! Penjelasannya sangat mudah dipahami. Rekomendasi wajib untuk semua anggota."
            </p>
            <div class="mt-3 text-right">
                <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus Ulasan</button>
            </div>
        </div>

        {{-- ULASAN 2 (3 Bintang) --}}
        <div class="p-4 border border-[#BAD7E9] rounded-lg bg-[#FCFFE7]/50 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="text-lg font-bold text-yellow-500">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </span>
                    <p class="text-sm font-semibold text-[#2B3467]">Buku: Fisika Modern</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Oleh: Budi S.</p>
                    <p class="text-xs text-gray-500">Tanggal: 20 Nov 2025</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 italic border-l-4 border-orange-500 pl-3">
                "Buku ini bagus, tetapi beberapa bab awal kurang terstruktur. Cukup membantu untuk kuliah, tapi perlu revisi."
            </p>
            <div class="mt-3 text-right">
                <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus Ulasan</button>
            </div>
        </div>
        
        {{-- ULASAN 3 (1 Bintang) --}}
        <div class="p-4 border border-[#EB455F]/50 rounded-lg bg-[#FCFFE7]/50 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="text-lg font-bold text-yellow-500">
                        <i class="fas fa-star"></i>
                    </span>
                    <p class="text-sm font-semibold text-[#2B3467]">Buku: Ekonomi Makro</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Oleh: Pengunjung Anonim</p>
                    <p class="text-xs text-gray-500">Tanggal: 18 Nov 2025</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 italic border-l-4 border-red-500 pl-3">
                "Kondisi buku sangat buruk saat dipinjam, banyak coretan. Mohon petugas dicek sebelum dipinjamkan."
            </p>
            <div class="mt-3 text-right">
                <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus Ulasan</button>
            </div>
        </div>

    </div>

</div>
@endsection