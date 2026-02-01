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
        Schema::create('compliance', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_pelapor');
            $table->string('Departemen');
            $table->string('Lokasi');
            $table->string('Jenis_insiden');
            $table->string('Jenis_inspeksi');
            $table->date('Tanggal_lapor');
            $table->enum('Status', ['Escalated', 'Pending', 'Resolved','Open']);
            $table->enum('Tingkat_keparahan', ['Low', 'Medium', 'High', 'Critical']);
            $table->string('Diselesaikan_oleh');
             $table->json('file_dokumentasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance');
    }
};
