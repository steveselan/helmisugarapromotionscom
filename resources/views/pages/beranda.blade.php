@extends('layout.master')
@section('title','Dashboard')
@section('konten')
    <div class="alert alert-primary" role="alert">
        Selamat datang kembali <b>{{ Auth::user()->name }}</b> di aplikasi kami!
    </div>
@endsection