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
        'telepon',
        'foto',
        'tanggal_kunjungan',
        'nama_penerima',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'jam_keluar'
    ];

}