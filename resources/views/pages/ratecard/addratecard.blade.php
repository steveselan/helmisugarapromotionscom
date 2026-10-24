<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Master Media & Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Form Input Rate Card Media</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('media.store') }}" method="POST" x-data="mediaForm()">
            @csrf

            <!-- Informasi Media Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Media</label>
                    <input type="text" name="nama_media" placeholder="Contoh: Kompas.com" required 
                           class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Media</label>
                    {{-- <input type="text" name="jenis_media" placeholder="Contoh: Media Online" required 
                           class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500"> --}}
                    <select class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500" id="jenis_media" name="jenis_media">
                        <option selected>Choose...</option>
                        <option value="OLWB">Online - Web Base</option>
                        <option value="OLNM">Online - Homeless / New Media</option>
                        <option value="RA">Radio</option>
                        <option value="PR">Print</option>
                        <option value="TV">TV</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    {{-- <input type="text" name="kategori" placeholder="Contoh: Lifestyle" required 
                           class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500"> --}}
                    <select class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500" id="kategori" name="kategori">
                        <option selected>Choose...</option>
                        <option value="NEWS">News</option>
                        <option value="LS">Lifestyle</option>
                        <option value="OR">Sport</option>
                    </select>
                </div>
            </div>

            <hr class="my-6">

            <!-- Bagian Dynamic Items dengan Select Option -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Item & Harga Promosi</h3>
                    <button type="button" @click="addItem()" 
                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                        + Tambah Baris Item
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-md border">
                            
                            <!-- Dropdown Select untuk Nama Item -->
                            <div class="flex-1">
                                <select :name="`items[${index}][nama_item]`" x-model="item.nama_item" required
                                        class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm bg-white">
                                    <option value="">-- Pilih Item Promosi --</option>
                                    @foreach($mater_item as $mItem)
                                        <option value="{{ $mItem->nama_item }}">{{ $mItem->nama_item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Input Harga -->
                            <div class="w-1/3">
                                <input type="number" :name="`items[${index}][harga]`" x-model="item.harga" 
                                       placeholder="Harga (Rp)" required min="0"
                                       class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm">
                                
                            </div>
                            <!-- Input Harga -->
                            <div class="w-1/3">
                                <input type="text" :name="`items[${index}][keterangan]`" x-model="item.keterangan" 
                                       placeholder="Keterangan"
                                       class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm">
                                
                            </div>

                            <!-- Tombol Hapus Baris -->
                            <div>
                                <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                        class="px-3 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full py-3 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 transition">
                    Simpan Data Media & Item
                </button>
            </div>
        </form>
    </div>

    <script>
        function mediaForm() {
            return {
                items: [
                    { nama_item: '', harga: '' }
                ],
                addItem() {
                    this.items.push({ nama_item: '', harga: '' });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const inputHarga = document.getElementById('harga');
    const inputHargaAsli = document.getElementById('harga_asli');

    inputHarga.addEventListener('keyup', function (e) {
        // Format angka saat diketik
        let value = this.value.replace(/[^,\d]/g, '').toString();
        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        
        // Tampilkan ke input text
        this.value = rupiah;

        // Simpan nilai murni (tanpa titik) ke input hidden untuk dikirim ke database
        let nilaiMurni = rupiah.replace(/\./g, '').replace(',', '.');
        if(inputHargaAsli) {
            inputHargaAsli.value = nilaiMurni;
        }
    });
});
    </script>
</body>
</html>