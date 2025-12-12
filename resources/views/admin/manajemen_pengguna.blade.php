@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
        </button>
    </div>
    <div class="col-md-6">
        <form id="filterForm" action="{{ route('pengelolaan.pengguna') }}" method="GET" class="row g-2">
            <div class="col-md-6">
                <select class="form-select" id="roleFilter" name="role">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ ($currentRole ?? '')==='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ ($currentRole ?? '')==='petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="pengunjung" {{ ($currentRole ?? '')==='pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchUser" name="search" value="{{ $currentSearch ?? '' }}" placeholder="Cari pengguna...">
            </div>
        </form>
    </div>
</div>

<div class="stat-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>
                        <span class="sort-header" data-sort="username" role="button" aria-label="Urutkan berdasarkan NISN/NIP">
                            NISN/NIP
                            @if(($currentSort ?? '')==='username')
                                <i class="fas fa-sort-{{ ($currentDir ?? 'asc')==='asc' ? 'up' : 'down' }} ms-1"></i>
                            @else
                                <i class="fas fa-sort ms-1"></i>
                            @endif
                        </span>
                    </th>
                    <th>
                        <span class="sort-header" data-sort="nama" role="button" aria-label="Urutkan berdasarkan Nama">
                            Nama
                            @if(($currentSort ?? '')==='nama')
                                <i class="fas fa-sort-{{ ($currentDir ?? 'asc')==='asc' ? 'up' : 'down' }} ms-1"></i>
                            @else
                                <i class="fas fa-sort ms-1"></i>
                            @endif
                        </span>
                    </th>
                    <th>
                        <span class="sort-header" data-sort="role" role="button" aria-label="Urutkan berdasarkan Role">
                            Role
                            @if(($currentSort ?? '')==='role')
                                <i class="fas fa-sort-{{ ($currentDir ?? 'asc')==='asc' ? 'up' : 'down' }} ms-1"></i>
                            @else
                                <i class="fas fa-sort ms-1"></i>
                            @endif
                        </span>
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                <tr>
                    <td><strong>{{ $user->username }}</strong></td>
                    <td>{{ $user->nama }}</td>
                    <td>
                        @php
                            // Tampilkan role berbasis kolom yang tersedia
                            $roleLabel = 'Pengunjung';
                            if (isset($user->role) && $user->role) {
                                $roleLabel = $user->role === 'admin' ? 'Admin' : ($user->role === 'petugas' ? 'Petugas' : 'Pengunjung');
                            } else {
                                // Fallback ke tipe_anggota jika kolom role tidak ada
                                if (($user->tipe_anggota ?? '') === 'Admin') {
                                    $roleLabel = 'Admin';
                                } elseif (($user->tipe_anggota ?? '') === 'Petugas') {
                                    $roleLabel = 'Petugas';
                                } else {
                                    $roleLabel = 'Pengunjung';
                                }
                            }
                        @endphp
                        @if($roleLabel === 'Admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($roleLabel === 'Petugas')
                            <span class="badge bg-primary">Petugas</span>
                        @else
                            <span class="badge bg-info">Pengunjung</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-warning" onclick="openEditModal({{ $user->id_user }}, '{{ $user->username }}', '{{ $user->nama }}', '{{ $user->role }}', '{{ $user->tipe_anggota }}', '{{ $user->kelas }}', '{{ $user->status_keanggotaan }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger" onclick="deleteUser({{ $user->id_user }}, '{{ $user->nama }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-users fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Belum ada data pengguna
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pengelolaan.pengguna.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: var(--dark); color: white;">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NISN/NIP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan NISN (siswa) atau NIP (guru/staf)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role Pengguna <span class="text-danger">*</span></label>
                        <select class="form-select" id="roleSelect" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="petugas">Petugas</option>
                            <option value="pengunjung">Pengguna (Pengunjung)</option>
                        </select>
                        <small class="text-muted">Admin tidak dapat ditambah di sini.</small>
                    </div>
                    <div class="mb-3" id="kategoriPengunjungGroup" style="display:none;">
                        <label class="form-label">Tipe Anggota <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategoriPengunjung" name="tipe_anggota">
                            <option value="">Pilih Kategori</option>
                            <option value="Siswa">Siswa</option>
                            <option value="Guru">Guru</option>
                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                            <option value="Staf">Staf</option>
                        </select>
                        <small class="text-muted">Pilih tipe anggota jika role adalah Pengguna.</small>
                    </div>
                    <!-- Hidden field when role is Petugas -->
                    <input type="hidden" name="tipe_anggota" id="tipeAnggotaHidden">
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" name="kelas" placeholder="Contoh: XII IPA 1">
                        <small class="text-muted">Opsional, untuk siswa</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Keanggotaan</label>
                        <select class="form-select" name="status_keanggotaan">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Dibekukan">Dibekukan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="background: var(--dark); color: white;">
                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NISN/NIP</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (opsional)</label>
                        <input type="password" class="form-control" id="editPassword" name="password" placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role Pengguna</label>
                        <select class="form-select" id="editRole" name="role" required>
                            <option value="petugas">Petugas</option>
                            <option value="pengunjung">Pengguna (Pengunjung)</option>
                        </select>
                    </div>
                    <div class="mb-3" id="editKategoriGroup" style="display:none;">
                        <label class="form-label">Tipe Anggota</label>
                        <select class="form-select" id="editTipeAnggota" name="tipe_anggota">
                            <option value="Siswa">Siswa</option>
                            <option value="Guru">Guru</option>
                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                            <option value="Staf">Staf</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="editKelas" name="kelas" placeholder="Contoh: XII IPA 1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Keanggotaan</label>
                        <select class="form-select" id="editStatus" name="status_keanggotaan">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Dibekukan">Dibekukan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
<script>
// Auto-submit filters
document.getElementById('roleFilter')?.addEventListener('change', function() {
    document.getElementById('filterForm')?.submit();
});
// Auto-submit search as you type with debounce
let searchDebounce;
document.getElementById('searchUser')?.addEventListener('input', function() {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(function() {
        document.getElementById('filterForm')?.submit();
    }, 300);
});

// Sort header click handling (toggle dir)
document.querySelectorAll('.sort-header').forEach(function(el){
    el.addEventListener('click', function(){
        const sortKey = el.getAttribute('data-sort');
        const params = new URLSearchParams(window.location.search);
        const currentSort = params.get('sort') || '';
        const currentDir = (params.get('dir') || 'asc').toLowerCase();
        const nextDir = (currentSort === sortKey && currentDir === 'asc') ? 'desc' : 'asc';
        params.set('sort', sortKey);
        params.set('dir', nextDir);
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    });
});
function openEditModal(id, username, nama, role, tipe_anggota, kelas, status) {
    // Set form action
    const form = document.getElementById('editUserForm');
    form.action = `{{ url('/manajemen-pengguna') }}/${id}`;
    // Fill fields
    document.getElementById('editUsername').value = username;
    document.getElementById('editNama').value = nama;
    document.getElementById('editPassword').value = '';
    document.getElementById('editRole').value = role || 'pengunjung';
    document.getElementById('editKelas').value = kelas || '';
    document.getElementById('editStatus').value = status || 'Aktif';

    // Show/hide tipe anggota based on role
    const group = document.getElementById('editKategoriGroup');
    const tipeSelect = document.getElementById('editTipeAnggota');
    if ((role || '').toLowerCase() === 'pengunjung') {
        group.style.display = '';
        tipeSelect.value = tipe_anggota || 'Umum';
        tipeSelect.setAttribute('name', 'tipe_anggota');
        tipeSelect.required = true;
    } else {
        group.style.display = 'none';
        tipeSelect.removeAttribute('name');
        tipeSelect.required = false;
    }

    // Append modal to body and show
    const modalEl = document.getElementById('editUserModal');
    document.body.appendChild(modalEl);
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

// Toggle tipe anggota requirement when role changes in edit modal
document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'editRole') {
        const role = e.target.value || '';
        const group = document.getElementById('editKategoriGroup');
        const tipeSelect = document.getElementById('editTipeAnggota');
        if (role.toLowerCase() === 'pengunjung') {
            group.style.display = '';
            tipeSelect.setAttribute('name', 'tipe_anggota');
            tipeSelect.required = true;
        } else {
            group.style.display = 'none';
            tipeSelect.removeAttribute('name');
            tipeSelect.required = false;
        }
    }
});

function deleteUser(id, nama) {
    if(confirm('Hapus pengguna: ' + nama + '?')) {
        // Submit delete form
        alert('Delete user ID: ' + id);
    }
}

// Ensure modal is appended to <body> so no parent overlay blocks clicks
document.addEventListener('show.bs.modal', function (event) {
    if (event.target && event.target.id === 'addUserModal') {
        try {
            document.body.appendChild(event.target);
        } catch (e) {}
    }
});
// Role/Kategori dynamic mapping to `tipe_anggota`
function updateTipeAnggota() {
    const role = document.getElementById('roleSelect').value;
    const kategoriEl = document.getElementById('kategoriPengunjung');
    const hidden = document.getElementById('tipeAnggotaHidden');
    if (role === 'petugas') {
        document.getElementById('kategoriPengunjungGroup').style.display = 'none';
        // Jangan kirim nilai karena kolom enum tidak punya 'Petugas'
        hidden.value = '';
        // Ensure only hidden is submitted
        hidden.setAttribute('name', 'tipe_anggota');
        kategoriEl.removeAttribute('name');
        kategoriEl.required = false;
    } else if (role === 'pengunjung') {
        document.getElementById('kategoriPengunjungGroup').style.display = '';
        hidden.value = '';
        // Ensure select is submitted and required
        kategoriEl.setAttribute('name', 'tipe_anggota');
        kategoriEl.required = true;
        hidden.removeAttribute('name');
    } else {
        document.getElementById('kategoriPengunjungGroup').style.display = 'none';
        hidden.value = '';
        // Default: neither submitted
        hidden.removeAttribute('name');
        kategoriEl.removeAttribute('name');
        kategoriEl.required = false;
    }
}
document.getElementById('roleSelect')?.addEventListener('change', updateTipeAnggota);
document.getElementById('kategoriPengunjung')?.addEventListener('change', updateTipeAnggota);

// Initialize on modal show
document.addEventListener('show.bs.modal', function (event) {
    if (event.target && event.target.id === 'addUserModal') {
        try { document.body.appendChild(event.target); } catch (e) {}
        setTimeout(updateTipeAnggota, 0);
    }
    if (event.target && event.target.id === 'editUserModal') {
        try { document.body.appendChild(event.target); } catch (e) {}
    }
});
</script>
@endpush

@push('styles')
<style>
/* Ensure modal sits above sidebar/cards and is clickable */
.modal { z-index: 1055; }
.modal-backdrop { z-index: 1050; }
/* Prevent parent containers from blocking clicks over the modal */
.stat-card { position: relative; }
</style>
@endpush