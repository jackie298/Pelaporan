<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'parent_id'];

    // Relasi untuk mengambil folder di dalamnya
    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    // Relasi untuk mengetahui folder induknya
    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
