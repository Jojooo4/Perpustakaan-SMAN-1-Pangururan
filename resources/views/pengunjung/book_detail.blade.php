@extends('layouts.pengunjung')

@section('title', $book->judul)

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('pengunjung.catalog') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Katalog
    </a>
</div>

<div class="row g-4">
    <!-- LEFT: Book Details -->
    <div class="col-lg-8">
        <div class="detail-card">
            <div class="detail-card-header">
                <h4 class="mb-0">
                    <i class="fas fa-book me-2"></i>Detail Buku
                </h4>
            </div>
            <div class="detail-card-body">
                <div class="row">
                    <!-- Book Cover -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="book-cover-large">
                            @if($book->gambar)
                                <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}">
                            @else
                                <div class="book-cover-placeholder">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Book Info -->
                    <div class="col-md-8">
                        <h3 class="book-title-detail">{{ $book->judul }}</h3>
                        
                        <div class="book-info-grid">
                            <div class="info-item">
                                <i class="fas fa-user-edit text-primary"></i>
                                <div>
                                    <small class="text-muted">Penulis</small>
                                    <p class="mb-0"><strong>{{ $book->nama_pengarang ?? 'N/A' }}</strong></p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-building text-primary"></i>
                                <div>
                                    <small class="text-muted">Penerbit</small>
                                    <p class="mb-0"><strong>{{ $book->penerbit ?? 'N/A' }}</strong></p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-calendar text-primary"></i>
                                <div>
                                    <small class="text-muted">Tahun Terbit</small>
                                    <p class="mb-0"><strong>{{ $book->tahun_terbit ?? 'N/A' }}</strong></p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-file-alt text-primary"></i>
                                <div>
                                    <small class="text-muted">Jumlah Halaman</small>
                                    <p class="mb-0"><strong>{{ $book->jumlah_halaman ?? 'N/A' }} halaman</strong></p>
                                </div>
                            </div>
                        </div>
                        
                        @if($book->genres && $book->genres->count() > 0)
                        <div class="mt-3">
                            <small class="text-muted d-block mb-2"><i class="fas fa-tags me-1"></i>Genre</small>
                            <div class="genre-badges">
                                @foreach($book->genres as $genre)
                                    <span class="badge bg-secondary">{{ $genre->nama_genre }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="detail-card mt-4">
            <div class="detail-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>Ulasan Buku
                    </h5>
                    @if($userHasBorrowed)
                    <a href="{{ route('pengunjung.reviews.create', $book->id_buku) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Tulis Review
                    </a>
                    @endif
                </div>
            </div>
            <div class="detail-card-body">
                @forelse($reviews as $review)
                <div class="review-item">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong class="text-dark">{{ $review->user->nama ?? 'Anonymous' }}</strong>
                            <div class="rating-stars mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $review->created_at ? \Carbon\Carbon::parse($review->created_at)->diffForHumans() : '' }}
                        </small>
                    </div>
                    <p class="review-text mb-0">{{ $review->komentar }}</p>
                </div>
                @empty
                <div class="empty-reviews">
                    <i class="fas fa-comment-slash"></i>
                    <p>Belum ada ulasan untuk buku ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- RIGHT: Borrow Action Card -->
    <div class="col-lg-4">
        <div class="borrow-card">
            <div class="borrow-card-header">
                <h5 class="mb-0">
                    <i class="fas fa-hand-holding-heart me-2"></i>Pinjam Buku Ini
                </h5>
            </div>
            <div class="borrow-card-body">
                <!-- Stock Info -->
                <div class="stock-display">
                    @if($book->stok_tersedia > 0)
                        <div class="stock-available">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Tersedia</strong>
                                <p class="mb-0">{{ $book->stok_tersedia }} eksemplar siap dipinjam</p>
                            </div>
                        </div>
                    @else
                        <div class="stock-unavailable">
                            <i class="fas fa-times-circle"></i>
                            <div>
                                <strong>Tidak Tersedia</strong>
                                <p class="mb-0">Semua eksemplar sedang dipinjam</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Borrow Form -->
                @if($book->stok_tersedia > 0)
                <form action="{{ route('pengunjung.catalog.borrow', $book->id_buku) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-borrow">
                        <i class="fas fa-book-reader me-2"></i>Ajukan Peminjaman
                    </button>
                </form>
                <p class="borrow-note">
                    <i class="fas fa-info-circle me-1"></i>
                    Permintaan akan diproses oleh admin/petugas
                </p>
                @else
                <button class="btn-borrow-disabled" disabled>
                    <i class="fas fa-ban me-2"></i>Tidak Dapat Dipinjam
                </button>
                <p class="borrow-note text-danger">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Stok sedang habis, coba lagi nanti
                </p>
                @endif
                
                <!-- Additional Info -->
                <div class="borrow-info">
                    <h6>Informasi Peminjaman:</h6>
                    <ul>
                        <li><i class="fas fa-clock"></i> Durasi: 7 hari</li>
                        <li><i class="fas fa-redo"></i> Dapat diperpanjang 1x</li>
                        <li><i class="fas fa-exclamation"></i> Denda: Rp 1.000/hari</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Detail Card */
.detail-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}

.detail-card-header {
    background: linear-gradient(135deg, var(--dark) 0%, #3d4a7a 100%);
    color: white;
    padding: 1.25rem 1.5rem;
}

.detail-card-header h4,
.detail-card-header h5 {
    color: white;
}

.detail-card-body {
    padding: 2rem;
}

/* Book Cover Large */
.book-cover-large {
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.book-cover-large img {
    width: 100%;
    height: auto;
    display: block;
}

.book-cover-placeholder {
    width: 100%;
    aspect-ratio: 2/3;
    background: linear-gradient(135deg, var(--secondary), #c9e4f0);
    display: flex;
    align-items: center;
    justify-content: center;
}

.book-cover-placeholder i {
    font-size: 5rem;
    color: white;
    opacity: 0.6;
}

/* Book Title */
.book-title-detail {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1.5rem;
    line-height: 1.3;
}

/* Book Info Grid */
.book-info-grid {
    display: grid;
    gap: 1.25rem;
}

.info-item {
    display: flex;
    gap: 1rem;
    align-items: start;
}

.info-item i {
    font-size: 1.5rem;
    margin-top: 0.25rem;
}

.info-item small {
    font-size: 0.85rem;
    display: block;
    margin-bottom: 0.25rem;
}

/* Genre Badges */
.genre-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.genre-badges .badge {
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
}

/* Reviews */
.review-item {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.review-item:last-child {
    margin-bottom: 0;
}

.rating-stars {
    font-size: 0.9rem;
}

.review-text {
    color: #495057;
    line-height: 1.6;
}

.empty-reviews {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
}

.empty-reviews i {
    font-size: 3rem;
    opacity: 0.3;
    margin-bottom: 1rem;
}

/* Borrow Card */
.borrow-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    position: sticky;
    top: 20px;
}

.borrow-card-header {
    background: linear-gradient(135deg, var(--primary) 0%, #c93551 100%);
    color: white;
    padding: 1.25rem 1.5rem;
}

.borrow-card-header h5 {
    color: white;
}

.borrow-card-body {
    padding: 2rem;
}

/* Stock Display */
.stock-display {
    margin-bottom: 1.5rem;
}

.stock-available,
.stock-unavailable {
    display: flex;
    align-items: start;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: 12px;
}

.stock-available {
    background: rgba(40, 167, 69, 0.1);
    border: 2px solid #28a745;
}

.stock-available i {
    font-size: 2rem;
    color: #28a745;
}

.stock-unavailable {
    background: rgba(220, 53, 69, 0.1);
    border: 2px solid #dc3545;
}

.stock-unavailable i {
    font-size: 2rem;
    color: #dc3545;
}

.stock-available strong,
.stock-unavailable strong {
    display: block;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

/* Borrow Button */
.btn-borrow {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, var(--primary) 0%, #c93551 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 1rem;
}

.btn-borrow:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(235, 69, 95, 0.4);
}

.btn-borrow-disabled {
    width: 100%;
    padding: 1rem;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: not-allowed;
    margin-bottom: 1rem;
}

.borrow-note {
    font-size: 0.85rem;
    color: #6c757d;
    text-align: center;
    margin-bottom: 1.5rem;
}

/* Borrow Info */
.borrow-info {
    background: #f8f9fa;
    padding: 1.25rem;
    border-radius: 12px;
}

.borrow-info h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.75rem;
}

.borrow-info ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.borrow-info li {
    padding: 0.5rem 0;
    font-size: 0.9rem;
    color: #495057;
}

.borrow-info li i {
    color: var(--primary);
    margin-right: 0.5rem;
    width: 20px;
}

/* Mobile Responsive */
@media (max-width: 991px) {
    .borrow-card {
        position: relative;
        top: 0;
    }
    
    .book-title-detail {
        font-size: 1.5rem;
    }
}
</style>
@endpush

