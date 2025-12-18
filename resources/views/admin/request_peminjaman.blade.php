@extends('layouts.admin')

@section('title', 'Request Peminjaman')
@section('page-title', 'Request Peminjaman Buku')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <div class="stat-card">
            <h6 class="mb-0">Request Pending</h6>
            <h3 class="mb-0 text-warning">{{ $pendingCount }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <select class="form-select" onchange="window.location.href='?status='+this.value">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
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
                    <th>Tanggal Request</th>
                    <th>Status</th>
                    <th>Diproses Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td>{{ $req->id_request }}</td>
                    <td><strong>{{ $req->user->nama ?? '-' }}</strong></td>
                    <td>
                        @if($req->buku)
                            {{ $req->buku->judul }}
                        @else
                            <span class="text-danger">Buku tidak ditemukan (ID: {{ $req->id_buku }})</span>
                        @endif
                    </td>
                    <td>{{ $req->tanggal_request ? \Carbon\Carbon::parse($req->tanggal_request)->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        @if($req->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($req->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($req->diproses_oleh)
                            {{ $req->diproses->nama ?? '-' }}
                            <br><small class="text-muted">{{ $req->tanggal_diproses ? \Carbon\Carbon::parse($req->tanggal_diproses)->format('d/m/Y H:i') : '' }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($req->status == 'pending')
                            @if($req->buku)
                                <button class="btn btn-success btn-sm me-1" onclick="showApproveModal({{ $req->id_request }}, '{{ addslashes($req->user->nama) }}', '{{ addslashes($req->buku->judul) }}', '{{ $req->tanggal_request ? \Carbon\Carbon::parse($req->tanggal_request)->format('d/m/Y H:i') : '-' }}')">
                                    <i class="fas fa-check me-1"></i>Approve
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="showRejectModal({{ $req->id_request }}, '{{ addslashes($req->buku->judul) }}')">
                                    <i class="fas fa-times me-1"></i>Reject
                                </button>
                            @else
                                <span class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Data buku hilang</span>
                            @endif
                        @else
                            @if($req->status == 'ditolak' && $req->catatan_admin)
                                <button class="btn btn-sm btn-secondary" onclick="showReason('{{ addslashes($req->catatan_admin) }}')">
                                    <i class="fas fa-info-circle"></i> Lihat Alasan
                                </button>
                            @else
                                <span class="text-muted">Sudah diproses</span>
                            @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Tidak ada request peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $requests->appends(request()->query())->links() }}
</div>

<!-- Approve Modal (Custom) -->
<div class="custom-modal-overlay" id="approveModal">
    <div class="custom-modal-content">
        <form id="approveForm" method="POST">
            @csrf
            <div class="custom-modal-header success">
                <h5><i class="fas fa-check-circle me-2"></i>Konfirmasi Approve Peminjaman</h5>
                <button type="button" class="custom-modal-close" onclick="closeModal('approveModal')">&times;</button>
            </div>
            <div class="custom-modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Pastikan data berikut sudah benar sebelum menyetujui peminjaman.
                </div>
                
                <div class="mb-3">
                    <label class="fw-bold text-muted small">Peminjam:</label>
                    <p class="mb-0" id="approveBorrowerName"></p>
                </div>
                
                <div class="mb-3">
                    <label class="fw-bold text-muted small">Buku:</label>
                    <p class="mb-0" id="approveBookTitle"></p>
                </div>
                
                <div class="mb-3">
                    <label class="fw-bold text-muted small">Tanggal Request:</label>
                    <p class="mb-0" id="approveRequestDate"></p>
                </div>
                
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-calendar-check me-2"></i>
                    <small>Periode peminjaman: <strong>7 hari</strong> dari hari ini</small>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="custom-modal-btn secondary" onclick="closeModal('approveModal')">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" class="custom-modal-btn success">
                    <i class="fas fa-check me-1"></i>Ya, Setujui Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal (Custom) -->
<div class="custom-modal-overlay" id="rejectModal">
    <div class="custom-modal-content">
        <form id="rejectForm" method="POST">
            @csrf
            <div class="custom-modal-header danger">
                <h5><i class="fas fa-times-circle me-2"></i>Konfirmasi Reject Peminjaman</h5>
                <button type="button" class="custom-modal-close" onclick="closeModal('rejectModal')">&times;</button>
            </div>
            <div class="custom-modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Request akan ditolak. Berikan alasan yang jelas.
                </div>

                <div class="mb-3">
                    <label class="fw-bold text-muted small">Buku:</label>
                    <p class="mb-0"><strong id="rejectBookTitle"></strong></p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="catatan_admin" rows="4" required placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="custom-modal-btn secondary" onclick="closeModal('rejectModal')">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" class="custom-modal-btn danger">
                    <i class="fas fa-times me-1"></i>Ya, Tolak Request
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reason Modal (Custom) -->
<div class="custom-modal-overlay" id="reasonModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5>Alasan Penolakan</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('reasonModal')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <p id="reasonText"></p>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="custom-modal-btn secondary" onclick="closeModal('reasonModal')">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ===== CUSTOM MODAL STYLES ===== */
.custom-modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 99998;
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(4px);
}

.custom-modal-overlay.show {
    display: flex;
    opacity: 1;
    align-items: center;
    justify-content: center;
}

.custom-modal-content {
    position: relative;
    background: white;
    border-radius: 15px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    animation: modalSlideIn 0.3s ease;
    z-index: 99999;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.custom-modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 15px 15px 0 0;
}

.custom-modal-header.success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border-bottom: none;
}

.custom-modal-header.danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border-bottom: none;
}

.custom-modal-header h5 {
    margin: 0;
    font-weight: 600;
}

.custom-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: inherit;
    padding: 0;
    line-height: 1;
}

.custom-modal-body {
    padding: 1.5rem;
}

.custom-modal-footer {
    padding: 1.5rem;
    text-align: right;
    border-top: 1px solid #f0f0f0;
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.custom-modal-btn {
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
}

.custom-modal-btn.primary {
    background: #2b3458;
    color: white;
}

.custom-modal-btn.primary:hover {
    background: #1a1f2e;
    transform: translateY(-2px);
}

.custom-modal-btn.secondary {
    background: #e9ecef;
    color: #333;
}

.custom-modal-btn.secondary:hover {
    background: #dee2e6;
}

.custom-modal-btn.success {
    background: #28a745;
    color: white;
}

.custom-modal-btn.success:hover {
    background: #218838;
}

.custom-modal-btn.danger {
    background: #dc3545;
    color: white;
}

.custom-modal-btn.danger:hover {
    background: #c82333;
}
</style>
@endpush

@push('scripts')
<script>
// Custom Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking on overlay
document.addEventListener('DOMContentLoaded', function() {
    ['approveModal', 'rejectModal', 'reasonModal'].forEach(modalId => {
        const overlay = document.getElementById(modalId);
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeModal(modalId);
                }
            });
        }
    });

    // ESC key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('approveModal');
            closeModal('rejectModal');
            closeModal('reasonModal');
        }
    });
});

function showApproveModal(id, borrowerName, bookTitle, requestDate) {
    document.getElementById('approveBorrowerName').textContent = borrowerName;
    document.getElementById('approveBookTitle').textContent = bookTitle;
    document.getElementById('approveRequestDate').textContent = requestDate;
    document.getElementById('approveForm').action = `/request-peminjaman/${id}/approve`;
    openModal('approveModal');
}

function showRejectModal(id, bookTitle) {
    document.getElementById('rejectBookTitle').textContent = bookTitle;
    document.getElementById('rejectForm').action = `/request-peminjaman/${id}/reject`;
    const textarea = document.querySelector('#rejectForm textarea[name="catatan_admin"]');
    if (textarea) textarea.value = '';
    openModal('rejectModal');
}

function showReason(reason) {
    document.getElementById('reasonText').textContent = reason;
    openModal('reasonModal');
}
</script>
@endpush
