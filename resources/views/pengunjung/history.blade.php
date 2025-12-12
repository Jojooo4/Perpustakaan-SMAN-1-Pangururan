@extends('layouts.pengunjung')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

@section('content')
<div class="container-lg visitor-dashboard fade-in-dashboard">
    <div class="bg-overlay-soft rounded-3 p-2 p-md-3 mb-4">
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="stat-card gradient-warning shadow-sm">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
                    <p class="stat-label">Denda Belum Lunas</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-md-end">
            <a href="{{ route('pengunjung.dashboard') }}" class="btn btn-hero-search">
                <i class="fas fa-home me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

<!-- Sedang Dipinjam -->
    <div class="card-modern mb-4 shadow-sm rounded-4 bg-white bg-opacity-95 border-0">
        <div class="card-header-modern d-flex align-items-center rounded-top-4 px-3 py-2 bg-white bg-opacity-95 border-bottom fw-bold" style="backdrop-filter: saturate(120%) blur(2px);">
            <h5 class="mb-0 text-dark"><i class="fas fa-book-reader me-2"></i>Peminjaman Aktif</h5>
        </div>
        <div class="card-body-modern p-3">
        <div class="table-responsive">
                <table class="table table-hover table-sm align-middle mb-0">
                    <thead class="table-light rounded-3"><tr><th style="width:48px">#</th><th>Buku</th><th>Tgl Pinjam</th><th>Jatuh Tempo</th><th class="text-end">Denda</th></tr></thead>
                <tbody>
                    @forelse($loans->filter(fn($l)=>$l->status_peminjaman==='Dipinjam') as $loan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                                <strong class="d-block">{{ $loan->asetBuku->buku->judul ?? '-' }}</strong>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-pill bg-primary-subtle text-primary border">Aktif</span>
                                    <small class="text-muted">Aset: {{ $loan->asetBuku->kode ?? '-' }}</small>
                                </div>
                        </td>
                        <td>{{ $loan->tanggal_pinjam ? \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $loan->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}</td>
                        <td class="text-end"><span class="fw-semibold {{ ($loan->denda ?? 0) > 0 ? 'text-danger' : 'text-secondary' }}">Rp {{ number_format($loan->denda ?? 0, 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada peminjaman aktif</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

<!-- Terlambat -->
    <div class="card-modern mb-4 shadow-sm rounded-4 bg-white bg-opacity-95 border-0">
        <div class="card-header-modern d-flex align-items-center rounded-top-4 px-3 py-2 bg-white bg-opacity-95 border-bottom fw-bold" style="backdrop-filter: saturate(120%) blur(2px);">
            <h5 class="mb-0 text-dark"><i class="fas fa-exclamation-triangle me-2"></i>Riwayat Keterlambatan</h5>
        </div>
        <div class="card-body-modern p-3">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
                    <thead class="table-light rounded-3"><tr><th style="width:48px">#</th><th>Buku</th><th>Jatuh Tempo</th><th>Tgl Kembali</th><th class="text-end">Denda</th></tr></thead>
                <tbody>
                    @forelse($loans->filter(fn($l)=>$l->status_peminjaman==='Terlambat') as $loan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong class="d-block">{{ $loan->asetBuku->buku->judul ?? '-' }}</strong>
                            <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border">Terlambat</span>
                                <small class="text-muted">Aset: {{ $loan->asetBuku->kode ?? '-' }}</small>
                            </div>
                        </td>
                        <td>{{ $loan->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                        <td class="text-end"><span class="fw-bold text-danger">Rp {{ number_format($loan->denda ?? 0, 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada keterlambatan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

<!-- Dikembalikan -->
    <div class="card-modern shadow-sm rounded-4 bg-white bg-opacity-95 border-0">
        <div class="card-header-modern d-flex align-items-center rounded-top-4 px-3 py-2 bg-white bg-opacity-95 border-bottom fw-bold" style="backdrop-filter: saturate(120%) blur(2px);">
            <h5 class="mb-0 text-dark"><i class="fas fa-check-circle me-2"></i>Riwayat Pengembalian</h5>
        </div>
        <div class="card-body-modern p-3">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
                    <thead class="table-light rounded-3"><tr><th style="width:48px">#</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th class="text-end">Denda</th></tr></thead>
                <tbody>
                    @forelse($loans->filter(fn($l)=>$l->status_peminjaman==='Dikembalikan') as $loan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong class="d-block">{{ $loan->asetBuku->buku->judul ?? '-' }}</strong>
                            <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-pill bg-success-subtle text-success border">Dikembalikan</span>
                                <small class="text-muted">Aset: {{ $loan->asetBuku->kode ?? '-' }}</small>
                            </div>
                        </td>
                        <td>{{ $loan->tanggal_pinjam ? \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                        <td class="text-end"><span class="fw-semibold">Rp {{ number_format($loan->denda ?? 0, 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada yang dikembalikan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
            <div class="d-flex justify-content-end mt-2">
                {{ $loans->links() }}
            </div>
        </div>
    </div>
    </div>
</div>
    
</div>
@endsection
