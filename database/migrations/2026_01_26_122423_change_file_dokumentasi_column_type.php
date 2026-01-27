<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dokumentasi_kegiatan', function (Blueprint $table) {
            // Ubah dari string/varchar ke TEXT agar bisa menampung ribuan karakter
            $table->text('file_dokumentasi')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('dokumentasi_kegiatan', function (Blueprint $table) {
            $table->string('file_dokumentasi', 255)->nullable()->change();
        });
    }
};
