@extends('layout.master')

@section('title','Daftar Produk')

@section('konten')
    <a href="/produk/create" type="button" class="btn btn-primary mb-3">Tambah Data</a>
    <div class="alert alert-primary">
        <b>Nama Toko : </b>{{ $data_toko['nama_toko'] }}<br>
        <b>Alamat : </b>{{ $data_toko['alamat'] }}<br>
        <b>Tipe Toko : </b>{{ $data_toko['tipe'] }}
    </div>
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
        <div class="card-header d-flex justify-content-between align-item-center">
            Daftar Produk
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
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Produk</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_produk as $dataProduk)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $dataProduk->kode_produk }}</td>
                            <td>{{ $dataProduk->nama_produk }}</td>
                            <td>{{ $dataProduk->nama_kategori }}</td>
                            <td>{{ $dataProduk->harga }}</td>
                            <td>{{ $dataProduk->stok }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus{{ $dataProduk->id_produk }}">Hapus
                                </button>
                                {{-- <button type="button" class="btn btn-danger">Hapus</button> --}}
                                <a href="/produk/{{ $dataProduk->id_produk }}/edit" class="btn btn-warning">Edit</a>
                                <a href="/produk/{{ $dataProduk->id_produk }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">data produk tidak di temukan</td></tr>
                    @endforelse 
                </tbody>
            </table>
        </div>
    </div>

<!-- Modal -->
    @foreach ($data_produk as $produk)
    <div class="modal fade" id="hapus{{ $produk->id_produk }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/produk/{{ $produk->id_produk }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            Apakah anda yakin mau dihapus {{ $produk->nama_produk }}?
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