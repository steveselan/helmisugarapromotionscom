<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materitem extends Model
{
     use HasFactory;

    protected $table = 'tb_materitem';
    protected $primaryKey = 'id_materitem';
    protected $guarded = ['id_materitem'];
}
