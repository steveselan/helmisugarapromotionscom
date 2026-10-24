@extends('layout.master')

@section('konten')
    <div class="card">
        <div class="card-header">Edit Kategori</div>
        <div class="card-body">
            <form action="{{ route('kategori.update',$editKategori->id_kategori) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" aria-describedby="nama_kategori" value="{{ $editKategori->nama_kategori }}">
                            @error('nama_kategori')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" aria-describedby="deskripsi" value="{{ $editKategori->deskripsi }}">
                            @error('deskripsi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="class-sm-12">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection