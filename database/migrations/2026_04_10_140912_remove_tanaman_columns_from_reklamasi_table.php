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
        Schema::table('reklamasi', function (Blueprint $table) {
            // Menghapus kolom yang tidak diperlukan
            $table->dropColumn(['jenis_tanaman', 'pupuk', 'jumlah_tanaman']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reklamasi', function (Blueprint $table) {
            // Mengembalikan kolom jika migration di-rollback
            $table->enum('jenis_tanaman', ['pionir', 'lokal', 'covercrop'])->after('metode_reklamasi');
            $table->string('pupuk')->after('jenis_tanaman');
            $table->integer('jumlah_tanaman')->after('pupuk');
        });
    }
};