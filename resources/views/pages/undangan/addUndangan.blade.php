@extends('layout.master')

@section('title','Tambah Undangan')

@section('konten')
    <div class="card">
        <div class="card-header">Form tambah undangan</div>
        <div class="card-body">
            <form action="/undangan" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Jenis Undangan</label>
                            <select class="custom-select" id="status" name="jenis_undangan">
                                <option selected>Choose...</option>
                                    <option value="PC">Press Conference</option>
                                    <option value="Konser">Konser</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Untuk Event?</label>
                            <select class="custom-select" id="status" name="event_id">
                                <option selected>Choose...</option>
                                @foreach ( $acara as $list_acara )
                                    <option value="{{ $list_acara->id_event }}">{{ $list_acara->judul_event }}</option>
                                @endforeach
                            </select>
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
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" aria-describedby="lokasi" value="{{ old('lokasi') }}">
                             @error('lokasi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="time" class="form-control" id="jam" name="jam" aria-describedby="jam" value="{{ old('jam') }}">
                            @error('jam')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label for="jam" class="form-label">Kapasitas Kursi</label>
                            <input type="number" class="form-control" id="kapasitas" name="kapasitas" aria-describedby="kapasitas" value="{{ old('kapasitas') }}">
                            @error('kapasitas')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="class-sm-12 mt-3">
                        <button type="submit" class="btn btn-primary">Tambah Undangan</button>
                        <a href="/undangan" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection