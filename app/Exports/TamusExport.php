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
        return Tamu::latest()->get(); // Lebih baik agar data terbaru di atas
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Tamu',
            'Nama Penerima',
            'Telepon',
            'Instansi / Perusahaan',
            'Nomor Kartu',
            'Jenis Tamu',
            'Keperluan',
            'Tanggal Kunjungan',
            'Waktu Datang',
            'Waktu Pulang',
            'Foto',
        ];
    }

    public function map($tamu): array
    {
        return [
            $tamu->id,
            $tamu->nama_tamu,
            $tamu->nama_penerima,
            $tamu->telepon,
            $tamu->instansi ?? $tamu->asal_perusahaan ?? '-', // tergantung field mana yang digunakan
            $tamu->nomor_kartu ?? '-',
            $tamu->jenis_tamu,
            $tamu->keperluan,
            optional($tamu->tanggal_kunjungan)->format('d-m-Y'),
            optional($tamu->jam_datang)->format('H:i'),
            optional($tamu->jam_pulang)->format('H:i'),
            $tamu->foto ? asset('storage/foto/' . $tamu->foto) : '-',
        ];
    }
}
