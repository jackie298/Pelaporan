<?php

namespace App\Exports;

use App\Models\RekapAnggaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapAnggaranExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RekapAnggaran::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'nama',
            'realisasi',
            'keterangan_jasa',
            'harga',
            'status',
            'keterangan',
            'uraian_rkab',
            'file_kontrak',
            'periode',
        ];
    }

    public function map($rekapAnggaran): array
    {
        return [
            $rekapAnggaran->id,
            $rekapAnggaran->nama,
            $rekapAnggaran->realisasi,
            $rekapAnggaran->keterangan_jasa,
            $rekapAnggaran->harga,
            $rekapAnggaran->status,
            $rekapAnggaran->keterangan,
            $rekapAnggaran->uraian_rkab,
            $rekapAnggaran->file_kontrak,
            $rekapAnggaran->periode,
        ];
    }

    public function title(): string
    {
        return 'Rekap Anggaran';
    }

    public function filename(): string
    {
        return 'rekap_anggaran_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Rekap Anggaran';
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }


}
