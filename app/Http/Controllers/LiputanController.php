<?php

namespace App\Http\Controllers;

use App\Models\Liputan;
use App\Models\Undangan;
use Illuminate\Http\Request;

class LiputanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function formrsvp($judul)
    {
        $dataUndangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')->where('judul', $judul)->firstOrFail();
        return view('checkmail',[
            'form_rsvp' => $dataUndangan
        ]);
    }

    public function checkemail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|email:dns'
        ]);

        $idUndanganAktif = $request->kode_undangan;

        // 1. Ambil data event/undangan yang sedang dikunjungi saat ini
        $dataUndangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')
                                ->where('tb_undangan.id_undangan', $idUndanganAktif)
                                ->firstOrFail();
                                
        // Cek Kapasitas / kuota event
        $batasKapasitas = $dataUndangan->kapasitas;

        // Hitung total orang yang sudah mendaftar di event ini
        $totalPendaftar = Liputan::where('undangan_id', $idUndanganAktif)->count();

        if($totalPendaftar >= $batasKapasitas){
            //jika kuota sudah penuh, tolak pendaftaran baru
            return view('thankyou',[
                'data_undangan' => $dataUndangan,
                'keterangan' => 'Mohon maaf, kuota pendaftaran event ini sudah penuh',
                'warna' => 'danger'
            ]);
        }

        // 2. CEK UTAMA: Apakah email ini SUDAH TERDAFTAR di undangan AKTIF ini?
        $sudahTerdaftar = Liputan::where('email', $request->email)
                                ->where('undangan_id', $idUndanganAktif)
                                ->first();
        // dd($sudahTerdaftar);

        if ($sudahTerdaftar)
        {
            // untuk undangan PC
            if($sudahTerdaftar->jenis_undangan == 'PC')
            {
                // Langsung arahkan ke halaman "sudah terdaftar" (atau kembalikan pesan bahwa email sudah terdaftar)
                return view('thankyou', [
                    'data_undangan' => $dataUndangan,
                    'keterangan' => 'Email anda sudah terdaftar untuk event ini!',
                    'warna' => 'success'
                ]);
            }else{
                    // untuk undangan Konser
                    // JIKA SUDAH TERDAFTAR DI EVENT INI tapi linknya tidak kososng
                    if($sudahTerdaftar->link1 !== null){
                        // Langsung arahkan ke halaman "sudah terdaftar" (atau kembalikan pesan bahwa email sudah terdaftar)
                        return view('thankyou', [
                            'data_undangan' => $dataUndangan,
                            'keterangan' => 'Email anda sudah terdaftar untuk event ini!',
                            'warna' => 'success'
                        ]);
                    }else{
                        return view('formrsvp', [
                            'data_undangan' => $dataUndangan,
                            'cek_email' => $sudahTerdaftar, // Membawa data lama agar nama/phone tetap terisi
                            'email' => $request->email,
                            'input_data_null' => '',
                            'undangan' => $idUndanganAktif
                        ]);
                    }
            }
        }else{
            // 3. JIKA BELUM TERDAFTAR DI EVENT INI:
            // Cek apakah dia punya riwayat profil dari event LAIN (misal: event PC sebelumnya) 
            // agar nama & nomor HP-nya bisa otomatis terisi (Autofill) di form
            $profilLama = Liputan::where('email', $request->email)
                                ->select('nama', 'email', 'phone', 'media', 'jabatan')
                                ->orderBy('updated_at', 'desc')
                                ->first();
            
                return view('formrsvp', [
                'data_undangan' => $dataUndangan,
                'cek_email' => $profilLama, // Membawa data Nama/Phone lama untuk autofill (jika ada)
                'email' => $request->email,
                'input_data_null' => '',
                'undangan' => $idUndanganAktif
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi dinamis berdasarkan jenis undangan
        $rules = [
            'email' => 'required|email|email:rfc,dns',
            'nama' => 'required|max:30',
            'phone' => 'required',
            'media' => 'required',
            'jabatan' => 'required',
            'jenis_undangan' => 'required',
            'kode_undangan' => 'required',
        ];

        // Jika jenis undangannya Konser, validasi input_berita. Jika PC, validasi alamatweb.
        if ($request->jenis_undangan == 'Konser') {
            $rules['input_berita'] = 'required|array';
            $rules['input_berita.*'] = 'required|string|max:255';
        } else {
            $rules['alamatweb'] = 'required';
        }

        $request->validate($rules);

        $judulUndangan = $request->judul;

        // Ambil data untuk dilempar ke halaman thank you jika di tolak
        $dataUndangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')
                            ->where('tb_undangan.judul', $judulUndangan)
                            ->firstOrFail();
        // filter dan blokir kata terlarang (Email atau Nama Media)
        $blockedWords = ['film', 'movie', 'cinema', 'blogspot', 'motion', 'picture', 'histor', 'premiere'];

        // Gabungkan String Email dan nama media yang di input lalu ubah ke huruf kecil (lowercase)
        $stringToCheck = strtolower($request->email . ' ' . $request->media);

        foreach($blockedWords as $word)
            if(str_contains($stringToCheck, $word)){
                // jika mengandung kata terlarang, arahkan ke halaman thank you dengan kailmat penolakan halus
                return view('thankyou',[
                    'data_undangan' => $dataUndangan,
                    'keterangan' => 'Mohon maaf, pendaftaran untuk kategori media Anda belum dapat diproses otomatis melalui sistem ini. Silakan berkoordinasi langsung dengan PIC kami di nomor WA [0818-1891-9308] untuk informasi ketersediaan kursi.',
                    'warna' => 'danger'
                ]);
            }

        // 2. Olah data link berita (untuk Konser)
        $linkBerita = $request->input('input_berita');
        $jsonLink1 = null;
        
        if (!empty($linkBerita)) {
            $filteredBerita = array_filter($linkBerita, function($value) {
                return !is_null($value) && trim($value) !== '';
            });
            if (!empty($filteredBerita)) {
                $jsonLink1 = json_encode(array_values($filteredBerita));
            }
        }

        // 3. Proses Simpan / Update ke Database
        if ($request->jenis_undangan == 'PC') {
            // Logika Simpan untuk Press Conference
            Liputan::create([
                'email' => $request->email,
                'nama' => $request->nama,
                'phone' => $request->phone,
                'media' => $request->media,
                'jabatan' => $request->jabatan,
                'jenis_undangan' => $request->jenis_undangan,
                'undangan_id' => $request->kode_undangan,
                'link2' => $request->alamatweb,
                'jenis_media' => 'NP',
                'link1' => null
            ]);
        } else {
            // Logika Simpan / Update untuk Konser
            $dataUpdateOrCreate = [
                'email' => $request->email,
                'nama' => $request->nama,
                'phone' => $request->phone,
                'media' => $request->media,
                'jabatan' => $request->jabatan,
                'jenis_undangan' => $request->jenis_undangan,
                'undangan_id' => $request->kode_undangan,
                'link1' => $jsonLink1, // Simpan array link berita ke link1
                'jenis_media' => 'NP',
            ];

            if ($request->kode_liputan !== null) {
                Liputan::where('id_liputan', $request->kode_liputan)->update($dataUpdateOrCreate);
            } else {
                Liputan::create($dataUpdateOrCreate);
            }
        }

        return redirect('liputan/thankyou/' . $judulUndangan);
    }

    public function thankyou($judul){
        $dataUndangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')
                                ->where('tb_undangan.judul', $judul)
                                ->firstOrFail();
        
        return view('thankyou',[
                    'data_undangan' => $dataUndangan,
                    'keterangan' => 'Terima kasih! Data anda sudah terdaftar',
                    'warna' => 'success'
         ]);
    }

    public function listrsvp($judul){

        $undangan = Undangan::where('judul', $judul)->firstOrFail();
        $id_undangan = $undangan->id_undangan;
        
        $dataundangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')->findOrFail($id_undangan);
        $dataliputan = Liputan::where('undangan_id',$id_undangan)->orderBy('updated_at','desc')->get();

        $totalrsvp = Liputan::where('undangan_id',$id_undangan)->count();
        $totalhadir = Liputan::where('undangan_id', $id_undangan)->sum('jumlah_id');
        $totalphotographer = Liputan::where('undangan_id', $id_undangan)->where('jabatan', 'PGVG')->sum('jumlah_id');

    
        return view('listrsvp',[
            'data_undangan' => $dataundangan,
            'data_liputan' => $dataliputan,
            'total_rsvp' => $totalrsvp,
            'total_hadir' => $totalhadir,
            'total_photographer' => $totalphotographer
        ]);
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
        $event = Undangan::find($request->undanganid);
        $judul_event = $event->judul;
        // $request->validate([
        //     'email' => 'required|email|email:rfc,dns',
        //     'nama' => 'required|max:30',
        //     'phone' => 'required',
        //     'media' => 'required',
        //     'jabatan' => 'required',
        //     'input_berita' => 'required|array',
        //     'input_berita.*' => 'required|string|max:255',
        // ]);
        $arrayBerita = $request->input_berita;
        Liputan::where('id_liputan',$id)->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'jabatan' => $request->jabatan,
                    'jenis_undangan' => $request->jenis_undangan,
                    'jenis_media' => $request->jenis_media,
                    'link2' => $request->alamatweb,
                    'jumlah_id' => $request->jumlahid
            ]);

        // return "Berhasil di Update";
        // return redirect('/liputan/listrsvp/'.$judul_event);
        // 2. Kembalikan ke halaman sebelumnya secara otomatis
        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        Liputan::findOrFail($id)->delete();

        return redirect()->back();

    }
}
