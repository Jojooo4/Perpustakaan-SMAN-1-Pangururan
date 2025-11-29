@extends('layouts.admin')

@section('title', 'Manajemen Buku')
@section('page-title', 'Manajemen Buku')

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    .book-cover-preview {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .image-upload-preview {
        max-width: 200px;
        max-height: 250px;
        margin-top: 10px;
        border-radius: 8px;
    }
</style>
@endpush

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
            <i class="fas fa-plus me-2"></i>Tambah Buku
        </button>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" id="searchBook" placeholder="Cari buku...">
        </div>
    </div>
</div>

<div class="stat-card">
    <div class="table-responsive">
        <table class="table table-hover" id="booksTable">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus ?? [] as $buku)
                <tr>
                    <td>
                        @if($buku->gambar)
                            <img src="{{ asset('storage/' . $buku->gambar) }}" class="book-cover-preview" alt="{{ $buku->judul }}">
                        @else
                            <div class="book-cover-preview bg-secondary d-flex align-items-center justify-content-center text-white">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $buku->kode_buku }}</td>
                    <td><strong>{{ $buku->judul }}</strong></td>
                    <td>{{ $buku->nama_pengarang ?? '-' }}</td>
                    <td>{{ $buku->penerbit ?? '-' }}</td>
                    <td>{{ $buku->tahun_terbit ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $buku->stok_tersedia > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $buku->stok_tersedia }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info" onclick="viewBook('{{ $buku->kode_buku }}')" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning" onclick="editBook('{{ $buku->kode_buku }}')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger" onclick="deleteBook('{{ $buku->kode_buku }}', '{{ $buku->judul }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-book-open fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Belum ada data buku
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('buku.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: var(--dark); color: white;">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Buku Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode_buku" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pengarang</label>
                            <input type="text" class="form-control" name="nama_pengarang">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" name="tahun_terbit" min="1900" max="2100">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah Halaman</label>
                            <input type="number" class="form-control" name="jumlah_halaman">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stok Tersedia</label>
                            <input type="number" class="form-control" name="stok_tersedia" value="0">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Cover Buku</label>
                            <input type="file" class="form-control" name="gambar" accept="image/*" onchange="previewImage(event, 'addPreview')">
                            <img id="addPreview" class="image-upload-preview" style="display: none;">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Genre</label>
                            <select class="form-select" name="genres[]" multiple>
                                @foreach($genres ?? [] as $genre)
                                    <option value="{{ $genre->id_genre }}">{{ $genre->nama_genre }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Tekan Ctrl untuk memilih lebih dari satu</small>
                        </div>
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

<!-- Edit Book Modal (will be populated via AJAX) -->
<div class="modal fade" id="editBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="editBookContent">
            <!-- Content loaded via JavaScript -->
        </div>
    </div>
</div>

<!-- View Book Modal -->
<div class="modal fade" id="viewBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="viewBookContent">
            <!-- Content loaded via JavaScript -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus buku:</p>
                <h6 id="deleteBookTitle" class="text-center"></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#booksTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[2, 'asc']]
    });
    
    // Search functionality
    $('#searchBook').on('keyup', function() {
        $('#booksTable').DataTable().search(this.value).draw();
    });
});

function previewImage(event, previewId) {
    const preview = document.getElementById(previewId);
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

function editBook(kodeBuku) {
    // TODO: Load book data via AJAX and populate edit modal
    alert('Edit buku: ' + kodeBuku + '\nFitur ini terhubung ke controller untuk edit data.');
}

function viewBook(kodeBuku) {
    // TODO: Load book details via AJAX
    alert('View detail buku: ' + kodeBuku);
}

function deleteBook(kodeBuku, judul) {
    document.getElementById('deleteBookTitle').innerText = judul;
    document.getElementById('deleteForm').action = '/admin/books/' + kodeBuku;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush