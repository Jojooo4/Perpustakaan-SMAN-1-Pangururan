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
                            <button class="btn btn-success btn-sm" onclick="markPaid({{ $d->id_peminjaman }})">
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

<!-- Custom Confirmation Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white" id="paymentModalLabel">
                    <i class="fas fa-money-check-alt me-2"></i>Konfirmasi Pembayaran Denda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <div class="payment-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                </div>
                <h5 class="mb-2">Tandai Denda Sebagai Lunas?</h5>
                <p class="text-muted mb-0">Pastikan pembayaran telah diterima sebelum menandai denda sebagai lunas.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-success px-4" id="confirmPayment">
                    <i class="fas fa-check me-2"></i>Ya, Tandai Lunas
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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

.modal-content {
    border-radius: 20px;
    overflow: hidden;
}

.modal-header {
    padding: 1.5rem;
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
</style>
@endpush

@push('scripts')
<script>
let selectedDendaId = null;
let shouldSubmit = false;

function markPaid(id) {
    selectedDendaId = id;
    shouldSubmit = false;
    const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
    modal.show();
}

// Handle confirm button click
document.getElementById('confirmPayment').addEventListener('click', function() {
    if(selectedDendaId) {
        shouldSubmit = true;
        // Close modal using Bootstrap method
        const modalElement = document.getElementById('paymentModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if(modal) {
            modal.hide();
        }
    }
});

// Submit form after modal is completely hidden
document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
    if(shouldSubmit && selectedDendaId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('denda.mark-paid', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', selectedDendaId);

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        document.body.appendChild(form);
        form.submit();
        
        // Reset
        shouldSubmit = false;
        selectedDendaId = null;
    }
});
</script>
@endpush