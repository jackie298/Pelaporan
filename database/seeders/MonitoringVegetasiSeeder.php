<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonitoringVegetasi;
use App\Models\User;

class MonitoringVegetasiSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $data = [
            [
                'lokasi' => 'Pit Utara',
                'titik_pantau' => 'TP-001',
                'jenis_tanaman' => 'Sengon',
                'tinggi_triwulan1' => 15.50,
                'tinggi_triwulan2' => 18.25,
                'tinggi_triwulan3' => 22.75,
                'tinggi_triwulan4' => 28.50,
                'tahun' => 2026,
                'catatan' => 'Pertumbuhan normal, tidak ada serangan hama',
                'created_by' => $user->id,
            ],
            [
                'lokasi' => 'Area Reklamasi Selatan',
                'titik_pantau' => 'TP-002',
                'jenis_tanaman' => 'Jati',
                'tinggi_triwulan1' => 12.30,
                'tinggi_triwulan2' => 14.80,
                'tinggi_triwulan3' => 16.90,
                'tinggi_triwulan4' => 19.20,
                'tahun' => 2026,
                'catatan' => 'Pertumbuhan lambat, perlu pemupukan tambahan',
                'created_by' => $user->id,
            ],
            [
                'lokasi' => 'Blok A Penutupan',
                'titik_pantau' => 'TP-003',
                'jenis_tanaman' => 'Mahoni',
                'tinggi_triwulan1' => 18.75,
                'tinggi_triwulan2' => 21.40,
                'tinggi_triwulan3' => 25.60,
                'tinggi_triwulan4' => 30.25,
                'tahun' => 2026,
                'catatan' => 'Pertumbuhan sangat baik, kondisi tanah optimal',
                'created_by' => $user->id,
            ],
            [
                'lokasi' => 'Sektor 3 Reklamasi',
                'titik_pantau' => 'TP-004',
                'jenis_tanaman' => 'Angsana',
                'tinggi_triwulan1' => 10.20,
                'tinggi_triwulan2' => 11.80,
                'tinggi_triwulan3' => null,
                'tinggi_triwulan4' => null,
                'tahun' => 2026,
                'catatan' => 'Pengukuran TW3 dan TW4 belum dilakukan',
                'created_by' => $user->id,
            ],
            [
                'lokasi' => 'Workshop Area',
                'titik_pantau' => 'TP-005',
                'jenis_tanaman' => 'Nangka',
                'tinggi_triwulan1' => 8.50,
                'tinggi_triwulan2' => 9.75,
                'tinggi_triwulan3' => 11.20,
                'tinggi_triwulan4' => 13.80,
                'tahun' => 2026,
                'catatan' => 'Tanaman buah, pertumbuhan sesuai ekspektasi',
                'created_by' => $user->id,
            ],
        ];

        foreach ($data as $item) {
            MonitoringVegetasi::create($item);
        }
    }
}