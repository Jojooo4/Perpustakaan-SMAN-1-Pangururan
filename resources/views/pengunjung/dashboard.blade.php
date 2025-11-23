
@extends('layouts.pengunjung')

@section('title','Dashboard Pengunjung')

@section('content')
<style>
  /* Color palette provided:
     EB455F, FCFFE7, BAD7E9, 2B3467 */
  :root{
    --p-primary: #EB455F; /* accent / warm red */
    --p-bg: #FCFFE7; /* very light background */
    --p-muted: #BAD7E9; /* soft blue */
    --p-dark: #2B3467; /* deep navy */
    --card-radius: 1rem;
  }

  body { background: var(--p-bg); }

  .dashboard-hero{
    background: linear-gradient(90deg,var(--p-dark) 0%, rgba(43,52,103,0.8) 60%);
    color: #fff;
    border-radius: var(--card-radius);
    padding: 1.25rem;
    position: relative;
    overflow: hidden;
  }
  .dashboard-hero .subtitle{ color: rgba(255,255,255,0.9); }

  .dashboard-avatar{ width:72px; height:72px; border-radius:50%; border:3px solid rgba(255,255,255,0.15); object-fit:cover; }

  .search-large{ background: #fff; border-radius: 0.75rem; padding:0.6rem; box-shadow: 0 6px 20px rgba(43,52,103,0.12); }
  .search-input{ border: none; outline: none; }
  .search-btn{ background: var(--p-primary); color:#fff; border:none; }

  .dashboard-card{ border-radius: var(--card-radius); background: #fff; box-shadow:0 10px 30px rgba(43,52,103,0.06); border:1px solid rgba(43,52,103,0.04); }
  .quick-action{ background: linear-gradient(180deg, rgba(235,69,95,0.06), rgba(235,69,95,0.02)); border:1px solid rgba(235,69,95,0.08); }

  .book-thumb{ width:100%; height:160px; object-fit:cover; border-radius:0.5rem 0.5rem 0 0; }
  .book-card-body{ padding:0.8rem; }

  .announce{ background: linear-gradient(90deg, rgba(43,52,103,0.03), rgba(186,215,233,0.04)); border-left:4px solid var(--p-dark); padding:1rem; border-radius:0.5rem; }

  @media (max-width:767px){ .book-thumb{ height:140px; } }

</style>


<div class="container-fluid py-4">

  <div class="row mb-4">
    <div class="col-12">
      <div class="dashboard-hero d-flex align-items-center gap-3">
        <div class="flex-grow-1">
          <h3 class="mb-1">Halo, {{ auth()->user()->nama ?? auth()->user()->username }}!</h3>
          <div class="subtitle">Temukan buku yang Anda butuhkan atau cek peminjaman Anda.</div>
          <div class="mt-3">
            <form action="{{ route('pengunjung.search') ?? '#' }}" method="GET">
              <div class="d-flex align-items-center search-large" role="search">
                <input name="q" class="form-control search-input me-2" type="search" placeholder="Cari judul, pengarang, kategori..." aria-label="Search">
                <button class="btn search-btn px-4" type="submit"><i class="bi bi-search"></i> Cari</button>
              </div>
            </form>
          </div>
          {{-- search only here; quote moved below hero --}}
        </div>
        <div class="text-end d-none d-md-block">
          <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? auth()->user()->username) }}&background=EB455F&color=fff" class="dashboard-avatar" alt="avatar">
        </div>
      </div>
    </div>
  </div>

    {{-- Daily quote row (separate from hero) --}}
    @php
      $quotes = [
        'Buku adalah jendela dunia. — Pepatah',
        'Membaca adalah cara pindah dari satu hati ke hati lain. — Anonymous',
        'Buku membuka pintu ke dunia yang tak terbatas. — Anonymous',
        'Sebuah ruangan tanpa buku ibarat sebuah tubuh tanpa jiwa. — Cicero',
        'Bacalah untuk hidup, bukan hidup untuk membaca. — Anonymous'
      ];
      $idx = \Illuminate\Support\Carbon::now()->dayOfYear % count($quotes);
      $todayQuote = $quotes[$idx];
    @endphp
    <div class="row mb-3">
      <div class="col-12">
        <div class="card p-3" style="border-left:4px solid var(--p-primary);">
          <div class="fw-semibold">Kata Bijak Hari Ini</div>
          <div class="fst-italic text-muted">{{ $todayQuote }}</div>
        </div>
      </div>
    </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <div class="row g-3">
        <div class="col-12">
          <div class="card dashboard-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Koleksi Populer</h5>
              <a href="{{ route('pengunjung.katalog') ?? '#' }}" class="text-decoration-none" style="color:var(--p-dark);">Lihat semua</a>
            </div>
            <div class="row g-3">
              @forelse($popularBooks ?? [] as $book)
              <div class="col-sm-6 col-md-4">
                <div class="card book-card dashboard-card">
                  <img src="{{ $book->cover_url ?? 'https://via.placeholder.com/300x200?text=Book' }}" class="book-thumb" alt="{{ $book->judul ?? 'Buku' }}">
                  <div class="book-card-body">
                    <h6 class="mb-1 fw-semibold">{{ Str::limit($book->judul ?? '-', 40) }}</h6>
                    <small class="text-muted">{{ $book->pengarang ?? '-' }}</small>
                  </div>
                </div>
              </div>
              @empty
              <!-- fallback sample cards -->
              <div class="col-sm-6 col-md-4">
                <div class="card book-card dashboard-card">
                  <img src="https://cdn.pixabay.com/photo/2014/04/02/10/55/open-book-306872_1280.png" class="book-thumb" alt="Sample">
                  <div class="book-card-body">
                    <h6 class="mb-1 fw-semibold">Pengantar Pemrograman</h6>
                    <small class="text-muted">John Doe</small>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="card book-card dashboard-card">
                  <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/books-1294672_1280.png" class="book-thumb" alt="Sample">
                  <div class="book-card-body">
                    <h6 class="mb-1 fw-semibold">Sejarah Lokal</h6>
                    <small class="text-muted">S. Pangururan</small>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="card book-card dashboard-card">
                  <img src="https://cdn.pixabay.com/photo/2013/07/13/11/50/book-160533_1280.png" class="book-thumb" alt="Sample">
                  <div class="book-card-body">
                    <h6 class="mb-1 fw-semibold">Kumpulan Cerita</h6>
                    <small class="text-muted">Lengkap</small>
                  </div>
                </div>
              </div>
              @endforelse
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card dashboard-card p-3">
            <h5 class="mb-3">Koleksi Terbaru</h5>
            <div class="row g-3">
              @forelse($latestBooks ?? [] as $book)
              <div class="col-sm-6 col-md-3">
                <div class="card book-card dashboard-card">
                  <img src="{{ $book->cover_url ?? 'https://via.placeholder.com/300x200?text=New' }}" class="book-thumb" alt="{{ $book->judul ?? 'Buku' }}">
                  <div class="book-card-body">
                    <h6 class="mb-1 fw-semibold">{{ Str::limit($book->judul ?? '-', 30) }}</h6>
                    <small class="text-muted">{{ $book->pengarang ?? '-' }}</small>
                  </div>
                </div>
              </div>
              @empty
              <div class="col-6 col-md-3">
                <div class="card dashboard-card p-3 text-center">
                  <img src="https://cdn.pixabay.com/photo/2014/04/02/10/55/open-book-306872_1280.png" style="width:80px;" alt="sample">
                  <div class="mt-2">Tidak ada koleksi terbaru</div>
                </div>
              </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="d-grid gap-3">
        <div class="card dashboard-card p-3 quick-action">
          <h6 class="mb-2">Akses Cepat</h6>
          <div class="row g-2">
            <div class="col-6">
              <a href="{{ route('pengunjung.riwayat') ?? '#' }}" class="d-block text-center p-2 rounded text-decoration-none" style="background:#fff; border-radius:0.5rem;">
                <i class="bi bi-clock-history fs-3" style="color:var(--p-primary)"></i>
                <div class="small mt-1">Riwayat Pinjam</div>
              </a>
            </div>
            <div class="col-6">
              <a href="{{ route('pengunjung.katalog') ?? '#' }}" class="d-block text-center p-2 rounded text-decoration-none" style="background:#fff; border-radius:0.5rem;">
                <i class="bi bi-journal-bookmark fs-3" style="color:var(--p-primary)"></i>
                <div class="small mt-1">Katalog</div>
              </a>
            </div>
            <div class="col-6">
              <a href="{{ route('pengunjung.perpanjang') ?? '#' }}" class="d-block text-center p-2 rounded text-decoration-none" style="background:#fff; border-radius:0.5rem;">
                <i class="bi bi-arrow-repeat fs-3" style="color:var(--p-primary)"></i>
                <div class="small mt-1">Perpanjang</div>
              </a>
            </div>
          </div>
        </div>

        <div class="card dashboard-card p-3">
          <h6 class="mb-3">Pengumuman</h6>
          @if(!empty($announcements ?? []))
            <ul class="list-unstyled mb-0">
              @foreach($announcements as $note)
                <li class="mb-2 announce"> <strong>{{ $note->title ?? 'Pengumuman' }}</strong>
                  <div class="small text-muted">{{ $note->message ?? $note->body ?? '' }}</div>
                  <div class="small text-muted">{{ isset($note->date) ? $note->date->format('d M Y') : '' }}</div>
                </li>
              @endforeach
            </ul>
          @else
            <div class="announce">Hari ini perpustakaan buka seperti biasa. Cek katalog untuk buku baru.</div>
          @endif
        </div>

        <div class="card dashboard-card p-3">
          <h6 class="mb-2">Informasi Peminjaman</h6>
          <p class="mb-0">— Data peminjaman Anda akan tampil di sini. Silakan hubungi petugas jika ada kendala.</p>
        </div>
      </div>
    </div>
  </div>

</div>


<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
