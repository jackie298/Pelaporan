<?php

use Database\Seeders\UserSeeder;
use Database\Seeders\EquipmentSeeder;
use Database\Seeders\RekapAnggaranSeeder;
use Database\Seeders\WorkHourSeeder;
use Database\Seeders\DokumentasiKegiatanSeeder;
use Database\Seeders\WasteWaterManagementSeeder;
use Database\Seeders\BukaanLahanSeeder;
use Database\Seeders\ReklamasiSeeder;
use Database\Seeders\RevegetasiSeeder;
use Database\Seeders\NurserySeeder;
use Database\Seeders\ComplianceSeeder;
use Database\Seeders\TrashManagementSeeder;
use Database\Seeders\MonitoringVegetasiSeeder;
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
            WorkHourSeeder::class,
            DokumentasiKegiatanSeeder::class,
            WasteWaterManagementSeeder::class,
            BukaanLahanSeeder::class,
            ReklamasiSeeder::class,
            RevegetasiSeeder::class,
            NurserySeeder::class,
            ComplianceSeeder::class,
            TrashManagementSeeder::class,
            MonitoringVegetasiSeeder::class,
            RekapAnggaranSeeder::class,
        ]);
    }
}
