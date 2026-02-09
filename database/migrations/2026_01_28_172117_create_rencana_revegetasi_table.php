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
        Schema::create('rencana_revegetasi', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            // TARGET BULANAN UNTUK REVEGETASI
            $table->integer('januari');
            $table->integer('februari');
            $table->integer('maret');
            $table->integer('april');
            $table->integer('mei');
            $table->integer('juni');
            $table->integer('juli');
            $table->integer('agustus');
            $table->integer('september');
            $table->integer('oktober');
            $table->integer('november');
            $table->integer('desember');
            // END FORM TARGET BULANAN REVEGETASI
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_revegetasi');
    }
};
