@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')

    {{-- RINGKASAN STATISTIK (CARDS) --}}
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Card Total Judul Buku --}}
        <div class="flex items-center bg-white p-5 rounded-xl shadow-lg transition duration-300 hover:shadow-xl transform hover:-translate-y-1 relative group overflow-hidden">
            <div class="absolute inset-0 bg-[#EB455F] opacity-0 group-hover:opacity-5 transition duration-300"></div>
            <div class="shrink-0 w-16 h-16 rounded-full bg-[#EB455F] flex justify-center items-center text-white text-3xl mr-4">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="z-10">
                <p class="text-4xl font-bold text-[#2B3467]">2,500</p>
                <h3 class="text-sm text-[#BAD7E9] font-medium mt-1">Total Judul Buku</h3>
            </div>
        </div>
        
        {{-- Card Peminjaman Aktif --}}
        <div class="flex items-center bg-white p-5 rounded-xl shadow-lg transition duration-300 hover:shadow-xl transform hover:-translate-y-1 relative group overflow-hidden">
            <div class="absolute inset-0 bg-[#2B3467] opacity-0 group-hover:opacity-5 transition duration-300"></div>
            <div class="shrink-0 w-16 h-16 rounded-full bg-[#2B3467] flex justify-center items-center text-white text-3xl mr-4">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="z-10">
                <p class="text-4xl font-bold text-[#2B3467]">120</p>
                <h3 class="text-sm text-[#BAD7E9] font-medium mt-1">Peminjaman Aktif Saat Ini</h3>
            </div>
        </div>
        
        {{-- Card Jumlah Anggota --}}
        <div class="flex items-center bg-white p-5 rounded-xl shadow-lg transition duration-300 hover:shadow-xl transform hover:-translate-y-1 relative group overflow-hidden">
            <div class="absolute inset-0 bg-[#BAD7E9] opacity-0 group-hover:opacity-5 transition duration-300"></div>
            <div class="shrink-0 w-16 h-16 rounded-full bg-[#BAD7E9] flex justify-center items-center text-[#2B3467] text-3xl mr-4">
                <i class="fas fa-users"></i>
            </div>
            <div class="z-10">
                <p class="text-4xl font-bold text-[#2B3467]">850</p>
                <h3 class="text-sm text-[#BAD7E9] font-medium mt-1">Jumlah Anggota Aktif</h3>
            </div>
        </div>
        
        {{-- Card Kasus Denda --}}
        <div class="flex items-center bg-white p-5 rounded-xl shadow-lg transition duration-300 hover:shadow-xl transform hover:-translate-y-1 relative group overflow-hidden">
            <div class="absolute inset-0 bg-red-600 opacity-0 group-hover:opacity-5 transition duration-300"></div>
            <div class="shrink-0 w-16 h-16 rounded-full bg-red-600 flex justify-center items-center text-white text-3xl mr-4">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="z-10">
                <p class="text-4xl font-bold text-[#2B3467]">15</p>
                <h3 class="text-sm text-[#BAD7E9] font-medium mt-1">Kasus Denda Belum Selesai</h3>
            </div>
        </div>
    </section>
    {{-- END RINGKASAN STATISTIK --}}

    {{-- GRAFIK & LAPORAN TAMBAHAN --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Grafik Tren Peminjaman --}}
        <div class="report-box bg-white p-6 rounded-xl shadow-md lg:col-span-2">
            <h3 class="text-lg font-semibold text-[#2B3467] border-b pb-3 mb-5 border-[#BAD7E9]">Grafik Tren Peminjaman (6 Bulan)</h3>
            <div class="placeholder-chart h-80 bg-[#FCFFE7] border border-[#BAD7E9] flex justify-center items-center text-[#BAD7E9] italic rounded-md text-sm">
                <p>Placeholder: Area untuk Chart.js/ApexCharts</p>
            </div>
        </div>

        {{-- Permintaan Perpanjangan (Tabel) --}}
        <div class="report-box bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-semibold text-[#2B3467] border-b pb-3 mb-5 border-[#BAD7E9]">Permintaan Perpanjangan (3 Terbaru)</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-[#2B3467]">
                    <thead class="text-xs text-[#2B3467] uppercase bg-[#BAD7E9]/50">
                        <tr><th class="py-2 px-1">Anggota</th><th class="py-2 px-1">Buku</th><th class="py-2 px-1 text-center">Aksi</th></tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/20"><td>Siti A.</td><td>Sejarah Dunia</td><td class="text-center"><button class="btn bg-[#EB455F] text-white hover:bg-[#2B3467] px-3 py-1 rounded-md text-xs transition duration-150">Setujui</button></td></tr>
                        <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/20"><td>Budi S.</td><td>Fisika Modern</td><td class="text-center"><button class="btn bg-[#EB455F] text-white hover:bg-[#2B3467] px-3 py-1 rounded-md text-xs transition duration-150">Setujui</button></td></tr>
                        <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/20"><td>Ahmad K.</td><td>Novel X</td><td class="text-center"><button class="btn bg-[#EB455F] text-white hover:bg-[#2B3467] px-3 py-1 rounded-md text-xs transition duration-150">Setujui</button></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Review Terbaru --}}
        <div class="report-box bg-white p-6 rounded-xl shadow-md lg:col-span-1">
            <h3 class="text-lg font-semibold text-[#2B3467] border-b pb-3 mb-5 border-[#BAD7E9]">Review Terbaru</h3>
            <ul class="divide-y divide-[#BAD7E9]">
                <li class="py-2 flex justify-between items-center text-sm text-[#2B3467]">
                    <div><i class="fas fa-star text-yellow-500 mr-2"></i> "Sangat informatif!"</div>
                    <small class="italic text-[#BAD7E9]">Buku X</small>
                </li>
                <li class="py-2 flex justify-between items-center text-sm text-[#2B3467]">
                    <div><i class="fas fa-star text-yellow-500 mr-2"></i> "Ceritanya bagus"</div>
                    <small class="italic text-[#BAD7E9]">Buku Y</small>
                </li>
                <li class="py-2 flex justify-between items-center text-sm text-[#2B3467]">
                    <div><i class="fas fa-star text-yellow-500 mr-2"></i> "Kurang lengkap"</div>
                    <small class="italic text-[#BAD7E9]">Buku Z</small>
                </li>
            </ul>
        </div>
        
    </section>
    {{-- END GRAFIK & LAPORAN TAMBAHAN --}}

@endsection