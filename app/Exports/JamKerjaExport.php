<?php

namespace App\Exports;

use App\Models\workhours as Jamkerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class JamKerjaExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Jamkerja::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Alat ID',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Jam Istirahat',
            'Total Jam',
            'Lokasi',
            'Aktivitas',
            'Catatan',
            'Created At',
            'Updated At',
        ];
    }

    public function map($jamkerja): array
    {
        return [
            $jamkerja->id,
            $jamkerja->alat_id,
            $jamkerja->tanggal,
            $jamkerja->jam_mulai,
            $jamkerja->jam_selesai,
            $jamkerja->jam_istirahat,
            $jamkerja->total_jam,
            $jamkerja->lokasi,
            $jamkerja->aktivitas,
            $jamkerja->catatan ?? '-',
            $jamkerja->created_at ? $jamkerja->created_at->format('d-m-Y H:i') : '-',
            $jamkerja->updated_at ? $jamkerja->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Jam Kerja';
    }

    public function filename(): string
    {
        return 'jam_kerja_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Jam Kerja';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}
