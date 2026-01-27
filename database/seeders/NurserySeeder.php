<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nursery;
use App\Models\User;

class NurserySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user untuk relasi created_by
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $data = [
            [
                'jenis_tanaman' => 'Sengon',
                'jumlah_bibit' => 5000,
                'tanggal_penyemaian' => now()->subDays(30),
                'lokasi_pembibitan' => 'Nursery Utara',
                'status_pertumbuhan' => 'bagus',
                'persentase_keberhasilan' => 85.50,
                'catatan' => 'Bibit tumbuh seragam, siap tanam bulan depan',
                'estimasi_siap_tanam' => now()->addDays(15),
                'created_by' => $user->id,
            ],
            [
                'jenis_tanaman' => 'Jati',
                'jumlah_bibit' => 3000,
                'tanggal_penyemaian' => now()->subDays(25),
                'lokasi_pembibitan' => 'Nursery Selatan',
                'status_pertumbuhan' => 'sedang',
                'persentase_keberhasilan' => 70.25,
                'catatan' => 'Perlu pemupukan tambahan',
                'estimasi_siap_tanam' => now()->addDays(20),
                'created_by' => $user->id,
            ],
            [
                'jenis_tanaman' => 'Mahoni',
                'jumlah_bibit' => 2500,
                'tanggal_penyemaian' => now()->subDays(20),
                'lokasi_pembibitan' => 'Nursery Utara',
                'status_pertumbuhan' => 'bagus',
                'persentase_keberhasilan' => 90.00,
                'catatan' => '-',
                'estimasi_siap_tanam' => now()->addDays(10),
                'created_by' => $user->id,
            ],
            [
                'jenis_tanaman' => 'Angsana',
                'jumlah_bibit' => 4000,
                'tanggal_penyemaian' => now()->subDays(15),
                'lokasi_pembibitan' => 'Nursery Barat',
                'status_pertumbuhan' => 'buruk',
                'persentase_keberhasilan' => 45.75,
                'catatan' => 'Serangan hama ulat, perlu penanganan segera',
                'estimasi_siap_tanam' => null,
                'created_by' => $user->id,
            ],
            [
                'jenis_tanaman' => 'Nangka',
                'jumlah_bibit' => 1500,
                'tanggal_penyemaian' => now()->subDays(10),
                'lokasi_pembibitan' => 'Nursery Timur',
                'status_pertumbuhan' => 'bagus',
                'persentase_keberhasilan' => 88.30,
                'catatan' => 'Bibit dari hasil panen sendiri',
                'estimasi_siap_tanam' => now()->addDays(25),
                'created_by' => $user->id,
            ],
        ];

        foreach ($data as $item) {
            Nursery::create($item);
        }
    }
}