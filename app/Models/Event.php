<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['nama_event', 'tanggal_event'];

    public function guests()
    {
        return $this->hasMany(EventGuest::class, 'event_id');
    }
}
