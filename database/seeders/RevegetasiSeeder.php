<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RevegetasiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA RENCANA (TARGET 12 BULAN)
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $rencana = [];
        foreach (range(1, 12) as $bulan) {
            $rencana[] = [
                'tahun' => 2026,
                'bulan' => $bulan,
                // Target dibuat bervariasi antara 1000 - 3000 bibit
                'target_bibit' => ($bulan <= 4 || $bulan >= 10) ? rand(2000, 3000) : rand(1000, 1500),
                'lokasi' => 'Area Disposal ' . ($bulan % 2 == 0 ? 'Utara' : 'Selatan'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('rencana_revegetasi')->insert($rencana);

        // 2. Ambil ID user yang ada di database
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