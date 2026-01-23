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
        Schema::create('reklamasi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_reklamasi');
            $table->string('lokasi_reklamasi');
            $table->decimal('luas_direklamasi', 10, 2);
            $table->string('jenis_kegiatan');
            $table->string('metode_reklamasi');
            $table->text('alat_berat_digunakan')->nullable();
            $table->string('izin_lingkungan')->nullable();
            $table->enum('status_kesesuaian', ['sesuai', 'tidak_sesuai']);
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reklamasi');
    }
};
