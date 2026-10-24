<?php

namespace App\Http\Controllers;

use App\Models\Liputan;
use App\Models\Newevent;
use App\Models\Undangan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UndanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataUndangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')->get();
       
        return view('pages.undangan.showUndangan',[
            'data_undangan' => $dataUndangan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $event = Newevent::where('status', 'New')->get();
        return view('pages.undangan.addUndangan',[
            'acara' => $event
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_undangan' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'jam' => 'required',
            'event_id' => 'required',
        ]);

        $event = Newevent::find($request->event_id);
        $judul_event = $event->judul_event;
        $judul = Str::words($judul_event, 3, '');
        Undangan::create([
            'jenis' => $request->jenis_undangan,
            'tanggal' => $request->tanggal,
            'lokasi_undangan' => $request->lokasi,
            'jam' => $request->jam,
            'event_id' => $request->event_id,
            'judul' => Str::lower($request->jenis_undangan .'-'. Str::slug($judul)),
            'kapasitas' => $request->kapasitas
        ]);

        return redirect('/undangan')->with('pesan','Undangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataUndangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')->findOrFail($id);

        return view('pages.undangan.detailUndangan',[
            'detail_undangan' => $dataUndangan
        ]);
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataUndangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')->findOrFail($id);

        return view('pages.undangan.editUndangan', compact('dataUndangan'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_undangan' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'jam' => 'required',
            'event_id' => 'required',
            'judul' => 'required',
            'kapasitas' => 'required',
        ]);

        Undangan::where('id_undangan',$id)->update([
            'jenis' => $request->jenis_undangan,
            'tanggal' => $request->tanggal,
            'lokasi_undangan' => $request->lokasi,
            'jam' => $request->jam,
            'event_id' => $request->event_id,
            'judul' => $request->judul,
            'kapasitas' => $request->kapasitas
        ]);

        return redirect('/undangan')->with('pesan','Undangan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listrsvpundangan($judul){
        $undangan = Undangan::where('judul', $judul)->firstOrFail();
        $id_undangan = $undangan->id_undangan;
        
        $dataundangan = Undangan::join('tb_newevent','tb_undangan.event_id','=','tb_newevent.id_event')->findOrFail($id_undangan);
        $dataliputan = Liputan::where('undangan_id',$id_undangan)->orderBy('updated_at','desc')->get();

        $totalrsvp = Liputan::where('undangan_id',$id_undangan)->count();
        $totalhadir = Liputan::where('undangan_id', $id_undangan)->sum('jumlah_id');
        $totalphotographer = Liputan::where('undangan_id', $id_undangan)->where('jabatan', 'PGVG')->sum('jumlah_id');

    
        return view('listrsvpundangan',[
            'data_undangan' => $dataundangan,
            'data_liputan' => $dataliputan,
            'total_rsvp' => $totalrsvp,
            'total_hadir' => $totalhadir,
            'total_photographer' => $totalphotographer
        ]);
    }
}
