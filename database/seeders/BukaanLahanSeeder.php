<?php

namespace Database\Seeders;

use App\Models\BukaanLahan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukaanLahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada data user. Silakan buat user terlebih dahulu.');
            return;
        }

        $userIds = $users->pluck('id')->toArray();

        $lokasiBukaan = [
            'Blok A Pit Utara',
            'Blok B Pit Selatan',
            'Area Penambangan Baru',
            'Zona Ekspansi Timur',
            'Lereng Barat',
            'Area Pengolahan Bijih',
            'Stockpile Batubara'
        ];

        $jenisVegetasiAwal = [
            'Hutan Sekunder',
            'Semak Belukar',
            'Padang Rumput',
            'Hutan Lindung',
            'Vegetasi Riparian'
        ];

        $metodePembukaan = [
            'Mekanis',
            'Manual',
            'Kombinasi Mekanis & Manual',
            'Hydraulic Mining'
        ];

        $alatBerat = [
            'Excavator PC300, Dump Truck HD785',
            'Dozer D85, Grader GD825',
            'Backhoe Loader, Articulated Dump Truck',
            'Wheel Loader, Off-Highway Truck'
        ];

        $izinLingkungan = [
            'SK AMDAL No. 123/2024',
            'Izin UKL-UPL No. 456/2024',
            'Keputusan KLHK No. 789/2024',
            'Izin Operasional Lingkungan No. 101/2024'
        ];

        $data = [];

        for ($i = 0; $i < 15; $i++) {
            $tanggal = now()->subDays(rand(0, 90))->toDateString();
            $luas = round(rand(500, 2500) / 100, 2); // 5.00 - 25.00 ha
            $status = ['sesuai', 'tidak_sesuai'][array_rand([0,1])];

            $data[] = [
                'tanggal_bukaan' => $tanggal,
                'lokasi_bukaan' => $lokasiBukaan[array_rand($lokasiBukaan)],
                'luas_dibuka' => $luas,
                'jenis_vegetasi_awal' => $jenisVegetasiAwal[array_rand($jenisVegetasiAwal)],
                'metode_pembukaan' => $metodePembukaan[array_rand($metodePembukaan)],
                'alat_berat_digunakan' => $alatBerat[array_rand($alatBerat)],
                'izin_lingkungan' => $izinLingkungan[array_rand($izinLingkungan)],
                'status_kesesuaian' => $status,
                'created_by' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('bukaan_lahan')->insert($data);

        $this->command->info('✅ ' . count($data) . ' data bukaan lahan berhasil ditambahkan.');
    }
}