<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';
    protected $guarded = ['id_kategori'];

    // public function kategori_event()
    // {
    //     return $this->belongsTo(Newevent::class, 'event_id', 'id_event');
    // }
}
