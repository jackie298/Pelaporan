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
            $table->date('tanggal');
            $table->enum('sumber_sampah',['area kantor', 'area site']);
            $table->integer('sampah_organik_terpilah')->nullable();
            $table->integer('sampah_anorganik_terpilah')->nullable();
            $table->integer('sampah_lainnya_dan_atau_residu')->nullable();
            $table->integer('total');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_management');
    }
};