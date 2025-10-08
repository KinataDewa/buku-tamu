<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventGuest extends Model
{
    protected $fillable = [
        'event_id',
        'nama_tamu',
        'jenis_tamu',
        'no_telp',
        'kehadiran',
        'foto'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function attendance()
    {
        return $this->hasOne(EventGuestAttendance::class, 'guest_id');
    }

}
