@extends('layout.master')

@section('title','Edit Produk')
@section('konten')
    <div class="card">
        <div class="card-header">Edit Data Produk</div>
        <div class="card-body">
            <form action="/produk/{{ $edit->id_produk }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" aria-describedby="nama_produk" value="{{ $edit->nama_produk }}">
                            @error('nama_produk')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" aria-describedby="harga" value="{{ $edit->harga }}"">
                             @error('harga')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" aria-describedby="stok" value="{{ $edit->stok }}"">
                             @error('stok')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                   <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="custom-select" id="kategori" name="kategori">
                                <option selected>Choose...</option>
                                @foreach ( $kategori as $list )
                                    @if($list->id_kategori == $edit->kategori_id)
                                        <option value="{{ $list->id_kategori }}" selected>{{ $list->nama_kategori }}</option>
                                    @else
                                        <option value="{{ $list->id_kategori }}">{{ $list->nama_kategori }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <img src="{{ asset('gambar_produk/'.$edit->gambar) }}" class="img-fluid float-right mb-3 " width="100" alt="...">
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" aria-describedby="gambar" value="{{ $edit->gambar }}">
                            <div class="form-text text-muted">*Isi bagian ini jika ingin menggati gambar yang sudah ada.</div>
                             @error('gambar')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="deskripsi" name="deskripsi">{{ $edit->deskripsi_produk }}</textarea>
                            <label for="floatingTextarea">Deskripsi</label>
                             @error('deskripsi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="class-sm-12">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="/produk" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection