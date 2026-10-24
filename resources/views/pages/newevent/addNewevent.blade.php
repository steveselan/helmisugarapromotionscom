@extends('layout.master')

@section('title','Tambah Event')

@section('konten')
    <div class="card">
        <div class="card-header">Form tambah event</div>
        <div class="card-body">
            <form action="/newevent" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="judul_event" class="form-label">Judul Event</label>
                            <input type="text" class="form-control" id="judul_event" name="judul_event" aria-describedby="judul_event" value="{{ old('judul_event') }}">
                            @error('judul_event')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="artis" class="form-label">Artis</label>
                            <input type="text" class="form-control" id="artis" name="artis" aria-describedby="artis" value="{{ old('artis') }}">
                             @error('artis')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" aria-describedby="lokasi" value="{{ old('lokasi') }}">
                             @error('lokasi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" aria-describedby="tanggal" value="{{ old('tanggal') }}">
                             @error('tanggal')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="link_tiket" class="form-label">Link Tiket</label>
                            <input type="text" class="form-control" id="link_tiket" name="link_tiket" aria-describedby="link_tiket" value="{{ old('link_tiket') }}">
                             @error('link_tiket')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="promotor" class="form-label">Promotor</label>
                            <input type="text" class="form-control" id="promotor" name="promotor" aria-describedby="promotor" value="{{ old('promotor') }}">
                             @error('promotor')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="custom-select" id="status" name="status">
                                <option selected>Choose...</option>
                                    <option value="New">New</option>
                                    <option value="Past">Past</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Kategori Event</label>
                            <select class="custom-select" id="kategori" name="kategori">
                                <option selected>Choose...</option>
                                @foreach ( $listkategori as $listkat )
                                    <option value="{{ $listkat->id_kategori }}">{{ $listkat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="gambar1" class="form-label">Gambar Wide</label>
                            <input type="file" class="form-control" id="gambar1" name="gambar1" aria-describedby="gambar1" value="{{ old('gambar1') }}">
                             @error('gambar1')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="gambar2" class="form-label">Gambar Square</label>
                            <input type="file" class="form-control" id="gambar2" name="gambar2" aria-describedby="gambar2" value="{{ old('gambar2') }}">
                             @error('gambar2')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="class-sm-12 mt-5">
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                        <a href="/newevent" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection