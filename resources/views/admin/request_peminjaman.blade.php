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
                    <td>{{ $req->buku->judul ?? '-' }}</td>
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
                            <button class="btn btn-success btn-sm me-1" onclick="approveRequest({{ $req->id_request }})">
                                <i class="fas fa-check me-1"></i>Approve
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="showRejectModal({{ $req->id_request }}, '{{ addslashes($req->buku->judul) }}')">
                                <i class="fas fa-times me-1"></i>Reject
                            </button>
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

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Request Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Buku: <strong id="rejectBookTitle"></strong></p>
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="catatan_admin" rows="4" required 
                                  placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reason Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="reasonText"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function approveRequest(id) {
    if(confirm('Setujui request peminjaman ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/request-peminjaman/${id}/approve`;
        
        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function showRejectModal(id, bookTitle) {
    document.getElementById('rejectBookTitle').textContent = bookTitle;
    document.getElementById('rejectForm').action = `/request-peminjaman/${id}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function showReason(reason) {
    document.getElementById('reasonText').textContent = reason;
    new bootstrap.Modal(document.getElementById('reasonModal')).show();
}
</script>
@endpush
