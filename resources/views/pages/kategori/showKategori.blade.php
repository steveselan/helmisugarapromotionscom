@extends('layout.master')

@section('title','Daftar Kategori')
@section('konten')
    <a href="/kategori/create" type="button" class="btn btn-primary mb-3">Tambah Kategori</a>
    
    @if (session('pesan'))
        {{-- <div class="alert alert-primary">{{ session('pesan') }}</div> --}}
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ session('pesan') }}</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-item-center">
            Daftar Kategori
            <div class="d-flex gap-1">
                @if (Request()->cari != '')
                <a href="/kategori" class="btn btn-outline-primary">Reset</a>
                @endif
                <form class="input-group" style="width: 300px">
                <input type="text" class="form-control" name="cari" value="{{ Request()->cari }}" placeholder="Cari Kategori" aria-label="cari" aria-describedby="button-addon2">
                <button type="submit" class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
            </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataKategori as $itemKategori)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $itemKategori->nama_kategori }}</td>
                            <td>{{ $itemKategori->deskripsi }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus{{ $itemKategori->id_kategori }}">Hapus
                                </button>
                                {{-- <button type="button" class="btn btn-danger">Hapus</button> --}}
                                <a href="/kategori/{{ $itemKategori->id_kategori }}/edit" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">data produk tidak di temukan</td></tr>
                    @endforelse 
                </tbody>
            </table>
        </div>
    </div>

<!-- Modal -->
@foreach ($dataKategori as $kategori)
<div class="modal fade" id="hapus{{ $kategori->id_kategori }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('kategori.destroy',$kategori->id_kategori) }}" method="POST" class="modal-content">
        @csrf
        @method('DELETE')
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah anda yakin mau dihapus {{ $kategori->nama_kategori }}?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Ya Hapus!</button>
      </div>
    </form>
  </div>
</div>    
@endforeach

@endsection