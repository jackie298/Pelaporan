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
        Schema::create('waste_water_management', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_sampling');
            $table->enum('lokasi_sampling', ['Settling Pond Rey Nabila', 'Settling Pond Jetty Lama']);
            $table->decimal('ph', 3, 1)->nullable();
            $table->decimal('tss', 8, 2)->nullable();
            $table->enum('status_kesesuaian', ['memenuhi', 'tidak_memenuhi']);
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('waste_water_management'); 
    }
};
