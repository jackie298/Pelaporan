<?php

namespace App\Exports;

use App\Models\Nursery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class NurseryExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Nursery::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Jenis Tanaman',
            'Tanggal Penyemaian',
            'Lokasi Pembibitan',
            'Status Pertumbuhan',
            'Presentase Keberhasilan',
            'Catatan',
            'Estimasi Siap Tanam',
            'Created At',
            'Updated At',
        ];

    }
    public function map($nursery): array
    {
        return [
            $nursery->id,
            $nursery->jenis_tanaman,
            $nursery->tanggal_penyemaian ? $nursery->tanggal_penyemaian->format('d-m-Y') : '-',
            $nursery->lokasi_pembibitan,
            $nursery->status_pertumbuhan,
            $nursery->persentase_keberhasilan ?? '-',
            $nursery->catatan ?? '-',
            $nursery->estimasi_siap_tanam ? $nursery->estimasi_siap_tanam->format('d-m-Y') : '-',
            $nursery->created_at ? $nursery->created_at->format('d-m-Y H:i') : '-',
            $nursery->updated_at ? $nursery->updated_at->format('d-m-Y H:i') : '-',
        ];
    }
    public function title(): string
    {
        return 'Nursery';
    }
    public function filename(): string
    {
        return 'nursery_export.xlsx';
    }
    public function sheetName(): string
    {
        return 'Nursery';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}
