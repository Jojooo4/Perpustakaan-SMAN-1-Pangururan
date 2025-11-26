<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin Perpustakaan')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite('resources/css/app.css') 
</head>
<body class="bg-[#FCFFE7] antialiased">
    
    <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="bg-[#2B3467] text-white p-5 lg:p-0 shadow-lg lg:col-span-1 fixed lg:static w-full lg:w-auto z-50">
            <div class="logo border-b border-white/10 pb-5 mb-5 hidden lg:block">
                <div class="text-2xl font-extrabold flex items-center pt-5 px-5">
                    <i class="fas fa-school text-[#EB455F] mr-3 text-3xl"></i>
                    <span class="tracking-wider">PERPUSKU ADMIN</span>
                </div>
            </div>
            
            <nav class="hidden lg:block">
                <div class="space-y-4">
                    
                    {{-- UTAMA --}}
                    <div class="menu-group">
                        <span class="uppercase text-xs font-semibold text-[#BAD7E9] px-5 mb-1 block">UTAMA</span>
                        <ul>
                            {{-- MENU DASHBOARD --}}
                            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                          {{ request()->routeIs('admin.dashboard') 
                                                ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                                : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                    <i class="fas fa-tachometer-alt w-5 mr-4 text-center"></i> Dashboard
                                </a>
                            </li>
                            
                            {{-- MENU MANAJEMEN BUKU - SEKARANG AKAN AKTIF JIKA ROUTE ADALAH 'buku.index' --}}
                            <li class="{{ request()->routeIs('buku.index') ? 'active' : '' }}">
                                <a href="{{ route('buku.index') }}" 
                                   class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                          {{ request()->routeIs('buku.index') 
                                                ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                                : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                    <i class="fas fa-book w-5 mr-4 text-center"></i> Manajemen Buku
                                </a>
                            </li>
                        </ul>
                    </div>
                    

                    {{-- TRANSAKSI --}}
                    <div class="menu-group">
                        <span class="uppercase text-xs font-semibold text-[#BAD7E9] px-5 mb-1 block">TRANSAKSI</span>
                        <ul>
                            {{-- MENU PINJAM & KEMBALI (Baris yang Diperbarui) --}}
                            <li class="{{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                                <a href="{{ route('transaksi.index') }}" 
                                   class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                          {{ request()->routeIs('transaksi.index') 
                                                ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                                : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                    <i class="fas fa-exchange-alt w-5 mr-4 text-center"></i> Pinjam & Kembali
                                </a>
                            </li>
                            
{{-- MENU PERMINTAAN PERPANJANGAN (Baris yang Diperbarui) --}}
                            <li class="{{ request()->routeIs('perpanjangan.index') ? 'active' : '' }}">
                                <a href="{{ route('perpanjangan.index') }}" 
                                   class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                          {{ request()->routeIs('perpanjangan.index') 
                                                ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                                : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                    <i class="fas fa-clock w-5 mr-4 text-center"></i> Permintaan Perpanjangan
                                </a>
                            </li>
                            
{{-- MENU LAPORAN DENDA (Baris yang Diperbarui) --}}
                            <li class="{{ request()->routeIs('denda.index') ? 'active' : '' }}">
                                <a href="{{ route('denda.index') }}" 
                                   class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                          {{ request()->routeIs('denda.index') 
                                                ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                                : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                    <i class="fas fa-money-check-alt w-5 mr-4 text-center"></i> Laporan Denda
                                </a>
                            </li>
                        </ul>
                    </div>
                    

{{-- PENGELOLAAN --}}
                    <div class="menu-group">
                        <span class="uppercase text-xs font-semibold text-[#BAD7E9] px-5 mb-1 block">PENGELOLAAN</span>
                        <ul>
                            {{-- MENU MANAJEMEN PENGGUNA (Baris yang Diperbarui) --}}
                            <li class="{{ request()->routeIs('pengelolaan.pengguna') ? 'active' : '' }}">
                                <a href="{{ route('pengelolaan.pengguna') }}" 
                                   class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                          {{ request()->routeIs('pengelolaan.pengguna') 
                                                ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                                : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                    <i class="fas fa-users-cog w-5 mr-4 text-center"></i> Manajemen Pengguna
                                </a>
                            </li>
                            
                            {{-- MENU REVIEW & ULASAN (Baris yang Diperbarui) --}}
                            <li class="{{ request()->routeIs('pengelolaan.review') ? 'active' : '' }}">
                                <a href="{{ route('pengelolaan.review') }}" 
                                   class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                          {{ request()->routeIs('pengelolaan.review') 
                                                ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                                : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                    <i class="fas fa-star w-5 mr-4 text-center"></i> Review & Ulasan
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
<div class="mt-8 border-t border-white/10 pt-4">
                    <ul>
                        {{-- MENU PENGATURAN PROFIL (Baris yang Diperbarui) --}}
                        <li class="{{ request()->routeIs('profil.index') ? 'active' : '' }}">
                            <a href="{{ route('profil.index') }}" 
                               class="flex items-center py-3 px-5 transition duration-200 border-l-4 
                                      {{ request()->routeIs('profil.index') 
                                            ? 'bg-white/10 border-[#EB455F] font-medium text-[#FCFFE7]' 
                                            : 'text-[#BAD7E9] border-transparent hover:bg-white/15 hover:border-[#BAD7E9]' }}">
                                <i class="fas fa-user-circle w-5 mr-4 text-center"></i> Pengaturan Profil
                            </a>
                        </li>
                        
                        {{-- MENU LOGOUT (Menggunakan form POST untuk keamanan) --}}
                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center text-[#BAD7E9] py-3 px-5 transition duration-200 hover:bg-white/15 border-l-4 border-transparent hover:border-[#BAD7E9]">
                                <i class="fas fa-sign-out-alt w-5 mr-4 text-center"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Form Logout Tersembunyi --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
            
             {{-- Navigasi Mobile (Perlu diperbarui juga jika menggunakan nav mobile) --}}
             <nav class="lg:hidden">
                <ul class="flex justify-around">
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a href="#" class="flex flex-col items-center text-xs p-2 {{ request()->routeIs('admin.dashboard') ? 'text-[#EB455F] font-bold' : 'text-[#BAD7E9]' }}"><i class="fas fa-tachometer-alt text-lg"></i> Dashboard</a></li>
                    <li class="{{ request()->routeIs('buku.index') ? 'active' : '' }}"><a href="{{ route('buku.index') }}" class="flex flex-col items-center text-xs p-2 {{ request()->routeIs('buku.index') ? 'text-[#EB455F] font-bold' : 'text-[#BAD7E9]' }}"><i class="fas fa-book text-lg"></i> Buku</a></li>
                    <li><a href="#" class="flex flex-col items-center text-xs p-2 text-[#BAD7E9]"><i class="fas fa-exchange-alt text-lg"></i> Transaksi</a></li>
                    <li><a href="#" class="flex flex-col items-center text-xs p-2 text-[#BAD7E9]"><i class="fas fa-users-cog text-lg"></i> Pengguna</a></li>
                    <li><a href="#" class="flex flex-col items-center text-xs p-2 text-[#BAD7E9]"><i class="fas fa-sign-out-alt text-lg"></i> Keluar</a></li>
                </ul>
            </nav>
        </aside>

        {{-- KONTEN UTAMA --}}
        <main class="lg:col-span-1 p-4 lg:p-8 pt-[70px] lg:pt-8">
            <header class="flex justify-between items-center bg-white p-4 lg:p-6 mb-8 rounded-lg shadow-md fixed top-0 left-0 lg:static w-full lg:w-auto z-40 lg:z-auto">
                <h2 class="text-2xl font-semibold text-[#2B3467] hidden lg:block">@yield('title', 'Dashboard')</h2>
                <div class="profile-area flex items-center ml-auto">
                    <div class="admin-info text-right mr-4 hidden sm:block">
                        <span class="block font-semibold text-sm text-[#2B3467]">Admin Perpustakaan</span>
                        <small class="text-xs text-[#BAD7E9]">Admin Utama</small>
                    </div>
                    <img src="https://via.placeholder.com/45/EB455F/fff?text=A" alt="Admin Profile" class="w-11 h-11 rounded-full object-cover border-2 border-[#EB455F] cursor-pointer">
                </div>
                <div class="lg:hidden text-xl font-bold text-[#2B3467]">PERPUSKU</div>
            </header>
            
            @yield('content')
            
        </main>
    </div>
</body>
</html>