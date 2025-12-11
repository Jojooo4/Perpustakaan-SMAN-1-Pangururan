@extends('layouts.petugas')

@section('title', 'Pinjam & Kembali')
@section('page-title', 'Manajemen Peminjaman')

@section('content')
@include('admin.pinjam_kembali', ['__inherit' => true])
@endsection
