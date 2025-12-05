@extends('layouts.admin')

@section('title', 'Review Ulasan')
@section('page-title', 'Review Ulasan Buku')

@section('content')
<div class="stat-card">
    <div class="row">
        @forelse($reviews ?? [] as $review)
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1">{{ $review->buku->judul ?? '-' }}</h6>
                            <small class="text-muted">oleh {{ $review->user->nama ?? '-' }}</small>
                        </div>
                        <button class="btn btn-danger btn-sm" onclick="deleteReview({{ $review->id_ulasan }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= ($review->rating ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <span class="ms-2 text-muted">({{ $review->rating }}/5)</span>
                    </div>
                    <p class="card-text">{{ $review->ulasan }}</p>
                    <small class="text-muted">
                        <i class="fas fa-user me-1"></i>
                        Review ID: {{ $review->id_ulasan }}
                    </small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            <i class="fas fa-star fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
            <h5>Belum ada review</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteReview(id) {
    if(confirm('Hapus review ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/reviews/${id}`;
        
        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        let method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush