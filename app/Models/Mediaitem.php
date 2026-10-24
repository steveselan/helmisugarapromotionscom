<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediaitem extends Model
{
    use HasFactory;

    protected $table = 'tb_mediaitem';
    protected $primaryKey = 'id_mediaitem';
    protected $guarded = ['id_mediaitem'];

    public function ratecard()
    {
        return $this->belongsTo(Ratecard::class, 'ratecard_id');
    }

   

}
