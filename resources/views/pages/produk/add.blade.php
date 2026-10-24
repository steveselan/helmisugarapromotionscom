@extends('layout.master')

@section('title','Tambah Produk')

@section('konten')
    <div class="card">
        <div class="card-header">Form tambah data produk</div>
        <div class="card-body">
            <form action="/produk" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" aria-describedby="nama_produk" value="{{ old('nama_produk') }}">
                            @error('nama_produk')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" aria-describedby="harga" value="{{ old('harga') }}">
                             @error('harga')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" aria-describedby="stok" value="{{ old('stok') }}">
                             @error('stok')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" aria-describedby="gambar" value="{{ old('gambar') }}">
                             @error('gambar')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Kategori</label>
                            <select class="custom-select" id="kategori" name="kategori">
                                <option selected>Choose...</option>
                                @foreach ( $list_kategori as $list )
                                    <option value="{{ $list->id_kategori }}">{{ $list->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <div class="form-floating mb-3">
                            <label for="floatingTextarea">Deskripsi</label>
                            <textarea class="form-control" placeholder="Leave a comment here" id="deskripsi" name="deskripsi"></textarea>
                             @error('deskripsi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="class-sm-12">
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection