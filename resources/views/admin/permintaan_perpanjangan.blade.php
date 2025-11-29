@extends('layouts.admin')

@section('title', 'Permintaan Perpanjangan')
@section('page-title', 'Permintaan Perpanjangan')

@section('content')
<div class="stat-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Jatuh Tempo Lama</th>
                    <th>Jatuh Tempo Baru</th>
                    <th>Alasan</th>
                    <th>Tanggal Request</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests ?? [] as $req)
                <tr>
                    <td>{{ $req->id_request }}</td>
                    <td><strong>{{ $req->peminjaman->user->nama ?? '-' }}</strong></td>
                    <td>{{ $req->peminjaman->asetBuku->buku->judul ?? '-' }}</td>
                    <td>{{ $req->peminjaman->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($req->peminjaman->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $req->tanggal_kembali_baru ? \Carbon\Carbon::parse($req->tanggal_kembali_baru)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $req->alasan }}</td>
                    <td>{{ $req->tanggal_request ? \Carbon\Carbon::parse($req->tanggal_request)->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        @if($req->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($req->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($req->status == 'pending')
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-success" onclick="approve({{ $req->id_request }})">
                                    <i class="fas fa-check"></i> Setuju
                                </button>
                                <button class="btn btn-danger" onclick="reject({{ $req->id_request }})">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                        @else
                            <span class="text-muted">Sudah diproses</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-clock fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                        Tidak ada permintaan perpanjangan
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
function approve(id) {
    if(confirm('Setujui permintaan perpanjangan ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/extensions/${id}/approve`;
        
        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function reject(id) {
    let reason = prompt('Alasan penolakan (opsional):');
    if(reason !== null) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/extensions/${id}/reject`;
        
        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        if(reason) {
            let reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'catatan_admin';
            reasonInput.value = reason;
            form.appendChild(reasonInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush