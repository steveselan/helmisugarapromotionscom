@extends('layout.master')

@section('title','Detail Produk')

@section('konten')
    <div class="card">
        <div class="card-header">
            Detail Produk
        </div>
        <div class="card-body">
            <img src="{{ asset('gambar_produk/'.$detail->gambar) }}" class="img-fluid mb-3" width="300" alt="...">
            <p>Kode Produk : {{ $detail->kode_produk }}</p>
            <p>Nama Produk : {{ $detail->nama_produk }}</p>
            <p>Harga : {{ $detail->harga }}</p>
            <p>Deskripsi : {{ $detail->deskripsi_produk }}</p>
            <p>Kategori : {{ $detail->nama_kategori }}</p>
            <p>Stok : {{ $detail->stok }}</p>
            <a href="/produk" class="btn btn-primary">Kembali</a>
        </div>
    </div>
@endsection