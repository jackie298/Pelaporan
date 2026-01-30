<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trash_management', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_limbah_masuk');
            $table->string('kode_limbah');
            $table->date('tanggal_masuk');
            $table->string('sumber_limbah');
            $table->double('jumlah_masuk_ton')->default(0);
            $table->date('maksimal_penyimpanan');
            $table->date('tanggal_keluar')->nullable();
            $table->double('jumlah_keluar_ton')->default(0);
            $table->string('tujuan_penyerahan')->nullable();
            $table->string('nomor_dokumen')->nullable();
            $table->double('sisa_limbah_ton')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_management');
    }
};