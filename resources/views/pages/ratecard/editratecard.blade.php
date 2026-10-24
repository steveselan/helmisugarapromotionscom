@extends('layout.master')

@section('title','Detail Media')

@section('konten')
<div class="card mb-3" style="max-width: 600px;">
<div class="row no-gutters">
        <div class="col-md-12">
            <div class="card-body">
                <h4 class="card-title font-weight-bold">{{ $edit_data_media->nama_media }} - {{ $edit_data_media->kota }}</h4>
                <form action="{{ route('ratecard.update',$edit_data_media->id_ratecard) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- <table class="table table-striped" id="tebel-item">
                        <thead>
                            <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Item Promosi</th>
                            <th scope="col" class="text-center">Harga</th>
                            <th scope="col" class="text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mater_item as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border border-gray-300 px-6 py-2">{{ $item->nama_item }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                    <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold">IDR.</span>
                                            
                                            <!-- PERBAIKAN: Ubah name="harga" jadi name="items[{{ $index }}][harga]" -->
                                            <input type="text" name="items[{{ $index }}][harga]" 
                                                class="form-control form-control-sm" 
                                                value="{{ $item->harga }}" oninput="formatRupiah(this)">
                                            
                                            <!-- PERBAIKAN: Hapus titik dua (:) pada :name -->
                                            <input type="hidden" name="items[{{ $index }}][id_mediaitem]" value="{{ $item->id_mediaitem }}">
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                    <table class="table table-striped" id="tabel-item">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%;">#</th>
                                <th scope="col" style="width: 35%;">Item Promosi</th>
                                <th scope="col" style="width: 30%" class="text-center">Harga</th>
                                <th scope="col" style="width: 25%;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Item yang sudah ada di database -->
                            @foreach ($mater_item as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border border-gray-300 px-6 py-2">
                                        {{ $item->nama_item }}
                                        <!-- Hidden ID untuk item lama -->
                                        <input type="hidden" name="items[{{ $index }}][id_mediaitem]" value="{{ $item->id_mediaitem }}">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold">IDR.</span>
                                            <input type="text" name="items[{{ $index }}][harga]" 
                                                class="form-control form-control-sm" 
                                                value="{{ $item->harga }}" oninput="formatRupiah(this)">
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Tombol Tambah Baris Baru -->
                    <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="tambahBarisBaru()">
                        + Tambah Item Promosi Baru
                    </button>

                    <div class="d-flex justify-content-between align-items-center p-2 border-top">
                        <button type="submit" class="btn btn-warning">Simpan Perubahan & Item Baru</button>
                        <a href="/ratecard" class="btn btn-primary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="d-flex justify-content-between align-item-center p-2">
        <div>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
        <div>
            <a href="/ratecard" class="btn btn-primary">Kembali</a>
        </div>
    </div> --}}
</div>
<script>
    // 1. Tangkap data master item dari controller dalam bentuk array JSON aman
    const listMasterItem = @json($daftar_master_item ?? []);

    let rowIndex = {{ count($mater_item) }};

    function tambahBarisBaru() {
        let tbody = document.querySelector('#tabel-item tbody');
        
        // Buat opsi dropdown berdasarkan data master item
        let optionsHtml = '<option value="">-- Pilih Item Promosi --</option>';
        listMasterItem.forEach(master => {
            optionsHtml += `<option value="${master.nama_item}">${master.nama_item}</option>`;
        });

        let html = `
            <tr class="hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-2 text-center">#</td>
                <td class="border border-gray-300 px-6 py-2">
                    <!-- Dropdown pilihan nama_item dari master -->
                    <select name="items[${rowIndex}][nama_item]" class="form-control form-control-sm" required>
                        ${optionsHtml}
                    </select>
                    <input type="hidden" name="items[${rowIndex}][id_mediaitem]" value="">
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold">IDR.</span>
                        <input type="text" name="items[${rowIndex}][harga]" 
                            class="form-control form-control-sm" placeholder="0" oninput="formatRupiah(this)" required>
                    </div>
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <input type="text" name="items[${rowIndex}][keterangan]" 
                        class="form-control form-control-sm" placeholder="Keterangan...">
                </td>
            </tr>
        `;
        
        tbody.insertAdjacentHTML('beforeend', html);
        rowIndex++;
    }

    function formatRupiah(input) {
        let value = input.value.replace(/\D/g, "");
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }
</script>
@endsection