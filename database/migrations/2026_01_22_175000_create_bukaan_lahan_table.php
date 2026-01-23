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
        Schema::create('bukaan_lahan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_bukaan');
            $table->string('lokasi_bukaan');
            $table->decimal('luas_dibuka', 10, 2);
            $table->string('jenis_vegetasi_awal');
            $table->string('metode_pembukaan');
            $table->text('alat_berat_digunakan')->nullable();
            $table->string('izin_lingkungan')->nullable();
            $table->enum('status_kesesuaian', ['sesuai', 'tidak_sesuai']);
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
        Schema::dropIfExists('bukaan_lahan');
    }
};
