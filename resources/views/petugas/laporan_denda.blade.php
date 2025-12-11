@extends('layouts.petugas')

@section('title', 'Laporan Denda')
@section('page-title', 'Laporan Denda')

@section('content')
@include('admin.laporan_denda', ['__inherit' => true])
@endsection
