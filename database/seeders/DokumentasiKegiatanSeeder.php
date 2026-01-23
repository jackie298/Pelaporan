<?php

namespace Database\Seeders;

use App\Models\DokumentasiKegiatan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumentasiKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada data user. Silakan buat user terlebih dahulu.');
            return;
        }

        $userIds = $users->pluck('id')->toArray();

        $data = [];
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'judul' => 'Dokumentasi Kegiatan ' . ($i + 1),
                'tanggal' => now()->subDays($i)->toDateString(),
                'lokasi' => 'Lokasi Operasional ' . ($i + 1),
                'deskripsi' => 'Deskripsi lengkap kegiatan operasional harian.',
                'jenis_kegiatan' => ['Inspeksi', 'Maintenance', 'Operasional'][array_rand([0,1,2])],
                'file_dokumentasi' => null,
                'created_by' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('dokumentasi_kegiatan')->insert($data);
        $this->command->info('✅ ' . count($data) . ' data dokumentasi kegiatan berhasil ditambahkan.');
    }
}