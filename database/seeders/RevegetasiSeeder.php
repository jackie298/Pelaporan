<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RevegetasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. DATA RENCANA (TARGET 12 BULAN)
        $rencana = [];
        foreach (range(1, 12) as $bulan) {
            $rencana[] = [
                'tahun' => 2026,
                'bulan' => $bulan,
                // Target bervariasi antara 1000 - 3000 bibit
                'target_bibit' => ($bulan <= 4 || $bulan >= 10) ? rand(2000, 3000) : rand(1000, 1500),
                'lokasi' => 'Area Disposal ' . ($bulan % 2 == 0 ? 'Utara' : 'Selatan'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Pastikan tabel rencana_revegetasi ada sebelum insert
        DB::table('rencana_revegetasi')->insert($rencana);

        // 2. Ambil ID user yang ada di database untuk relasi created_by
        $user = User::first();
        if (!$user) {
            $this->command->warn('Tidak ada data user ditemukan. Pastikan sudah ada user di tabel users.');
            return;
        }
        $userId = $user->id;

        // 3. DATA REALISASI REVEGETASI (Sesuai Struktur Migrasi)
        $dataRealisasi = [
            [
                'tanggal_monitoring'   => '2026-01-15',
                'lokasi_revegetasi'    => 'Area Disposal Selatan',
                'luas_area'            => 5.25,
                'jenis_vegetasi'       => 'pionir', // Sesuai ENUM
                'jumlah_tanaman'       => 2100,
                'tingkat_keberhasilan' => 'tinggi', // Sesuai ENUM
                'kondisi_tanah'        => 'Stabil (Topsoil)',
                'metode_penanaman'     => 'Manual pot',
                'catatan'              => 'Penanaman Akasia dan Sengon sesuai target Januari.',
                'created_by'           => $userId, 
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'tanggal_monitoring'   => '2026-02-20',
                'lokasi_revegetasi'    => 'Area Disposal Utara',
                'luas_area'            => 4.10,
                'jenis_vegetasi'       => 'covercrop', // Sesuai ENUM
                'jumlah_tanaman'       => 1800,
                'tingkat_keberhasilan' => 'sedang', // Sesuai ENUM
                'kondisi_tanah'        => 'Erosi Ringan',
                'metode_penanaman'     => 'Hydroseeding',
                'catatan'              => 'Beberapa titik tergerus air hujan, perlu penyulaman.',
                'created_by'           => $userId, 
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'tanggal_monitoring'   => '2026-03-10',
                'lokasi_revegetasi'    => 'Pit Barat Bekas Tambang',
                'luas_area'            => 2.50,
                'jenis_vegetasi'       => 'lokal', // Sesuai ENUM
                'jumlah_tanaman'       => 500,
                'tingkat_keberhasilan' => 'rendah', // Sesuai ENUM
                'kondisi_tanah'        => 'Masam / pH Rendah',
                'metode_penanaman'     => 'Manual',
                'catatan'              => 'Perlu penambahan kapur dolomit untuk menetralkan pH.',
                'created_by'           => $userId, 
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ];

        DB::table('revegetasi')->insert($dataRealisasi);
        
        $this->command->info('✅ Berhasil seeding data Rencana dan Realisasi Revegetasi.');
    }
}