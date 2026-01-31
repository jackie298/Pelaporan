<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrashManagementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('trash_management')->insert([
            [
                'jenis_limbah_masuk' => 'Oli Bekas',
                'kode_limbah' => 'B105d',
                'tanggal_masuk' => Carbon::now()->subDays(10),
                'sumber_limbah' => 'Workshop Maintenance',
                'jumlah_masuk_ton' => 0.500,
                'maksimal_penyimpanan' => Carbon::now()->addDays(80),
                'tanggal_keluar' => null,
                'jumlah_keluar_ton' => 0,
                'tujuan_penyerahan' => null,
                'nomor_dokumen' => null,
                'sisa_limbah_ton' => 0.500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'jenis_limbah_masuk' => 'Filter Bekas',
                'kode_limbah' => 'B110d',
                'tanggal_masuk' => Carbon::now()->subDays(20),
                'sumber_limbah' => 'Service Unit Excavator',
                'jumlah_masuk_ton' => 0.150,
                'maksimal_penyimpanan' => Carbon::now()->addDays(70),
                'tanggal_keluar' => Carbon::now()->subDay(),
                'jumlah_keluar_ton' => 0.150,
                'tujuan_penyerahan' => 'PT. Transporter Limbah Hijau',
                'nomor_dokumen' => 'MNF-9900123',
                'sisa_limbah_ton' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'jenis_limbah_masuk' => 'Majun Terkontaminasi',
                'kode_limbah' => 'B110d',
                'tanggal_masuk' => Carbon::now()->subDays(5),
                'sumber_limbah' => 'Gudang Logistik',
                'jumlah_masuk_ton' => 0.025,
                'maksimal_penyimpanan' => Carbon::now()->addDays(85),
                'tanggal_keluar' => null,
                'jumlah_keluar_ton' => 0,
                'tujuan_penyerahan' => null,
                'nomor_dokumen' => null,
                'sisa_limbah_ton' => 0.025,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}