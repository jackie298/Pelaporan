<?php

namespace App\Exports;

use App\Models\Equipment as Alat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AlatExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Alat::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Kode',
            'Jenis',
            'Merk',
            'Tahun',
            'No Polisi',
            'No Mesin',
            'Status',
            'Lokasi Sekarang',
            'Catatan',
            'Created At',
            'Updated At',
        ];
    }

    public function map($alat): array
    {
        return [
            $alat->id,
            $alat->nama,
            $alat->kode,
            $alat->jenis,
            $alat->merk,
            $alat->tahun,
            $alat->no_polisi,
            $alat->no_mesin,
            $alat->status,
            $alat->lokasi_sekarang,
            $alat->catatan ?? '-',
            $alat->created_at ? $alat->created_at->format('d-m-Y H:i') : '-',
            $alat->updated_at ? $alat->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Daftar Alat';
    }

    public function fileName(): string
    {
        return 'alat_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Daftar Alat';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}