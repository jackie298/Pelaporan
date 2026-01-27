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
        Schema::create('nursery', function (Blueprint $table) {
             $table->id();
            $table->string('jenis_tanaman');
            $table->integer('jumlah_bibit')->unsigned();
            $table->date('tanggal_penyemaian');
            $table->string('lokasi_pembibitan');
            $table->enum('status_pertumbuhan', ['bagus', 'sedang', 'buruk']);
            $table->decimal('persentase_keberhasilan', 5, 2)->nullable(); 
            $table->text('catatan')->nullable();
            $table->date('estimasi_siap_tanam')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
            $table->softDeletes();

            $table->index('jenis_tanaman');
            $table->index('lokasi_pembibitan');
            $table->index('status_pertumbuhan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nursery');
    }
};
