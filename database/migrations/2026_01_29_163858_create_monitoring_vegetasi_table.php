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
        Schema::create('monitoring_vegetasi', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi');
            $table->string('titik_pantau');
            $table->string('jenis_tanaman');
            $table->decimal('tinggi_triwulan1', 8, 2)->nullable(); // Tinggi triwulan ke-1 (cm)
            $table->decimal('tinggi_triwulan2', 8, 2)->nullable(); // Tinggi triwulan ke-2 (cm)
            $table->decimal('tinggi_triwulan3', 8, 2)->nullable(); // Tinggi triwulan ke-3 (cm)
            $table->decimal('tinggi_triwulan4', 8, 2)->nullable(); // Tinggi triwulan ke-4 (cm)
            $table->integer('tahun');
            $table->text('catatan')->nullable(); // Catatan tambahan
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Relasi ke user
            $table->timestamps();
            $table->softDeletes(); // Soft delete untuk recovery data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_vegetasi');
    }
};