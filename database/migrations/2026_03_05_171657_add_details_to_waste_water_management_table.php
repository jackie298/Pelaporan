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
        Schema::table('waste_water_management', function (Blueprint $table) {
            // Menggunakan Enum untuk titik pengambilan sampel (Sampler)
            $table->enum('sampler', ['inlet', 'outlet'])->nullable()->after('lokasi_sampling');
            
            // Menambahkan kolom cuaca
            $table->string('cuaca')->nullable()->after('sampler')->comment('Contoh: Cerah, Berawan, Hujan');
            
            // Menambahkan kolom debit_air
            $table->decimal('debit_air', 12, 2)->nullable()->after('tss');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waste_water_management', function (Blueprint $table) {
            $table->dropColumn(['sampler', 'cuaca', 'debit_air']);
        });
    }
};