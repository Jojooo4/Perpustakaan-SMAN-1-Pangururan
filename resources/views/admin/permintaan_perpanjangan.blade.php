@extends('layouts.admin')

@section('title', 'Permintaan Perpanjangan')

@section('content')

<h2 class="text-2xl font-bold text-[#2B3467] mb-6"></h2>

<div class="bg-white p-6 rounded-xl shadow-lg">

    {{-- HEADER DAN JUMLAH DATA --}}
    <div class="flex justify-between items-center mb-5 border-b pb-4 border-[#BAD7E9]">
        <h3 class="text-xl font-semibold text-[#2B3467] uppercase tracking-wider">ANTRIAN PERMINTAAN</h3>
        <span class="text-sm font-medium text-[#EB455F] bg-[#BAD7E9]/30 px-3 py-1 rounded-full">Total Antrian: 4</span>
    </div>

    {{-- FILTER DAN SEARCH --}}
    <div class="mb-6 flex justify-between gap-4">
        <input type="text" placeholder="Cari ID Anggota atau Judul Buku..." class="py-2 px-3 border border-[#BAD7E9] rounded-md text-sm w-1/3 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
        
        <select class="py-2 px-3 border border-[#BAD7E9] rounded-md text-sm text-[#2B3467]" disabled>
            <option>Semua Status</option>
            <option>Menunggu Persetujuan</option>
            <option>Ditolak</option>
        </select>
    </div>

    {{-- REQUESTS TABLE --}}
    <div class="overflow-x-auto rounded-xl border border-[#BAD7E9]">
        <table class="min-w-full bg-white text-sm">
            <thead>
                <tr class="bg-[#2B3467] text-white uppercase text-xs tracking-wider">
                    <th class="px-4 py-3 text-left">ID Transaksi</th>
                    <th class="px-4 py-3 text-left">Anggota (ID)</th>
                    <th class="px-4 py-3 text-left">Buku</th>
                    <th class="px-4 py-3 text-center">Tgl Jatuh Tempo Lama</th>
                    <th class="px-4 py-3 text-center">Durasi Tambahan</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi (UR 9)</th>
                </tr>
            </thead>
            <tbody>
                
                {{-- PERMINTAAN 1: Menunggu Persetujuan (Perpanjangan ke 1) --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100 bg-yellow-50/50">
                    <td class="px-4 py-3 text-[#2B3467]">TRX005</td>
                    <td class="px-4 py-3">Siti A. (A001)</td>
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Struktur Data Lanjut</td>
                    <td class="px-4 py-3 text-center">02/12/2025</td>
                    <td class="px-4 py-3 text-center font-bold text-[#EB455F]">+7 Hari</td>
                    <td class="px-4 py-3 text-center"><span class="bg-yellow-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Menunggu</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <button class="py-1 px-3 bg-green-600 text-white rounded-md text-xs hover:bg-green-700 transition" disabled>Setujui</button>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Tolak</button>
                    </td>
                </tr>

                {{-- PERMINTAAN 2: Ditolak (Sudah pernah diperpanjang) --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100">
                    <td class="px-4 py-3 text-[#2B3467]">TRX003</td>
                    <td class="px-4 py-3">Ahmad K. (A003)</td>
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Novel Senja</td>
                    <td class="px-4 py-3 text-center">15/11/2025</td>
                    <td class="px-4 py-3 text-center font-medium">+3 Hari</td>
                    <td class="px-4 py-3 text-center"><span class="bg-gray-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Ditolak</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <button class="py-1 px-3 bg-gray-400 text-white rounded-md text-xs disabled" disabled>Setujui</button>
                        <button class="py-1 px-3 bg-red-600 text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus Log</button>
                    </td>
                </tr>

                {{-- PERMINTAAN 3: Terlambat (Permintaan tidak valid) --}}
                <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100 bg-red-50/50">
                    <td class="px-4 py-3 text-[#2B3467]">TRX002</td>
                    <td class="px-4 py-3">Budi S. (A002)</td>
                    <td class="px-4 py-3 font-medium text-[#2B3467]">Fisika Modern</td>
                    <td class="px-4 py-3 text-center font-bold text-red-700">22/11/2025</td>
                    <td class="px-4 py-3 text-center font-medium">+7 Hari</td>
                    <td class="px-4 py-3 text-center"><span class="bg-red-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Terlambat</span></td>
                    <td class="px-4 py-3 text-center space-x-1">
                        <button class="py-1 px-3 bg-gray-400 text-white rounded-md text-xs disabled" disabled>Denda Dulu</button>
                        <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Tolak</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="flex justify-between items-center mt-5 text-sm">
        <div class="text-[#2B3467]">
            Showing 1 to 3 of 4 requests
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