<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_event',
        'tanggal_event',
    ];

    // Relasi ke tamu
    public function guests()
    {
        return $this->hasMany(EventGuest::class, 'event_id');
    }
}
