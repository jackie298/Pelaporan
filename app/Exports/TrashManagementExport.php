<?php

namespace App\Exports;

use App\Models\TrashManagement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class TrashManagementExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TrashManagement::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Sumber Sampah',
            'Sampah Organik (kg)',
            'Sampah Anorganik (kg)',
            'Sampah Lainnya dan atau residu (kg)',
            'Total Sampah (kg)',
            'Created At',
            'Updated At',
        ];
    }

    public function map($trash): array
    {
        return [
            $trash->id,
            $trash->tanggal,
            $trash->sumber_sampah,
            $trash->sampah_organik_terpilah,
            $trash->sampah_anorganik_teripilah,
            $trash->sampah_lainnya_dan_atau_residu,
            $trash->total,
            $trash->created_at,
            $trash->updated_at,
        ];
    }

    public function title(): string
    {
        return 'Trash Management';
    }

    public function fileName(): string
    {
        return 'trash_management.xlsx';
    }

    public function sheetName(): string
    {
        return 'Trash Management Data';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }

    
}
