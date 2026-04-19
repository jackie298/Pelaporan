<?php

namespace Database\Seeders;

use App\Models\TrashManagement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrashManagementSeeder extends Seeder
{
    /**
     * Opsi sumber sampah (harus sesuai dengan model & validasi)
     */
    private const SUMBER_SAMPAH = [
        'area kantor',
        'area site',
    ];

    /**
     * Range berat sampah dalam kg (min, max)
     */
    private const WEIGHT_RANGE = [
        'organik' => [5, 150],
        'anorganik' => [2, 100],
        'residu' => [1, 50],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Memulai seeding data Trash Management...');

        // Hapus data lama jika ingin fresh start (opsional)
        // TrashManagement::truncate();

        $generated = $this->generateSampleData();
        
        foreach ($generated as $data) {
            TrashManagement::create($data);
        }

        $this->command->info('✅ Seeding selesai!');
        $this->command->info('📊 Total data dibuat: ' . count($generated));
        $this->command->table(
            ['Sumber', 'Jumlah Data', 'Range Tanggal'],
            $this->getSummaryReport($generated)
        );
    }

    /**
     * Generate data sampel dengan menghindari duplikasi tanggal+sumber
     */
    private function generateSampleData(): array
    {
        $data = [];
        $used = []; // Track kombinasi tanggal+sumber yang sudah dipakai
        $faker = \Faker\Factory::create('id_ID');

        // Generate data untuk 90 hari terakhir
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(90);

        // Buat variasi data: 2 sumber × ~60 hari = ~120 data max
        $sources = self::SUMBER_SAMPAH;
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            foreach ($sources as $sumber) {
                // 70% kemungkinan ada data per hari per sumber (realistis: tidak setiap hari ada laporan)
                if ($faker->boolean(70)) {
                    $key = $currentDate->toDateString() . '_' . $sumber;
                    
                    // Skip jika kombinasi sudah ada
                    if (isset($used[$key])) {
                        continue;
                    }
                    $used[$key] = true;

                    // Generate weight dengan pola realistis
                    $organik = $this->generateWeight('organik', $faker, $sumber);
                    $anorganik = $this->generateWeight('anorganik', $faker, $sumber);
                    $residu = $this->generateWeight('residu', $faker, $sumber);

                    // Kadang-kadang salah satu jenis kosong (realistis)
                    if ($faker->boolean(10)) $organik = null;
                    if ($faker->boolean(10)) $anorganik = null;
                    if ($faker->boolean(15)) $residu = null;

                    // Pastikan minimal satu ada
                    if (is_null($organik) && is_null($anorganik) && is_null($residu)) {
                        $organik = $faker->numberBetween(5, 30);
                    }

                    $data[] = [
                        'tanggal' => $currentDate->toDateString(),
                        'sumber_sampah' => $sumber,
                        'sampah_organik_terpilah' => $organik,
                        'sampah_anorganik_terpilah' => $anorganik,
                        'sampah_lainnya_dan_atau_residu' => $residu,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            $currentDate->addDay();
        }

        return $data;
    }

    /**
     * Generate berat sampah dengan pola realistis berdasarkan jenis & sumber
     */
    private function generateWeight(string $type, \Faker\Generator $faker, string $sumber): int
    {
        [$min, $max] = self::WEIGHT_RANGE[$type];

        // Area site biasanya menghasilkan sampah lebih banyak
        $multiplier = $sumber === 'area site' ? 1.5 : 1;

        // Organik lebih dominan di area kantor (sisa makanan), 
        // anorganik lebih dominan di site (packaging, material)
        if ($type === 'organik' && $sumber === 'area kantor') {
            $min = (int)($min * 1.3);
            $max = (int)($max * 1.2);
        }
        if ($type === 'anorganik' && $sumber === 'area site') {
            $min = (int)($min * 1.4);
            $max = (int)($max * 1.3);
        }

        return (int)($faker->numberBetween($min, $max) * $multiplier);
    }

    /**
     * Generate laporan summary untuk CLI
     */
    private function getSummaryReport(array $data): array
    {
        $report = [];
        $grouped = collect($data)->groupBy('sumber_sampah');

        foreach (self::SUMBER_SAMPAH as $sumber) {
            $items = $grouped->get($sumber) ?? collect();
            $dates = $items->pluck('tanggal')->sort();
            
            $report[] = [
                ucfirst(str_replace('area ', '', $sumber)),
                $items->count(),
                $dates->isNotEmpty() 
                    ? $dates->first() . ' s/d ' . $dates->last() 
                    : '-',
            ];
        }

        return $report;
    }
}