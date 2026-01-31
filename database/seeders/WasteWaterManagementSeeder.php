<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WasteWaterManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user untuk relasi created_by
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada data user. Silakan buat user terlebih dahulu.');
            return;
        }

        $userIds = $users->pluck('id')->toArray();

        // Sesuaikan dengan enum di migrasi: Settling Pond Rey Nabila, Settling Pond Jetty Lama
        $lokasiSampling = [
            'Settling Pond Rey Nabila',
            'Settling Pond Jetty Lama'
        ];

        $data = [];

        for ($i = 0; $i < 15; $i++) {
            $tanggal = now()->subDays(rand(0, 60))->toDateString();
            $lokasi = $lokasiSampling[array_rand($lokasiSampling)];
            
            // Generate pH acak (5.0 - 9.5) sesuai presisi decimal(3,1)
            $ph = round(rand(50, 95) / 10, 1);
            
            // Generate TSS acak (20.00 - 250.00 mg/L) sesuai presisi decimal(8,2)
            $tss = round(rand(2000, 25000) / 100, 2);
            
            // Status kesesuaian berdasarkan baku mutu (Contoh: pH 6-9 dan TSS <= 200)
            $status = ($ph >= 6 && $ph <= 9 && $tss <= 200) ? 'memenuhi' : 'tidak_memenuhi';

            $data[] = [
                'tanggal_sampling' => $tanggal,
                'lokasi_sampling'  => $lokasi,
                'ph'               => $ph,
                'tss'              => $tss,
                'status_kesesuaian'=> $status,
                'catatan'          => "Sampling rutin di " . $lokasi,
                'created_by'       => $userIds[array_rand($userIds)],
                'created_at'       => now(),
                'updated_at'       => now(),
                // 'deleted_at'    => null (default null)
            ];
        }

        DB::table('waste_water_management')->insert($data);

        $this->command->info('✅ ' . count($data) . ' data waste water management berhasil ditambahkan sesuai enum lokasi.');
    }
}