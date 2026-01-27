<?php

use Database\Seeders\UserSeeder;
use Database\Seeders\EquipmentSeeder;
use Database\Seeders\DocumentContractSeeder;
use Database\Seeders\WorkHourSeeder;
use Database\Seeders\DokumentasiKegiatanSeeder;
use Database\Seeders\WasteWaterManagementSeeder;
use Database\Seeders\BukaanLahanSeeder;
use Database\Seeders\ReklamasiSeeder;
use Database\Seeders\NurserySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            EquipmentSeeder::class,
            DocumentContractSeeder::class,
            WorkHourSeeder::class,
            DokumentasiKegiatanSeeder::class,
            WasteWaterManagementSeeder::class,
            BukaanLahanSeeder::class,
            ReklamasiSeeder::class,
            NurserySeeder::class,
        ]);
    }
}
