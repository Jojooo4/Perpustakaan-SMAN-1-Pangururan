@extends('layouts.admin')

@section('title', 'Laporan Denda')
@section('page-title', 'Laporan Denda')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <div class="stat-card">
            <h6 class="mb-0">Total Denda Belum Lunas</h6>
            <h3 class="mb-0 text-danger">Rp {{ number_format($totalDendaBelumLunas ?? 0, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="lunas">Lunas</option>
            <option value="belum">Belum Lunas</option>
        </select>
    </div>
    <div class="col-md-3">
        <a href="{{ route('denda.export', request()->query()) }}" class="btn btn-success w-100 mb-2">
            <i class="fas fa-file-excel me-2"></i>Export Excel
        </a>
        <a href="{{ route('denda.export-pdf', request()->query()) }}" class="btn btn-danger w-100">
            <i class="fas fa-file-pdf me-2"></i>Export PDF
        </a>
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
                    <th>Jatuh Tempo</th>
                    <th>Kembali</th>
                    <th>Terlambat</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($denda ?? [] as $d)
                @php
                    $jatuhTempo = $d->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($d->tanggal_jatuh_tempo) : null;
                    $kembali = $d->tanggal_kembali ? \Carbon\Carbon::parse($d->tanggal_kembali) : now();
                    $hariTerlambat = $jatuhTempo ? max(0, $kembali->diffInDays($jatuhTempo, false) * -1) : 0;
                @endphp
                <tr>
                    <td>{{ $d->id_peminjaman }}</td>
                    <td><strong>{{ $d->user->nama ?? '-' }}</strong></td>
                    <td>{{ $d->asetBuku->buku->judul ?? '-' }}</td>
                    <td>{{ $jatuhTempo ? $jatuhTempo->format('d/m/Y') : '-' }}</td>
                    <td>{{ $d->tanggal_kembali ? $kembali->format('d/m/Y') : '-' }}</td>
                    <td><span class="badge bg-warning">{{ $hariTerlambat }} hari</span></td>
                    <td class="fw-bold text-danger">Rp {{ number_format($d->denda, 0, ',', '.') }}</td>
                    <td>
                        @if($d->denda_lunas ?? false)
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        @if(!($d->denda_lunas ?? false))
                            <button class="btn btn-success btn-sm" onclick="showPaymentModal({{ $d->id_peminjaman }})">
                                <i class="fas fa-check me-1"></i>Lunas
                            </button>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-check me-1"></i>Sudah Lunas
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-money-bill-wave fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Tidak ada data denda
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Custom Modal (Not Bootstrap) -->
<div id="customPaymentModal" class="custom-modal">
    <div class="custom-modal-overlay"></div>
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5>
                <i class="fas fa-money-check-alt me-2"></i>Konfirmasi Pembayaran Denda
            </h5>
            <button class="custom-close-btn" onclick="closePaymentModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div class="payment-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mt-4 mb-2">Tandai Denda Sebagai Lunas?</h5>
            <p class="text-muted">Pastikan pembayaran telah diterima sebelum menandai denda sebagai lunas.</p>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-secondary px-4" onclick="closePaymentModal()">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button class="btn btn-success px-4" onclick="confirmPayment()">
                <i class="fas fa-check me-2"></i>Ya, Tandai Lunas
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Custom Modal Styles */
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

.btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
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
let selectedDendaId = null;

function showPaymentModal(id) {
    selectedDendaId = id;
    const modal = document.getElementById('customPaymentModal');
    modal.classList.add('show');
    document.body.classList.add('modal-open');
}

function closePaymentModal() {
    const modal = document.getElementById('customPaymentModal');
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    selectedDendaId = null;
}

function confirmPayment() {
    if(selectedDendaId) {
        const id = selectedDendaId;
        closePaymentModal();
        
        // Detect if we're on petugas or admin page
        const currentPath = window.location.pathname;
        const isPetugas = currentPath.includes('/petugas/');
        
        // Submit form
        const form = document.createElement('form');
        form.method = 'POST';
        
        // Build correct URL based on current location
        if (isPetugas) {
            form.action = '/petugas/denda/' + id + '/lunas';
        } else {
            form.action = '/laporan-denda/' + id + '/lunas';
        }
        
        form.style.display = 'none';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        document.body.appendChild(form);
        console.log('Submitting to:', form.action);
        form.submit();
    }
}

// Close modal when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.querySelector('.custom-modal-overlay');
    if(overlay) {
        overlay.addEventListener('click', closePaymentModal);
    }
    
    // Close with ESC key
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            closePaymentModal();
        }
    });
});
</script>
@endpush