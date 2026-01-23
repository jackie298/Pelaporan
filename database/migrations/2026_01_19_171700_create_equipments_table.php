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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('jenis');
            $table->string('merk')->nullable();
            $table->integer('tahun')->nullable();
            $table->string('no_polisi')->nullable();
            $table->string('no_mesin')->nullable();
            $table->enum('status', ['tersedia', 'dipakai', 'rusak', 'perawatan', 'tidak_aktif'])->default('tersedia');
            $table->string('lokasi_sekarang')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
