<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Liputan extends Model
{
    use HasFactory;
    
    protected $table = 'tb_liputan';
    protected $primaryKey = 'id_liputan';
    protected $guarded = ['id_liputan'];
    
    protected $casts = [
        'link1' => 'array', // Mengubah JSON dari database menjadi PHP Array otomatis
    ];

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id','id_liputan');
    }
}
