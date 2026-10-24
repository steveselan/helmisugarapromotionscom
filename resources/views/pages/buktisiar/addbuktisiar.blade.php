@extends('layout.master')

@section('title', 'Upload Bukti Siar Item')

@section('konten')
<div class="max-w-2xl bg-white p-8 rounded-lg shadow-md">
    <!-- Informasi Item yang Dipilih -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
        <p class="text-sm text-gray-600">Media: <strong>{{ $detail->ratecard->nama_media }}</strong></p>
        <p class="text-base font-bold text-primary">Item Promosi: {{ $detail->mediaItem->nama_item }}</p>
        <p class="text-xs text-gray-600 mt-1">
            Total Kuantiti Dipesan: <strong>{{ $detail->qty }}</strong> | 
            Sudah di-upload: <strong>{{ $detail->buktisiar->count() }}</strong> | 
            <span class="text-red-600 font-bold">Kurang: {{ $sisaKuantiti }} slot lagi</span>
        </p>
    </div>

    @php
        $namaItemLower = strtolower($detail->mediaItem->nama_item ?? '');

        // Cek apakah item ini adalah Radio Spot
        $isRadioSpot =  str_contains($namaItemLower, 'radio') || str_contains($namaItemLower, 'spot');
        
        // Tentukan jumlah loop: Jika Radio Spot, paksakan hanya 1. Jika bukan, ikuti kuantiti aslinya.
        $jumlahLoop = $isRadioSpot ? 1 : $sisaKuantiti;

        $butuhLink = str_contains($namaItemLower, 'ig feed') || 
                     str_contains($namaItemLower, 'reel') || 
                     str_contains($namaItemLower, 'fb') || 
                     str_contains($namaItemLower, 'tiktok') || 
                     str_contains($namaItemLower, 'online article');
    @endphp

    <form action="{{ route('buktisiar.item.store', $detail->id_mediaplandetail) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($isRadioSpot)
            <div class="alert alert-info text-sm mb-4">
                ℹ️ <strong>Catatan:</strong> Untuk item Radio Spot, Anda cukup mengunggah 1 file rekap (PDF/Gambar) yang merangkum keseluruhan spot tertayang.
            </div>
        @endif
        <!-- Looping sebanyak kuantiti yang ada (Misal kuantiti 2, maka looping 2 kali) -->
        <div class="space-y-4">
            @for ($i = 0; $i < $jumlahLoop; $i++)
                <div class="p-4 border rounded-lg bg-gray-50 shadow-sm">
                    <h4 class="font-bold text-sm text-gray-700 mb-3">
                        {{ $isRadioSpot ? 'File Bukti Rekap Radio Spot' : 'Slot Bukti ke-' . ($i + 1) }}
                    </h4>

                    
                    <!-- Hidden input untuk menandai indeks -->
                    <input type="hidden" name="bukti[{{ $i }}][mediaplandetail_id]" value="{{ $detail->id_mediaplandetail }}">

                    <!-- Upload File -->
                    <div class="mb-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1">File Bukti (PDF / Gambar) :</label>
                        <input type="file" name="bukti[{{ $i }}][file_bukti]" class="form-control form-control-sm" accept=".pdf,image/*" required>
                    </div>

                    <!-- Keterangan / Tanggal Tayang -->
                    <div class="mb-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan / Tanggal Tayang :</label>
                        <input type="text" name="bukti[{{ $i }}][keterangan]" placeholder="Cth: Tayang tgl {{ $i+1 }} Oktober 2026" class="form-control form-control-sm">
                    </div>

                    <!-- Kolom Link (Kondisional) -->
                    @if($butuhLink)
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Link Postingan (URL) :</label>
                            <input type="url" name="bukti[{{ $i }}][link_posting]" placeholder="https://..." class="form-control form-control-sm" required>
                        </div>
                    @endif
                </div>
            @endfor
        </div>

        <div class="mt-5 flex justify-between">
            <button type="submit" class="btn btn-primary px-5 py-2.5 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700">
                Simpan Semua Bukti Siar
            </button>
            <a href="{{ route('buktisiar.gabungan', $detail->mediaplan->event_id) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection