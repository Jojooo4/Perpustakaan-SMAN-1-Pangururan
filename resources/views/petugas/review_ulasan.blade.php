@extends('layouts.petugas')

@section('title', 'Review Ulasan')
@section('page-title', 'Review Ulasan Buku')

@section('content')
@include('admin.review_ulasan', ['__inherit' => true])
@endsection
