@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')
<div class="row mb-3">
    <div class="col-md-3">
        <div class="stat-card">
            <h6 class="mb-0 text-muted">Total Aktivitas</h6>
            <h3 class="mb-0">{{ $stats['total'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h6 class="mb-0 text-muted">Hari Ini</h6>
            <h3 class="mb-0 text-primary">{{ $stats['today'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h6 class="mb-0 text-muted">Minggu Ini</h6>
            <h3 class="mb-0 text-success">{{ $stats['this_week'] }}</h3>
        </div>
    </div>
</div>

<div class="card-custom p-4">
    <h5 class="mb-3"><i class="fas fa-history me-2"></i>Riwayat Aktivitas</h5>
    
    <!-- Filters -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label small">Tabel</label>
            <select name="table" class="form-select form-select-sm">
                <option value="">Semua</option>
                <option value="peminjaman" {{ request('table') == 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                <option value="request_peminjaman" {{ request('table') == 'request_peminjaman' ? 'selected' : '' }}>Request Peminjaman</option>
                <option value="request_perpanjangan" {{ request('table') == 'request_perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                <option value="buku" {{ request('table') == 'buku' ? 'selected' : '' }}>Buku</option>
                <option value="users" {{ request('table') == 'users' ? 'selected' : '' }}>Users</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">Operasi</label>
            <select name="operation" class="form-select form-select-sm">
                <option value="">Semua</option>
                <option value="insert" {{ request('operation') == 'insert' ? 'selected' : '' }}>Insert</option>
                <option value="update" {{ request('operation') == 'update' ? 'selected' : '' }}>Update</option>
                <option value="delete" {{ request('operation') == 'delete' ? 'selected' : '' }}>Delete</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">User</label>
            <select name="user_id" class="form-select form-select-sm">
                <option value="">Semua</option>
                @foreach($users as $user)
                <option value="{{ $user->id_user }}" {{ request('user_id') == $user->id_user ? 'selected' : '' }}>{{ $user->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">Dari</label>
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label small">Sampai</label>
            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-1">
            <label class="form-label small">&nbsp;</label>
            <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-filter"></i></button>
        </div>
    </form>
    
    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead class="table-dark">
                <tr>
                    <th width="50">ID</th>
                    <th width="120">Waktu</th>
                    <th width="120">User</th>
                    <th width="100">Tabel</th>
                    <th width="80">Operasi</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->id_log }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->timestamp)->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $log->username }}</strong></td>
                    <td><span class="badge bg-secondary">{{ $log->nama_tabel }}</span></td>
                    <td>
                        @if($log->operasi == 'insert')
                            <span class="badge bg-success">INSERT</span>
                        @elseif($log->operasi == 'update')
                            <span class="badge bg-warning text-dark">UPDATE</span>
                        @else
                            <span class="badge bg-danger">DELETE</span>
                        @endif
                    </td>
                    <td>{{ $log->deskripsi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block" style="opacity: 0.3;"></i>
                        <span class="text-muted">Tidak ada log aktivitas</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $logs->appends(request()->query())->links() }}
</div>
@endsection
