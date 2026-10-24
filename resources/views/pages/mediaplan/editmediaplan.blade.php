@extends('layout.master')

@section('title', 'Edit Media Plan')

@section('konten')
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="max-w-5xl bg-white p-8 rounded-lg shadow-md" x-data="mediaPlanEditForm()">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('mediaplan.update', $mediaplan->id_mediaplan) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Informasi Utama Atas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg border mb-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Event :</label>            
                <select class="form-control w-full border-gray-300 rounded-md shadow-sm border p-2" disabled>
                    <option value="">-- Pilih Event --</option>
                    @foreach($list_event as $ev)
                        <option value="{{ $ev->id_event }}" {{ $mediaplan->event_id == $ev->id_event ? 'selected' : '' }}>
                            {{ $ev->judul_event }}
                        </option>
                    @endforeach
                </select>
                <!-- Input hidden agar event_id tetap terkirim ke Controller saat form disubmit -->
                <input type="hidden" name="event_id" value="{{ $mediaplan->event_id }}">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Jenis Media :</label>
                <select x-model="globalJenisMedia" @change="onGlobalJenisChange()" 
                        class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm bg-white" disabled>
                    <option value="">-- Pilih Jenis Media --</option>
                    @foreach($list_jenis as $jenis)
                        <option value="{{ $jenis }}">
                            @if ($jenis == 'RA') RADIO
                            @elseif ($jenis == 'OLWB') ONLINE WEB BASE  
                            @elseif ($jenis == 'OLNM') ONLINE NEW MEDIA  
                            @endif
                        </option>
                    @endforeach
                </select>
                <!-- Input hidden agar jenis_media tetap terkirim ke Controller saat form disubmit -->
                <input type="hidden" name="jenis_media" value="{{ $mediaplan->jenis_media }}">
            </div>
        </div>

        <!-- Tombol Tambah Media -->
        <div class="flex justify-end mb-4">
            <button type="button" @click="addMediaBlock()" 
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 transition"
                    :disabled="!globalJenisMedia">
                + Tambah Media
            </button>
        </div>

        <!-- Container Blok Media -->
        <div class="space-y-6">
            <template x-for="(mediaBlock, blockIndex) in mediaBlocks" :key="blockIndex">
                <div class="border-2 border-black p-4 rounded-md bg-white relative shadow-sm">
                    
                    <!-- Tombol Hapus Blok Media -->
                    <button type="button" @click="removeMediaBlock(blockIndex)" x-show="mediaBlocks.length > 1"
                            class="absolute top-4 right-4 px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition">
                        Hapus Media
                    </button>

                    <!-- Baris Nama Media, Tiket, ID Liputan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-end">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Media :</label>
                            <select :name="`media_blocks[${blockIndex}][ratecard_id]`" 
                                    x-model="mediaBlock.selectedRatecardId" 
                                    @change="onRatecardChange(blockIndex)" 
                                    class="form-control form-control-sm border-gray-300 rounded-md shadow-sm border p-2 text-sm w-full bg-gray-100" required>
                                <option value="">-- Pilih Nama Media --</option>
                                <template x-for="rc in getFilteredRatecards()" :key="rc.id_ratecard">
                                    <option :value="rc.id_ratecard" 
                                            :disabled="isRatecardSelected(rc.id_ratecard, blockIndex)"
                                            x-text="rc.nama_media + (rc.kota ? ' (' + rc.kota + ')' : '')">
                                    </option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jumlah Tiket :</label>
                            <input type="number" :name="`media_blocks[${blockIndex}][jumlah_tiket]`" 
                                   x-model.number="mediaBlock.jumlahTiket" 
                                   placeholder="0" min="0" 
                                   class="form-control form-control-sm border-gray-300 rounded-md shadow-sm border p-2 text-sm w-full">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">ID Liputan :</label>
                            <input type="text" :name="`media_blocks[${blockIndex}][id_liputan]`" 
                                   x-model="mediaBlock.idLiputan" 
                                   placeholder="Masukkan ID Liputan..." 
                                   class="form-control form-control-sm border-gray-300 rounded-md shadow-sm border p-2 text-sm w-full">
                        </div>
                    </div>

                    <!-- Tabel Item Promosi -->
                    <div class="table-responsive" x-show="mediaBlock.mediaItems.length > 0">
                        <table class="table table-bordered table-sm bg-white">
                            <thead class="thead-light">
                                <tr>
                                    <th>Item Promosi</th>
                                    <th class="text-center" style="width: 20%;">Harga</th>
                                    <th class="text-center" style="width: 20%;">Qty</th>
                                    <th class="text-center" style="width: 25%;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, itemIndex) in mediaBlock.mediaItems" :key="item.id_mediaitem">
                                    <tr>
                                        <td class="align-middle text-sm">
                                            <span x-text="item.nama_item"></span>
                                            <input type="hidden" :name="`media_blocks[${blockIndex}][items][${itemIndex}][id_mediaitem]`" :value="item.id_mediaitem">
                                            <input type="hidden" :name="`media_blocks[${blockIndex}][items][${itemIndex}][harga]`" :value="item.harga">
                                        </td>
                                        <td class="text-center align-middle text-sm">
                                            IDR <span x-text="formatRupiah(item.harga)"></span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <input type="number" :name="`media_blocks[${blockIndex}][items][${itemIndex}][qty]`" 
                                                   x-model.number="item.qty" 
                                                   placeholder="0" min="0" 
                                                   class="form-control form-control-sm text-center">
                                        </td>
                                        <td class="text-center align-middle font-weight-bold text-primary text-sm">
                                            IDR <span x-text="formatRupiah((item.qty || 0) * item.harga)"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                </div>
            </template>
        </div>

        <!-- Tombol Tambah Media -->
        <div class="flex justify-end mt-4">
            <button type="button" @click="addMediaBlock()" 
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 transition"
                    :disabled="!globalJenisMedia">
                + Tambah Media
            </button>
        </div>

        <div class="mt-8 flex justify-between">
            <button type="submit" class="py-3 px-6 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 transition">
                Perbarui Media Plan
            </button>
            <a href="{{ route('mediaplan.show', $mediaplan->id_mediaplan) }}" class="btn btn-secondary py-3">Batal</a>
        </div>
        
    </form>
</div>

<!-- Skrip Alpine.js untuk Load Data Lama saat Edit -->
<script>
    function mediaPlanEditForm() {
        return {
            allRatecards: @json($list_ratecard),
            globalJenisMedia: "{{ $mediaplan->jenis_media }}",
            
            // Tinggal panggil variabel yang sudah disiapkan dari controller
            mediaBlocks: @json($formattedMediaBlocks),

            getFilteredRatecards() {
                if (!this.globalJenisMedia) return [];
                return this.allRatecards.filter(rc => rc.jenis === this.globalJenisMedia);
            },

            isRatecardSelected(ratecardId, currentBlockIndex) {
                return this.mediaBlocks.some((block, index) => {
                    return index !== currentBlockIndex && block.selectedRatecardId == ratecardId;
                });
            },

            onGlobalJenisChange() {
                this.mediaBlocks = [];
                this.addMediaBlock();
            },

            addMediaBlock() {
                if (!this.globalJenisMedia) {
                    alert('Silakan pilih Jenis Media terlebih dahulu di bagian atas!');
                    return;
                }
                this.mediaBlocks.push({
                    selectedRatecardId: '',
                    jumlahTiket: '',
                    idLiputan: '',
                    mediaItems: []
                });
            },

            removeMediaBlock(index) {
                this.mediaBlocks.splice(index, 1);
            },

            onRatecardChange(index) {
                let ratecardId = this.mediaBlocks[index].selectedRatecardId;
                
                if (!ratecardId) {
                    this.mediaBlocks[index].mediaItems = [];
                    return;
                }

                let selectedRc = this.allRatecards.find(rc => rc.id_ratecard == ratecardId);

                if (selectedRc) {
                    let items = selectedRc.items || [];
                    this.mediaBlocks[index].mediaItems = items.map(item => ({
                        id_mediaitem: item.id_mediaitem,
                        nama_item: item.nama_item,
                        harga: item.harga,
                        qty: '' 
                    }));
                } else {
                    this.mediaBlocks[index].mediaItems = [];
                }
            },

            formatRupiah(angka) {
                if (!angka) return '0';
                return new Intl.NumberFormat('id-ID').format(angka);
            }
        }
    }
</script>
@endsection