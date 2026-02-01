<?php

namespace App\Exports;

use App\Models\MonitoringVegetasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MonitoringVegetasiExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MonitoringVegetasi::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Lokasi',
            'Titik Pantau',
            'Jenis Tanaman',
            'Triwulan I (cm)',
            'Triwulan II (cm)',
            'Triwulan III (cm)',
            'Triwulan IV (cm)',
            'Tahun',
            'Catatan',
            'Created By',
            'Created At',
            'Updated At',
        ];
    }

    public function map($monitoring): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $monitoring->lokasi ?? '-',
            $monitoring->titik_pantau ?? '-',
            $monitoring->jenis_tanaman ?? '-',
            $monitoring->tinggi_triwulan1 ?? '-',
            $monitoring->tinggi_triwulan2 ?? '-',
            $monitoring->tinggi_triwulan3 ?? '-',
            $monitoring->tinggi_triwulan4 ?? '-',
            $monitoring->tahun ?? '-',
            $monitoring->catatan ?? '-',
            $monitoring->creator ? $monitoring->creator->name : '-',
            $monitoring->created_at ? $monitoring->created_at->format('d-m-Y H:i') : '-',
            $monitoring->updated_at ? $monitoring->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Monitoring Vegetasi';
    }

    public function filename(): string
    {
        return 'monitoring_vegetasi_export_' . date('Y-m-d_His') . '.xlsx';
    }

    public function sheetName(): string
    {
        return 'Monitoring Vegetasi';
    }
    public function download(string $fileName)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $fileName);
    }
}