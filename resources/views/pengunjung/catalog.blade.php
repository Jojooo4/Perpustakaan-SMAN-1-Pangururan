@extends('layouts.pengunjung')

@section('title', 'Katalog Buku')

@section('content')
<!-- Page Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6 mb-3 mb-md-0">
            <h3 class="mb-1"><i class="fas fa-books me-2"></i>Katalog Buku</h3>
            <p class="text-muted mb-0">Jelajahi {{ $books->total() ?? 0 }} koleksi buku perpustakaan</p>
        </div>
        <div class="col-md-6">
            <form action="{{ route('pengunjung.catalog') }}" method="GET" class="search-form">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" name="search" 
                           placeholder="Cari judul,pengarang, atau penerbit..." 
                           value="{{ request('search') }}" autocomplete="off">
                    @if(request('search'))
                        <a href="{{ route('pengunjung.catalog') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                    <button class="btn btn-primary px-4" type="submit">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Book Grid -->
<div class="row g-4">
    @forelse($books as $book)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="book-card">
            <div class="book-cover">
                @if($book->gambar)
                    <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}">
                @else
                    <div class="book-cover-placeholder">
                        <i class="fas fa-book"></i>
                    </div>
                @endif
                
                <!-- Availability Badge -->
                <div class="availability-badge">
                    @if($book->stok_tersedia > 0)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Tersedia
                        </span>
                    @else
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle me-1"></i>Dipinjam
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="book-content">
                <h6 class="book-title" title="{{ $book->judul }}">{{ $book->judul }}</h6>
                <div class="book-meta">
                    <small class="d-block text-muted mb-1">
                        <i class="fas fa-user me-1"></i>{{ Str::limit($book->nama_pengarang ?? 'N/A', 25) }}
                    </small>
                    <small class="d-block text-muted">
                        <i class="fas fa-building me-1"></i>{{ $book->penerbit ?? 'N/A' }}
                    </small>
                </div>
                
                @if($book->stok_tersedia > 0)
                    <div class="stock-info">
                        <i class="fas fa-box"></i> Stok: {{ $book->stok_tersedia }}
                    </div>
                @endif
                
                <a href="{{ route('pengunjung.catalog.show', $book->id_buku) }}" class="btn-detail">
                    <i class="fas fa-eye me-1"></i>Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-results">
            <i class="fas fa-search"></i>
            <h5>Buku tidak ditemukan</h5>
            <p class="text-muted">Coba kata kunci lain atau <a href="{{ route('pengunjung.catalog') }}">lihat semua buku</a></p>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($books->hasPages())
<div class="mt-5">
    {{ $books->appends(request()->query())->links() }}
</div>
@endif
@endsection

@push('styles')
<style>
/* Page Header */
.page-header h3 {
    color: var(--dark);
    font-weight: 700;
}

/* Search Form */
.search-form .input-group {
    border-radius: 12px;
    overflow: hidden;
}

.search-form .form-control:focus {
    box-shadow: none;
    border-color: #dee2e6;
}

.search-form .input-group-text {
    border: 1px solid #dee2e6;
}

/* Book Card */
.book-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.book-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(235,69,95,0.15);
}

/* Book Cover */
.book-cover {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: var(--secondary);
}

.book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.book-card:hover .book-cover img {
    transform: scale(1.05);
}

.book-cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--secondary), #c9e4f0);
}

.book-cover-placeholder i {
    font-size: 4rem;
    color: white;
    opacity: 0.6;
}

/* Availability Badge */
.availability-badge {
    position: absolute;
    top: 12px;
    right: 12px;
}

.availability-badge .badge {
    font-size: 0.75rem;
    padding: 0.4rem 0.7rem;
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* Book Content */
.book-content {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.book-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.75rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.8em;
}

.book-meta {
    margin-bottom: 0.75rem;
    flex: 1;
}

.book-meta small {
    font-size: 0.85rem;
    line-height: 1.6;
}

.stock-info {
    font-size: 0.85rem;
    color: #6c757d;
    padding: 0.5rem 0;
    border-top: 1px solid #e9ecef;
    margin-bottom: 0.75rem;
}

.stock-info i {
    color: var(--primary);
}

/* Detail Button */
.btn-detail {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 0.6rem;
    background: var(--primary);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-detail:hover {
    background: #c93551;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(235,69,95,0.3);
}

/* Empty Results */
.empty-results {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

.empty-results i {
    font-size: 5rem;
    color: var(--secondary);
    opacity: 0.5;
    margin-bottom: 1.5rem;
}

.empty-results h5 {
    color: var(--dark);
    margin-bottom: 0.5rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .book-cover {
        height: 220px;
    }
    
    .book-title {
        font-size: 0.9rem;
    }
    
    .book-meta small {
        font-size: 0.8rem;
    }
    
    .availability-badge .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.5rem;
    }
}

/* Pagination Styling */
.pagination {
    justify-content: center;
}

.pagination .page-link {
    color: var(--primary);
    border-radius: 8px;
    margin: 0 0.2rem;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.06);
}

.pagination .page-item.active .page-link {
    background-color: var(--primary);
    border-color: var(--primary);
}

.pagination .page-link:hover {
    background-color: var(--secondary);
    transform: translateY(-2px);
}
</style>
@endpush

