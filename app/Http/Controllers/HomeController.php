<?php

namespace App\Http\Controllers;

use App\Models\Newevent;
use Illuminate\Http\Request;

class HomeController extends Controller
{   
    public function index(){
        $eventbaru = Newevent::where('status','New')->orderBy('tanggal','desc')->get();
        $eventlama = Newevent::join('tb_kategori','tb_newevent.kategori_id','=','tb_kategori.id_kategori')
                                ->where('status','Past')
                                ->orderBy('tanggal','desc')
                                ->get();

        return view('hsp', compact('eventbaru', 'eventlama'));  
    }
}
