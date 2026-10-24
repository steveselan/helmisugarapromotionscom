<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->cari;

        // query untuk ambil semua data
        $dataKategori = Kategori::when($search, function($query, $search){
            return $query->where('nama_kategori','like',"%$search%");
        })->get();
        
        return view('pages.kategori.showKategori',[
            'dataKategori' => $dataKategori
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kategori.addKategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'nama_kategori' => 'required|min:8',
            'deskripsi' => 'required|min:8'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('/kategori')->with('pesan', 'Kategori berhasil ditambahkan');
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
        $edit_kategori = Kategori::findOrFail($id);
        return view('pages.kategori.editKategori',[
            'editKategori' => $edit_kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validation
        // $request->validate([
        //     'nama_kategori' => 'required',
        //     'deskirpsi' => 'required'
        // ]);
        $kategori = Kategori::findOrFail($id);
        
        $kategori->update($request->all());

        return redirect('/kategori')->with('pesan','kategori berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kategori::findOrFail($id)->delete();

        return redirect('/kategori')->with('pesan','kategori berhasil di hapus');

    }
}
