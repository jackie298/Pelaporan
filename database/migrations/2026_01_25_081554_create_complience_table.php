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
        Schema::create('complience', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('jenis');
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_terbit');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->enum('status', ['Aktif', 'Kadaluarsa', 'Menunggu', 'Ditolak']);
            $table->text('keterangan')->nullable();
            $table->string('file_dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complience');
    }
};
