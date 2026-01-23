<?php

namespace Database\Seeders;

use App\Models\Reklamasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReklamasiSeeder extends Seeder
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

        $lokasiReklamasi = [
            'Pit Utara',
            'Pit Selatan',
            'Area Penutupan Tambang',
            'Lereng Timur',
            'Bekas Area Pengolahan',
            'Zona Reklamasi A',
            'Stockpile Batubara'
        ];

        $jenisKegiatan = [
            'Penimbunan',
            'Perataan Lahan',
            'Pembentukan Kontur',
            'Stabilisasi Lereng',
            'Pembuatan Kolam Pengendap'
        ];

        $metodeReklamasi = [
            'Mekanis',
            'Manual',
            'Kombinasi Mekanis & Manual',
            'Bioengineering'
        ];

        $alatBerat = [
            'Dozer D85, Grader GD825',
            'Excavator PC300, Dump Truck HD785',
            'Wheel Loader, Off-Highway Truck',
            'Backhoe Loader, Articulated Dump Truck'
        ];

        $izinLingkungan = [
            'SK Reklamasi No. 456/2024',
            'Izin KLHK No. 789/2024',
            'Keputusan AMDAL No. 101/2024',
            'Izin Operasional Lingkungan No. 202/2024'
        ];

        $data = [];

        for ($i = 0; $i < 15; $i++) {
            $tanggal = now()->subDays(rand(0, 90))->toDateString();
            $luas = round(rand(500, 2500) / 100, 2); // 5.00 - 25.00 ha
            $status = ['sesuai', 'tidak_sesuai'][array_rand([0,1])];

            $data[] = [
                'tanggal_reklamasi' => $tanggal,
                'lokasi_reklamasi' => $lokasiReklamasi[array_rand($lokasiReklamasi)],
                'luas_direklamasi' => $luas,
                'jenis_kegiatan' => $jenisKegiatan[array_rand($jenisKegiatan)],
                'metode_reklamasi' => $metodeReklamasi[array_rand($metodeReklamasi)],
                'alat_berat_digunakan' => $alatBerat[array_rand($alatBerat)],
                'izin_lingkungan' => $izinLingkungan[array_rand($izinLingkungan)],
                'status_kesesuaian' => $status,
                'catatan' => "Reklamasi rutin periode " . now()->subDays(rand(0, 30))->format('F Y'),
                'created_by' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('reklamasi')->insert($data);

        $this->command->info('✅ ' . count($data) . ' data reklamasi berhasil ditambahkan.');
    }
}