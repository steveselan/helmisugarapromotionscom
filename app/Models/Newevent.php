<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Newevent extends Model
{
    protected $table = 'tb_newevent';
    protected $primaryKey = 'id_event';
    protected $guarded = ['id_event'];

    public function undangan():HasMany
    {
        return $this->hasMany(Undangan::class, 'event_id','id_event');
    }

    public function medplan():HasMany
    {
        return $this->hasMany(Mediaplan::class, 'event_id');
    }

    // public function kategori():HasMany
    // {
    //     return $this->hasMany(Kategori::class, 'event_id');
    // }
}
