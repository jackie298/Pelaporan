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
        Schema::create('workhours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_id')->constrained('equipments')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->time('jam_istirahat')->nullable();
            $table->decimal('total_jam', 5, 2);
            $table->string('lokasi')->nullable();
            $table->text('aktivitas')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workhours');
    }
};
