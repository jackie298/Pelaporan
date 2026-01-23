<?php

namespace Database\Seeders;

use App\Models\Revegetasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevegetasiSeeder extends Seeder
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

        $lokasiRevegetasi = [
            'Pit Utara',
            'Pit Selatan',
            'Area Penutupan Tambang',
            'Stockpile Batubara',
            'Lereng Timur',
            'Zona Reklamasi A',
            'Bekas Area Pengolahan'
        ];

        $jenisVegetasi = [
            'Akasia + Rumput Vetiver',
            'Pohon Pelindung + Semak',
            'Rumput Gajah + Legum',
            'Tanaman Penutup Tanah',
            'Campuran Lokal'
        ];

        $kondisiTanah = [
            'stabil',
            'erosi ringan',
            'longsor kecil',
            'retakan tanah',
            'permukaan rata'
        ];

        $metodePenanaman = [
            'manual',
            'hidroseeding',
            'bioengineering',
            'kombinasi manual & mekanis'
        ];

        $data = [];

        for ($i = 0; $i < 15; $i++) {
            $tanggal = now()->subDays(rand(0, 90))->toDateString();
            $luas = round(rand(500, 2000) / 100, 2); // 5.00 - 20.00 ha
            $tingkat = ['rendah', 'sedang', 'tinggi'][array_rand([0,1,2])];

            $data[] = [
                'tanggal_monitoring' => $tanggal,
                'lokasi_revegetasi' => $lokasiRevegetasi[array_rand($lokasiRevegetasi)],
                'luas_area' => $luas,
                'jenis_vegetasi' => $jenisVegetasi[array_rand($jenisVegetasi)],
                'jumlah_tanaman' => rand(500, 5000),
                'tingkat_keberhasilan' => $tingkat,
                'kondisi_tanah' => $kondisiTanah[array_rand($kondisiTanah)],
                'metode_penanaman' => $metodePenanaman[array_rand($metodePenanaman)],
                'catatan' => "Monitoring rutin periode " . now()->subDays(rand(0, 30))->format('F Y'),
                'created_by' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('revegetasi')->insert($data);

        $this->command->info('✅ ' . count($data) . ' data revegetasi berhasil ditambahkan.');
    }
}