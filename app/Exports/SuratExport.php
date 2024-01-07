<?php

namespace App\Exports;

use App\Models\Letters;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class SuratExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Letters::all();
    }

    public function headings(): array
    {
        return [
            "Nomor Surat", "Perihal", "Tanggal Keluar", "Penerima Surat", "Notulis", "Hasil Rapat"
        ];
    }

    public function map($item): array
    {
        return [
            $item->letter_type_id,
            $item->letter_perihal,
            $item->created_at,
            $item->recipients,
            $item->user->name,
        ];
    }
}
