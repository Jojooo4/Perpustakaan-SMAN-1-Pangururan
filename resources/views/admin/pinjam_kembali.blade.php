@extends('layouts.admin')

@section('title', 'Pinjam & Kembali')

@section('content')

<h2 class="text-2xl font-bold text-[#2B3467] mb-6"></h2>

<div class="bg-white p-6 rounded-xl shadow-lg">

    {{-- TAB NAVIGATION --}}
    <div class="border-b border-[#BAD7E9] mb-6">
        <nav class="flex space-x-4" role="tablist">
            {{-- Tab 1: Peminjaman (Default Aktif) --}}
            <button id="tab-peminjaman" data-tab="peminjaman" class="tab-button py-2 px-4 font-semibold text-sm transition duration-150 border-b-2 border-[#EB455F] text-[#EB455F]">
                <i class="fas fa-arrow-up mr-2"></i> PENCATATAN PEMINJAMAN
            </button>
            {{-- Tab 2: Laporan Transaksi --}}
            <button id="tab-laporan" data-tab="laporan" class="tab-button py-2 px-4 font-semibold text-sm transition duration-150 border-b-2 border-transparent text-[#2B3467] hover:border-[#BAD7E9]">
                <i class="fas fa-list-alt mr-2"></i> LAPORAN TRANSAKSI (UR 8)
            </button>
        </nav>
    </div>

    {{-- TAB CONTENT --}}
    
    {{-- CONTENT 1: FORM PEMINJAMAN --}}
    <div id="content-peminjaman" class="tab-content">
        <h3 class="text-xl font-semibold text-[#2B3467] mb-4">Formulir Peminjaman Baru</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 border border-[#BAD7E9] rounded-lg bg-[#FCFFE7]/50">
            
            {{-- Kolom Kiri: Anggota --}}
            <div>
                <label for="member_id" class="block text-sm font-medium text-[#2B3467] mb-1">ID Anggota / Nama Pengunjung</label>
                <input type="text" id="member_id" placeholder="Cari ID atau Nama Anggota..." class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
                <p class="mt-2 text-xs text-green-600">Status: Anggota Aktif Ditemukan (Siti A.)</p>
                <div class="mt-4 p-3 bg-white border border-[#BAD7E9] rounded-md">
                    <p class="text-sm font-medium text-[#2B3467]">Detail Anggota:</p>
                    <ul class="text-xs text-gray-600 list-disc list-inside ml-2">
                        <li>Batas pinjam: 3 Buku</li>
                        <li>Pinjaman aktif: 1 Buku</li>
                        <li>Denda belum lunas: Rp 0</li>
                    </ul>
                </div>
            </div>

            {{-- Kolom Kanan: Buku dan Tanggal --}}
            <div>
                <label for="book_isbn" class="block text-sm font-medium text-[#2B3467] mb-1">ISBN / Judul Buku</label>
                <input type="text" id="book_isbn" placeholder="Cari ISBN atau Judul Buku..." class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
                <p class="mt-2 text-xs text-green-600">Status: Buku 'Sejarah Dunia' Tersedia (Eksemplar 003)</p>
                
                <label for="return_date" class="block text-sm font-medium text-[#2B3467] mt-4 mb-1">Tanggal Pengembalian (Maks 7 Hari)</label>
                <input type="date" id="return_date" value="2025-12-02" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
            </div>
        </div>

        <div class="mt-6 text-right">
            <button class="py-3 px-6 bg-[#EB455F] text-white font-semibold rounded-md hover:bg-[#2B3467] transition duration-150 shadow-md disabled:bg-gray-400" disabled>
                <i class="fas fa-save mr-2"></i> Catat Peminjaman
            </button>
        </div>
    </div>
    
    {{-- CONTENT 2: TABEL LAPORAN TRANSAKSI (UR 8) --}}
    <div id="content-laporan" class="tab-content hidden">
        <h3 class="text-xl font-semibold text-[#2B3467] mb-4">Laporan Transaksi Aktif dan Riwayat</h3>
        
        <div class="mb-4 flex justify-between items-center">
             <input type="text" placeholder="Filter ID/Nama/Judul..." class="py-2 px-3 border border-[#BAD7E9] rounded-md text-sm w-1/3" disabled>
             <button class="py-2 px-4 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 disabled:bg-gray-400" disabled>
                 <i class="fas fa-file-excel mr-2"></i> Export Excel (UR 10)
             </button>
        </div>

        <div class="overflow-x-auto rounded-xl border border-[#BAD7E9]">
            <table class="min-w-full bg-white text-sm">
                <thead>
                    <tr class="bg-[#2B3467] text-white uppercase text-xs tracking-wider">
                        <th class="px-4 py-3 text-left">ID Transaksi</th>
                        <th class="px-4 py-3 text-left">Anggota</th>
                        <th class="px-4 py-3 text-left">Buku (Eksemplar)</th>
                        <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                        <th class="px-4 py-3 text-center">Tgl Kembali (Jatuh Tempo)</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi (UR 8)</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Transaksi Aktif 1 (Jatuh Tempo Belum Lewat) --}}
                    <tr class="border-b border-[#BAD7E9]/50 hover:bg-[#BAD7E9]/30 transition duration-100 bg-yellow-50/50">
                        <td class="px-4 py-3 text-[#2B3467]">TRX001</td>
                        <td class="px-4 py-3">Siti A.</td>
                        <td class="px-4 py-3">Sejarah Dunia (003)</td>
                        <td class="px-4 py-3 text-center">25/11/2025</td>
                        <td class="px-4 py-3 text-center font-medium">02/12/2025</td>
                        <td class="px-4 py-3 text-center"><span class="bg-blue-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Aktif</span></td>
                        <td class="px-4 py-3 text-center space-x-1">
                            <button class="py-1 px-3 bg-green-500 text-white rounded-md text-xs hover:bg-green-600 transition" disabled>Kembalikan</button>
                            <button class="py-1 px-3 bg-red-600 text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                        </td>
                    </tr>
                    
                    {{-- Transaksi Aktif 2 (Terlambat) --}}
                    <tr class="border-b border-[#BAD7E9]/50 hover:bg-red-50 transition duration-100 bg-red-100">
                        <td class="px-4 py-3 text-[#2B3467]">TRX002</td>
                        <td class="px-4 py-3">Budi S.</td>
                        <td class="px-4 py-3">Fisika Modern (001)</td>
                        <td class="px-4 py-3 text-center">15/11/2025</td>
                        <td class="px-4 py-3 text-center font-bold text-red-700">22/11/2025</td>
                        <td class="px-4 py-3 text-center"><span class="bg-red-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Terlambat</span></td>
                        <td class="px-4 py-3 text-center space-x-1">
                            <button class="py-1 px-3 bg-green-500 text-white rounded-md text-xs hover:bg-green-600 transition" disabled>Denda & Kembali</button>
                            <button class="py-1 px-3 bg-red-600 text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                        </td>
                    </tr>
                    
                    {{-- Transaksi Selesai --}}
                    <tr class="hover:bg-[#BAD7E9]/30 transition duration-100">
                        <td class="px-4 py-3 text-[#2B3467]">TRX003</td>
                        <td class="px-4 py-3">Ahmad K.</td>
                        <td class="px-4 py-3">Novel Senja (005)</td>
                        <td class="px-4 py-3 text-center">10/11/2025</td>
                        <td class="px-4 py-3 text-center">17/11/2025</td>
                        <td class="px-4 py-3 text-center"><span class="bg-gray-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Selesai</span></td>
                        <td class="px-4 py-3 text-center space-x-1">
                            <button class="py-1 px-3 bg-gray-500 text-white rounded-md text-xs disabled" disabled>Lihat</button>
                            <button class="py-1 px-3 bg-red-600 text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Logika Sederhana untuk Tab Switching (Bisa dipindahkan ke file JS)
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-button');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-tab');

                // Reset semua tab style
                tabs.forEach(t => {
                    t.classList.remove('border-[#EB455F]', 'text-[#EB455F]');
                    t.classList.add('border-transparent', 'text-[#2B3467]');
                });

                // Set tab yang diklik menjadi aktif
                tab.classList.add('border-[#EB455F]', 'text-[#EB455F]');
                tab.classList.remove('border-transparent', 'text-[#2B3467]');

                // Sembunyikan semua konten dan tampilkan yang sesuai
                contents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById('content-' + target).classList.remove('hidden');
            });
        });
    });
</script>

@endsection