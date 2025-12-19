@extends('layouts.petugas')

@section('title', 'Pinjam & Kembali')
@section('page-title', 'Manajemen Peminjaman')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoanModal">
            <i class="fas fa-plus me-2"></i>Pinjam Buku
        </button>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="Dipinjam">Dipinjam</option>
            <option value="Dikembalikan">Dikembalikan</option>
            <option value="Terlambat">Terlambat</option>
        </select>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" id="searchLoan" placeholder="Cari peminjam...">
    </div>
</div>

<div class="stat-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman ?? [] as $p)
                <tr>
                    <td>{{ $p->id_peminjaman }}</td>
                    <td><strong>{{ $p->user->nama ?? '-' }}</strong></td>
                    <td>{{ $p->asetBuku->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                    <td>{{ $p->tanggal_jatuh_tempo ? $p->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                    <td>{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($p->status_peminjaman == 'Dipinjam')
                            <span class="badge bg-warning">Dipinjam</span>
                        @elseif($p->status_peminjaman == 'Dikembalikan')
                            <span class="badge bg-success">Dikembalikan</span>
                        @else
                            <span class="badge bg-danger">Terlambat</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $displayDenda = $p->denda;
                            if ($p->status_peminjaman == 'Dipinjam' && \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->isPast()) {
                                $dendaPerHari = DB::table('aturan_perpustakaan')->where('nama_aturan', 'denda_per_hari')->value('isi_aturan') ?? 500;
                                $hariTerlambat = max(0, now()->diffInDays($p->tanggal_jatuh_tempo, false) * -1);
                                $displayDenda = $hariTerlambat * $dendaPerHari;
                            }
                        @endphp
                        @if($displayDenda > 0)
                            <span class="text-danger fw-bold">
                                Rp {{ number_format($displayDenda, 0, ',', '.') }}
                                @if($p->status_peminjaman == 'Dipinjam')
                                    <small class="d-block text-muted">(Berjalan)</small>
                                @endif
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status_peminjaman == 'Dipinjam')
                            <button type="button" class="btn btn-success btn-sm" onclick="returnBook({{ $p->id_peminjaman }})">
                                <i class="fas fa-check me-1"></i>Kembalikan
                            </button>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-check me-1"></i>Selesai
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-exchange-alt fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Belum ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Loan Modal -->
<div class="modal fade" id="addLoanModal" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('petugas.transaksi.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: var(--dark); color: white;">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Pinjam Buku</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Peminjam <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_user" required>
                            <option value="">Pilih Peminjam</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id_user }}">{{ $user->nama }} ({{ $user->username }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <select class="form-select" id="selectBuku" required>
                            <option value="">Pilih Judul Buku</option>
                            @foreach($bukus ?? [] as $buku)
                                <option value="{{ $buku->id_buku }}">{{ $buku->judul }} - {{ $buku->nama_pengarang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="asetContainer" style="display:none;">
                        <label class="form-label">Nomor Inventaris <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_aset" id="selectAset" required>
                            <option value="">Pilih Nomor Inventaris</option>
                        </select>
                        <small class="text-muted">Pilih judul buku terlebih dahulu</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lama Peminjaman (Hari) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="lama_pinjam" min="1" max="14" value="7" required>
                        <small class="text-muted">Maksimal 14 hari</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Pinjam</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Modal (Not Bootstrap) - Konfirmasi Pengembalian -->
<div id="customReturnModal" class="custom-modal">
    <div class="custom-modal-overlay"></div>
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5>
                <i class="fas fa-undo me-2"></i>Konfirmasi Pengembalian Buku
            </h5>
            <button class="custom-close-btn" type="button" onclick="closeReturnModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div class="payment-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mt-4 mb-2">Yakin ingin mengembalikan buku ini?</h5>
            <p class="text-muted">Denda akan dihitung otomatis jika peminjaman terlambat.</p>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-secondary px-4" type="button" onclick="closeReturnModal()">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button class="btn btn-success px-4" type="button" onclick="confirmReturnBook()">
                <i class="fas fa-check me-2"></i>Ya, Kembalikan
            </button>
        </div>
        <form id="returnConfirmForm" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 99999;
    align-items: center;
    justify-content: center;
}

.custom-modal.show {
    display: flex !important;
}

.custom-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1;
}

.custom-modal-content {
    position: relative;
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    z-index: 2;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.custom-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
    border-radius: 20px 20px 0 0;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.custom-modal-header h5 {
    margin: 0;
    font-weight: 600;
}

.custom-close-btn {
    background: transparent;
    border: none;
    color: white;
    font-size: 2rem;
    line-height: 1;
    cursor: pointer;
    padding: 0;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.custom-close-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

.custom-modal-body {
    padding: 2rem;
    text-align: center;
}

.payment-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}

.payment-icon i {
    font-size: 2.5rem;
    color: white;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
    50% { box-shadow: 0 0 0 15px rgba(102, 126, 234, 0); }
    100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
}

.custom-modal-footer {
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
    border-top: 1px solid #e9ecef;
}

body.modal-open {
    overflow: hidden;
}
</style>
@endpush

@push('scripts')
<script>
// Keep page scrollable when modals show (no backdrop)
document.addEventListener('show.bs.modal', function () {
  document.body.classList.remove('modal-open');
  document.body.style.overflow = 'auto';
  document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
});

// 2-Step Book Selection
document.getElementById('selectBuku').addEventListener('change', function() {
  const bukuId = this.value;
  const asetContainer = document.getElementById('asetContainer');
  const selectAset = document.getElementById('selectAset');
  if (bukuId) {
    selectAset.innerHTML = '<option value="">Loading...</option>';
    asetContainer.style.display = 'block';
    fetch(`/api/aset-buku/${bukuId}`)
      .then(r => r.json())
      .then(data => {
        selectAset.innerHTML = '<option value="">Pilih Nomor Inventaris</option>';
        if (data.length > 0) {
          data.forEach(aset => {
            const option = document.createElement('option');
            option.value = aset.id_aset;
            option.textContent = `${aset.nomor_inventaris} - ${aset.kondisi_buku}`;
            selectAset.appendChild(option);
          });
        } else {
          selectAset.innerHTML = '<option value="">Tidak ada aset tersedia</option>';
        }
      })
      .catch(() => { selectAset.innerHTML = '<option value="">Error loading aset</option>'; });
  } else {
    asetContainer.style.display = 'none';
    selectAset.innerHTML = '<option value="">Pilih Nomor Inventaris</option>';
  }
});

function returnBook(id) {
    selectedReturnId = id;
    openReturnModal();
}

let selectedReturnId = null;

function openReturnModal() {
    const modal = document.getElementById('customReturnModal');
    if (!modal) return;
    modal.classList.add('show');
    document.body.classList.add('modal-open');
}

function closeReturnModal() {
    const modal = document.getElementById('customReturnModal');
    if (!modal) return;
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    selectedReturnId = null;
}

function confirmReturnBook() {
    const id = selectedReturnId;
    if (!id) return;

    // Build action URL (admin vs petugas) before closing modal (close resets selectedReturnId)
    const currentPath = window.location.pathname;
    const isPetugas = currentPath.includes('/petugas/');
    const actionUrl = isPetugas
        ? ('/petugas/transaksi/' + id + '/kembali')
        : ('/pinjam-kembali/' + id + '/kembali');

    closeReturnModal();

    const form = document.getElementById('returnConfirmForm');
    if (!form) return;
    form.action = actionUrl;
    form.submit();
}

// Close modal when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('customReturnModal');
    const overlay = modal?.querySelector('.custom-modal-overlay');
    if (overlay) overlay.addEventListener('click', closeReturnModal);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeReturnModal();
    });
});

// Simple client-side filtering by status and borrower name
document.addEventListener('DOMContentLoaded', function() {
  const statusFilter = document.getElementById('statusFilter');
  const searchLoan = document.getElementById('searchLoan');
  const rows = Array.from(document.querySelectorAll('table tbody tr'));
  function applyFilters() {
    const status = statusFilter.value.trim().toLowerCase();
    const q = (searchLoan.value || '').trim().toLowerCase();
    rows.forEach(tr => {
      const borrower = tr.querySelector('td:nth-child(2)')?.innerText.toLowerCase() || '';
      const statusText = tr.querySelector('td:nth-child(7) .badge')?.innerText.toLowerCase() || '';
      const matchStatus = status === '' || statusText === status;
      const matchSearch = q === '' || borrower.includes(q);
      tr.style.display = (matchStatus && matchSearch) ? '' : 'none';
    });
  }
  statusFilter.addEventListener('change', applyFilters);
  searchLoan.addEventListener('input', applyFilters);
});
</script>
@endpush
