<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Undangan extends Model
{
    // use HasFactory;
    
    protected $table = 'tb_undangan';
    protected $primaryKey = 'id_undangan';
    protected $guarded = ['id_undangan'];

    public function newevent(): BelongsTo
    {
        return $this->belongsTo(Newevent::class, 'undangan_id', 'id_undangan');
    }

    public function liputan(): HasMany
    {
        return $this->hasMany(Liputan::class, 'undangan_id', 'id_undangan');
    }
}
