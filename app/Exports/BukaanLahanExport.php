<?php

namespace App\Exports;

use App\Models\BukaanLahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BukaanLahanExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BukaanLahan::all();
    }

    public function title(): string
    {
        return 'Bukaan Lahan';
    }

    public function filename(): string
    {
        return 'bukaan_lahan_export.xlsx';
    }

    public function sheetName(): string
    {
        return 'Bukaan Lahan';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Bukaan',
            'Lokasi Bukaan',
            'Luas Dibuka',
            'Jenis Vegetasi Awal',
            'Metode Pembukaan',
            'Alat Berat Digunakan',
            'Izin Lingkungan',
            'Status Kesesuaian',
            'Created At',
            'Updated At',
        ];
    }

    public function map($bukaanLahan): array
    {
        return [
            $bukaanLahan->id,
            $bukaanLahan->tanggal_bukaan ? $bukaanLahan->tanggal_bukaan->format('d-m-Y') : '-',
            $bukaanLahan->lokasi_bukaan,
            $bukaanLahan->luas_dibuka,
            $bukaanLahan->jenis_vegetasi_awal,
            $bukaanLahan->metode_pembukaan,
            $bukaanLahan->alat_berat_digunakan ?? '-',
            $bukaanLahan->izin_lingkungan ?? '-',
            ucfirst($bukaanLahan->status_kesesuaian),
            $bukaanLahan->created_at ? $bukaanLahan->created_at->format('d-m-Y H:i') : '-',
            $bukaanLahan->updated_at ? $bukaanLahan->updated_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function download(string $fileName)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $fileName);
    }
}