<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\WasteB3Keluar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ✅ Hapus file-file lama dari storage sebelum drop kolom
        WasteB3Keluar::onlyTrashed()
            ->whereNotNull('file_dokumen')
            ->get()
            ->each(function ($item) {
                if ($item->file_dokumen) {
                    $path = 'public/waste-b3/dokumen-keluar/' . $item->file_dokumen;
                    if (Storage::exists($path)) {
                        Storage::delete($path);
                    }
                }
            });

        // ✅ Drop kolom file_dokumen dari tabel
        Schema::table('waste_b3_keluar', function (Blueprint $table) {
            $table->dropColumn('file_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ✅ Rollback: tambahkan kembali kolom (nullable agar data lama tidak error)
        Schema::table('waste_b3_keluar', function (Blueprint $table) {
            $table->string('file_dokumen')->nullable()
                  ->after('nomor_dokumen_keluar')
                  ->comment('Scan dokumen manifest');
        });
    }
};