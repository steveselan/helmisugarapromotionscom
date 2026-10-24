@extends('layout.master')
@section('title','Undangan')
@section('konten')
    <a href="/undangan/create" type="button" class="btn btn-primary mb-3">Tambah Undangan</a>
    @if (session('pesan'))
        {{-- <div class="alert alert-primary">{{ session('pesan') }}</div> --}}
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('pesan') }}</strong> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-item-center">
            Daftar Undangan
            <div class="d-flex gap-1">
                @if (Request()->cari != '')
                <a href="/produk" class="btn btn-outline-primary">Reset</a>
                @endif
                <form class="input-group" style="width: 300px">
                <input type="text" class="form-control" name="cari" value="{{ Request()->cari }}" placeholder="Cari Data" aria-label="cari" aria-describedby="button-addon2">
                <button type="submit" class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
            </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                    <th scope="col" class="align-middle">No</th>
                    <th scope="col" width="30%">Judul Undangan</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col" class="align-middle">Tanggal</th>
                    <th scope="col" class="align-middle">Kapasitas</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_undangan as $dataundangan)
                        <tr>
                            <th class="align-middle" scope="row">{{ $loop->iteration }}</th>
                            <td class="align-middle">{{ $dataundangan->judul_event }}</td>
                            <td class="align-middle text-center">{{ $dataundangan->jenis }}</td>
                            <td class="align-middle" width="20%">{{ $dataundangan->lokasi_undangan }}</td>
                            <td class="align-middle text-center">{{ $dataundangan->tanggal }}</td>
                            <td class="align-middle text-center">{{ $dataundangan->kapasitas }}</td>
                            <td class="align-middle text-center">
                                <a href="/undangan/listrsvpundangan/{{ $dataundangan->judul }}" class="btn btn-sm btn-secondary">List RSVP</a>
                                {{-- <button type="button" class="btn btn-danger">Hapus</button> --}}
                                <a href="{{ route('undangan.edit',$dataundangan->id_undangan) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="/undangan/{{ $dataundangan->id_undangan }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">data produk tidak di temukan</td></tr>
                    @endforelse 
                </tbody>
            </table>
        </div>
    </div>

<!-- Modal -->
    @foreach ($data_undangan as $data)
    <div class="modal fade" id="hapus{{ $data->id_event }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/undangan/{{ $data->id_event }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            Apakah anda yakin mau dihapus {{ $data->judul_event }}?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya Hapus!</button>
        </div>
        </form>
    </div>
    </div>
    @endforeach
@endsection