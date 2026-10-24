<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratecard extends Model
{
    use HasFactory;

    protected $table = 'tb_ratecard';
    protected $primaryKey = 'id_ratecard';
    protected $guarded = ['id_ratecard'];

    public function items()
    {
        return $this->hasMany(Mediaitem::class, 'ratecard_id');
    }

    public function mediaplan()
    {
        return $this->belongsTo(Mediaplan::class, 'ratecard_id');
    }

}
