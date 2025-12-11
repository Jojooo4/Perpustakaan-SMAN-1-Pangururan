@extends('layouts.petugas')

@section('title', 'Permintaan Perpanjangan')
@section('page-title', 'Permintaan Perpanjangan')

@section('content')
@include('admin.permintaan_perpanjangan', ['__inherit' => true])
@endsection
