@extends('layouts.pengunjung')

@section('title', 'Request Saya')

@section('content')
<div class="page-header mb-4">
    <h3 class="mb-1"><i class="fas fa-clipboard-list me-2"></i>Request Peminjaman Saya</h3>
    <p class="text-muted mb-0">Pantau status request peminjaman buku Anda</p>
</div>

<div class="row g-4">
    @forelse($requests as $req)
    <div class="col-md-6">
        <div class="request-card">
            <div class="d-flex gap-3">
                <!-- Book Cover -->
                @if($req->buku->gambar)
                    <img src="{{ asset('storage/'.$req->buku->gambar) }}" alt="{{ $req->buku->judul }}" class="book-thumbnail">
                @else
                    <div class="book-thumbnail-placeholder">
                        <i class="fas fa-book"></i>
                    </div>
                @endif
                
                <!-- Request Info -->
                <div class="flex-grow-1">
                    <h6 class="book-title-req">{{ $req->buku->judul }}</h6>
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ $req->tanggal_request ? \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y, H:i') : '-' }}
                    </small>
                    
                    <!-- Status Badge -->
                    @if($req->status == 'pending')
                        <span class="badge bg-warning text-dark mb-2">
                            <i class="fas fa-clock me-1"></i>Menunggu Persetujuan
                        </span>
                    @elseif($req->status == 'disetujui')
                        <span class="badge bg-success mb-2">
                            <i class="fas fa-check-circle me-1"></i>Disetujui
                        </span>
                    @else
                        <span class="badge bg-danger mb-2">
                            <i class="fas fa-times-circle me-1"></i>Ditolak
                        </span>
                    @endif
                    
                    <!-- Processing Info -->
                    @if($req->status != 'pending')
                        <small class="d-block text-muted mb-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Diproses: {{ $req->tanggal_diproses ? \Carbon\Carbon::parse($req->tanggal_diproses)->format('d M Y, H:i') : '-' }}
                        </small>
                    @endif
                    
                    <!-- Rejection Reason -->
                    @if($req->status == 'ditolak' && $req->catatan_admin)
                        <div class="alert alert-danger py-2 px-3 mb-2">
                            <small><strong>Alasan:</strong> {{ $req->catatan_admin }}</small>
                        </div>
                    @endif
                    
                    <!-- Approval Message -->
                    @if($req->status == 'disetujui')
                        <div class="alert alert-success py-2 px-3 mb-2">
                            <small><i class="fas fa-check me-1"></i>Request Anda disetujui. Buku dapat diambil di perpustakaan.</small>
                        </div>
                    @endif
                    
                    <!-- Actions -->
                    @if($req->status == 'pending')
                        <button class="btn btn-sm btn-danger mt-2" onclick="cancelRequest({{ $req->id_request }})">
                            <i class="fas fa-times me-1"></i>Batalkan Request
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h5>Belum Ada Request</h5>
            <p class="text-muted">Anda belum pernah mengajukan peminjaman buku</p>
            <a href="{{ route('pengunjung.catalog') }}" class="btn btn-primary mt-3">
                <i class="fas fa-books me-2"></i>Jelajahi Katalog
            </a>
        </div>
    </div>
    @endforelse
</div>

@if($requests->hasPages())
<div class="mt-4">
    {{ $requests->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
function cancelRequest(id) {
    if(confirm('Batalkan request peminjaman ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pengunjung/my-requests/${id}/cancel`;
        
        let method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        
        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

@push('styles')
<style>
.page-header h3 {
    color: var(--dark);
    font-weight: 700;
}

.request-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}

.request-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.book-thumbnail {
    width: 80px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}

.book-thumbnail-placeholder {
    width: 80px;
    height: 120px;
    background: linear-gradient(135deg, var(--secondary), #c9e4f0);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.book-thumbnail-placeholder i {
    font-size: 2rem;
    color: white;
    opacity: 0.7;
}

.book-title-req {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.empty-state i {
    font-size: 5rem;
    color: var(--secondary);
    opacity: 0.4;
    margin-bottom: 1.5rem;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .request-card {
        padding: 1rem;
    }
    
    .book-thumbnail,
    .book-thumbnail-placeholder {
        width: 60px;
        height: 90px;
    }
}
</style>
@endpush
