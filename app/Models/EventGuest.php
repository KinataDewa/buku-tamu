<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventGuest extends Model
{
    protected $fillable = ['event_id', 'nama_tamu', 'kehadiran'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
