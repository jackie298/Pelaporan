<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        $equipments = [
            [
                'nama' => 'Excavator Komatsu PC200',
                'kode' => 'EXC-001',
                'jenis' => 'Excavator',
                'merk' => 'Komatsu',
                'tahun' => 2022,
                'no_polisi' => 'B 1234 ABC',
                'no_mesin' => 'KMTPC200XXXXX',
                'status' => 'tersedia',
                'lokasi_sekarang' => 'Gudang Utama',
                'catatan' => 'Alat dalam kondisi prima'
            ],
            [
                'nama' => 'Dump Truck Hino 500',
                'kode' => 'DMP-002',
                'jenis' => 'Dump Truck',
                'merk' => 'Hino',
                'tahun' => 2021,
                'no_polisi' => 'B 5678 DEF',
                'no_mesin' => 'HINO500XXXXX',
                'status' => 'dipakai',
                'lokasi_sekarang' => 'Site Proyek A',
                'catatan' => 'Digunakan untuk angkut material'
            ],
            [
                'nama' => 'Bulldozer Caterpillar D6',
                'kode' => 'BLD-003',
                'jenis' => 'Bulldozer',
                'merk' => 'Caterpillar',
                'tahun' => 2020,
                'no_polisi' => null,
                'no_mesin' => 'CATD6XXXXXXX',
                'status' => 'perawatan',
                'lokasi_sekarang' => 'Bengkel Internal',
                'catatan' => 'Servis rutin bulanan'
            ],
            [
                'nama' => 'Wheel Loader Volvo L90',
                'kode' => 'WHL-004',
                'jenis' => 'Wheel Loader',
                'merk' => 'Volvo',
                'tahun' => 2023,
                'no_polisi' => 'B 9012 GHI',
                'no_mesin' => 'VOLVOL90XXXX',
                'status' => 'tersedia',
                'lokasi_sekarang' => 'Gudang Utama',
                'catatan' => 'Baru dibeli Q1 2026'
            ],
            [
                'nama' => 'Crane Mobile Tadano ATF 200',
                'kode' => 'CRN-005',
                'jenis' => 'Crane',
                'merk' => 'Tadano',
                'tahun' => 2019,
                'no_polisi' => 'B 3456 JKL',
                'no_mesin' => 'TADANO200XXX',
                'status' => 'rusak',
                'lokasi_sekarang' => 'Area Parkir',
                'catatan' => 'Rusak parah, menunggu suku cadang'
            ]
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }
    }
}