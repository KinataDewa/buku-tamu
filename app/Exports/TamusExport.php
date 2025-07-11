<?php

namespace App\Exports;

use App\Models\Tamu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TamusExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Tamu::all();
    }

    public function headings(): array
    {
        return [
            'Nama Tamu',
            'Nama Penerima',
            'Telepon',
            'Tanggal Kunjungan',
            'Keperluan',
            'Jenis Tamu',
        ];
    }

    public function map($tamu): array
    {
        return [
            $tamu->nama_tamu,
            $tamu->nama_penerima,
            $tamu->telepon,
            $tamu->tanggal_kunjungan ? \Carbon\Carbon::parse($tamu->tanggal_kunjungan)->format('d-m-Y') : '',
            $tamu->keperluan,
            $tamu->jenis_tamu,
        ];
    }
}
