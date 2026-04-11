<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('revegetasi', function (Blueprint $table) {
            // Mengubah tipe data menjadi string
            $table->string('jenis_vegetasi')->change();
        });
    }

    public function down(): void
    {
        Schema::table('revegetasi', function (Blueprint $table) {
            // Mengembalikan ke enum jika rollback
            $table->enum('jenis_vegetasi', ['pionir', 'lokal', 'covercrop'])->change();
        });
    }
};