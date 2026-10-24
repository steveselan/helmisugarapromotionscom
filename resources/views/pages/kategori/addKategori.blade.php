@extends('layout.master')

@section('konten')
    <div class="card">
        <div class="card-header">Tambah Kategori</div>
        <div class="card-body">
            <form action="/kategori" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" aria-describedby="nama_kategori" value="{{ old('nama_kategori') }}">
                            @error('nama_kategori')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" aria-describedby="deskripsi" value="{{ old('deskripsi') }}">
                            @error('deskripsi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="class-sm-12">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection