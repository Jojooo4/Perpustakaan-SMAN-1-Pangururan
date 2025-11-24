@extends('layouts.admin')

@section('title', 'Password Reset Requests')

@section('content')
    <div class="p-4">
        <h3>Permintaan Reset Password</h3>
        <p class="text-muted">Daftar permintaan yang dikirim oleh pengguna (siswa tanpa email). Tanggal paling baru ada di baris paling bawah.</p>

        @if(empty($requests))
            <div class="alert alert-info">Belum ada permintaan.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Identifier</th>
                            <th>User ID</th>
                            <th>Pesan</th>
                            <th>Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $r['identifier'] ?? '-' }}</td>
                                <td>{{ $r['user_id'] ?? '-' }}</td>
                                <td style="max-width:360px; white-space:pre-wrap;">{{ $r['message'] ?? '-' }}</td>
                                <td>{{ $r['created_at'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
