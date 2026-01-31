<?php

namespace App\Exports;

use App\Models\Reklamasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReklamasiExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Reklamasi::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Reklamasi',
            'Lokasi Reklamasi',
            'Luas Area Reklamasi',
            'Jenis Kegiatan',
            'Metode Reklamasi',
            'Alat Berat Digunakan',
            'Izin Lingkungan',
            'Status Kesesuaian',
            'Catatan',
            'Created At',
            'Updated At',
        ];
    }   

    public function map($reklamasi): array
    {
        return [
            $reklamasi->id,
            $reklamasi->tanggal_reklamasi ? $reklamasi->tanggal_reklamasi->format('d-m-Y') : '-',
            $reklamasi->lokasi_reklamasi,
            $reklamasi->luas_direklamasi,
            $reklamasi->jenis_kegiatan,
            $reklamasi->metode_reklamasi,
            $reklamasi->alat_berat_digunakan ?? '-',
            $reklamasi->izin_lingkungan ?? '-',
            ucfirst($reklamasi->status_kesesuaian),
            $reklamasi->catatan ?? '-',
            $reklamasi->created_at ? $reklamasi->created_at->format('d-m-Y H:i') : '-',
            $reklamasi->updated_at ? $reklamasi->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Reklamasi';
    }

    public function filename(): string
    {
        return 'reklamasi_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Reklamasi'; 
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}
