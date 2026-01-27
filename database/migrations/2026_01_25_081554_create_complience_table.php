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
        Schema::create('complience', function (Blueprint $table) {
            $table->id();
            $table->string('ReportedBy');
            $table->string('Departemen');
            $table->string('Location');
            $table->string('IncidentType');
            $table->string('ComplianceType');
            $table->date('Date_reported');;
            $table->enum('Status', ['Escalated', 'Pending', 'Resolved','Open']);
            $table->enum('Severity', ['Low', 'Medium', 'High', 'Critical']);
            $table->string('ResolvedBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complience');
    }
};
