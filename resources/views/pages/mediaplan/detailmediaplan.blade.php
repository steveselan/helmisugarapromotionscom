@extends('layout.master')

@section('title', 'Detail Media Plan')

@section('konten')
<div class="max-w-6xl bg-white p-8 rounded-lg shadow-md">
    <!-- Informasi Utama Header -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg border">
        <div>
            <span class="font-bold text-gray-700">Judul Media Plan :</span> 
            <span class="rounded">{{ $mediaplan->event->judul_event ?? '-' }}</span>
        </div>
        <div>
            <span class="font-bold text-gray-700">Jenis Media :</span> 
            <span class="rounded">
                 @if ($mediaplan->jenis_media == 'RA') RADIO
                 @elseif ($mediaplan->jenis_media == 'OLWB') ONLINE WEB BASE  
                 @elseif ($mediaplan->jenis_media == 'OLNM') ONLINE NEW MEDIA  
                 @endif
            </span>
        </div>
    </div>

    <!-- Tabel Detail -->
    <div class="table-responsive">
        <table class="table table-bordered table-sm text-center align-middle">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Media</th>
                    <th>Item of Promotion</th>
                    <th>Price / Item</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Tiket</th>
                    <th>ID Liputan</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($groupedDetails as $ratecardId => $details)
                    @php 
                        $firstRow = $details->first();
                        $rowCount = $details->count();
                    @endphp

                    @foreach($details as $index => $detail)
                        <tr>
                            <!-- Kolom No & Nama Media hanya dicetak sekali di baris pertama tiap group (Rowspan) -->
                            @if($index === 0)
                                <td rowspan="{{ $rowCount }}" class="align-middle font-bold">{{ $no++ }}</td>
                                <td rowspan="{{ $rowCount }}" class="align-middle font-bold">
                                    {{ $firstRow->ratecard->nama_media ?? '-' }}
                                </td>
                            @endif

                            <!-- Kolom Detail Item Promosi -->
                            <td class="text-start">{{ $detail->mediaItem->nama_item ?? '-' }}</td>
                            <td class="text-end">Rp. {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td class="text-end">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>

                            <!-- Kolom Jumlah Tiket & ID Liputan disatukan dengan rowspan -->
                            @if($index === 0)
                                <td rowspan="{{ $rowCount }}" class="align-middle">{{ $firstRow->jumlah_tiket }}</td>
                                <td rowspan="{{ $rowCount }}" class="align-middle">{{ $firstRow->id_media }}</td>
                            @endif
                           
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <!-- BAGIAN FOOTER UNTUK TOTAL -->
            <tfoot class="bg-gray-100 font-bold">
                <tr>
                    <td colspan="5" class="text-end pe-3">TOTAL KESELURUHAN:</td>
                    <td class="text-end text-primary">Rp. {{ number_format($totalSubtotal, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $totalTiket }}</td>
                    <td class="text-center">{{ $totalIdmedia }}</td>
                    <td class="text-center"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('mediaplan.index') }}" class="btn btn-primary">Kembali</a>
        <a href="/mediaplan/{{ $mediaplan->id_mediaplan }}/edit" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection