<?php

namespace App\Models;

use App\Models\Mediaplandetail;
use Illuminate\Database\Eloquent\Model;

class Mediaplan extends Model
{
    protected $table = 'tb_mediaplan';
    protected $primaryKey = 'id_mediaplan';
    protected $guarded = ['id_mediaplan'];

    public function mediaplan_detail()
    {
        return $this->hasMany(Mediaplandetail::class, 'mediaplan_id', 'id_mediaplan');
    }

    public function event()
    {
        return $this->belongsTo(Newevent::class, 'event_id', 'id_event');
    }
}
