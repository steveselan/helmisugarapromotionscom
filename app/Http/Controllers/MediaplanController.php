<?php

namespace App\Http\Controllers;

use App\Models\Mediaitem;
use App\Models\Mediaplan;
use App\Models\Mediaplandetail;
use App\Models\Newevent;
use App\Models\Ratecard;
use Illuminate\Http\Request;

class MediaplanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list_mediaplan = Mediaplan::join('tb_newevent','tb_mediaplan.event_id','=','tb_newevent.id_event')->get();
        // $list_event = Newevent::get();

        return view('pages.mediaplan.showmediaplan',[
            'data_mediaplan' => $list_mediaplan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $list_event = Newevent::where('status','New')->get();
         $list_ratecard = Ratecard::with('items')->get();
         $list_jenis = Ratecard::select('jenis')->distinct()->pluck('jenis');

         return view('pages.mediaplan.addmediaplan', compact('list_event','list_ratecard','list_jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dasar
        $request->validate([
            'event_id'    => 'required',
            'jenis_media' => 'required',
            'media_blocks' => 'required|array',
        ]);

            // 2. Simpan data utama ke tabel 'mediaplans' (Header)
            $mediaplan = Mediaplan::create([
                'event_id'    => $request->event_id,
                'jenis_media' => $request->jenis_media,
            ]);

            // 3. Looping setiap blok media yang ditambahkan user
            foreach ($request->media_blocks as $block) {
                $ratecardId  = $block['ratecard_id'] ?? null;
                $jumlahTiket = $block['jumlah_tiket'] ?? 0;
                $idLiputan   = $block['id_media'] ?? null;

                // Pastikan ratecard dipilih
                if ($ratecardId && isset($block['items'])) {
                    
                    // 4. Looping item-item promosi di dalam blok media tersebut
                    foreach ($block['items'] as $itemData) {
                        $kuantiti = isset($itemData['kuantiti']) && $itemData['kuantiti'] !== '' ? (int) $itemData['kuantiti'] : 0;

                        // Hanya simpan item jika kuantitinya diisi lebih dari 0
                        if ($kuantiti > 0) {
                            $hargaSatuan = $itemData['harga'];
                            $subtotal    = $kuantiti * $hargaSatuan;

                            for($i = 0; $i < $kuantiti; $i++)
                                {
                                    Mediaplandetail::create([
                                        'mediaplan_id' => $mediaplan->id_mediaplan,
                                        'ratecard_id'  => $ratecardId,
                                        'jumlah_tiket' => $jumlahTiket,
                                        'id_media'   => $idLiputan,
                                        'mediaitem_id' => $itemData['id_mediaitem'],
                                        'qty'     => $kuantiti,
                                        'harga_satuan' => $hargaSatuan,
                                        'subtotal'     => $subtotal,
                                    ]);
                                }
                        }
                    }
                }
            }

            return redirect('/mediaplan')->with('success', 'Media Plan berhasil disimpan dengan sukses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data mediaplan beserta event dan detail yang berelasi
        $mediaplan = Mediaplan::with(['event','mediaplan_detail.ratecard', 'mediaplan_detail.mediaitem'])
                    ->findOrFail($id);
        
        $groupedDetails = $mediaplan->mediaplan_detail->groupBy('ratecard_id');

        //menghitung total keseluruhan
        $totalSubtotal = $mediaplan->mediaplan_detail->sum('subtotal');

        // Karena jumlah_tiket dan id_liputan tersimpan di setiap baris detail media,
        // kita ambil nilai unik per media agar tidak terhitung ganda (double counting)
        $totalTiket = $mediaplan->mediaplan_detail->unique('ratecard_id')->sum('jumlah_tiket');
        $totalIdmedia = $mediaplan->mediaplan_detail->unique('ratecard_id')->sum('id_media');

        return view('pages.mediaplan.detailmediaplan', compact('mediaplan','groupedDetails','totalSubtotal','totalTiket','totalIdmedia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mediaplan = Mediaplan::with(['mediaplan_detail.ratecard.items'])->findOrFail($id);
        $list_event = Newevent::all();
        $list_ratecard = Ratecard::with('items')->get();
        $list_jenis = Ratecard::select('jenis')->distinct()->pluck('jenis');

        // Ubah data details menjadi format yang rapi untuk Alpine.js di sini
        $formattedMediaBlocks = $mediaplan->mediaplan_detail->groupBy('ratecard_id')->map(function($group) {
            $first = $group->first();
            return [
                'selectedRatecardId' => $first->ratecard_id,
                'jumlahTiket' => $first->jumlah_tiket,
                'idLiputan' => $first->id_media,
                'mediaItems' => $first->ratecard->items->map(function($item) use ($group) {
                    $existing = $group->where('mediaitem_id', $item->id_mediaitem)->first();
                    return [
                        'id_mediaitem' => $item->id_mediaitem,
                        'nama_item' => $item->nama_item,
                        'harga' => $item->harga,
                        'qty' => $existing ? $existing->qty : ''
                    ];
                })->values()
            ];
        })->values();

        return view('pages.mediaplan.editmediaplan', compact('mediaplan','list_event','list_ratecard','list_jenis','formattedMediaBlocks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'event_id'     => 'required',
            'jenis_media'  => 'required',
            'media_blocks' => 'required|array',
        ]);

        // 1. update header media plan
        $mediaplan = Mediaplan::findOrFail($id);
        $mediaplan->update([
            'event_id' => $request->event_id,
            'jenis_media' => $request->jenis_media
        ]);

        // 2. hapus seluruh detail lama (untuk membersihkan media yang dihapus atau di-reset)
        Mediaplandetail::where('mediaplan_id', $mediaplan->id_mediaplan)->delete();

        // 3. masukkan ulang data detail yang baru dikirimkan dari form edit
        foreach($request->media_blocks as $block){
            $ratecardId     = $block['ratecard_id'] ?? null;
            $jumlahTiket    = $block['jumlah_tiket'] ?? 0;
            $idMedia        = $block['id_liputan'] ?? null;

            if($ratecardId && isset($block['items'])){
                foreach($block['items'] as $itemData){
                    $qty = isset($itemData['qty']) && $itemData['qty'] !== '' ? (int) $itemData['qty'] : 0;
                    
                    // simpan hanya item yg qty nya diisi > 0
                    if($qty > 0){
                        $hargaSatuan = $itemData['harga'];
                        $subtotal = $qty * $hargaSatuan;

                        Mediaplandetail::create([
                            'mediaplan_id' => $mediaplan->id_mediaplan,
                            'ratecard_id' => $ratecardId,
                            'jumlah_tiket' => $jumlahTiket,
                            'id_media' => $idMedia,
                            'mediaitem_id' => $itemData['id_mediaitem'],
                            'qty' => $qty,
                            'harga_satuan' => $hargaSatuan,
                            'subtotal' => $subtotal      
                        ]);
                    }
                }
            }
        }

        return redirect()->route('mediaplan.show', $mediaplan->id_mediaplan)
                 ->with('success', 'Media Plan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
