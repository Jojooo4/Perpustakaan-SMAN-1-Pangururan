@extends('layouts.admin')

@section('title', 'Laporan Denda')

@section('content')

<h2 class="text-2xl font-bold text-[#2B3467] mb-6"></h2>

<div class="bg-white p-6 rounded-xl shadow-lg">

    {{-- TAB NAVIGATION --}}
    <div class="border-b border-[#BAD7E9] mb-6">
        <nav class="flex space-x-4" role="tablist">
            {{-- Tab 1: Laporan Denda (Default Aktif) --}}
            <button id="tab-laporan" data-tab="laporan" class="tab-button py-2 px-4 font-semibold text-sm transition duration-150 border-b-2 border-[#EB455F] text-[#EB455F]">
                <i class="fas fa-table mr-2"></i> DATA KASUS DENDA (UR 10)
            </button>
            {{-- Tab 2: Pencatatan Denda Baru --}}
            <button id="tab-catat" data-tab="catat" class="tab-button py-2 px-4 font-semibold text-sm transition duration-150 border-b-2 border-transparent text-[#2B3467] hover:border-[#BAD7E9]">
                <i class="fas fa-plus-circle mr-2"></i> CATAT DENDA BARU (UR 12)
            </button>
        </nav>
    </div>

    {{-- TAB CONTENT 1: TABEL LAPORAN DENDA --}}
    <div id="content-laporan" class="tab-content">
        <h3 class="text-xl font-semibold text-[#2B3467] mb-4">Daftar Kasus Denda Aktif & Riwayat</h3>
        
        <form action="{{ route('denda.export') }}" method="POST" class="mb-4 flex justify-between items-center">
            @csrf
            <input type="text" placeholder="Filter ID Transaksi/Anggota..." class="py-2 px-3 border border-[#BAD7E9] rounded-md text-sm w-1/3" disabled>
            
            {{-- Tombol Export Excel (UR 10) --}}
            <button type="submit" class="py-2 px-4 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 disabled:bg-gray-400" disabled>
                <i class="fas fa-file-excel mr-2"></i> Export Laporan (Excel)
            </button>
        </form>

        <div class="overflow-x-auto rounded-xl border border-[#BAD7E9]">
            <table class="min-w-full bg-white text-sm">
                <thead>
                    <tr class="bg-[#2B3467] text-white uppercase text-xs tracking-wider">
                        <th class="px-4 py-3 text-left">ID Kasus</th>
                        <th class="px-4 py-3 text-left">Anggota / Transaksi</th>
                        <th class="px-4 py-3 text-left">Jenis Denda (UR 12)</th>
                        <th class="px-4 py-3 text-center">Jumlah Denda</th>
                        <th class="px-4 py-3 text-center">Status Pembayaran</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Kasus 1: Aktif (Keterlambatan) --}}
                    <tr class="border-b border-[#BAD7E9]/50 hover:bg-red-50/50 transition duration-100 bg-red-100/50">
                        <td class="px-4 py-3 text-[#2B3467]">DND001</td>
                        <td class="px-4 py-3">Budi S. (TRX002)</td>
                        <td class="px-4 py-3 font-medium text-red-600">Keterlambatan (7 Hari)</td>
                        <td class="px-4 py-3 text-center font-bold">Rp 7.000</td>
                        <td class="px-4 py-3 text-center"><span class="bg-red-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">BELUM LUNAS</span></td>
                        <td class="px-4 py-3 text-center space-x-1">
                            <button class="py-1 px-3 bg-green-600 text-white rounded-md text-xs hover:bg-green-700 transition" disabled>Lunasi</button>
                            <button class="py-1 px-3 bg-[#2B3467] text-white rounded-md text-xs hover:bg-gray-700 transition" disabled>Ubah</button>
                        </td>
                    </tr>
                    
                    {{-- Kasus 2: Aktif (Kerusakan) --}}
                    <tr class="border-b border-[#BAD7E9]/50 hover:bg-yellow-50/50 transition duration-100">
                        <td class="px-4 py-3 text-[#2B3467]">DND002</td>
                        <td class="px-4 py-3">Rina M. (TRX010)</td>
                        <td class="px-4 py-3 font-medium text-orange-600">Kerusakan Buku (Cover Sobek)</td>
                        <td class="px-4 py-3 text-center font-bold">Rp 50.000</td>
                        <td class="px-4 py-3 text-center"><span class="bg-red-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">BELUM LUNAS</span></td>
                        <td class="px-4 py-3 text-center space-x-1">
                            <button class="py-1 px-3 bg-green-600 text-white rounded-md text-xs hover:bg-green-700 transition" disabled>Lunasi</button>
                            <button class="py-1 px-3 bg-[#2B3467] text-white rounded-md text-xs hover:bg-gray-700 transition" disabled>Ubah</button>
                        </td>
                    </tr>

                    {{-- Kasus 3: Selesai (Kehilangan) --}}
                    <tr class="hover:bg-[#BAD7E9]/30 transition duration-100">
                        <td class="px-4 py-3 text-[#2B3467]">DND003</td>
                        <td class="px-4 py-3">Faisal G. (TRX015)</td>
                        <td class="px-4 py-3 font-medium text-gray-600">Kehilangan Buku (Ekonomi Makro)</td>
                        <td class="px-4 py-3 text-center">Rp 150.000</td>
                        <td class="px-4 py-3 text-center"><span class="bg-green-600 text-white px-2 py-0.5 rounded-full text-xs font-semibold">LUNAS (10/11/25)</span></td>
                        <td class="px-4 py-3 text-center space-x-1">
                            <button class="py-1 px-3 bg-gray-400 text-white rounded-md text-xs disabled" disabled>Lihat</button>
                            <button class="py-1 px-3 bg-[#EB455F] text-white rounded-md text-xs hover:bg-red-700 transition" disabled>Hapus Log</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    
    {{-- TAB CONTENT 2: FORM PENCATATAN DENDA BARU (UR 12) --}}
    <div id="content-catat" class="tab-content hidden">
        <h3 class="text-xl font-semibold text-[#2B3467] mb-4">Pencatatan Denda Manual (Kehilangan / Kerusakan)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 border border-[#EB455F]/50 rounded-lg bg-[#FCFFE7]/50">
            
            {{-- Kolom Kiri: Transaksi & Anggota --}}
            <div>
                <label for="transaksi_id" class="block text-sm font-medium text-[#2B3467] mb-1">ID Transaksi Terkait</label>
                <input type="text" id="transaksi_id" placeholder="Cari ID Transaksi Aktif..." class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
                <p class="mt-2 text-xs text-green-600">Anggota Terkait: Rina M. (Ekonomi Makro)</p>
                
                <label for="jenis_denda" class="block text-sm font-medium text-[#2B3467] mt-4 mb-1">Jenis Kasus Denda (UR 12)</label>
                <select id="jenis_denda" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
                    <option>Pilih Jenis Denda</option>
                    <option>Kerusakan Buku (Minor)</option>
                    <option>Kerusakan Buku (Mayor/Parah)</option>
                    <option>Kehilangan Buku</option>
                    <option>Denda Keterlambatan (Manual)</option>
                </select>
            </div>

            {{-- Kolom Kanan: Biaya & Keterangan --}}
            <div>
                <label for="jumlah_denda" class="block text-sm font-medium text-[#2B3467] mb-1">Jumlah Biaya Denda (Rp)</label>
                <input type="number" id="jumlah_denda" placeholder="Masukkan jumlah denda..." class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md font-bold text-lg focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled>
                
                <label for="keterangan" class="block text-sm font-medium text-[#2B3467] mt-4 mb-1">Keterangan / Detail Kasus</label>
                <textarea id="keterangan" rows="3" placeholder="Contoh: Cover terlepas di bagian depan..." class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]" disabled></textarea>
            </div>
        </div>

        <div class="mt-6 text-right">
            <button class="py-3 px-6 bg-[#EB455F] text-white font-semibold rounded-md hover:bg-[#2B3467] transition duration-150 shadow-md disabled:bg-gray-400" disabled>
                <i class="fas fa-plus mr-2"></i> Simpan Pencatatan Denda
            </button>
        </div>
    </div>
</div>

<script>
    // Logika Sederhana untuk Tab Switching
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