@extends('layout.master')
@section('title','Media Plan')
@section('konten')
    <a href="/mediaplan/create" type="button" class="btn btn-primary mb-3">Tambah Media Plan</a>
    @if (session('pesan'))
        {{-- <div class="alert alert-primary">{{ session('pesan') }}</div> --}}
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ session('pesan') }}</strong> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="dataTable" width="cellspacing="0">
                    <thead>
                        <tr>
                        <th scope="col" class="align-middle">No</th>
                            <th scope="col" width="30%">Nama Media Plan</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($data_mediaplan as $mediaplan)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td class="align-middle">{{ $mediaplan->judul_event }}</td>
                                <td class="align-middle">
                                    @if ($mediaplan->jenis_media == 'RA') RADIO
                                    @elseif ($mediaplan->jenis_media == 'OLWB') ONLINE WEB BASE  
                                    @elseif ($mediaplan->jenis_media == 'OLNM') ONLINE NEW MEDIA  
                                    @endif
                                </td>
                                <td class="align-middle">
                                <a href="/mediaplan/show/{{ $mediaplan->id_mediaplan }}" class="btn btn-info">Detail</a>
                                <a href="/mediaplan/{{ $mediaplan->id_mediaplan }}/edit" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><tr colspan="6" class="text-center">data produk tidak di temukan<tr>
                        @endforelse 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection