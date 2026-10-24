@extends('layout.master')

@section('title','Detail Media')

@section('konten')
<div class="card mb-3" style="max-width: 600px;">
<div class="row no-gutters">
        <div class="col-md-12">
            <div class="card-body">
                <h4 class="card-title font-weight-bold">{{ $data_media->nama_media }} - {{ $data_media->kota }}</h4>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Item Promosi</th>
                        <th scope="col" class="text-center">Harga</th>
                        <th scope="col" class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mater_item as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <!-- Sesuaikan nama kolom dengan database Anda (misal: nama_item, harga, keterangan) -->
                                <td class="border border-gray-300 px-6 py-2">{{ $item->nama_item }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                   <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold">IDR.   </span>
                                        <input type="text" 
                                            class="form-control form-control-sm" 
                                            value="{{ number_format($item->harga, 0, ',', '.') }}" readonly>
                                    </div>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-item-center p-2">
        <div>
            <a href="/ratecard/edit/{{ $item->ratecard_id }}" class="btn btn-warning">Edit</a>
        </div>
        <div>
            <a href="/ratecard" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>
@endsection