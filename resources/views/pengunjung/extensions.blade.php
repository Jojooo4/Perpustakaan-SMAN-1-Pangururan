@extends('layouts.pengunjung')

@section('title', 'Perpanjangan Peminjaman')

@section('content')
<div class="page-header mb-4">
    <h3 class="mb-1"><i class="fas fa-clock me-2"></i>Perpanjangan Peminjaman</h3>
    <p class="text-muted mb-0">Ajukan perpanjangan untuk buku yang sedang dipinjam</p>
</div>

<!-- Active Loans Card -->
<div class="card-custom p-4 mb-4">
    <h5 class="mb-3"><i class="fas fa-book-open me-2"></i>Peminjaman Aktif</h5>
    
    @if($activeLoans && $activeLoans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeLoans as $loan)
                    <tr>
                        <td><strong>{{ $loan->asetBuku->buku->judul ?? 'N/A' }}</strong></td>
                        <td>{{ $loan->tanggal_jatuh_tempo ? $loan->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($loan->isTerlambat())
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if(!$loan->isTerlambat() && !$loan->requestPerpanjangan()->where('status', 'pending')->exists())
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#extendModal{{ $loan->id_peminjaman }}">
                                    <i class="fas fa-plus me-1"></i>Ajukan Perpanjangan
                                </button>
                            @elseif($loan->requestPerpanjangan()->where('status', 'pending')->exists())
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @else
                                <span class="text-danger small">Tidak dapat diperpanjang</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
            <p class="text-muted">Tidak ada peminjaman aktif</p>
        </div>
    @endif
</div>

<!-- Extension History Card -->
<div class="card-custom p-4">
    <h5 class="mb-3"><i class="fas fa-history me-2"></i>Riwayat Permintaan Perpanjangan</h5>
    
    @if($extensionRequests && $extensionRequests->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tanggal Request</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($extensionRequests as $req)
                    <tr>
                        <td>{{ $req->peminjaman->asetBuku->buku->judul ?? 'N/A' }}</td>
                        <td>{{ $req->tanggal_request ? \Carbon\Carbon::parse($req->tanggal_request)->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($req->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $req->catatan_admin ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted text-center py-3">Belum ada permintaan perpanjangan</p>
    @endif
</div>

<!-- Modals -->
@if($activeLoans && $activeLoans->count() > 0)
    @foreach($activeLoans as $loan)
    <div class="modal fade" id="extendModal{{ $loan->id_peminjaman }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('pengunjung.extensions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_peminjaman" value="{{ $loan->id_peminjaman }}">
                    
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-clock me-2"></i>Ajukan Perpanjangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="alert alert-info" data-autohide="10000">
                            <strong>Buku:</strong> {{ $loan->asetBuku->buku->judul }}<br>
                            <strong>Jatuh Tempo Saat Ini:</strong> {{ $loan->tanggal_jatuh_tempo->format('d/m/Y') }}
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Perpanjang Berapa Hari? <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="hari_perpanjangan" min="1" max="7" value="7" required>
                            <small class="text-muted">Maksimal 7 hari</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alasan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Masukkan alasan perpanjangan..."></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Ajukan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endif
@endsection

@push('styles')
<style>
.page-header h3 {
    color: var(--dark);
    font-weight: 700;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: var(--dark);
}

/* Prevent body scroll issues */
body.modal-open {
    overflow: hidden !important;
    padding-right: 0 !important;
}

/* Ensure modal displays properly */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5);
}
</style>
@endpush

@push('scripts')
<script>
// Comprehensive modal cleanup script
(function() {
    // 1. Clean on page load
    window.addEventListener('DOMContentLoaded', function() {
        cleanupModals();
    });
    
    // 2. Clean when modal is fully hidden
    document.addEventListener('hidden.bs.modal', function(event) {
        setTimeout(cleanupModals, 150);
    });
    
    // 3. Clean before page unload
    window.addEventListener('beforeunload', function() {
        cleanupModals();
    });
    
    // Helper function to clean all modal artifacts
    function cleanupModals() {
        // Remove all backdrops
        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
            backdrop.remove();
        });
        
        // Remove modal-open class
        document.body.classList.remove('modal-open');
        
        // Reset body styles
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Close any open modals
        document.querySelectorAll('.modal.show').forEach(function(modal) {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) {
                bsModal.hide();
            }
        });
    }
    
    // 4. Prevent multiple modal instances
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(trigger) {
        trigger.addEventListener('click', function() {
            // Clean before opening new modal
            cleanupModals();
        });
    });
})();
</script>
@endpush
