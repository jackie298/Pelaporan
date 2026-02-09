<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RencanaRevegetasi;

class RevegetasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. DATA RENCANA REVEGETASI (12 BULAN DALAM 1 RECORD)
        $tahunList = [2024, 2025, 2026];
        
        foreach ($tahunList as $tahun) {
            $targetBulanan = [];
            
            // Generate target untuk setiap bulan
            foreach (RencanaRevegetasi::getDaftarBulan() as $key => $namaBulan) {
                // Target bervariasi antara 1000 - 3000 bibit
                // Bulan basah (Oktober-Maret) target lebih tinggi
                if (in_array($key, ['oktober', 'november', 'desember', 'januari', 'februari', 'maret'])) {
                    $targetBulanan[$key] = rand(2000, 3000);
                } else {
                    $targetBulanan[$key] = rand(1000, 1500);
                }
            }
            
            RencanaRevegetasi::create([
                'tahun' => $tahun,
                'januari' => $targetBulanan['januari'],
                'februari' => $targetBulanan['februari'],
                'maret' => $targetBulanan['maret'],
                'april' => $targetBulanan['april'],
                'mei' => $targetBulanan['mei'],
                'juni' => $targetBulanan['juni'],
                'juli' => $targetBulanan['juli'],
                'agustus' => $targetBulanan['agustus'],
                'september' => $targetBulanan['september'],
                'oktober' => $targetBulanan['oktober'],
                'november' => $targetBulanan['november'],
                'desember' => $targetBulanan['desember'],
                'lokasi' => $tahun === 2024 ? 'Area Disposal Selatan' : 
                           ($tahun === 2025 ? 'Area Disposal Utara' : 'Area Reklamasi Komprehensif'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. DATA REALISASI REVEGETASI (Sesuai Struktur Migrasi)
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('⚠️  Tidak ada data user ditemukan. Pastikan sudah ada user di tabel users.');
            $this->command->warn('   Jalankan: php artisan migrate --seed atau buat user manual terlebih dahulu.');
            return;
        }

        $userId = $user->id;

        $dataRealisasi = [
            [
                'tanggal_monitoring'   => '2024-01-15',
                'lokasi_revegetasi'    => 'Area Disposal Selatan',
                'luas_area'            => 5.25,
                'jenis_vegetasi'       => 'pionir',
                'jumlah_tanaman'       => 2100,
                'tingkat_keberhasilan' => 'tinggi',
                'kondisi_tanah'        => 'Stabil (Topsoil)',
                'metode_penanaman'     => 'Manual pot',
                'catatan'              => 'Penanaman Akasia dan Sengon sesuai target Januari.',
                'created_by'           => $userId,
                'created_at'           => now()->subMonths(24),
                'updated_at'           => now()->subMonths(24),
            ],
            [
                'tanggal_monitoring'   => '2024-02-20',
                'lokasi_revegetasi'    => 'Area Disposal Selatan',
                'luas_area'            => 4.10,
                'jenis_vegetasi'       => 'covercrop',
                'jumlah_tanaman'       => 1800,
                'tingkat_keberhasilan' => 'sedang',
                'kondisi_tanah'        => 'Erosi Ringan',
                'metode_penanaman'     => 'Hydroseeding',
                'catatan'              => 'Beberapa titik tergerus air hujan, perlu penyulaman.',
                'created_by'           => $userId,
                'created_at'           => now()->subMonths(23),
                'updated_at'           => now()->subMonths(23),
            ],
            [
                'tanggal_monitoring'   => '2024-03-10',
                'lokasi_revegetasi'    => 'Pit Barat Bekas Tambang',
                'luas_area'            => 2.50,
                'jenis_vegetasi'       => 'lokal',
                'jumlah_tanaman'       => 500,
                'tingkat_keberhasilan' => 'rendah',
                'kondisi_tanah'        => 'Masam / pH Rendah',
                'metode_penanaman'     => 'Manual',
                'catatan'              => 'Perlu penambahan kapur dolomit untuk menetralkan pH.',
                'created_by'           => $userId,
                'created_at'           => now()->subMonths(22),
                'updated_at'           => now()->subMonths(22),
            ],
            [
                'tanggal_monitoring'   => '2025-06-15',
                'lokasi_revegetasi'    => 'Area Disposal Utara',
                'luas_area'            => 6.80,
                'jenis_vegetasi'       => 'pionir',
                'jumlah_tanaman'       => 2800,
                'tingkat_keberhasilan' => 'tinggi',
                'kondisi_tanah'        => 'Stabil (Topsoil)',
                'metode_penanaman'     => 'Hydroseeding',
                'catatan'              => 'Progress penanaman sesuai target Juni.',
                'created_by'           => $userId,
                'created_at'           => now()->subMonths(8),
                'updated_at'           => now()->subMonths(8),
            ],
            [
                'tanggal_monitoring'   => '2025-09-05',
                'lokasi_revegetasi'    => 'Area Disposal Utara',
                'luas_area'            => 3.20,
                'jenis_vegetasi'       => 'covercrop',
                'jumlah_tanaman'       => 1200,
                'tingkat_keberhasilan' => 'sedang',
                'kondisi_tanah'        => 'Erosi Sedang',
                'metode_penanaman'     => 'Manual',
                'catatan'              => 'Perlu perbaikan drainase di beberapa titik.',
                'created_by'           => $userId,
                'created_at'           => now()->subMonths(5),
                'updated_at'           => now()->subMonths(5),
            ],
            [
                'tanggal_monitoring'   => '2026-01-20',
                'lokasi_revegetasi'    => 'Area Reklamasi Komprehensif',
                'luas_area'            => 8.50,
                'jenis_vegetasi'       => 'pionir',
                'jumlah_tanaman'       => 3200,
                'tingkat_keberhasilan' => 'tinggi',
                'kondisi_tanah'        => 'Stabil (Topsoil)',
                'metode_penanaman'     => 'Hydroseeding + Manual',
                'catatan'              => 'Penanaman awal tahun 2026 berjalan optimal.',
                'created_by'           => $userId,
                'created_at'           => now()->subMonths(1),
                'updated_at'           => now()->subMonths(1),
            ],
            [
                'tanggal_monitoring'   => '2026-02-15',
                'lokasi_revegetasi'    => 'Area Reklamasi Komprehensif',
                'luas_area'            => 5.75,
                'jenis_vegetasi'       => 'lokal',
                'jumlah_tanaman'       => 2400,
                'tingkat_keberhasilan' => 'tinggi',
                'kondisi_tanah'        => 'Stabil (Topsoil)',
                'metode_penanaman'     => 'Manual pot',
                'catatan'              => 'Penanaman tanaman lokal berjalan sesuai rencana.',
                'created_by'           => $userId,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ];

        // Insert ke tabel revegetasi jika tabel ada
        if (DB::getSchemaBuilder()->hasTable('revegetasi')) {
            DB::table('revegetasi')->insert($dataRealisasi);
        } else {
            $this->command->warn('⚠️  Tabel "revegetasi" belum ada. Jalankan migration terlebih dahulu.');
        }

        $this->command->info('✅ Berhasil seeding data:');
        $this->command->info('   - Rencana Revegetasi: ' . count($tahunList) . ' tahun (' . RencanaRevegetasi::count() . ' record)');
        $this->command->info('   - Realisasi Revegetasi: ' . count($dataRealisasi) . ' record');
    }
}