<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'nama_tamu',
        'kehadiran',
    ];

    // Relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
