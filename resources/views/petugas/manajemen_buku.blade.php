@extends('layouts.petugas')

@section('title', 'Manajemen Buku')
@section('page-title', 'Manajemen Buku')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    .book-cover-preview { width: 60px; height: 80px; object-fit: cover; border-radius: 4px; }
    .image-upload-preview { max-width: 200px; max-height: 250px; margin-top: 10px; border-radius: 8px; }
</style>
@endpush

@section('content')
@include('admin.manajemen_buku', ['__inherit' => true])
@endsection
