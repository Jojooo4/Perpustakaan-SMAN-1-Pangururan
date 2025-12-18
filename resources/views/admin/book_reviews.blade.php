@extends('layouts.admin')

@section('title', 'Review - ' . $book->judul)
@section('page-title', 'Review Buku')

@section('content')
{{-- Book Info Header --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="book-header-card">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    @if($book->gambar)
                        <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" class="book-cover">
                    @else
                        <div class="book-cover-placeholder">
                            <i class="fas fa-book fa-3x"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-7">
                    <h3 class="mb-2">{{ $book->judul }}</h3>
                    <p class="text-muted mb-1"><i class="fas fa-user me-2"></i>{{ $book->nama_pengarang ?? '-' }}</p>
                    <p class="text-muted mb-0"><i class="fas fa-building me-2"></i>{{ $book->penerbit ?? '-' }}</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="rating-summary">
                        <div class="avg-rating-display">{{ number_format($avgRating ?? 0, 1) }}</div>
                        <div class="stars-display mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= ($avgRating ?? 0))
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted mb-0">{{ $totalReviews }} {{ Str::plural('Review', $totalReviews) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Rating Distribution --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="stat-card">
            <h5 class="mb-3"><i class="fas fa-chart-bar me-2"></i>Distribusi Rating</h5>
            @foreach($ratingDistribution as $rating => $count)
            <div class="rating-bar-container mb-2">
                <div class="rating-bar-label">{{ $rating }} <i class="fas fa-star text-warning"></i></div>
                <div class="rating-bar-track">
                    <div class="rating-bar-fill" style="width: {{ $totalReviews > 0 ? ($count / $totalReviews * 100) : 0 }}%"></div>
                </div>
                <div class="rating-bar-count">{{ $count }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="row mb-3">
    <div class="col-md-3">
        <select class="form-select" id="ratingFilter" onchange="window.location.href='{{ route('review.book', $book->id_buku) }}?rating=' + this.value + '&search={{ request('search') }}'">
            <option value="">Semua Rating</option>
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
            @endfor
        </select>
    </div>
    <div class="col-md-9">
        <form action="{{ route('review.book', $book->id_buku) }}" method="GET" class="d-flex">
            <input type="hidden" name="rating" value="{{ request('rating') }}">
            <input type="text" class="form-control me-2" name="search" placeholder="Cari nama reviewer..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>

{{-- Reviews List --}}
<div class="row">
    @forelse($reviews as $review)
    <div class="col-12 mb-3">
        <div class="review-card">
            <div class="review-header">
                <div class="reviewer-info">
                    <div class="reviewer-avatar">
                        @if($review->user && $review->user->foto_profil)
                            <img src="{{ asset('storage/' . $review->user->foto_profil) }}" alt="{{ $review->user->nama }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $review->user->nama ?? 'Anonymous' }}</h6>
                        <small class="text-muted">Review #{{ $review->id_ulasan }}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <form action="{{ route('pengelolaan.review.destroy', $review->id_ulasan) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="review-comment">
                {{ $review->komentar }}
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="stat-card text-center py-5">
            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
            <p class="text-muted">Tidak ada review yang ditemukan</p>
        </div>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($reviews->hasPages())
<div class="row mt-4">
    <div class="col-12">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
</div>
@endif

{{-- Back Button --}}
<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('pengelolaan.review') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
.book-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.book-cover {
    width: 120px;
    height: 160px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
}

.book-cover-placeholder {
    width: 120px;
    height: 160px;
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.rating-summary {
    background: rgba(255,255,255,0.2);
    padding: 1.5rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.avg-rating-display {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1;
}

.stars-display i {
    font-size: 1.2rem;
}

.rating-bar-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.rating-bar-label {
    min-width: 80px;
    font-weight: 500;
}

.rating-bar-track {
    flex: 1;
    height: 25px;
    background: #e9ecef;
    border-radius: 15px;
    overflow: hidden;
}

.rating-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    transition: width 0.5s ease;
}

.rating-bar-count {
    min-width: 40px;
    text-align: right;
    font-weight: 600;
}

.review-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.review-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.reviewer-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    overflow: hidden;
}

.reviewer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.review-rating i {
    font-size: 1.1rem;
}

.review-comment {
    color: #555;
    line-height: 1.6;
    font-size: 0.95rem;
}
</style>
@endpush
@endsection
