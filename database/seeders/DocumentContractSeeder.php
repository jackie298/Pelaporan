<?php

namespace Database\Seeders;

use App\Models\DocumentContract;
use Illuminate\Database\Seeder;

class DocumentContractSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = [
            [
                'nama' => 'Kontrak Pengadaan Alat Berat',
                'realisasi' => '2025-01-15',
                'keterangan_jasa' => 'Pengadaan excavator dan dump truck untuk proyek tambang',
                'harga' => 1250000000,
                'status' => 'aktif',
                'keterangan' => 'Kontrak berlaku selama 2 tahun',
                'uraian_rkab' => 'Pengadaan alat berat sesuai matriks RKAB Q1 2025',
                'file_kontrak' => '#', // 👈 DIISI DENGAN #
            ],
            [
                'nama' => 'Jasa Maintenance Bulanan',
                'realisasi' => '2025-02-01',
                'keterangan_jasa' => 'Perawatan berkala alat berat di area operasional',
                'harga' => 75000000,
                'status' => 'selesai',
                'keterangan' => 'Layanan selesai sesuai jadwal',
                'uraian_rkab' => 'Maintenance rutin sesuai standar operasional',
                'file_kontrak' => '#',
            ],
            [
                'nama' => 'Sewa Generator Listrik',
                'realisasi' => '2025-03-10',
                'keterangan_jasa' => 'Penyewaan generator 500 kVA untuk site utara',
                'harga' => 45000000,
                'status' => 'aktif',
                'keterangan' => 'Berlaku hingga akhir Q2 2025',
                'uraian_rkab' => 'Dukungan listrik darurat sesuai RKAB',
                'file_kontrak' => '#',
            ],
            [
                'nama' => 'Konsultasi Teknis Tambang',
                'realisasi' => '2024-12-20',
                'keterangan_jasa' => 'Audit keselamatan dan efisiensi operasional',
                'harga' => 120000000,
                'status' => 'batal',
                'keterangan' => 'Dibatalkan karena perubahan anggaran',
                'uraian_rkab' => 'Kegiatan tidak masuk dalam revisi RKAB 2025',
                'file_kontrak' => '#',
            ],
            [
                'nama' => 'Pengadaan Suku Cadang',
                'realisasi' => '2025-01-30',
                'keterangan_jasa' => 'Penggantian onderdil mesin excavator',
                'harga' => 85000000,
                'status' => 'selesai',
                'keterangan' => 'Barang telah diterima dan dipasang',
                'uraian_rkab' => 'Penggantian suku cadang kritis Q1',
                'file_kontrak' => '#',
            ],
        ];

        foreach ($contracts as $data) {
            DocumentContract::create($data);
        }

        $this->command->info('✅ ' . count($contracts) . ' data kontrak berhasil ditambahkan dengan file_kontrak = #');
    }
}