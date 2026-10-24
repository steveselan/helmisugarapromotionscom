<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index(Request $request){
        $data_toko = [
            'nama_toko'=>'makmur Jaya Abadi',
            'alamat'=>'Bondowoso, Jawa Timur',
            'tipe'=>'Ruko'
        ];

        $search = $request->cari;

        $data_produk = produk::when($search, function($query, $search){
            return $query->where('nama_produk','like',"%{$search}%");
        })
        ->join('tb_kategori','tb_produk.kategori_id','=','tb_kategori.id_kategori')
        ->get(); // query untuk mengambil semua data yang ada di tabel produk
        // $queryBuilder = DB::table('tb_produk')->get(); // query untuk mengambil semua data di tabel produk.
        return view('pages.produk.show',[
            'data_toko' => $data_toko,
            'data_produk' => $data_produk
        ]);
    }

    public function create(){
        $data_kategori = Kategori::get();
        return view('pages.produk.add',[
            'list_kategori' => $data_kategori
        ]);
    }

    public function store(Request $request){
        // validasi
        $request->validate([
            'nama_produk' => 'required|min:8',
            'harga' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
            'kategori' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg|max:2000'
        ],[
            'nama_produk.min' => 'Nama produk minimal 8 karakter',
            'nama_produk.required' => 'Kolom nama produk wajib diisi',
            'harga.required' => 'Kolom harga wajib diisi',
            'deskripsi.required' => 'Kolom deskripsi wajib diisi',
            'gambar.mimes' => 'Gambar hanya boleh dengan format jpg,png,jpeg'
        ]);

        $namaFile = Str::random(5).'.'.$request->gambar->extension();
        $request->gambar->move(public_path('gambar_produk'),$namaFile);

        // untuk menambahkan data ke tb_produk
        Produk::create([
            'kode_produk' => Str::random(5), 
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'deskripsi_produk' => $request->deskripsi,
            'kategori_id' => $request->kategori,
            'stok' => $request->stok,
            'gambar' => $namaFile
        ]);

        // setelah tambah data, akan mengarahkan ke halaman produk
        return redirect('/produk')->with('pesan','produk berhasil ditambahkan');
    }

    public function show($id){
        // query untuk mengambil data
        $data = Produk::join('tb_kategori','tb_produk.kategori_id','=','tb_kategori.id_kategori')->findOrFail($id);

        return view('pages.produk.detail', [
            'detail' => $data
            ]);
    }

    public function edit($id){
        $editData = Produk::findOrFail($id);
        $kategori = Kategori::get();

        return view('pages.produk.edit',[
            'edit' => $editData,
            'kategori' => $kategori
        ]);
    }

    public function update($id, Request $request){
        // validasi
        $request->validate([
            'nama_produk' => 'required|min:8',
            'harga' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
            'kategori' => 'required',
            'gambar' => 'image|mimes:png,jpg,jpeg|max:2000'
        ],[
            'nama_produk.min' => 'Nama produk minimal 8 karakter',
            'nama_produk.required' => 'Kolom nama produk wajib diisi',
            'harga.required' => 'Kolom harga wajib diisi',
            'stok.required' => 'Kolom stok wajib diisi',
            'deskripsi.required' => 'Kolom deskripsi wajib diisi',
            'gambar.mimes' => 'Gambar hanya boleh dengan format jpg,png,jpeg'
        ]);

        if($request->hasFile('gambar')){
            $namaFile = Str::random(5).'.'.$request->gambar->extension();
            $request->gambar->move(public_path('gambar_produk'),$namaFile);
        }else{
            $data_lama = Produk::findOrFail($id);
            $namaFile = $data_lama->gambar;
        }

        //query untuk simpan data yang telah di edit
        Produk::where('id_produk',$id)->update([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori,
            'deskripsi_produk' => $request->deskripsi,
            'gambar' => $namaFile
        ]);

        return redirect('/produk')->with('pesan', 'Data produk berhasil di update');
    }

    public function destroy($id){
        //query menghapus data
        produk::findOrFail($id)->delete();
        
        return redirect('/produk')->with('pesan', 'Data Produk berhasil dihapus');
    }
}
