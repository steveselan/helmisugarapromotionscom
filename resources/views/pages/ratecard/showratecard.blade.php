@extends('layout.master')
@section('title','Rate Card Media')
@section('konten')
    <a href="/ratecard/create" type="button" class="btn btn-primary mb-3">Tambah Rate Card</a>
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
                <table class="table table-striped table-bordered" id="dataTable" width="cellspacing="0">
                    <thead>
                        <tr>
                        <th scope="col" class="align-middle">No</th>
                            <th scope="col" width="30%">Nama Media</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Kategori</th>
                            <th scope="col" class="align-middle">Kota</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($data_ratecard as $ratecard)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td class="align-middle">{{ $ratecard->nama_media }}</td>
                                <td class="align-middle">{{ $ratecard->jenis }}</td>
                                <td class="align-middle">{{ $ratecard->kategori }}</td>
                                <td class="align-middle">{{ $ratecard->kota }}</td>
                                <td class="align-middle">
                                <a href="/ratecard/show/{{ $ratecard->id_ratecard }}" class="btn btn-sm btn-info">Detail</a>
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