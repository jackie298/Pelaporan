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
        Schema::create('revegetasi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_monitoring');
            $table->string('lokasi_revegetasi');
            $table->decimal('luas_area', 10, 2);
            $table->enum('jenis_vegetasi', ['pionir', 'lokal', 'covercrop']);
            $table->integer('jumlah_tanaman')->nullable();
            $table->enum('tingkat_keberhasilan', ['rendah', 'sedang', 'tinggi']);
            $table->string('kondisi_tanah')->nullable();
            $table->string('metode_penanaman')->nullable();
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
        Schema::dropIfExists('revegetasi');
    }
};
