@extends('layouts.pengunjung')

@section('title', 'Perpanjangan Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">Perpanjangan Peminjaman</h3>
        
        <div class="card-custom p-4">
            <h5 class="mb-3">Peminjaman Aktif</h5>
            @if($activeLoans && $activeLoans->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeLoans as $loan)
                            <tr>
                                <td><strong>{{ $loan->asetBuku->buku->judul ?? 'N/A' }}</strong></td>
                                <td>{{ $loan->tanggal_jatuh_tempo ? $loan->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($loan->isTerlambat())
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-success">Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$loan->isTerlambat() && !$loan->requestPerpanjangan()->where('status', 'pending')->exists())
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#extendModal{{ $loan->id_peminjaman }}">
                                            <i class="fas fa-plus me-1"></i>Ajukan Perpanjangan
                                        </button>
                                    @elseif($loan->requestPerpanjangan()->where('status', 'pending')->exists())
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    @else
                                        <span class="text-danger">Tidak dapat diperpanjang (terlambat)</span>
                                    @endif
                                </td>
                            </tr>
                            
                            <!-- Extension Modal -->
                            <div class="modal fade" id="extendModal{{ $loan->id_peminjaman }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('pengunjung.extensions.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_peminjaman" value="{{ $loan->id_peminjaman }}">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ajukan Perpanjangan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Buku:</strong> {{ $loan->asetBuku->buku->judul }}</p>
                                                <p><strong>Jatuh Tempo Saat Ini:</strong> {{ $loan->tanggal_jatuh_tempo->format('d/m/Y') }}</p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Perpanjang Berapa Hari? <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="hari_perpanjangan" min="1" max="7" value="7" required>
                                                    <small class="text-muted">Maksimal 7 hari</small>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan</label>
                                                    <textarea class="form-control" name="alasan" rows="3" placeholder="Opsional"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Ajukan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-3">Tidak ada peminjaman aktif</p>
            @endif
        </div>
        
        <!-- Extension History -->
        <div class="card-custom p-4 mt-4">
            <h5 class="mb-3">Riwayat Permintaan Perpanjangan</h5>
            @if($extensionRequests && $extensionRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Tanggal Request</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($extensionRequests as $req)
                            <tr>
                                <td>{{ $req->peminjaman->asetBuku->buku->judul ?? 'N/A' }}</td>
                                <td>{{ $req->tanggal_request ? \Carbon\Carbon::parse($req->tanggal_request)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($req->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $req->catatan_admin ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-3">Belum ada permintaan perpanjangan</p>
            @endif
        </div>
    </div>
</div>
@endsection
