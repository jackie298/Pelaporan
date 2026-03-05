<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteWaterManagement;
use App\Models\User;
use Carbon\Carbon;

class WasteWaterManagementSeeder extends Seeder
{
    public function run()
    {
        // Ambil user pertama sebagai penginput (untuk memenuhi created_by)
        $user = User::first();
        
        // Jika belum ada user, buat satu user dummy agar seeder tidak error
        if (!$user) {
            $user = User::create([
                'name' => 'Admin System',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $lokasi = ['Settling Pond Rey Nabila', 'Settling Pond Jetty Lama'];
        $samplers = ['Inlet', 'Outlet'];
        
        for ($i = 30; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);

            foreach ($lokasi as $loc) {
                foreach ($samplers as $samp) {
                    
                    if ($samp == 'Inlet') {
                        $ph = fake()->randomFloat(2, 5.5, 8.5);
                        $tss = fake()->numberBetween(150, 350);
                    } else {
                        $ph = fake()->randomFloat(2, 6.5, 7.5);
                        $tss = fake()->numberBetween(50, 180);
                    }

                    WasteWaterManagement::create([
                        'tanggal_sampling' => $tanggal->format('Y-m-d'),
                        'lokasi_sampling'  => $loc,
                        'sampler'          => $samp,
                        'ph'               => $ph,
                        'tss'              => $tss,
                        'catatan'          => 'Sampling rutin harian',
                        'created_by'       => $user->id, // <--- TAMBAHKAN INI
                    ]);
                }
            }
        }
    }
}