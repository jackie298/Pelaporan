<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compliance;

class ComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'ReportedBy' => 'Ahmad Fauzi',
                'Departemen' => 'HSE',
                'Location' => 'Pit Utara, Blok A',
                'IncidentType' => 'Kecelakaan Kerja - Terjatuh',
                'ComplianceType' => 'Internal',
                'Date_reported' => now()->subDays(15),
                'Status' => 'Resolved',
                'Severity' => 'Medium',
                'ResolvedBy' => 'Budi Santoso',
            ],
            [
                'ReportedBy' => 'Siti Rahayu',
                'Departemen' => 'Produksi',
                'Location' => 'Area Pengolahan, Sektor 3',
                'IncidentType' => 'Tumpahan Bahan Kimia',
                'ComplianceType' => 'Eksternal/Regulasi',
                'Date_reported' => now()->subDays(10),
                'Status' => 'Pending',
                'Severity' => 'High',
                'ResolvedBy' => 'Budi Santoso',
            ],
            [
                'ReportedBy' => 'Dian Permata',
                'Departemen' => 'Maintenance',
                'Location' => 'Workshop Alat Berat',
                'IncidentType' => 'Kebocoran Oli Mesin',
                'ComplianceType' => 'Internal',
                'Date_reported' => now()->subDays(7),
                'Status' => 'Open',
                'Severity' => 'Low',
                'ResolvedBy' => 'Budi Santoso',
            ],
            [
                'ReportedBy' => 'Rudi Hartono',
                'Departemen' => 'HSE',
                'Location' => 'Jalan Angkut, Rute 2',
                'IncidentType' => 'Pelanggaran Prosedur Keselamatan',
                'ComplianceType' => 'Audit',
                'Date_reported' => now()->subDays(5),
                'Status' => 'Escalated',
                'Severity' => 'Critical',
                'ResolvedBy' => 'Manager HSE',
            ],
            [
                'ReportedBy' => 'Lina Wijaya',
                'Departemen' => 'HRD',
                'Location' => 'Kantor Administrasi',
                'IncidentType' => 'Keluhan Karyawan - Lingkungan Kerja',
                'ComplianceType' => 'Internal',
                'Date_reported' => now()->subDays(3),
                'Status' => 'Open',
                'Severity' => 'Medium',
                'ResolvedBy' => 'Budi Santoso',
            ],
        ];

        foreach ($data as $item) {
            Compliance::create($item);
        }
    }
}