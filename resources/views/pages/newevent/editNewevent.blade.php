@extends('layout.master')

@section('title','Tambah Event')

@section('konten')
    <div class="card">
        <div class="card-header">Form tambah event</div>
        <div class="card-body">
            <form action="{{ route('newevent.update',$editevent->id_event) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="judul_event" class="form-label">Judul Event</label>
                            <input type="text" class="form-control" id="judul_event" name="judul_event" aria-describedby="judul_event" value="{{ $editevent->judul_event }}">
                            <input type="hidden" name="page" value="{{ $page }}">
                            @error('judul_event')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="artis" class="form-label">Artis</label>
                            <input type="text" class="form-control" id="artis" name="artis" aria-describedby="artis" value="{{ $editevent->artis }}">
                             @error('artis')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" aria-describedby="lokasi" value="{{ $editevent->lokasi }}">
                             @error('lokasi')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" aria-describedby="tanggal" value="{{ $editevent->tanggal }}">
                             @error('tanggal')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="link_tiket" class="form-label">Link Tiket</label>
                            <input type="text" class="form-control" id="link_tiket" name="link_tiket" aria-describedby="link_tiket" value="{{ $editevent->link_tiket }}">
                             @error('link_tiket')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="promotor" class="form-label">Promotor</label>
                            <input type="text" class="form-control" id="promotor" name="promotor" aria-describedby="promotor" value="{{ $editevent->promotor }}">
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
                                <option value="New" {{ ($editevent->status == 'New') ? 'selected' : ''; }}>New</option>
                                <option value="Past" {{ ($editevent->status == 'Past') ? 'selected' : ''; }}>Past</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Kategori Event</label>
                            <select class="custom-select" id="kategori" name="kategori">
                                <option selected>Choose...</option>
                                @foreach ( $listkategori as $listkat )
                                    <option value="{{ $listkat->id_kategori }}" {{ ($listkat->id_kategori == $editevent->kategori_id) ? 'selected' : ''; }}>{{ $listkat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="gambar1" class="form-label">Gambar Wide</label>
                            <input type="file" class="form-control" id="gambar1" name="gambar1" aria-describedby="gambar1" value="{{ $editevent->gambar1 }}">
                             @error('gambar1')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($editevent->gambar1 == null)
                            <p>Belum ada gambar</p>
                        @else
                            <img src="{{ asset('gambar_banner/'.$editevent->gambar1) }}" class="img-fluid mx-auto d-block mb-3 " height="10%" alt="...">
                        @endif
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="gambar2" class="form-label">Gambar Square</label>
                            <input type="file" class="form-control" id="gambar2" name="gambar2" aria-describedby="gambar2" value="{{ $editevent->gambar2 }}">
                             @error('gambar2')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($editevent->gambar2 == null)
                            <p>Belum ada gambar</p>
                        @else
                            <img src="{{ asset('gambar_banner/'.$editevent->gambar2) }}" class="img-fluid mx-auto d-block mb-3 " height="10%" alt="...">
                        @endif
                        
                    </div>
                    <div class="class-sm-12 mt-5">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="/newevent" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection