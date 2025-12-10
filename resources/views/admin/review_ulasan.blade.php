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
                
                <div class="ms-3 flex-grow-1">
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
                        <i class="fas fa-eye me-1"></i>Lihat Ulasan
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
@endsection

@push('scripts')
<script>
let loadedReviews = {};

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
                                <strong>${review.nomor_identitas}</strong>
                                <div class="mb-1">
                                    ${getStarHTML(review.rating)}
                                    <small class="text-muted ms-2">${formatDate(review.created_at)}</small>
                                </div>
                                <p class="mb-0">${review.ulasan || '-'}</p>
                            </div>
                            <button class="btn btn-sm btn-danger" onclick="deleteReview(${review.id_ulasan})">
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

function deleteReview(id) {
    if(confirm('Hapus ulasan ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/review-ulasan/${id}`;
        
        let methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
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