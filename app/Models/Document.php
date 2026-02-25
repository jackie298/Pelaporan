<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'folder_id',
        'title',
        'original_name',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'description',
    ];

    /**
     * Relasi: Satu dokumen dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor untuk mengubah ukuran file ke format yang mudah dibaca (KB/MB)
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Helper untuk mendapatkan URL file yang bisa diakses
     */
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function folder() {
        return $this->belongsTo(Folder::class);
    }
}