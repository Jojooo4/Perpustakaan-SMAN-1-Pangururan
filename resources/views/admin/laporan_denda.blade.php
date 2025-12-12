@extends('layouts.admin')

@section('title', 'Laporan Denda')
@section('page-title', 'Laporan Denda')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <div class="stat-card">
            <h6 class="mb-0">Total Denda Belum Lunas</h6>
            <h3 class="mb-0 text-danger">Rp {{ number_format($totalDendaBelumLunas ?? 0, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="lunas">Lunas</option>
            <option value="belum">Belum Lunas</option>
        </select>
    </div>
    <div class="col-md-3">
        <a href="{{ route('denda.export', request()->query()) }}" class="btn btn-success w-100 mb-2">
            <i class="fas fa-file-excel me-2"></i>Export Excel
        </a>
        <a href="{{ route('denda.export-pdf', request()->query()) }}" class="btn btn-danger w-100">
            <i class="fas fa-file-pdf me-2"></i>Export PDF
        </a>
    </div>
</div>

<div class="stat-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Jatuh Tempo</th>
                    <th>Kembali</th>
                    <th>Terlambat</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($denda ?? [] as $d)
                @php
                    $jatuhTempo = $d->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($d->tanggal_jatuh_tempo) : null;
                    $kembali = $d->tanggal_kembali ? \Carbon\Carbon::parse($d->tanggal_kembali) : now();
                    $hariTerlambat = $jatuhTempo ? max(0, $kembali->diffInDays($jatuhTempo, false) * -1) : 0;
                @endphp
                <tr>
                    <td>{{ $d->id_peminjaman }}</td>
                    <td><strong>{{ $d->user->nama ?? '-' }}</strong></td>
                    <td>{{ $d->asetBuku->buku->judul ?? '-' }}</td>
                    <td>{{ $jatuhTempo ? $jatuhTempo->format('d/m/Y') : '-' }}</td>
                    <td>{{ $d->tanggal_kembali ? $kembali->format('d/m/Y') : '-' }}</td>
                    <td><span class="badge bg-warning">{{ $hariTerlambat }} hari</span></td>
                    <td class="fw-bold text-danger">Rp {{ number_format($d->denda, 0, ',', '.') }}</td>
                    <td>
                        @if($d->denda_lunas ?? false)
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        @if(!($d->denda_lunas ?? false))
                            <button class="btn btn-success btn-sm" onclick="markPaid({{ $d->id_peminjaman }})">
                                <i class="fas fa-check me-1"></i>Lunas
                            </button>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-check me-1"></i>Sudah Lunas
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-money-bill-wave fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Tidak ada data denda
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markPaid(id) {
    if(confirm('Tandai denda sebagai lunas?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('denda.mark-paid', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id);

        const csrf = document.createElement('input');
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