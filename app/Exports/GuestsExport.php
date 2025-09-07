<?php

namespace App\Exports;

use App\Models\EventGuest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestsExport implements FromCollection, WithHeadings
{
    protected $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    public function collection()
    {
        return EventGuest::where('event_id', $this->event_id)
            ->select('nama_tamu')
            ->get();
    }

    public function headings(): array
    {
        return ['Nama Tamu'];
    }
}
