<?php

namespace App\Exports;

use App\Models\WasteWaterManagement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class WasteWaterExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WasteWaterManagement::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Sampling',
            'Lokasi Sampling',
            'pH',
            'TSS (mg/L)',
            'Status Kesesuaian',
            'catatan',
            'Created At',
            'Updated At',
        ];
    }

    public function map($wastewater): array
    {
        return [
            $wastewater->id,
            $wastewater->tanggal_sampling ? $wastewater->tanggal_sampling->format('d-m-Y') : '-',
            $wastewater->lokasi_sampling,
            $wastewater->ph ?? '-',
            $wastewater->tss ?? '-',
            $wastewater->status_kesesuaian,
            $wastewater->catatan ?? '-',
            $wastewater->created_at ? $wastewater->created_at->format('d-m-Y H:i') : '-',
            $wastewater->updated_at ? $wastewater->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Waste Water';
    }

    public function filename(): string
    {
        return 'wastewater_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Waste Water';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}
