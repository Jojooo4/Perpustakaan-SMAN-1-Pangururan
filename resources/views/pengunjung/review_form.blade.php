@extends('layouts.pengunjung')

@section('title', 'Tulis Review')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card-custom p-4">
            <h4 class="mb-4"><i class="fas fa-star me-2" style="color: var(--primary);"></i>Tulis Review untuk "{{ $book->judul }}"</h4>
            
            <form action="{{ route('pengunjung.reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kode_buku" value="{{ $book->kode_buku }}">
                
                <div class="mb-3">
                    <label class="form-label">Rating <span class="text-danger">*</span></label>
                    <div class="rating-input d-flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                        <label style="cursor: pointer; font-size: 2rem;">
                            <input type="radio" name="rating" value="{{ $i }}" required style="display: none;">
                            <i class="far fa-star" data-rating="{{ $i }}"></i>
                        </label>
                        @endfor
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ulasan Anda <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="ulasan" rows="5" required placeholder="Tulis review Anda tentang buku ini..."></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Review
                    </button>
                    <a href="{{ route('pengunjung.catalog.show', $book->kode_buku) }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.rating-input i').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.dataset.rating;
        const input = this.previousElementSibling;
        input.checked = true;
        
        // Update star display
        document.querySelectorAll('.rating-input i').forEach((s, idx) => {
            if (idx < rating) {
                s.classList.remove('far');
                s.classList.add('fas', 'text-warning');
            } else {
                s.classList.remove('fas', 'text-warning');
                s.classList.add('far');
            }
        });
    });
});
</script>
@endpush
