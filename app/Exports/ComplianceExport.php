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
            'Reported By',
            'Departemen',
            'Location',
            'Incident Type',
            'Compliance Type',
            'Date Reported',
            'Status',
            'Severity',
            'Resolved By',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Memetakan data dari Model ke kolom Excel
     */
    public function map($compliance): array
    {
        return [
            $compliance->id,
            $compliance->ReportedBy,
            $compliance->Departemen,
            $compliance->Location,
            $compliance->IncidentType,
            $compliance->ComplianceType,
            // Pastikan tanggal diformat agar terbaca dengan baik di Excel
            $compliance->Date_reported ? \Carbon\Carbon::parse($compliance->Date_reported)->format('d-m-Y') : '-',
            ucfirst($compliance->Status),
            $compliance->Severity,
            $compliance->ResolvedBy ?? '-',
            $compliance->created_at ? $compliance->created_at->format('d-m-Y H:i') : '-',
            $compliance->updated_at ? $compliance->updated_at->format('d-m-Y H:i') : '-',
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
