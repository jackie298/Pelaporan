<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteB3Masuk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class WasteB3MasukSeeder extends Seeder
{
    public function run()
    {
        // Ambil satu user untuk mengisi created_by
        $user = User::first() ?? User::factory()->create();

        // Daftar Master Data Limbah
        $dataLimbah = [
            ['nama' => 'Oli Bekas', 'kode' => 'B105D'],
            ['nama' => 'Filter Bekas', 'kode' => 'B110D'],
            ['nama' => 'Aki Bekas', 'kode' => 'A102D'],
            ['nama' => 'Majun Terkontaminasi', 'kode' => 'B110D-1'], // Dibedakan agar unik
            ['nama' => 'Grease/Gemuk Bekas', 'kode' => 'B105D-2'],
            ['nama' => 'Lampu TL Bekas', 'kode' => 'B107D'],
            ['nama' => 'Sludge Oil', 'kode' => 'B301-1'],
            ['nama' => 'Kemasan Bekas B3', 'kode' => 'B104D'],
            ['nama' => 'Toner Cartridge', 'kode' => 'B353-1'],
            ['nama' => 'Tanah Terkontaminasi', 'kode' => 'B110D-2'],
        ];

        $sumber = ['Workshop Utama', 'Maintenance Unit', 'Elektrikal', 'Genset House', 'Laboratorium', 'Klinik', 'Pit 1 Alun'];

        // Menggunakan count($dataLimbah) agar tidak melanggar aturan unik jika datanya sedikit,
        // atau kita tambahkan suffix unik jika ingin tetap 50 data.
        foreach (range(1, 50) as $index) {
            $limbahRaw = $dataLimbah[array_rand($dataLimbah)];
            
            // Logika Tanggal
            $tglMasuk = Carbon::now()->subDays(rand(1, 180));
            $tglMaksimal = (clone $tglMasuk)->addDays(180);

            $jumlahTon = rand(1, 15) + (rand(0, 99) / 100);

            WasteB3Masuk::create([
                'jenis_limbah'         => $limbahRaw['nama'],
                // Pastikan UPPERCASE dan tambahkan suffix agar UNIK di database
                'kode_limbah'          => strtoupper($limbahRaw['kode'] . '-' . Str::random(4)),
                'tanggal_masuk'        => $tglMasuk,
                'sumber_limbah'        => $sumber[array_rand($sumber)],
                'jumlah_ton'           => $jumlahTon,
                'jumlah_tersisa_ton'   => $jumlahTon,
                'maksimal_penyimpanan' => $tglMaksimal,
                'status'               => 'belum_dikeluarkan',
                'nomor_manifest'       => 'MAN-' . strtoupper(Str::random(8)),
                'catatan'              => 'Data dummy hasil seeder otomatis - Entry #' . $index,
                'created_by'           => $user->id,
            ]);
        }
    }
}