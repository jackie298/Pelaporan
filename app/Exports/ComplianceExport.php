<?php

namespace App\Exports;

use App\Models\Compliance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomFileName;
use Maatwebsite\Excel\Concerns\WithCustomSheetName;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ComplianceExport implements FromCollection, Withheadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Compliance::all();
    }

    /**
     * Menentukan Header Tabel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelapor',
            'Departemen',
            'Lokasi',
            'jenis Insiden',
            'Jenis Inspeksi',
            'Tanggal Lapor',
            'Status',
            'Tingkat Keparahan',
            'Diselesaikan Oleh',
        ];
    }

    /**
     * Memetakan data dari Model ke kolom Excel
     */
    public function map($compliance): array
    {
        return [
            $compliance->id,
            $compliance->Nama_pelapor,
            $compliance->Departemen,
            $compliance->Lokasi,
            $compliance->Jenis_insiden,
            $compliance->Jenis_inspeksi,
            // Pastikan tanggal diformat agar terbaca dengan baik di Excel
            $compliance->Tanggal_lapor ? \Carbon\Carbon::parse($compliance->Tanggal_lapor)->format('d-m-Y') : '-',
            ucfirst($compliance->Status),
            $compliance->Tingkat_keparahan,
            $compliance->Diselesaikan_oleh ?? '-',
        ];
    }

    /**
     * Nama Sheet di dalam file Excel
     */
    public function title(): string
    {
        return 'Compliance Data';
    }

    public function fileName(): string
    {
        return 'compliance_data.xlsx';
    }

    public function sheetName(): string
    {
        return 'Compliance';
    }

    public function columnFormats(): array
    {
        return [
            'G' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function download(string $filename)
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $filename);
    }
}
