@extends('layouts.admin')

@section('title', 'Review Ulasan')
@section('page-title', 'Review Ulasan Buku')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <p class="text-muted">Klik pada buku untuk melihat semua ulasan</p>
    </div>
</div>

<div class="row">
    @forelse($booksWithReviews as $book)
    <div class="col-md-6 mb-4">
        <div class="stat-card" style="cursor: pointer; transition: transform 0.2s;" 
             onclick="toggleReviews({{ $book->id_buku }})"
             onmouseover="this.style.transform='scale(1.02)'" 
             onmouseout="this.style.transform='scale(1)'">
            <div class="d-flex">
                @if($book->gambar)
                    <img src="{{ asset('storage/'.$book->gambar) }}" 
                         alt="{{ $book->judul }}" 
                         style="width: 100px; height: 150px; object-fit: cover; border-radius: 8px;">
                @else
                    <div style="width: 100px; height: 150px; background: #ecf0f1; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book fa-3x text-muted"></i>
                    </div>
                @endif
                
                <div class="ms-3 grow">
                    <h5 class="mb-2">{{ $book->judul }}</h5>
                    <p class="text-muted mb-2">{{ $book->nama_pengarang }}</p>
                    
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($book->avg_rating))
                                <i class="fas fa-star text-warning"></i>
                            @elseif($i - $book->avg_rating < 1)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                        <strong class="ms-2">{{ number_format($book->avg_rating, 1) }}</strong>
                        <span class="text-muted ms-1">({{ $book->total_reviews }} ulasan)</span>
                    </div>
                    
                    <button class="btn btn-sm btn-primary mt-2" onclick="event.stopPropagation(); toggleReviews({{ $book->id_buku }})">
                        <i class="fas fa-eye me-1"></i>Lihat
                    </button>
                </div>
            </div>
            
            <!-- Reviews Container (Initially Hidden) -->
            <div id="reviews-{{ $book->id_buku }}" class="mt-3 pt-3 border-top" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Semua Ulasan ({{ $book->total_reviews }})</h6>
                    <button class="btn btn-sm btn-secondary" onclick="event.stopPropagation(); toggleReviews({{ $book->id_buku }})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="reviews-content-{{ $book->id_buku }}">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="stat-card text-center py-5">
            <i class="fas fa-comments fa-4x mb-3" style="opacity: 0.3;"></i>
            <h5 class="text-muted">Belum ada ulasan buku</h5>
        </div>
    </div>
    @endforelse
</div>

{{ $booksWithReviews->links() }}

<!-- Custom Delete Review Modal (style follows laporan denda popup) -->
<div id="customDeleteReviewModal" class="custom-modal" aria-hidden="true">
    <div class="custom-modal-overlay"></div>
    <div class="custom-modal-content" role="dialog" aria-modal="true" aria-label="Konfirmasi Hapus Ulasan">
        <div class="custom-modal-header">
            <h5>
                <i class="fas fa-trash me-2"></i>Konfirmasi Hapus
            </h5>
            <button class="custom-close-btn" type="button" onclick="closeDeleteReviewModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div class="payment-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mt-4 mb-2">Hapus ulasan ini?</h5>
            <p class="text-muted">Ulasan yang dihapus tidak dapat dikembalikan.</p>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-secondary px-4" type="button" onclick="closeDeleteReviewModal()">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button class="btn btn-danger px-4" type="button" onclick="confirmDeleteReview()">
                <i class="fas fa-trash me-2"></i>Ya, Hapus
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Custom Modal Styles (scoped) */
#customDeleteReviewModal.custom-modal {
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

#customDeleteReviewModal.custom-modal.show {
    display: flex !important;
}

#customDeleteReviewModal .custom-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1;
}

#customDeleteReviewModal .custom-modal-content {
    position: relative;
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    z-index: 2;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: deleteReviewModalSlideIn 0.3s ease;
}

@keyframes deleteReviewModalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#customDeleteReviewModal .custom-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
    border-radius: 20px 20px 0 0;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#customDeleteReviewModal .custom-modal-header h5 {
    margin: 0;
    font-weight: 600;
}

#customDeleteReviewModal .custom-close-btn {
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

#customDeleteReviewModal .custom-close-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

#customDeleteReviewModal .custom-modal-body {
    padding: 2rem;
    text-align: center;
}

#customDeleteReviewModal .payment-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: deleteReviewPulse 2s infinite;
}

#customDeleteReviewModal .payment-icon i {
    font-size: 2.5rem;
    color: white;
}

@keyframes deleteReviewPulse {
    0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
    50% { box-shadow: 0 0 0 15px rgba(102, 126, 234, 0); }
    100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
}

#customDeleteReviewModal .custom-modal-footer {
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
    border-top: 1px solid #e9ecef;
}

#customDeleteReviewModal .custom-modal-footer .btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

#customDeleteReviewModal .custom-modal-footer .btn:hover {
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
let loadedReviews = {};
let selectedDeleteReviewId = null;

function toggleReviews(bukuId) {
    const container = document.getElementById(`reviews-${bukuId}`);
    
    if (container.style.display === 'none') {
        container.style.display = 'block';
        
        // Load reviews if not already loaded
        if (!loadedReviews[bukuId]) {
            loadReviews(bukuId);
        }
    } else {
        container.style.display = 'none';
    }
}

function loadReviews(bukuId) {
    fetch(`/api/reviews/${bukuId}`)
        .then(response => response.json())
        .then(data => {
            loadedReviews[bukuId] = true;
            const contentDiv = document.getElementById(`reviews-content-${bukuId}`);
            
            if (data.length === 0) {
                contentDiv.innerHTML = '<p class="text-muted text-center">Tidak ada ulasan</p>';
                return;
            }
            
            let html = '';
            data.forEach(review => {
                html += `
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>${review.user ? review.user.nama : 'Anonymous'}</strong>
                                <div class="mb-1">
                                    ${getStarHTML(review.rating)}
                                    <small class="text-muted ms-2">Review #${review.id_ulasan}</small>
                                </div>
                                <p class="mb-0">${review.komentar || '-'}</p>
                            </div>
                            <button class="btn btn-sm btn-danger" onclick="showDeleteReviewModal(${review.id_ulasan})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            contentDiv.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById(`reviews-content-${bukuId}`).innerHTML = 
                '<p class="text-danger">Error loading reviews</p>';
        });
}

function getStarHTML(rating) {
    let stars = '';
    for(let i = 1; i <= 5; i++) {
        if(i <= rating) {
            stars += '<i class="fas fa-star text-warning"></i>';
        } else {
            stars += '<i class="far fa-star text-warning"></i>';
        }
    }
    return stars;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

function showDeleteReviewModal(id) {
    selectedDeleteReviewId = id;
    const modal = document.getElementById('customDeleteReviewModal');
    modal.classList.add('show');
    document.body.classList.add('modal-open');
}

function closeDeleteReviewModal() {
    const modal = document.getElementById('customDeleteReviewModal');
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    selectedDeleteReviewId = null;
}

function confirmDeleteReview() {
    if (!selectedDeleteReviewId) return;
    const id = selectedDeleteReviewId;
    closeDeleteReviewModal();

    const currentPath = window.location.pathname;
    const isPetugas = currentPath.includes('/petugas/');

    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';
    form.action = isPetugas ? `/petugas/review/${id}` : `/review-ulasan/${id}`;

    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    document.body.appendChild(form);
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.querySelector('#customDeleteReviewModal .custom-modal-overlay');
    if (overlay) {
        overlay.addEventListener('click', closeDeleteReviewModal);
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteReviewModal();
        }
    });
});
</script>
@endpush