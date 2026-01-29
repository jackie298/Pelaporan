<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RevegetasiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil ID user yang ada di database
        $userId = User::first()->id ?? 1; // Mengambil user pertama, atau default ke ID 1

        $data = [
            [
                'tanggal_monitoring' => '2026-01-15',
                'lokasi_revegetasi' => 'Area Disposal Selatan',
                'luas_area' => 5.25,
                'jenis_vegetasi' => 'Akasia & Sengon',
                'jumlah_tanaman' => 2100,
                'kondisi_tanah' => 'Stabil (Topsoil)',
                'metode_penanaman' => 'Manual pot',
                'tingkat_keberhasilan' => 'tinggi',
                'catatan' => 'Sesuai target Januari.',
                'created_by' => $userId, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_monitoring' => '2026-02-20',
                'lokasi_revegetasi' => 'Area Disposal Utara',
                'luas_area' => 4.1,
                'jenis_vegetasi' => 'Rumput Vetiver',
                'jumlah_tanaman' => 1800,
                'kondisi_tanah' => 'Erosi Ringan',
                'metode_penanaman' => 'Hydroseeding',
                'tingkat_keberhasilan' => 'sedang',
                'catatan' => 'Beberapa titik tergerus air hujan.',
                'created_by' => $userId, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('revegetasi')->insert($data);
    }
}