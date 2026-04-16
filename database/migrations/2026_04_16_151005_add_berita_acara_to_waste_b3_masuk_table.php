<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('waste_b3_masuk', function (Blueprint $table) {
            // Menambahkan field berita_acara setelah nomor_manifest
            // Nullable agar data lama yang tidak punya berita acara tidak error
            $table->string('berita_acara')->nullable()
                  ->after('nomor_manifest')
                  ->comment('Nama file/path dokumen berita acara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waste_b3_masuk', function (Blueprint $table) {
            // Menghapus kolom jika rollback
            $table->dropColumn('berita_acara');
        });
    }
};