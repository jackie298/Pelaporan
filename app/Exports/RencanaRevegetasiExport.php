<?php

namespace App\Exports;

use App\Models\RencanaRevegetasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RencanaRevegetasiExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RencanaRevegetasi::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tahun',
            'Bulan',
            'Target Bibit',
            'Lokasi',
            'Created At',
            'Updated At',
        ];
    }

    public function map($rencana): array
    {
        return [
            $rencana->id,
            $rencana->tahun,
            $rencana->bulan,
            $rencana->target_bibit,
            $rencana->lokasi ?? '-',
            $rencana->created_at ? $rencana->created_at->format('d-m-Y H:i') : '-',
            $rencana->updated_at ? $rencana->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Rencana Revegetasi';
    }

    public function filename(): string
    {
        return 'rencana_revegetasi_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Rencana Revegetasi';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}
