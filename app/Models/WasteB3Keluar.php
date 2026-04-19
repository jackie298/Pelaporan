<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class WasteB3Keluar extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'waste_b3_keluar';

    /**
     * Kolom yang bisa diisi mass assignment.
     * ✅ UPDATED: Added 'berita_acara' to fillable
     */
    protected $fillable = [
        'waste_b3_masuk_id',
        'tanggal_keluar',
        'jumlah_keluar_ton',
        'tujuan_penyerahan',
        'nomor_dokumen_keluar',
        'berita_acara',
        'catatan',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     * ✅ UPDATED: Changed decimal:2 to decimal:3 for consistency
     */
    protected $casts = [
        'tanggal_keluar' => 'date:Y-m-d',
        'jumlah_keluar_ton' => 'decimal:3',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi: Referensi ke data limbah masuk.
     */
    public function limbahMasuk(): BelongsTo
    {
        return $this->belongsTo(WasteB3Masuk::class, 'waste_b3_masuk_id');
    }

    /**
     * Accessor: Format tanggal keluar yang user-friendly.
     */
    public function getTanggalKeluarFormattedAttribute(): string
    {
        return $this->tanggal_keluar ? $this->tanggal_keluar->format('d/m/Y') : '-';
    }

    /**
     * Accessor: Format jumlah keluar dengan satuan (3 desimal).
     */
    public function getJumlahKeluarTonFormattedAttribute(): string
    {
        // Parameter ke-2 pada number_format diubah dari 2 menjadi 3
        return number_format($this->jumlah_keluar_ton, 3, ',', '.') . ' ton';
    }

    /**
     * Accessor: Format tujuan penyerahan dengan huruf kapital.
     */
    public function getTujuanPenyerahanFormattedAttribute(): string
    {
        return ucwords(strtolower($this->tujuan_penyerahan));
    }

    // ========================================
    // ✅ NEW: Accessors for Berita Acara File
    // ========================================

    /**
     * Accessor: URL lengkap untuk file berita acara.
     */
    public function getBeritaAcaraUrlAttribute(): ?string
    {
        if (empty($this->berita_acara)) {
            return null;
        }

        // Jika sudah URL lengkap, return langsung
        if (filter_var($this->berita_acara, FILTER_VALIDATE_URL)) {
            return $this->berita_acara;
        }

        // Jika path relatif, tambahkan storage path
        // Asumsi file disimpan di: storage/app/public/waste-b3/berita-acara-keluar/
        return Storage::url('waste-b3/berita-acara-keluar/' . $this->berita_acara);
    }

    /**
     * Accessor: Cek apakah file berita acara ada di storage.
     */
    public function getBeritaAcaraExistsAttribute(): bool
    {
        if (empty($this->berita_acara)) {
            return false;
        }

        // Cek di storage
        $path = 'public/waste-b3/berita-acara-keluar/' . $this->berita_acara;
        return Storage::exists($path);
    }

    /**
     * Accessor: Badge HTML untuk status file berita acara.
     */
    public function getBeritaAcaraStatusBadgeAttribute(): string
    {
        if (empty($this->berita_acara)) {
            return '<span class="badge badge-sm bg-gradient-secondary">Belum Upload</span>';
        }

        if ($this->berita_acara_exists) {
            $ext = pathinfo($this->berita_acara, PATHINFO_EXTENSION);
            $icon = $ext === 'pdf' ? 'fa-file-pdf' : 'fa-file-image';
            return "<span class=\"badge badge-sm bg-gradient-success\"><i class=\"fas {$icon}\"></i> Tersedia</span>";
        }

        return '<span class="badge badge-sm bg-gradient-danger"><i class="fas fa-times"></i> File Hilang</span>';
    }

    /**
     * Accessor: Icon class untuk file berita acara (untuk tombol/link).
     */
    public function getBeritaAcaraIconAttribute(): string
    {
        if (empty($this->berita_acara)) {
            return 'fa-file';
        }
        
        $ext = pathinfo($this->berita_acara, PATHINFO_EXTENSION);
        return match($ext) {
            'pdf' => 'fa-file-pdf',
            'jpg', 'jpeg', 'png' => 'fa-file-image',
            default => 'fa-file',
        };
    }

    /**
     * Scope untuk filter berdasarkan tanggal keluar.
     */
    public function scopeTanggalKeluar($query, string $tanggal)
    {
        return $query->whereDate('tanggal_keluar', $tanggal);
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal keluar.
     */
    public function scopeTanggalKeluarAntara($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal_keluar', [$dari, $sampai]);
    }

    /**
     * Scope untuk filter berdasarkan waste_b3_masuk_id.
     */
    public function scopeLimbahMasuk($query, int $id)
    {
        return $query->where('waste_b3_masuk_id', $id);
    }

    /**
     * Scope untuk filter berdasarkan tujuan penyerahan.
     */
    public function scopeTujuanPenyerahan($query, string $tujuan)
    {
        return $query->where('tujuan_penyerahan', 'like', "%{$tujuan}%");
    }

    /**
     * Scope untuk filter berdasarkan nomor dokumen.
     */
    public function scopeNomorDokumen($query, string $nomor)
    {
        return $query->where('nomor_dokumen_keluar', 'like', "%{$nomor}%");
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Validasi: Cek apakah jumlah keluar melebihi sisa limbah
        static::creating(function ($model) {
            $limbahMasuk = $model->limbahMasuk;
            
            if ($limbahMasuk) {
                $sisaLimbah = $limbahMasuk->sisa_limbah;
                
                if ($model->jumlah_keluar_ton > $sisaLimbah) {
                    throw new \InvalidArgumentException(
                        "Jumlah keluar ({$model->jumlah_keluar_ton} ton) melebihi sisa limbah ({$sisaLimbah} ton)"
                    );
                }
            }
        });

        // Update jumlah_tersisa_ton di limbah masuk setelah pengeluaran disimpan
        static::created(function ($model) {
            $limbahMasuk = $model->limbahMasuk;
            
            if ($limbahMasuk) {
                $limbahMasuk->update([
                    'jumlah_tersisa_ton' => $limbahMasuk->jumlah_tersisa_ton - $model->jumlah_keluar_ton
                ]);
            }
        });

        // Restore jumlah_tersisa_ton di limbah masuk saat pengeluaran di-soft delete
        static::deleted(function ($model) {
            if ($model->isForceDeleting()) {
                return;
            }

            $limbahMasuk = $model->limbahMasuk;
            
            if ($limbahMasuk) {
                $limbahMasuk->update([
                    'jumlah_tersisa_ton' => $limbahMasuk->jumlah_tersisa_ton + $model->jumlah_keluar_ton
                ]);
            }
        });

        // Restore jumlah_tersisa_ton saat restore dari soft delete
        static::restored(function ($model) {
            $limbahMasuk = $model->limbahMasuk;
            
            if ($limbahMasuk) {
                $limbahMasuk->update([
                    'jumlah_tersisa_ton' => $limbahMasuk->jumlah_tersisa_ton - $model->jumlah_keluar_ton
                ]);
            }
        });
    }
}