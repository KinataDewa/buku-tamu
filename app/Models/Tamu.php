<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $fillable = [
        'keperluan',
        'jenis_tamu',
        'nama_tamu',
        'nama_penerima',
        'telepon',
        'foto',
    ];
}