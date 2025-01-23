<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QueryExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Kelas',
            'Mulai',
            'Sampai',
            'Sesi',
            'Materi',
            'Peserta',
            'Terdaftar',
            'Sedang Mengikuti',
            'Lulus',
            'Gagal',
            'Dibatalkan',
        ];
    }
}
