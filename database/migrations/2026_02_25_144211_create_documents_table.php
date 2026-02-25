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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // Menghubungkan dokumen ke user yang mengunggah
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title'); // Nama tampilan dokumen
            $table->string('original_name'); // Nama file asli (contoh: laporan_final.pdf)
            $table->string('file_path'); // Lokasi penyimpanan (path) di storage
            $table->string('file_type'); // Ekstensi atau MIME type (pdf, docx, dll)
            $table->bigInteger('file_size'); // Ukuran file dalam bytes
            
            // Opsional: kategori atau deskripsi
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
