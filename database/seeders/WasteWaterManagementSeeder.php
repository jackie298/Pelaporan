<?php

namespace Database\Seeders;

use App\Models\WasteWaterManagement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WasteWaterManagementSeeder extends Seeder
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

        $lokasiSampling = [
            'Outfall IPAL',
            'Sungai Hilir Tambang',
            'Kolam Pengendap Utama',
            'Area Pengolahan Bijih',
            'Stockpile Batubara',
            'Drainase Perimeter',
            'Titik Monitoring Lingkungan'
        ];

        $data = [];

        for ($i = 0; $i < 15; $i++) {
            $tanggal = now()->subDays(rand(0, 60))->toDateString();
            $lokasi = $lokasiSampling[array_rand($lokasiSampling)];
            
            // Generate pH acak (4.0 - 9.0)
            $ph = round(rand(40, 90) / 10, 1);
            
            // Generate TSS acak (10.00 - 300.00 mg/L)
            $tss = round(rand(1000, 30000) / 100, 2);
            
            // Status kesesuaian berdasarkan baku mutu umum:
            // - pH: 6-9 → memenuhi
            // - TSS: ≤ 100 mg/L → memenuhi
            $status = ($ph >= 6 && $ph <= 9 && $tss <= 100) ? 'memenuhi' : 'tidak_memenuhi';

            $data[] = [
                'tanggal_sampling' => $tanggal,
                'lokasi_sampling' => $lokasi,
                'ph' => $ph,
                'tss' => $tss,
                'status_kesesuaian' => $status,
                'catatan' => "Sampling rutin periode " . now()->subDays(rand(0, 30))->format('F Y'),
                'created_by' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('waste_water_management')->insert($data);

        $this->command->info('✅ ' . count($data) . ' data waste water management berhasil ditambahkan.');
    }
}