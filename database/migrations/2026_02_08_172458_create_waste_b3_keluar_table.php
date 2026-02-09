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
        Schema::create('waste_b3_keluar', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke limbah masuk
            $table->foreignId('waste_b3_masuk_id')
                  ->constrained('waste_b3_masuk')
                  ->onDelete('cascade')
                  ->comment('Referensi ke limbah masuk yang dikeluarkan');
            
            $table->date('tanggal_keluar');
            $table->double('jumlah_keluar_ton', 10, 2)->default(0);
            
            // Informasi pengeluaran
            $table->string('tujuan_penyerahan');
            $table->string('nomor_dokumen_keluar')
                  ->comment('Nomor manifest/B3 keluar');
            
            // Dokumentasi
            $table->string('file_dokumen')->nullable()
                  ->comment('Scan dokumen manifest');
            $table->text('catatan')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index('tanggal_keluar');
            $table->index('waste_b3_masuk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_b3_keluar');
    }
};