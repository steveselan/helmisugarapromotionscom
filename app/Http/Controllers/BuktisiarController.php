<?php

namespace App\Http\Controllers;

use App\Models\Buktisiar;
use App\Models\Mediaplan;
use App\Models\Mediaplandetail;
use App\Models\Newevent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuktisiarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mediaplan = Mediaplan::join('tb_newevent','tb_mediaplan.event_id','=','tb_newevent.id_event')->with('event')->get()->groupBy('event_id');
        return view('pages.buktisiar.showbuktisiar', compact('data_mediaplan'));
    }

    public function detailMediaplan($event_id)
    {
        // 1. Cari SEMUA mediaplan yang punya event_id yang sama 
        // (misal: dapat 3 mediaplan: Radio, Web Base, New Media)
        $mediaplan = Mediaplan::where('event_id', $event_id)->get();

        // Ambil ID-ID dari mediaplan tersebut
        $mediaplanId = $mediaplan->pluck('id_mediaplan');

        // 2. ambil data event untuk informasi judul
        $event = Newevent::findOrFail($event_id);

        // 3. ambil SEMUA detail item promosi dari seluruh mediaplan_id tersebut sekaligus
        $allDetails = Mediaplandetail::with(['ratecard','mediaitem','mediaplan','buktisiar'])
                        ->whereIn('mediaplan_id', $mediaplanId)->get();
        
        // grouping berdasaran ratecard (Nama Media) agar nanti di blade bisa dipakai rowspan yang rapi
        $groupDetails = $allDetails->groupBy('ratecard_id');

        return view('pages.buktisiar.detailbuktisiar', compact('event','mediaplan','groupDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPerItem($id_detail)
    {
        $detail = Mediaplandetail::with(['ratecard', 'mediaitem','mediaplan.event'])->findOrFail($id_detail);

        // hitung sisa kuantiti yang belum di upload
        $sudahUploadCount = $detail->buktisiar->count();
        $sisaKuantiti = $detail->qty - $sudahUploadCount;

        // jika kuantiti sudah habis (atau minus), arahkan kembali dengan pesan
        if($sisaKuantiti <= 0)
            {
                return redirect()->route('buktisiar.gabungan', $detail->mediaplan->event_id)
                                ->with('error', 'Jumlah bukti siar untuk item ini sudah lengkap!');
            }
        return view('pages.buktisiar.addbuktisiar', compact('detail','sisaKuantiti'));
    }

    public function storePerItem(Request $request, $id_detail)
    {
        //1. Validasi input form
        $request->validate([
            'bukti' => 'required|array',
            'bukti.*.file_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bukti.*.keterangan' => 'nullable|string|max:255',
            'bukti.*.link_posting' => 'nullable|url|max:255',
        ],[
            'bukti.*.file_bukti.required' => 'File bukti wajib di unggah.',
            'bukti.*.file_bukti.mimes' => 'Format file harus berupa PDF, JPG, JPEG, atau PNG.',
            'bukti.*.file_bukti.max' => 'Ukuran file adalah maksimal 5MB.',
            'bukti.*.file_bukti.url' => 'Formant URL link tidak valid',
        ]);

        //2. Ambil data detail mediaplan untuk keperluan redirect nanti
        $detail = Mediaplandetail::with('mediaplan')->findOrFail($id_detail);

        // 3. Lakukan perulangan (looping) terhadap array bukti yang dikirim dari form
        foreach ($request->bukti as $item) {
            $filePath = null;

            // proses upload file jika ada file yang dikirim pada slot tersebut
            if (isset($item['file_bukti']) && $item['file_bukti']->isValid()) {
                $file = $item['file_bukti'];
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // simpan file ke folder public/storage/uploads/bukti_siar
                $filePath = $file->storeAs('uploads/bukti_siar', $filename, 'public');
            }

            //Simpan ke tabel tb_buktisiar

            Buktisiar::create([
                'mediaplandetail_id' => $id_detail,
                'file_bukti'         => $filePath,
                'keterangan'         => $item['keterangan'] ?? null,
                'link_posting'       => $item['link_posting'] ?? null,
            ]);
        }
        // 4. redirect kembali ke halaman rekap  gabungan event dengan pesan sukses
        return redirect()->route('buktisiar.gabungan', $detail->mediaplan->event_id)
                        ->with('success', 'Semua bukti siar berhasil disimpan!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_buktisiar)
    {
        //cari data bukti siar berdasarkan ID
        $bukti = Buktisiar::findOrFail($id_buktisiar);
        $detailId = $bukti->mediaplandetail_id;

        // hapus file fisik dari storege jika file tersebut ada
        if($bukti->file_bukti && Storage::disk('public')->exists($bukti->file_bukti))
        {
            Storage::disk('public')->delete($bukti->file_bukti);
        }

        // hapus data dari database
        $bukti->delete();

        // redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Bukti Siar Berhasil di Hapus');
    }
}
