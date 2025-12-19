@extends('layouts.admin')

@section('title', 'Permintaan Perpanjangan')
@section('page-title', 'Permintaan Perpanjangan')

@section('content')
<div class="stat-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Jatuh Tempo Lama</th>
                    <th>Jatuh Tempo Baru</th>
                    <th>Alasan</th>
                    <th>Tanggal Request</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests ?? [] as $req)
                <tr>
                    <td>{{ $req->id_request }}</td>
                    <td><strong>{{ $req->peminjaman->user->nama ?? '-' }}</strong></td>
                    <td>{{ $req->peminjaman->asetBuku->buku->judul ?? '-' }}</td>
                    <td>{{ $req->peminjaman->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($req->peminjaman->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $req->tanggal_perpanjangan_baru ? \Carbon\Carbon::parse($req->tanggal_perpanjangan_baru)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $req->catatan ?? '-' }}</td>
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
                        @if($req->status == 'pending')
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-success" onclick="showApproveModal({{ $req->id_request }})">
                                    <i class="fas fa-check"></i> Setuju
                                </button>
                                <button class="btn btn-danger" onclick="showRejectModal({{ $req->id_request }})">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                        @else
                            <span class="text-muted">Sudah diproses</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-clock fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Tidak ada permintaan perpanjangan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Custom Approve Modal (style follows laporan denda popup) -->
<div id="customApproveModal" class="custom-modal" aria-hidden="true">
    <div class="custom-modal-overlay"></div>
    <div class="custom-modal-content" role="dialog" aria-modal="true" aria-label="Konfirmasi Persetujuan Perpanjangan">
        <div class="custom-modal-header">
            <h5>
                <i class="fas fa-clock me-2"></i>Konfirmasi Perpanjangan
            </h5>
            <button class="custom-close-btn" type="button" onclick="closeApproveModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div class="payment-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mt-4 mb-2">Setujui permintaan perpanjangan ini?</h5>
            <p class="text-muted">Pastikan data perpanjangan sudah benar sebelum menyetujui.</p>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-secondary px-4" type="button" onclick="closeApproveModal()">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button class="btn btn-success px-4" type="button" onclick="confirmApprove()">
                <i class="fas fa-check me-2"></i>Ya, Setujui
            </button>
        </div>
    </div>
</div>

<!-- Custom Reject Modal (style follows laporan denda popup) -->
<div id="customRejectModal" class="custom-modal" aria-hidden="true">
    <div class="custom-modal-overlay"></div>
    <div class="custom-modal-content" role="dialog" aria-modal="true" aria-label="Konfirmasi Penolakan Perpanjangan">
        <div class="custom-modal-header">
            <h5>
                <i class="fas fa-times-circle me-2"></i>Konfirmasi Penolakan
            </h5>
            <button class="custom-close-btn" type="button" onclick="closeRejectModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div class="payment-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mt-4 mb-2">Tolak permintaan perpanjangan ini?</h5>
            <p class="text-muted">Alasan penolakan bersifat opsional.</p>
            <div class="mt-3 text-start">
                <label class="form-label fw-semibold">Alasan penolakan (opsional)</label>
                <textarea id="rejectReason" class="form-control" rows="3" placeholder="Tulis alasan... (opsional)"></textarea>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-secondary px-4" type="button" onclick="closeRejectModal()">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button class="btn btn-danger px-4" type="button" onclick="confirmReject()">
                <i class="fas fa-times me-2"></i>Ya, Tolak
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Custom Modal Styles (scoped) */
#customApproveModal.custom-modal,
#customRejectModal.custom-modal {
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

#customApproveModal.custom-modal.show,
#customRejectModal.custom-modal.show {
    display: flex !important;
}

#customApproveModal .custom-modal-overlay,
#customRejectModal .custom-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1;
}

#customApproveModal .custom-modal-content,
#customRejectModal .custom-modal-content {
    position: relative;
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    z-index: 2;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: approveModalSlideIn 0.3s ease;
}

@keyframes approveModalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#customApproveModal .custom-modal-header,
#customRejectModal .custom-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
    border-radius: 20px 20px 0 0;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#customApproveModal .custom-modal-header h5,
#customRejectModal .custom-modal-header h5 {
    margin: 0;
    font-weight: 600;
}

#customApproveModal .custom-close-btn,
#customRejectModal .custom-close-btn {
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

#customApproveModal .custom-close-btn:hover,
#customRejectModal .custom-close-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

#customApproveModal .custom-modal-body,
#customRejectModal .custom-modal-body {
    padding: 2rem;
    text-align: center;
}

#customApproveModal .payment-icon,
#customRejectModal .payment-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: approvePulse 2s infinite;
}

#customApproveModal .payment-icon i,
#customRejectModal .payment-icon i {
    font-size: 2.5rem;
    color: white;
}

@keyframes approvePulse {
    0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
    50% { box-shadow: 0 0 0 15px rgba(102, 126, 234, 0); }
    100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
}

#customApproveModal .custom-modal-footer,
#customRejectModal .custom-modal-footer {
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
    border-top: 1px solid #e9ecef;
}

#customApproveModal .custom-modal-footer .btn,
#customRejectModal .custom-modal-footer .btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

#customApproveModal .custom-modal-footer .btn:hover,
#customRejectModal .custom-modal-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

body.modal-open {
    overflow: hidden;
}
</style>
@endpush

@push('scripts')
<script>
let selectedPerpanjanganRequestId = null;
let selectedPerpanjanganRejectId = null;

function showApproveModal(id) {
    selectedPerpanjanganRequestId = id;
    const modal = document.getElementById('customApproveModal');
    modal.classList.add('show');
    document.body.classList.add('modal-open');
}

function closeApproveModal() {
    const modal = document.getElementById('customApproveModal');
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    selectedPerpanjanganRequestId = null;
}

function confirmApprove() {
    if (!selectedPerpanjanganRequestId) return;
    const id = selectedPerpanjanganRequestId;
    closeApproveModal();

    const currentPath = window.location.pathname;
    const isPetugas = currentPath.includes('/petugas/');

    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';

    if (isPetugas) {
        form.action = '/petugas/perpanjangan/' + id + '/approve';
    } else {
        form.action = '/permintaan_perpanjangan/' + id + '/approve';
    }

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    document.body.appendChild(form);
    form.submit();
}

function showRejectModal(id) {
    selectedPerpanjanganRejectId = id;
    const modal = document.getElementById('customRejectModal');
    const reasonEl = document.getElementById('rejectReason');
    if (reasonEl) reasonEl.value = '';
    modal.classList.add('show');
    document.body.classList.add('modal-open');
    setTimeout(() => { if (reasonEl) reasonEl.focus(); }, 0);
}

function closeRejectModal() {
    const modal = document.getElementById('customRejectModal');
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    selectedPerpanjanganRejectId = null;
}

function confirmReject() {
    if (!selectedPerpanjanganRejectId) return;
    const id = selectedPerpanjanganRejectId;
    const reason = (document.getElementById('rejectReason')?.value || '').trim();
    closeRejectModal();

    const currentPath = window.location.pathname;
    const isPetugas = currentPath.includes('/petugas/');

    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';
    form.action = isPetugas
        ? '/petugas/perpanjangan/' + id + '/reject'
        : '/permintaan_perpanjangan/' + id + '/reject';

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    if (reason) {
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'catatan_admin';
        reasonInput.value = reason;
        form.appendChild(reasonInput);
    }

    document.body.appendChild(form);
    form.submit();
}

// Close modal when clicking overlay or ESC
document.addEventListener('DOMContentLoaded', function() {
    const approveOverlay = document.querySelector('#customApproveModal .custom-modal-overlay');
    if (approveOverlay) approveOverlay.addEventListener('click', closeApproveModal);

    const rejectOverlay = document.querySelector('#customRejectModal .custom-modal-overlay');
    if (rejectOverlay) rejectOverlay.addEventListener('click', closeRejectModal);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApproveModal();
            closeRejectModal();
        }
    });
});
</script>
@endpush