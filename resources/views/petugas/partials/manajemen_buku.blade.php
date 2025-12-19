@extends('layouts.petugas')

@section('title', 'Manajemen Buku')
@section('page-title', 'Manajemen Buku')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .book-cover-preview { width: 60px; height: 80px; object-fit: cover; border-radius: 4px; }
    .image-upload-preview { max-width: 200px; max-height: 250px; margin-top: 10px; border-radius: 8px; }
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
                    <td>{{ $buku->id_buku }}</td>
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
                            <button class="btn btn-info" onclick="viewBook('{{ $buku->id_buku }}')" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning" onclick="editBook('{{ $buku->id_buku }}')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger" onclick="deleteBook('{{ $buku->id_buku }}', '{{ $buku->judul }}')" title="Hapus">
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

<!-- Add Book Modal - uses petugas routes -->
<div class="modal fade" id="addBookModal" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: var(--dark); color: black;">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Buku Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
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
                            <select class="form-select" id="genreSelectAdd" name="genres[]" multiple>
                                @foreach($genres ?? [] as $genre)
                                    <option value="{{ $genre->id_genre }}">{{ $genre->nama_genre }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Cari dan pilih lebih dari satu genre</small>
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

<!-- Edit Book Modal -->
<div class="modal fade" id="editBookModal" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="editBookContent"></div>
    </div>
</div>

<!-- View Book Modal -->
<div class="modal fade" id="viewBookModal" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="viewBookContent"></div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="true">
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
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#booksTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        order: [[2, 'asc']]
    });
    $('#searchBook').on('keyup', function() { table.search(this.value).draw(); });
    document.addEventListener('show.bs.modal', function () {
        document.body.classList.remove('modal-open');
        document.body.style.overflow = 'auto';
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    });

    if (window.jQuery && $('#genreSelectAdd').length) {
        $('#genreSelectAdd').select2({
            width: '100%',
            placeholder: 'Pilih genre',
            allowClear: true
        });
        $(document).on('shown.bs.modal', '#addBookModal', function () {
            $('#genreSelectAdd').select2('close');
        });
    }
});

function previewImage(event, previewId) {
    const preview = document.getElementById(previewId);
    const file = event.target.files[0];
    if (file) { const reader = new FileReader(); reader.onload = function(e){ preview.src = e.target.result; preview.style.display='block'; }; reader.readAsDataURL(file); }
}

function getRowData(id) {
    const row = Array.from(document.querySelectorAll('#booksTable tbody tr')).find(tr => {
        const kodeCell = tr.querySelector('td:nth-child(2)');
        return kodeCell && kodeCell.textContent.trim() === String(id);
    });
    if (!row) return null;
    const coverEl = row.querySelector('td:nth-child(1) img');
    const judul = row.querySelector('td:nth-child(3)')?.innerText.trim();
    const pengarang = row.querySelector('td:nth-child(4)')?.innerText.trim();
    const penerbit = row.querySelector('td:nth-child(5)')?.innerText.trim();
    const tahun = row.querySelector('td:nth-child(6)')?.innerText.trim();
    const stok = row.querySelector('td:nth-child(7) .badge')?.innerText.trim();
    const cover = coverEl ? coverEl.getAttribute('src') : null;
    return { id, judul, pengarang, penerbit, tahun, stok, cover };
}

function viewBook(id) {
    const data = getRowData(id); if (!data) return;
    const html = `
        <div class=\"modal-header\" style=\"background: var(--dark); color: white;\">
            <h5 class=\"modal-title\"><i class=\"fas fa-eye me-2\"></i>Detail Buku</h5>
            <button type=\"button\" class=\"btn-close btn-close-white\" data-bs-dismiss=\"modal\"></button>
        </div>
        <div class=\"modal-body\">
            <div class=\"row\">
                <div class=\"col-md-4 mb-3\">${data.cover ? `<img src=\"${data.cover}\" class=\"image-upload-preview\" />` : '<div class=\"image-upload-preview bg-light d-flex align-items-center justify-content-center\"><i class=\"fas fa-book fa-2x text-muted\"></i></div>'}</div>
                <div class=\"col-md-8\">
                    <p><strong>Kode:</strong> ${data.id}</p>
                    <p><strong>Judul:</strong> ${data.judul}</p>
                    <p><strong>Pengarang:</strong> ${data.pengarang}</p>
                    <p><strong>Penerbit:</strong> ${data.penerbit}</p>
                    <p><strong>Tahun:</strong> ${data.tahun}</p>
                    <p><strong>Stok:</strong> ${data.stok}</p>
                </div>
            </div>
        </div>
        <div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Tutup</button></div>`;
    document.getElementById('viewBookContent').innerHTML = html;
    new bootstrap.Modal(document.getElementById('viewBookModal')).show();
}

function editBook(id) {
    const data = getRowData(id); if (!data) return;
    const action = `{{ route('petugas.buku.update', ['id_buku' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id);
    const html = `
        <form action=\"${action}\" method=\"POST\" enctype=\"multipart/form-data\">
            @csrf
            @method('PUT')
            <div class=\"modal-header\" style=\"background: var(--dark); color: white;\"><h5 class=\"modal-title\"><i class=\"fas fa-edit me-2\"></i>Edit Buku</h5><button type=\"button\" class=\"btn-close btn-close-white\" data-bs-dismiss=\"modal\"></button></div>
            <div class=\"modal-body\"><div class=\"row\">
                <div class=\"col-md-12 mb-3\"><label class=\"form-label\">Judul Buku <span class=\"text-danger\">*</span></label><input type=\"text\" class=\"form-control\" name=\"judul\" value=\"${data.judul}\" required></div>
                <div class=\"col-md-6 mb-3\"><label class=\"form-label\">Nama Pengarang</label><input type=\"text\" class=\"form-control\" name=\"nama_pengarang\" value=\"${data.pengarang}\"></div>
                <div class=\"col-md-6 mb-3\"><label class=\"form-label\">Penerbit</label><input type=\"text\" class=\"form-control\" name=\"penerbit\" value=\"${data.penerbit}\"></div>
                <div class=\"col-md-4 mb-3\"><label class=\"form-label\">Tahun Terbit</label><input type=\"number\" class=\"form-control\" name=\"tahun_terbit\" value=\"${data.tahun}\"></div>
                <div class=\"col-md-4 mb-3\"><label class=\"form-label\">Stok Tersedia</label><input type=\"number\" class=\"form-control\" name=\"stok_tersedia\" value=\"${data.stok}\"></div>
                <div class=\"col-12 mb-3\"><label class=\"form-label\">Cover Buku</label><input type=\"file\" class=\"form-control\" name=\"gambar\" accept=\"image/*\" onchange=\"previewImage(event, 'editPreview')\"><img id=\"editPreview\" class=\"image-upload-preview\" style=\"display: ${data.cover ? 'block' : 'none'};\" src=\"${data.cover || ''}\"></div>
            </div></div>
            <div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Batal</button><button type=\"submit\" class=\"btn btn-primary\"><i class=\"fas fa-save me-2\"></i>Simpan</button></div>
        </form>`;
    document.getElementById('editBookContent').innerHTML = html;
    new bootstrap.Modal(document.getElementById('editBookModal')).show();
}

function deleteBook(idBuku, judul) {
    document.getElementById('deleteBookTitle').innerText = judul;
    document.getElementById('deleteForm').action = `{{ route('petugas.buku.destroy', ['id_buku' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', idBuku);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
