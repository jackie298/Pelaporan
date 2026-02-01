<?php

namespace App\Exports;

use App\Models\DokumentasiKegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DokumentasiKegiatanExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DokumentasiKegiatan::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul',
            'Tanggal',
            'Lokasi',
            'Deskripsi',
            'Jenis Kegiatan',
            'Created At',
            'Updated At',
        ];
    }

    public function map($dokumentasi): array
    {
        return [
            $dokumentasi->id,
            $dokumentasi->judul,
            $dokumentasi->tanggal ? $dokumentasi->tanggal->format('d-m-Y') : '-',
            $dokumentasi->lokasi,
            $dokumentasi->deskripsi,
            $dokumentasi->jenis_kegiatan,
            $dokumentasi->created_at ? $dokumentasi->created_at->format('d-m-Y H:i') : '-',
            $dokumentasi->updated_at ? $dokumentasi->updated_at->format('d-m-Y H:i') : '-',
        ];
    }


    public function title(): string
    {
        return 'Dokumentasi Kegiatan';
    }

    public function filename(): string
    {
        return 'dokumentasi_kegiatan_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Dokumentasi Kegiatan';
    }

    public function download(string $fileName)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $fileName);
    }
}
