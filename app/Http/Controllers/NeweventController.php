<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Newevent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NeweventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_event = Newevent::join('tb_kategori','tb_newevent.kategori_id','=','tb_kategori.id_kategori')->orderBy('tanggal','desc')->get();
        $kategori = Kategori::get();
        return view('pages.newevent.showNewevent',[
            'data_event' => $data_event,
            'listkategori' => $kategori
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $kategori = Kategori::get();
        return view('pages.newevent.addNewEvent',[
            'listkategori' => $kategori
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_event' => 'required',
            'artis' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'link_tiket' => 'required',
            'promotor' => 'required',
            'status' => 'required',
            'kategori' => 'required',
            'gambar1' => 'required|image|mimes:png,jpg,jpeg,webp|max:2000',
            'gambar2' => 'required|image|mimes:png,jpg,jpeg,webp|max:2000'
        ]); 

        // Proses gambar 1
        $file1 = $request->file('gambar1');
        $namaGambar1 = Str::slug($request->artis) . '_' . '.webp';
        $destinationPath = public_path('gambar_banner');
        
        if(!file_exists($destinationPath)){
            mkdir($destinationPath, 0755, true);
        }

        //konversi gambar 1 ke format webp
        $this->convertToWebp($file1->getRealPath(), $destinationPath . '/' . $namaGambar1, $file1->getClientOriginalExtension());
        

        // proses gambar 2
        $file2 = $request->file('gambar2');
        $namaGambar2 = Str::slug($request->artis) . '_mobile' . '.webp';

        // konversi gambar 2 ke format webp
        $this->convertToWebp($file2->getRealPath(), $destinationPath . '/' . $namaGambar2, $file2->getClientOriginalExtension());

    
        Newevent::create([
            'judul_event' => $request->judul_event,
            'artis' => $request->artis,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'link_tiket' => $request->link_tiket,
            'promotor' => $request->promotor,
            'status' => $request->status,
            'kategori_id' => $request->kategori,
            'gambar1' => $namaGambar1,
            'gambar2' => $namaGambar2
        ]);

        return redirect('/newevent')->with('pesan','Event baru berhasil di tambahkan dengan format WebP!');
    }

    //---- Fungsi Helper Konveri Webp ----
    private function convertToWebp($source, $destination, $extension)
    {
        $extension = strtolower($extension);
        
        if ($extension == 'jpg' || $extension == 'jpeg') {
            $img = imagecreatefromjpeg($source);
        } elseif ($extension == 'png') {
            $img = imagecreatefrompng($source);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
        } elseif ($extension == 'webp') {
            copy($source, $destination);
            return;
        } else {
            return;
        }

        // Simpan dalam format webp dengan kualitas 80%
        imagewebp($img, $destination, 80);
        imagedestroy($img);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detailEvent = Newevent::findOrFail($id);
        $kategori = Kategori::get();
        return view('pages.newevent.detailNewevent',[
            'detail_event' => $detailEvent,
            'listkategori' => $kategori
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $edit_event = Newevent::findOrFail($id);
        $kategori = Kategori::get();

        // Ambil nomor halaman dari request (jika ada, jika tidak default ke 1)
        $page = $request->input('page', 1);

        return view('pages.newevent.editNewevent',[
            'editevent' => $edit_event,
            'listkategori' => $kategori,
            'page' => $page // kirim variabel page ke view
        ]);
    }

    // Tambahkan method ini di NeweventController.php
    public function getJsonData($id)
    {
        $event = Newevent::findOrFail($id);
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul_event' => 'required',
            'artis' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'link_tiket' => 'required',
            'promotor' => 'required',
            'status' => 'required',
            'gambar1' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
            'gambar2' => 'nullable|image|mimes:png,jpg,jpeg|max:2000'
        ]); 

        if ($request->hasFile('gambar1')) {
            $editGambar1 = Str::slug($request->artis).'.'.$request->gambar1->extension();
            $request->gambar1->move(public_path('gambar_banner'),$editGambar1);
        }else{
             $gambarlama1 = Newevent::findOrFail($id);
             $editGambar1 = $gambarlama1->gambar1;
        }

        if ($request->hasFile('gambar2')) {
             $editGambar2 = Str::slug($request->artis).'_mobile'.'.'.$request->gambar2->extension();
            $request->gambar2->move(public_path('gambar_banner'),$editGambar2);
        }else{
             $gambarlama2 = Newevent::findOrFail($id);
             $editGambar2 = $gambarlama2->gambar2;
        }

        Newevent::where('id_event',$id)->update([
            'judul_event' => $request->judul_event,
            'artis' => $request->artis,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'link_tiket' => $request->link_tiket,
            'promotor' => $request->promotor,
            'status' => $request->status,
            'kategori_id' => $request->kategori,
            'gambar1' => $editGambar1,
            'gambar2' => $editGambar2
        ]);

       // return redirect('/newevent')->with('pesan','Event baru berhasil di update');
       // Kembali menggunakan redirect normal
        return redirect()->back()->with('pesan', 'Data event berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Newevent::findOrFail($id)->delete();
        return redirect('/newevent')->with('pesan','Event baru berhasil di hapus');
    }
}
