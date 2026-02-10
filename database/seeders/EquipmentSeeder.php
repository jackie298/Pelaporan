<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        $equipments = [
            // EXCA
            ['nama' => 'EXCA', 'kode' => 'EXC 224', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            ['nama' => 'EXCA', 'kode' => 'EXC 243', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            ['nama' => 'EXCA', 'kode' => 'EXC 247', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            ['nama' => 'EXCA', 'kode' => 'EXC 263', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            
            // EXCA LONG ARM
            ['nama' => 'EXCA LONG ARM', 'kode' => 'EXC LA 264', 'jenis' => 'EXCA LONG ARM', 'status' => 'tersedia'],
            
            // EXCA lainnya
            ['nama' => 'EXCA', 'kode' => 'EXC 265', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            ['nama' => 'EXCA', 'kode' => 'EXC 242', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            ['nama' => 'EXCA', 'kode' => 'EXC 238', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            
            // EXC BREKER
            ['nama' => 'EXC BREKER', 'kode' => 'EXC BR 216', 'jenis' => 'EXC BREKER', 'status' => 'tersedia'],
            
            // EXCA
            ['nama' => 'EXCA', 'kode' => 'EXC 246', 'jenis' => 'EXCA', 'status' => 'tersedia'],
            
            // BULDOZER
            ['nama' => 'BULDOZER', 'kode' => 'BD 35', 'jenis' => 'BULDOZER', 'status' => 'tersedia'],
            
            // DUMP TRUCK
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 173', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 177', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 193', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 194', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 126', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 127', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 128', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 141', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 145', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
            ['nama' => 'DUMP TRUCK', 'kode' => 'DT 146', 'jenis' => 'DUMP TRUCK', 'status' => 'tersedia'],
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }
    }
}