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

        // Mapping aktivitas berdasarkan jenis equipment
        $activities = [
            'EXCA' => [
                'Penggalian material',
                'Pemuatan material ke dump truck',
                'Pembersihan area kerja',
                'Penyiapan bench tambang'
            ],
            'EXCA LONG ARM' => [
                'Pengerukan sungai/drainase',
                'Pembersihan lereng tinggi',
                'Pembuangan material jarak jauh'
            ],
            'EXC BREKER' => [
                'Pemecahan batuan besar',
                'Pembongkaran struktur beton',
                'Breaking material keras'
            ],
            'BULDOZER' => [
                'Pemerataan jalan tambang',
                'Pushing material',
                'Pembersihan area kerja',
                'Penyiapan lahan'
            ],
            'DUMP TRUCK' => [
                'Hauling material overburden',
                'Transportasi batubara',
                'Pengangkutan material ke stockpile'
            ],
        ];

        // Mapping lokasi berdasarkan jenis equipment
        $locations = [
            'EXCA' => ['Pit Utara', 'Pit Selatan', 'Face Tambang', 'Area Loading'],
            'EXCA LONG ARM' => ['Area Drainase', 'Lereng Timur', 'Sungai Tambang'],
            'EXC BREKER' => ['Quarry', 'Area Breaking', 'Primary Crusher'],
            'BULDOZER' => ['Jalan Hauling', 'Area Dumping', 'Road Maintenance'],
            'DUMP TRUCK' => ['Route Pit-to-Crusher', 'Hauling Road', 'Stockpile Area'],
        ];

        $workHoursData = [];

        // Generate data untuk 7 hari terakhir
        for ($i = 0; $i < 7; $i++) {
            $tanggal = now()->subDays($i)->toDateString();

            foreach ($equipments as $equipment) {
                $jenis = $equipment->jenis;
                
                // Acak jam mulai & selesai (sesuai shift operasional)
                $jamMulai = rand(6, 8) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                $jamSelesai = rand(16, 18) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                $istirahat = rand(1, 2); // 1 atau 2 jam

                // Hitung total jam
                [$h1, $m1] = array_map('intval', explode(':', $jamMulai));
                [$h2, $m2] = array_map('intval', explode(':', $jamSelesai));

                $menit1 = $h1 * 60 + $m1;
                $menit2 = $h2 * 60 + $m2;

                if ($menit2 <= $menit1) {
                    $menit2 += 24 * 60; // handle overnight
                }

                $totalJam = round(($menit2 - $menit1) / 60 - $istirahat, 2);

                // Pilih aktivitas & lokasi berdasarkan jenis
                $aktivitasList = $activities[$jenis] ?? ['Operasional harian alat berat'];
                $lokasiList = $locations[$jenis] ?? ['Area Tambang'];

                $workHoursData[] = [
                    'alat_id' => $equipment->id,
                    'tanggal' => $tanggal,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'jam_istirahat' => $istirahat,
                    'total_jam' => $totalJam,
                    'lokasi' => $lokasiList[array_rand($lokasiList)],
                    'aktivitas' => $aktivitasList[array_rand($aktivitasList)],
                    'catatan' => 'Kondisi alat normal, ' . ['tidak ada kendala', 'performa optimal', 'maintenance rutin selesai', 'operasi sesuai target'][array_rand([0,1,2,3])],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Masukkan data
        DB::table('workhours')->insert($workHoursData);

        $this->command->info('✅ ' . count($workHoursData) . ' data work hours berhasil ditambahkan untuk ' . $equipments->count() . ' unit alat.');
    }
}