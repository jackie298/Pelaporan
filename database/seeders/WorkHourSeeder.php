<?php

namespace Database\Seeders;

use App\Models\workhours;
use App\Models\Equipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data equipment
        $equipments = Equipment::all();
        if ($equipments->isEmpty()) {
            $this->command->warn('Tidak ada data alat. Silakan jalankan EquipmentSeeder terlebih dahulu.');
            return;
        }

        // Ambil 3 alat pertama sebagai contoh
        $alatIds = $equipments->pluck('id')->toArray();

        $workHoursData = [];

        // Generate data untuk 7 hari terakhir
        for ($i = 0; $i < 7; $i++) {
            $tanggal = now()->subDays($i)->toDateString();

            foreach ($alatIds as $alatId) {
                // Acak jam mulai & selesai
                $jamMulai = rand(6, 8) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                $jamSelesai = rand(16, 18) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                $istirahat = rand(1, 2); // 1 atau 2 jam

                // Hitung total jam (asumsi format HH:mm)
                [$h1, $m1] = array_map('intval', explode(':', $jamMulai));
                [$h2, $m2] = array_map('intval', explode(':', $jamSelesai));

                $menit1 = $h1 * 60 + $m1;
                $menit2 = $h2 * 60 + $m2;

                if ($menit2 <= $menit1) {
                    $menit2 += 24 * 60; // handle overnight
                }

                $totalJam = round(($menit2 - $menit1) / 60 - $istirahat, 2);

                $workHoursData[] = [
                    'alat_id' => $alatId,
                    'tanggal' => $tanggal,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'jam_istirahat' => $istirahat,
                    'total_jam' => $totalJam,
                    'lokasi' => 'Area Tambang ' . ['Utara', 'Selatan', 'Timur', 'Barat'][array_rand([0,1,2,3])],
                    'aktivitas' => 'Operasional harian alat berat',
                    'catatan' => 'Kondisi alat normal, tidak ada kendala',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Masukkan data
        DB::table('workhours')->insert($workHoursData);

        $this->command->info('✅ ' . count($workHoursData) . ' data work hours berhasil ditambahkan.');
    }
}