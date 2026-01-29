<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'compliance'; 

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'ReportedBy',
        'Departemen',
        'Location',
        'IncidentType',
        'ComplianceType',
        'Date_reported',
        'Status',
        'Severity',
        'ResolvedBy',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'Date_reported' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope untuk dokumen dengan status tertentu.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('Status', $status);
    }

    /**
     * Scope untuk dokumen dengan severity tertentu.
     */
    public function scopeSeverity($query, $severity)
    {
        return $query->where('Severity', $severity);
    }

    /**
     * Scope untuk dokumen dari departemen tertentu.
     */
    public function scopeDepartemen($query, $departemen)
    {
        return $query->where('Departemen', $departemen);
    }
}