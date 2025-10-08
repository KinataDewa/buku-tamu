<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGuestAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'guest_id',
        'foto',
        'waktu_hadir',
    ];

    public function guest()
    {
        return $this->belongsTo(EventGuest::class, 'guest_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
