@extends('layout.master')
@section('title','Bukti Siar')
@section('konten')
    <a href="/mediaplan/create" type="button" class="btn btn-primary mb-3">Tambah Bukti Siar</a>
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
                            <th scope="col">No</th>
                            <th scope="col" width="30%">Nama Media Plan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($data_mediaplan as $eventId => $items)
                        @php 
                            // Ambil baris pertama dari grup ini untuk mengakses data event-nya
                            $firstItem = $items->first(); 
                        @endphp
                            <tr>
                                <td class="align-middle" width="50">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $firstItem->event->judul_event ?? '-' }}</td>
                                <td class="align-middle">
                                <a href="/buktisiar/event/{{ $eventId }}" class="btn btn-info">Detail</a>
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