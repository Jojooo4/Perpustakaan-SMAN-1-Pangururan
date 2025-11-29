@extends('layouts.admin')

@section('title', 'Pinjam & Kembali')
@section('page-title', 'Manajemen Peminjaman')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoanModal">
            <i class="fas fa-plus me-2"></i>Pinjam Buku
        </button>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="Dipinjam">Dipinjam</option>
            <option value="Dikembalikan">Dikembalikan</option>
            <option value="Terlambat">Terlambat</option>
        </select>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" id="searchLoan" placeholder="Cari peminjam...">
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
                    <th>Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman ?? [] as $p)
                <tr>
                    <td>{{ $p->id_peminjaman }}</td>
                    <td><strong>{{ $p->user->nama ?? '-' }}</strong></td>
                    <td>{{ $p->asetBuku->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                    <td>{{ $p->tanggal_jatuh_tempo ? $p->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                    <td>{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($p->status_peminjaman == 'Dipinjam')
                            <span class="badge bg-warning">Dipinjam</span>
                        @elseif($p->status_peminjaman == 'Dikembalikan')
                            <span class="badge bg-success">Dikembalikan</span>
                        @else
                            <span class="badge bg-danger">Terlambat</span>
                        @endif
                    </td>
                    <td>
                        @if($p->denda > 0)
                            <span class="text-danger fw-bold">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status_peminjaman == 'Dipinjam')
                            <button class="btn btn-success btn-sm" onclick="returnBook({{ $p->id_peminjaman }})">
                                <i class="fas fa-check me-1"></i>Kembalikan
                            </button>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-check me-1"></i>Selesai
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-exchange-alt fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Belum ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Loan Modal -->
<div class="modal fade" id="addLoanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.loans.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: var(--dark); color: white;">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Pinjam Buku</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Peminjam <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_user" required>
                            <option value="">Pilih Peminjam</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id_user }}">{{ $user->nama }} ({{ $user->username }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Buku <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_aset_buku" required>
                            <option value="">Pilih Buku</option>
                            @foreach($asetTersedia ?? [] as $aset)
                                <option value="{{ $aset->id_aset }}">
                                    {{ $aset->buku->judul ?? '-' }} ({{ $aset->nomor_inventaris }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lama Peminjaman (Hari) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="lama_pinjam" min="1" max="14" value="7" required>
                        <small class="text-muted">Maksimal 14 hari</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Pinjam
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function returnBook(id) {
    if(confirm('Kembalikan buku ini? Denda akan dihitung otomatis jika terlambat.')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pinjam_kembali/${id}/kembali`;
        
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