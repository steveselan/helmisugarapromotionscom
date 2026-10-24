<?php

namespace App\Models;

use App\Models\Buktisiar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediaplandetail extends Model
{
    use HasFactory;

    protected $table = 'tb_mediaplandetail';
    protected $primaryKey = 'id_mediaplandetail';
    protected $guarded = ['id_mediaplandetail'];

    public function mediaitem()
    {
        return $this->belongsTo(Mediaitem::class, 'mediaitem_id', 'id_mediaitem');
    }

    public function ratecard()
    {
        return $this->belongsTo(Ratecard::class, 'ratecard_id', 'id_ratecard');
    }

    // TAMBAHKAN FUNGSI INI:
    public function mediaplan()
    {
        return $this->belongsTo(Mediaplan::class, 'mediaplan_id', 'id_mediaplan');
        // Catatan: Sesuaikan 'mediaplan_id' (foreign key) dan 'id_mediaplan' (primary key parent) 
        // dengan struktur kolom yang ada di database Anda.
    }

    public function buktisiar()
    {
        // karena 1 detail bisa punya banyak bukti (Seperti radio spot atau multiple slot)
        return $this->hasMany(Buktisiar::class, 'mediaplandetail_id', 'id_mediaplandetail');
    }
}
