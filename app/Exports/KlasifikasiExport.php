<?php

namespace App\Exports;

use App\Models\LetterTypes;
use App\Models\Letters;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class KlasifikasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LetterTypes::all();
    }

    public function headings(): array
    {
        return [
            "Kode Surat", "Klasifikasi Surat", "Surat Tertaut"
        ];
    }

    public function map($item): array
    {
        return [
            $item->letter_code,
            $item->name_type,
            Letters::where('letter_type_id', $item->id)->count()
        ];
    }

    public function title(): string
    {
        return 'Klasifikasi Surat';
    }
}
