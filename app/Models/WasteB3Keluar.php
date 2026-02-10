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
     */
    protected $fillable = [
        'waste_b3_masuk_id',
        'tanggal_keluar',
        'jumlah_keluar_ton',
        'tujuan_penyerahan',
        'nomor_dokumen_keluar',
        'file_dokumen',
        'catatan',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal_keluar' => 'date:Y-m-d',
        'jumlah_keluar_ton' => 'decimal:2',
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
     * Accessor: Format jumlah keluar dengan satuan.
     */
    public function getJumlahKeluarTonFormattedAttribute(): string
    {
        return number_format($this->jumlah_keluar_ton, 2, ',', '.') . ' ton';
    }

    /**
     * Accessor: Format tujuan penyerahan dengan huruf kapital.
     */
    public function getTujuanPenyerahanFormattedAttribute(): string
    {
        return ucwords(strtolower($this->tujuan_penyerahan));
    }

    /**
     * Accessor: URL lengkap untuk file dokumen.
     */
    public function getFileDokumenUrlAttribute(): ?string
    {
        if (empty($this->file_dokumen)) {
            return null;
        }

        // Jika sudah URL lengkap, return langsung
        if (filter_var($this->file_dokumen, FILTER_VALIDATE_URL)) {
            return $this->file_dokumen;
        }

        // Jika path relatif, tambahkan storage path
        return asset('storage/' . $this->file_dokumen);
    }

    /**
     * Accessor: Cek apakah file dokumen ada.
     */
    public function getFileDokumenExistsAttribute(): bool
    {
        if (empty($this->file_dokumen)) {
            return false;
        }

        // Cek di storage
        return Storage::disk('public')->exists($this->file_dokumen);
    }

    /**
     * Accessor: Icon untuk status file dokumen.
     */
    public function getFileDokumenStatusAttribute(): string
    {
        if (empty($this->file_dokumen)) {
            return '<span class="badge badge-sm bg-gradient-secondary">Belum Upload</span>';
        }

        if ($this->file_dokumen_exists) {
            return '<span class="badge badge-sm bg-gradient-success"><i class="fas fa-check"></i> Tersedia</span>';
        }

        return '<span class="badge badge-sm bg-gradient-danger"><i class="fas fa-times"></i> File Hilang</span>';
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