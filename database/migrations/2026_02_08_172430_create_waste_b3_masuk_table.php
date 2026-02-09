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
        Schema::create('waste_b3_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_limbah');
            $table->string('kode_limbah');
            $table->date('tanggal_masuk');
            $table->string('sumber_limbah');
            $table->double('jumlah_ton', 10, 2)->default(0);
            $table->date('maksimal_penyimpanan');
            
            // Status tracking
            $table->enum('status', ['belum_dikeluarkan', 'sebagian_dikeluarkan', 'sudah_dikeluarkan', 'kadaluarsa'])
                  ->default('belum_dikeluarkan');
            
            // Stok tracking (otomatis di-update saat ada pengeluaran)
            $table->double('jumlah_tersisa_ton', 10, 2)->default(0)
                  ->comment('Stok tersisa setelah pengeluaran');
            
            // Referensi dokumen
            $table->string('nomor_manifest')->nullable()
                  ->comment('Nomor manifest limbah masuk');
            $table->text('catatan')->nullable();

            // Tracking pembuat data
            $table->foreignId('created_by')->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('User yang membuat data');
            
            $table->softDeletes();
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index('tanggal_masuk');
            $table->index('status');
            $table->index('kode_limbah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_b3_masuk');
    }
};