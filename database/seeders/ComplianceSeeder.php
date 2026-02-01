<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compliance;
use Illuminate\Support\Facades\DB;

class ComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama terlebih dahulu
        DB::table('compliance')->truncate();

        $data = [
            [
                'Nama_pelapor' => 'Ahmad Fauzi',
                'Departemen' => 'HSE',
                'Lokasi' => 'Pit Utara, Blok A',
                'Jenis_insiden' => 'Kecelakaan Kerja - Terjatuh dari Ketinggian',
                'Jenis_inspeksi' => 'Internal',
                'Tanggal_lapor' => now()->subDays(15),
                'Status' => 'Resolved',
                'Tingkat_keparahan' => 'Medium',
                'Diselesaikan_oleh' => 'Budi Santoso',
            ],
            [
                'Nama_pelapor' => 'Siti Rahayu',
                'Departemen' => 'Produksi',
                'Lokasi' => 'Area Pengolahan, Sektor 3',
                'Jenis_insiden' => 'Tumpahan Bahan Kimia Berbahaya',
                'Jenis_inspeksi' => 'Eksternal/Regulasi',
                'Tanggal_lapor' => now()->subDays(10),
                'Status' => 'Pending',
                'Tingkat_keparahan' => 'High',
                'Diselesaikan_oleh' => 'Dian Permata',
            ],
            [
                'Nama_pelapor' => 'Dian Permata',
                'Departemen' => 'Maintenance',
                'Lokasi' => 'Workshop Alat Berat',
                'Jenis_insiden' => 'Kebocoran Oli Mesin Excavator',
                'Jenis_inspeksi' => 'Internal',
                'Tanggal_lapor' => now()->subDays(7),
                'Status' => 'Open',
                'Tingkat_keparahan' => 'Low',
                'Diselesaikan_oleh' => 'Rudi Hartono',
            ],
            [
                'Nama_pelapor' => 'Rudi Hartono',
                'Departemen' => 'HSE',
                'Lokasi' => 'Jalan Angkut, Rute 2',
                'Jenis_insiden' => 'Pelanggaran Prosedur K3 - Tidak Menggunakan APD',
                'Jenis_inspeksi' => 'Audit',
                'Tanggal_lapor' => now()->subDays(5),
                'Status' => 'Escalated',
                'Tingkat_keparahan' => 'Critical',
                'Diselesaikan_oleh' => 'Manager HSE',
            ],
            [
                'Nama_pelapor' => 'Lina Wijaya',
                'Departemen' => 'HRD',
                'Lokasi' => 'Kantor Administrasi',
                'Jenis_insiden' => 'Keluhan Karyawan - Lingkungan Kerja Tidak Nyaman',
                'Jenis_inspeksi' => 'Internal',
                'Tanggal_lapor' => now()->subDays(3),
                'Status' => 'Open',
                'Tingkat_keparahan' => 'Medium',
                'Diselesaikan_oleh' => 'Ahmad Fauzi',
            ],
            [
                'Nama_pelapor' => 'Budi Santoso',
                'Departemen' => 'Produksi',
                'Lokasi' => 'Area Penambangan, Sektor 5',
                'Jenis_insiden' => 'Kerusakan Alat Berat - Excavator',
                'Jenis_inspeksi' => 'Internal',
                'Tanggal_lapor' => now()->subDays(8),
                'Status' => 'Resolved',
                'Tingkat_keparahan' => 'High',
                'Diselesaikan_oleh' => 'Tim Maintenance',
            ],
            [
                'Nama_pelapor' => 'Eko Prasetyo',
                'Departemen' => 'HSE',
                'Lokasi' => 'Area Gudang Bahan Peledak',
                'Jenis_insiden' => 'Inspeksi Rutin - Temuan Pelanggaran',
                'Jenis_inspeksi' => 'Audit',
                'Tanggal_lapor' => now()->subDays(12),
                'Status' => 'Pending',
                'Tingkat_keparahan' => 'Medium',
                'Diselesaikan_oleh' => 'Siti Rahayu',
            ],
            [
                'Nama_pelapor' => 'Wati Susanti',
                'Departemen' => 'Maintenance',
                'Lokasi' => 'Area Bengkel',
                'Jenis_insiden' => 'Kecelakaan Kerja - Terjepit Mesin',
                'Jenis_inspeksi' => 'Internal',
                'Tanggal_lapor' => now()->subDays(20),
                'Status' => 'Resolved',
                'Tingkat_keparahan' => 'High',
                'Diselesaikan_oleh' => 'Dokter Perusahaan',
            ],
            [
                'Nama_pelapor' => 'Joko Widodo',
                'Departemen' => 'Produksi',
                'Lokasi' => 'Pit Selatan, Blok C',
                'Jenis_insiden' => 'Pelanggaran Prosedur Operasional',
                'Jenis_inspeksi' => 'Eksternal/Regulasi',
                'Tanggal_lapor' => now()->subDays(4),
                'Status' => 'Open',
                'Tingkat_keparahan' => 'Low',
                'Diselesaikan_oleh' => 'Supervisor Produksi',
            ],
            [
                'Nama_pelapor' => 'Dewi Lestari',
                'Departemen' => 'HRD',
                'Lokasi' => 'Area Mess Karyawan',
                'Jenis_insiden' => 'Keluhan - Fasilitas Tidak Memadai',
                'Jenis_inspeksi' => 'Internal',
                'Tanggal_lapor' => now()->subDays(6),
                'Status' => 'Pending',
                'Tingkat_keparahan' => 'Low',
                'Diselesaikan_oleh' => 'Manager HRD',
            ],
        ];

        foreach ($data as $item) {
            Compliance::create($item);
        }

        $this->command->info('✅ Seeder Compliance berhasil dijalankan!');
        $this->command->info('📊 Total data: ' . count($data) . ' record');
    }
}