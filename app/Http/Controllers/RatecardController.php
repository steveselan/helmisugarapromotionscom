<?php

namespace App\Http\Controllers;

use App\Models\Materitem;
use App\Models\Mediaitem;
use App\Models\Ratecard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RatecardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataratecard = Ratecard::get();
        return view('pages.ratecard.showratecard',[
            'data_ratecard' => $dataratecard
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mater_item = Materitem::all();

        return view('pages.ratecard.addratecard1', compact('mater_item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'nama_media' => 'required|string|max:255',
        //     'jenis_media' => 'required|string|max:255',
        //     'kategori' => 'required|string|max:255',
        //     'items' => 'required|array|min:1',
        //     'items.*.nama_item' => 'required|string|max:255',
        //     'items.*.harga' => 'required|numeric|min:0'
        // ]);

        $ratecard = Ratecard::create([
            'nama_media' => Str::upper($request->nama_media),
                'jenis' => $request->jenis_media,
                'kategori' => $request->kategori,
                'kota' => Str::upper($request->kota)
        ]);
        foreach ($request->items as $item){
                $ratecard->items()->create([
                    'nama_item' => $item['nama_item'],
                    'harga' => $item['harga'],
                    'keterangan' => $item['keterangan']
                ]);
        }
        return redirect('/ratecard')->with('pesan', 'Data media dan item berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. Ambil informasi utama ratecard (opsional, jika butuh data header-nya)
        $dataratecard = Ratecard::findOrFail($id);

        // 2. Ambil SEMUA list item yang terikat pada ratecard ini dari tabel tb_mediaitem
        // Pastikan nama kolom foreign key-nya sesuai (misal: ratecard_id)
        $mater_item = Mediaitem::where('ratecard_id', $id)->get();

        return view('pages.ratecard.detailratecard', [
            'data_media' => $dataratecard,
            'mater_item' => $mater_item // Kirim data list item ini ke view untuk loop @foreach
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 1. Ambil informasi utama ratecard (opsional, jika butuh data header-nya)
        $dataratecard = Ratecard::findOrFail($id);
        
        // 2. Ambil SEMUA list item yang terikat pada ratecard ini dari tabel tb_mediaitem
        // Pastikan nama kolom foreign key-nya sesuai (misal: ratecard_id)
        $mater_item = Mediaitem::where('ratecard_id', $id)->get();
        $daftar_master_item = Materitem::all();

        return view('pages.ratecard.editratecard', [
            'edit_data_media' => $dataratecard,
            'mater_item' => $mater_item, // Kirim data list item ini ke view untuk loop @foreach
            'daftar_master_item' => $daftar_master_item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    // Cek apakah ada data items yang dikirim dari form
    if ($request->has('items')) {
        foreach ($request->items as $itemData) {
            
            // // Pastikan id_mediaitem dan harga terisi
            // if (isset($itemData['id_mediaitem']) && isset($itemData['harga'])) {
                
            //     // 1. Bersihkan titik (.) pada string harga dari format rupiah (misal: "1.500.000" jadi "1500000")
            //     $hargaMurni = str_replace('.', '', $itemData['harga']);

            //     // Lakukan update ke tabel mediaitem berdasarkan id_mediaitem
            //     Mediaitem::where('id_mediaitem', $itemData['id_mediaitem'])->update([
            //         'harga' => $hargaMurni
            //     ]);
            // }

            // Bersihkan format titik pada harga rupiah
            $hargaMurni = isset($itemData['harga']) ? str_replace('.', '', $itemData['harga']) : 0;

            // Jika ada id_mediaitem -> Update harga item yang sudah ada
            if (!empty($itemData['id_mediaitem'])) {
                Mediaitem::where('id_mediaitem', $itemData['id_mediaitem'])->update([
                    'harga' => $hargaMurni
                ]);
            } 
            // Jika id_mediaitem kosong -> Buat baris data baru ke tabel tb_mediaitem
            else {
                if (!empty($itemData['nama_item'])) {
                    Mediaitem::create([
                        'ratecard_id' => $id,
                        'nama_item'   => $itemData['nama_item'],
                        'harga'       => $hargaMurni,
                        'keterangan'  => $itemData['keterangan'] ?? '-'
                    ]);
                }
            }
        }
    }

    return redirect('/ratecard/show/'.$id)->with('success', 'Harga berhasil diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
