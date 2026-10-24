@extends('layout.master')

@section('title', 'Detail Bukti Siar Gabungan')

@section('konten')
<div class="max-w-7xl bg-white p-8 rounded-lg shadow-md">

    <!-- Informasi Event -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
        <p class="text-lg font-bold text-primary">Media Plan: {{ $event->judul_event }}</p>
        <p class="text-sm text-gray-600">Gabungan Jenis Media: 
            @foreach($mediaplan as $mp)
                <span class="badge bg-secondary text-light mr-1">{{ $mp->jenis_media }}</span>
            @endforeach
        </p>
    </div>

    <!-- Tabel Gabungan Seluruh Media -->
    <div class="table-responsive">
        <table class="table table-sm table-bordered text-center align-middle">
            <thead class="bg-dark text-white">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Nama Media</th>
                    <th style="width: 20%;">Type of Promosi</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 15%;">Status Bukti Siar</th>
                    <th style="width: 15%;">Aksi Bukti Siar</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($groupDetails as $ratecardId => $details)
                    @php 
                        $firstRow = $details->first();
                        $rowCount = $details->count();
                    @endphp

                    @foreach($details as $index => $detail)
                        <tr>
                            @if($index === 0)
                                <td rowspan="{{ $rowCount }}" class="align-middle font-bold">{{ $no++ }}</td>
                               
                                <td rowspan="{{ $rowCount }}" class="align-middle font-bold">
                                    {{ $firstRow->ratecard->nama_media ?? '-' }}
                                </td>
                            @endif

                            <td class="text-start">{{ $detail->mediaItem->nama_item ?? '-' }}</td>
                            <td>{{ $detail->qty }}</td>
                            
                            <!-- Kolom Status & Aksi Bukti Siar -->
                            
                             @if($detail->buktisiar->isNotEmpty())
                                <!-- JIKA SUDAH ADA BUKTI -->
                                <td>
                                    <span class="px-3 py-2 badge bg-success bg-green-100 text-xs font-bold text-white rounded-full">
                                                ✅ Sudah Upload ({{ $detail->buktisiar->count() }} / {{ $detail->qty }})
                                    </span>
                                </td>
                                <td>
                                <!-- Tombol yang memicu Bootstrap Modal -->
                                    <button type="button"
                                            class="btn btn-sm btn-info text-white preview-btn"
                                            data-bukti='@json($detail->buktisiar)'
                                            data-media="{{ $detail->ratecard->nama_media ?? 'Media' }}"
                                            data-item="{{ $detail->mediaitem->nama_item ?? 'Item' }}"
                                            onclick="handlePreviewClick(this)">
                                        🔍 Preview
                                    </button>

                                    <!-- Tombol Tambah (hanya muncul jika jumlah bukti masih kurang dari kuantiti)-->
                                    @if($detail->buktisiar->count() < $detail->qty)
                                    <a href="{{ route('buktisiar.item.create', $detail->id_mediaplandetail) }}" class="btn btn-sm btn-primary text-white preview-btn">
                                                + Tambah
                                    </a>
                                    @endif
                                </td>
    
                                @else
                                <td>
                                    <!-- JIKA BELUM ADA BUKTI -->
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full block mb-1">
                                        ❌ Belum Ada
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('buktisiar.item.create', $detail->id_mediaplandetail) }}" class="btn btn-sm btn-primary">
                                        + Upload Bukti
                                    </a>
                                </td>
                                @endif
                            
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('buktisiar.index') }}" class="btn btn-secondary">Kembali ke Daftar Event</a>
    </div>
</div>

<!-- ========================================== -->
<!-- BOOTSTRAP MODAL PREVIEW                    -->
<!-- ========================================== -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <!-- Menggunakan modal-dialog-centered dan modal-lg agar proposional, Anda bisa ganti modal-lg jika ingin lebih ramping -->
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="previewModalLabel">Preview Bukti Siar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten bukti siar akan dimasukkan lewat Javascript di bawah -->
                <div id="modal-bukti-content" class="space-y-4">
                    <p class="text-center text-muted">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Fungsi perantara untuk membaca data-* dari tombol yang diklik
    function handlePreviewClick(button) {
        let buktiList = JSON.parse(button.getAttribute('data-bukti'));
        let namaMedia = button.getAttribute('data-media');
        let namaItem = button.getAttribute('data-item');

        showPreviewModal(buktiList, namaMedia, namaItem);
    }

    // Fungsi utama modal preview
    function showPreviewModal(buktiList, namaMedia, namaItem) {
        // Sekarang ini akan merender teks aslinya dengan benar (Contoh: Preview Bukti Siar - Femina - IG Feed)
        let modalTitle = document.getElementById('previewModalLabel');
        modalTitle.innerText = `Preview Bukti Siar - ${namaMedia} - ${namaItem}`;

        let container = document.getElementById('modal-bukti-content');
        container.innerHTML = ''; // Kosongkan kontainer sebelumnya

        if (!buktiList || buktiList.length === 0) {
            container.innerHTML = '<p class="text-center text-muted">Tidak ada bukti siar.</p>';
            return;
        }

        let rowDiv = document.createElement('div');
        rowDiv.className = 'row g-5 justify-content-center';

        buktiList.forEach((item, index) => {
            let fileExt = item.file_bukti ? item.file_bukti.split('.').pop().toLowerCase() : '';
            let fileUrl = `/storage/${item.file_bukti}`;
            let keterangan = item.keterangan ? item.keterangan : '-';
            let linkPosting = item.link_posting ? `<a href="${item.link_posting}" target="_blank" class="text-primary text-decoration-underline">${item.link_posting}</a>` : '<span class="text-muted">-</span>';

            let filePreviewHTML = '';
            if (['jpg', 'jpeg', 'png', 'webp'].includes(fileExt)) {
                filePreviewHTML = `
                    <div class="mb-2 text-center w-100">
                        <img src="${fileUrl}" alt="Bukti Siar" class="img-fluid rounded border mb-2 mx-auto" style="height: 180px; width: 100%; object-fit: contain; background-color: #f8f9fa;">
                        <br>
                        <div class="d-flex gap-2 mt-2">
                            <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-secondary flex-grow-1">Perbesar ↗</a>
                            
                            <form action="/bukti-siar/${item.id_buktisiar}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bukti siar ini?');" class="flex-grow-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger w-50 ml-2"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                `;
            } else if (fileExt === 'pdf') {
                filePreviewHTML = `
                    <div class="mb-2 text-center py-3 bg-light rounded border w-100">
                        <p class="mb-2 fw-semibold text-danger small">Dokumen PDF</p>
                        <div class="d-flex gap-2 px-2">
                            <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-danger flex-grow-1">
                                📄 Buka PDF
                            </a>
                            
                            <form action="/bukti-siar/${item.id_buktisiar}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokumen PDF ini?');" class="flex-grow-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus 🗑️</button>
                            </form>
                        </div>
                    </div>
                `;
            } else {
                filePreviewHTML = `<p class="text-muted text-center">Format file tidak didukung.</p>`;
            }

            let colDiv = document.createElement('div');
            colDiv.className = 'col-md-6 mb-4';

            colDiv.innerHTML = `
                <div class="card h-100 p-3 bg-white border shadow-sm text-center d-flex flex-column align-items-center justify-content-between mt-2">
                    <div>
                        <span class="badge bg-secondary mb-2 text-white">Bukti ke-${index + 1}</span>
                        <hr class="my-1 w-100">
                    </div>
                    
                    <div class="small my-2 w-100">
                        <p class="mb-1"><strong>Ket / Tgl:</strong> <br>${keterangan}</p>
                        <p class="mb-1 text-break"><strong>Link:</strong> <br>${linkPosting}</p>
                    </div>

                    <div class="mt-auto w-100">
                        ${filePreviewHTML}
                    </div>
                </div>
            `;

            rowDiv.appendChild(colDiv);
        });

        container.appendChild(rowDiv);

        let myModal = new bootstrap.Modal(document.getElementById('previewModal'));
        myModal.show();
    }
</script>
@endsection