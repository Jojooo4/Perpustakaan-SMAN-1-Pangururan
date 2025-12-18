@extends('layouts.petugas')

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

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true" style="z-index: 1055;" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="approveModalLabel">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Approve Peminjaman
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Ya, Setujui Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true" style="z-index: 1055;" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fas fa-times-circle me-2"></i>Konfirmasi Reject Peminjaman
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Ya, Tolak Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reason Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true" style="z-index: 1055;" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reasonModalLabel">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="reasonText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showApproveModal(id, borrowerName, bookTitle, requestDate) {
    document.getElementById('approveBorrowerName').textContent = borrowerName;
    document.getElementById('approveBookTitle').textContent = bookTitle;
    document.getElementById('approveRequestDate').textContent = requestDate;
    document.getElementById('approveForm').action = `/petugas/request-peminjaman/${id}/approve`;
    new bootstrap.Modal(document.getElementById('approveModal'), { backdrop: false, keyboard: true }).show();
}

function showRejectModal(id, bookTitle) {
    document.getElementById('rejectBookTitle').textContent = bookTitle;
    document.getElementById('rejectForm').action = `/petugas/request-peminjaman/${id}/reject`;
    const textarea = document.querySelector('#rejectForm textarea[name="catatan_admin"]');
    if (textarea) textarea.value = '';
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'), { backdrop: false, keyboard: true });
    modal.show();
}

function showReason(reason) {
    document.getElementById('reasonText').textContent = reason;
    new bootstrap.Modal(document.getElementById('reasonModal'), { backdrop: false, keyboard: true }).show();
}
</script>
@endpush
