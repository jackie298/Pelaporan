<?php

namespace App\Exports;

use App\Models\Revegetasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RevegetasiExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Revegetasi::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Penanaman',
            'Lokasi Revegetasi',
            'Luas Area',
            'Jenis Vegetasi',
            'Jumlah Tanaman',
            'Tingkat Keberhasilan',
            'Kondisi Tanah',
            'Created At',
            'Metode Penanaman',
            'Catatan',
            'Updated At',
        ];
    }

    public function map($revegetasi): array
    {
        return [
            $revegetasi->id,
            $revegetasi->tanggal_monitoring ? $revegetasi->tanggal_monitoring->format('d-m-Y') : '-',
            $revegetasi->lokasi_revegetasi,
            $revegetasi->luas_area,
            $revegetasi->jenis_vegetasi,
            $revegetasi->jumlah_tanaman,
            $revegetasi->tingkat_keberhasilan,
            $revegetasi->kondisi_tanah ?? '-',
            $revegetasi->metode_penanaman ?? '-',
            $revegetasi->catatan ?? '-',
            $revegetasi->created_at ? $revegetasi->created_at->format('d-m-Y H:i') : '-',
            $revegetasi->updated_at ? $revegetasi->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Revegetasi';
    }

    public function filename(): string
    {
        return 'revegetasi_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Revegetasi';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}
