@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('content')

<h2 class="text-2xl font-bold text-[#2B3467] mb-6"></h2>

<div class="bg-white p-6 rounded-xl shadow-lg">
    
    <div class="mb-5 border-b pb-4 border-[#BAD7E9]">
        <h3 class="text-xl font-semibold text-[#2B3467] uppercase tracking-wider">INFORMASI DASAR & FOTO</h3>
    </div>

    {{-- Pesan Sukses (Biarkan tetap ada sebagai placeholder) --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- PENTING: TAMBAHKAN enctype="multipart/form-data" --}}
    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- LAYOUT 3 KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- KOLOM 1: FOTO PROFIL BARU --}}
            <div class="md:col-span-1 text-center border-r border-[#BAD7E9] pr-6">
                <h4 class="text-md font-semibold text-[#2B3467] mb-3">Foto Profil</h4>
                
                {{-- Placeholder/Tampilan Foto Saat Ini --}}
                <img src="https://via.placeholder.com/150/EB455F/fff?text=ADMIN" 
                     alt="Foto Profil" 
                     class="w-36 h-36 rounded-full object-cover mx-auto border-4 border-[#EB455F] mb-4">
                
                {{-- Input File untuk Upload Foto --}}
                <label class="block text-sm font-medium text-[#2B3467] mb-1 cursor-pointer py-2 px-4 bg-[#BAD7E9] rounded-md hover:bg-[#BAD7E9]/70 transition">
                    <i class="fas fa-camera mr-2"></i> Pilih Foto Baru
                    <input type="file" name="profile_photo" class="hidden" onchange="document.getElementById('file-name').innerText = this.files[0].name">
                </label>
                <p id="file-name" class="mt-2 text-xs text-gray-500 italic">Maks. 2MB (JPG, PNG)</p>
            </div>


            {{-- KOLOM 2: Detail Profil --}}
            <div class="md:col-span-1">
                <h4 class="text-md font-semibold text-[#2B3467] mb-3">Detail Akun</h4>
                
                <label for="name" class="block text-sm font-medium text-[#2B3467] mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="Admin Perpustakaan" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]">
                
                <label for="email" class="block text-sm font-medium text-[#2B3467] mt-4 mb-1">Email (Username)</label>
                <input type="email" id="email" name="email" value="admin@perpus.sch.id" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md bg-[#FCFFE7]" disabled>
                <p class="mt-2 text-xs text-gray-500">Email tidak dapat diubah.</p>
                
                <label for="role" class="block text-sm font-medium text-[#2B3467] mt-4 mb-1">Role</label>
                <input type="text" id="role" value="Admin Utama" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md bg-[#FCFFE7]" disabled>
            </div>

            {{-- KOLOM 3: Pengaturan Password --}}
            <div class="md:col-span-1 border-l border-[#BAD7E9] pl-6">
                <h4 class="text-md font-semibold text-[#2B3467] mb-3">Ubah Password</h4>
                
                <label for="current_password" class="block text-sm font-medium text-[#2B3467] mb-1">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" placeholder="Masukkan password lama" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]">
                
                <label for="new_password" class="block text-sm font-medium text-[#2B3467] mt-4 mb-1">Password Baru</label>
                <input type="password" id="new_password" name="new_password" placeholder="Masukkan password baru" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]">
                
                <label for="new_password_confirmation" class="block text-sm font-medium text-[#2B3467] mt-4 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi password baru" class="w-full py-2 px-3 border border-[#BAD7E9] rounded-md focus:ring-1 focus:ring-[#EB455F] focus:border-[#EB455F]">
            </div>
            
        </div>
        
        <div class="mt-8 border-t pt-6 border-[#BAD7E9] text-right">
            <button type="submit" class="py-3 px-6 bg-[#EB455F] text-white font-semibold rounded-md hover:bg-[#2B3467] transition duration-150 shadow-md">
                <i class="fas fa-sync-alt mr-2"></i> Perbarui Profil
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT SEDERHANA UNTUK MENAMPILKAN NAMA FILE YANG DIPILIH --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('input[name="profile_photo"]');
        const fileNameDisplay = document.getElementById('file-name');

        if (fileInput && fileNameDisplay) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileNameDisplay.innerText = this.files[0].name;
                } else {
                    fileNameDisplay.innerText = 'Maks. 2MB (JPG, PNG)';
                }
            });
        }
    });
</script>

@endsection