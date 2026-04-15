<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WasteB3Masuk extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'waste_b3_masuk';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'jenis_limbah',
        'kode_limbah',
        'tanggal_masuk',
        'sumber_limbah',
        'jumlah_ton',
        'jumlah_tersisa_ton',
        'maksimal_penyimpanan',
        'status',
        'jumlah_tersisa_ton',
        'nomor_manifest',
        'catatan',
        'created_by',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal_masuk' => 'date:Y-m-d',
        'maksimal_penyimpanan' => 'date:Y-m-d',
        'jumlah_ton' => 'decimal:2',
        'jumlah_tersisa_ton' => 'decimal:2',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Opsi nilai untuk enum status
     * Digunakan untuk tracking status limbah
     */
    public const STATUS_OPTIONS = [
        'belum_dikeluarkan' => 'Belum Dikeluarkan',
        'sebagian_dikeluarkan' => 'Sebagian Dikeluarkan',
        'sudah_dikeluarkan' => 'Sudah Dikeluarkan',
        'kadaluarsa' => 'Kadaluarsa',
    ];

    /**
     * Relasi: Data dimasukkan oleh User.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi: Riwayat pengeluaran limbah.
     */
    public function pengeluaran(): HasMany
    {
        return $this->hasMany(WasteB3Keluar::class, 'waste_b3_masuk_id');
    }

    /**
     * Accessor: Total jumlah yang sudah dikeluarkan.
     */
    public function getJumlahDikeluarkanAttribute(): float
    {
        return $this->pengeluaran()->sum('jumlah_keluar_ton');
    }

    /**
     * Accessor: Sisa limbah yang belum dikeluarkan.
     */
    public function getSisaLimbahAttribute(): float
    {
        return $this->jumlah_ton - $this->jumlah_dikeluarkan;
    }

    /**
     * Accessor: Label status yang mudah dibaca.
     */
    public function getStatusLabelAttribute(): string
    {
        if (empty($this->status)) {
            return '-';
        }
        
        return self::STATUS_OPTIONS[$this->status] ?? $this->status;
    }

    /**
     * Accessor: Format tanggal masuk yang user-friendly.
     */
    public function getTanggalMasukFormattedAttribute(): string
    {
        return $this->tanggal_masuk ? $this->tanggal_masuk->format('d/m/Y') : '-';
    }

    /**
     * Accessor: Format maksimal penyimpanan yang user-friendly.
     */
    public function getMaksimalPenyimpananFormattedAttribute(): string
    {
        return $this->maksimal_penyimpanan ? $this->maksimal_penyimpanan->format('d/m/Y') : '-';
    }

    /**
     * Accessor: Format jumlah ton dengan satuan.
     */
    public function getJumlahTonFormattedAttribute(): string
    {
        return number_format($this->jumlah_ton, 2, ',', '.') . ' ton';
    }

    /**
     * Accessor: Format sisa limbah dengan satuan.
     */
    public function getSisaLimbahFormattedAttribute(): string
    {
        return number_format($this->sisa_limbah, 2, ',', '.') . ' ton';
    }

    /**
     * Accessor: Warna badge untuk status (untuk frontend).
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'belum_dikeluarkan' => 'info',
            'sebagian_dikeluarkan' => 'warning',
            'sudah_dikeluarkan' => 'success',
            'kadaluarsa' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Accessor: Cek apakah limbah sudah kadaluarsa.
     */
    public function getIsKadaluarsaAttribute(): bool
    {
        if (!$this->maksimal_penyimpanan) {
            return false;
        }
        
        return now()->gt($this->maksimal_penyimpanan) && 
               $this->sisa_limbah > 0;
    }

    /**
     * Accessor: Cek apakah bisa dikeluarkan (masih ada stok).
     */
    public function getCanBeDikeluarkanAttribute(): bool
    {
        return $this->sisa_limbah > 0 && 
               $this->status !== 'sudah_dikeluarkan';
    }

    /**
     * Accessor: Hitung sisa waktu batas penyimpanan dalam format terstruktur.
     * 
     * @return array{
     *     tahun: int,
     *     bulan: int,
     *     hari: int,
     *     total_hari: int|null,
     *     is_expired: bool,
     *     label: string,
     *     badge_color: string,
     *     icon: string,
     *     raw_date: string
     * }
     */
    public function getSisaWaktuAttribute(): array
    {
        $batas = $this->maksimal_penyimpanan ? \Carbon\Carbon::parse($this->maksimal_penyimpanan) : null;
        
        if (!$batas) {
            return [
                'tahun' => 0,
                'bulan' => 0,
                'hari' => 0,
                'total_hari' => null,
                'is_expired' => false,
                'label' => 'Tidak ada batas',
                'badge_color' => 'secondary',
                'icon' => 'fa-circle-question',
                'raw_date' => '-'
            ];
        }

        $now = \Carbon\Carbon::now();
        $isExpired = $batas->lessThan($now);
        $diff = $now->diff($batas);
        $totalHari = $now->diffInDays($batas, false);
        
        // FIX: Gunakan format yang benar
        if ($isExpired) {
            $years = $diff->y;
            $months = $diff->m;
            $days = $diff->d;
            $label = 'Terlambat ';
            if ($years > 0) $label .= "{$years} thn ";
            if ($months > 0) $label .= "{$months} bln ";
            $label .= "{$days} hr";
            
            $badgeColor = 'danger';
            $icon = 'fa-skull-crossbones';
        } elseif ($totalHari == 0) {
            $label = 'Hari ini!';
            $badgeColor = 'warning';
            $icon = 'fa-bell';
        } elseif ($totalHari <= 3) {
            $label = 'Sangat Mendesak';
            $badgeColor = 'warning';
            $icon = 'fa-exclamation-triangle';
        } elseif ($totalHari <= 7) {
            $label = 'Mendesak';
            $badgeColor = 'info';
            $icon = 'fa-hourglass-half';
        } elseif ($totalHari <= 30) {
            $label = "{$diff->d} hari lagi";
            $badgeColor = 'success';
            $icon = 'fa-clock';
        } elseif ($totalHari <= 365) {
            $label = "{$diff->m} bulan, {$diff->d} hari";
            $badgeColor = 'success';
            $icon = 'fa-calendar-days';
        } else {
            $label = "{$diff->y} thn, {$diff->m} bln, {$diff->d} hr";
            $badgeColor = 'primary';
            $icon = 'fa-calendar-check';
        }

        return [
            'tahun' => $diff->y,
            'bulan' => $diff->m,
            'hari' => $diff->d,
            'total_hari' => $totalHari,
            'is_expired' => $isExpired,
            'label' => $label,
            'badge_color' => $badgeColor,
            'icon' => $icon,
            'raw_date' => $batas->format('d M Y')
        ];
    }

    /**
     * Scope untuk filter berdasarkan jenis limbah.
     */
    public function scopeJenisLimbah($query, string $jenis)
    {
        return $query->where('jenis_limbah', $jenis);
    }

    /**
     * Scope untuk filter berdasarkan sumber limbah.
     */
    public function scopeSumberLimbah($query, string $sumber)
    {
        return $query->where('sumber_limbah', $sumber);
    }

    /**
     * Scope untuk filter berdasarkan status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal masuk.
     */
    public function scopeTanggalMasukAntara($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal_masuk', [$dari, $sampai]);
    }

    /**
     * Scope untuk filter berdasarkan kode limbah.
     */
    public function scopeKodeLimbah($query, string $kode)
    {
        return $query->where('kode_limbah', 'like', "%{$kode}%");
    }

    /**
     * Scope untuk filter limbah yang belum dikeluarkan.
     */
    public function scopeBelumDikeluarkan($query)
    {
        return $query->where('status', 'belum_dikeluarkan');
    }

    /**
     * Scope untuk filter limbah yang masih ada stoknya.
     */
    public function scopeMasihAdaStok($query)
    {
        return $query->where('jumlah_tersisa_ton', '>', 0);
    }

    /**
     * Scope untuk filter limbah yang kadaluarsa.
     */
    public function scopeKadaluarsa($query)
    {
        return $query->where('maksimal_penyimpanan', '<', now())
                     ->where('jumlah_tersisa_ton', '>', 0);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Set jumlah_tersisa_ton = jumlah_ton saat pertama kali dibuat
        static::creating(function ($model) {
            if (empty($model->jumlah_tersisa_ton)) {
                $model->jumlah_tersisa_ton = $model->jumlah_ton;
            }
            
            // Set status default jika belum di-set
            if (empty($model->status)) {
                $model->status = 'belum_dikeluarkan';
            }
        });

        // Update status otomatis saat jumlah_tersisa_ton berubah
        static::saving(function ($model) {
            if ($model->isDirty('jumlah_tersisa_ton')) {
                if ($model->jumlah_tersisa_ton <= 0) {
                    $model->status = 'sudah_dikeluarkan';
                } elseif ($model->jumlah_tersisa_ton < $model->jumlah_ton) {
                    $model->status = 'sebagian_dikeluarkan';
                }
            }
        });

        // Update status menjadi kadaluarsa jika melewati batas
        static::saving(function ($model) {
            if ($model->maksimal_penyimpanan && 
                now()->gt($model->maksimal_penyimpanan) && 
                $model->jumlah_tersisa_ton > 0) {
                $model->status = 'kadaluarsa';
            }
        });
    }
}