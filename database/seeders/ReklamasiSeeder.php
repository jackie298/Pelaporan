<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReklamasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user untuk relasi created_by
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada data user. Silakan buat user terlebih dahulu.');
            return;
        }

        $userIds = $users->pluck('id')->toArray();

        $lokasiReklamasi = ['Pit Utara', 'Pit Selatan', 'Lereng Timur', 'Zona Reklamasi A', 'Stockpile Area'];
        $jenisKegiatan = ['Penimbunan', 'Perataan Lahan', 'Pembentukan Kontur', 'Stabilisasi Lereng'];
        $metodeReklamasi = ['Mekanis', 'Manual', 'Kombinasi'];
        
        // Data baru sesuai migrasi
        $jenisTanaman = ['pionir', 'lokal', 'covercrop'];
        $daftarPupuk = ['NPK', 'Urea', 'Kompos', 'Pupuk Organik Cair'];

        $data = [];

        for ($i = 0; $i < 15; $i++) {
            $tanggal = now()->subDays(rand(0, 90))->toDateString();
            $luas = round(rand(100, 500) / 100, 2); // 1.00 - 5.00 ha
            $jumlahTanaman = rand(100, 1000); // 100 - 1000 batang
            
            $data[] = [
                'tanggal_reklamasi'   => $tanggal,
                'lokasi_reklamasi'    => $lokasiReklamasi[array_rand($lokasiReklamasi)],
                'luas_direklamasi'    => $luas,
                'jenis_kegiatan'      => $jenisKegiatan[array_rand($jenisKegiatan)],
                'metode_reklamasi'    => $metodeReklamasi[array_rand($metodeReklamasi)],
                
                // Kolam baru berdasarkan migrasi
                'jenis_tanaman'       => $jenisTanaman[array_rand($jenisTanaman)],
                'pupuk'               => $daftarPupuk[array_rand($daftarPupuk)],
                'jumlah_tanaman'      => $jumlahTanaman,
                
                'alat_berat_digunakan'=> 'Excavator PC300, Dozer D85',
                'izin_lingkungan'     => 'SK No. ' . rand(100, 999) . '/LHK/2024',
                'status_kesesuaian'   => ['sesuai', 'tidak_sesuai'][array_rand([0, 1])],
                'catatan'             => "Rehabilitasi lahan pascatambang tahap " . ($i + 1),
                'created_by'          => $userIds[array_rand($userIds)],
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        DB::table('reklamasi')->insert($data);

        $this->command->info('✅ ' . count($data) . ' data reklamasi (penanaman & lahan) berhasil ditambahkan.');
    }
}