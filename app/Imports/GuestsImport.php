<?php

namespace App\Imports;

use App\Models\EventGuest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuestsImport implements ToModel, WithHeadingRow
{
    protected $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    public function model(array $row)
    {
        return new EventGuest([
            'event_id' => $this->event_id,
            'nama_tamu' => $row['nama_tamu'], // Pastikan kolom Excel bernama 'nama_tamu'
            'kehadiran' => false,
        ]);
    }
}
