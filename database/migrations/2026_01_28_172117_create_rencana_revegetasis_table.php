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
        Schema::create('rencana_revegetasis', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('bulan'); // 1-12
            $table->integer('target_bibit'); // Input manual jumlah batang
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_revegetasis');
    }
};
