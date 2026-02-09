<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RencanaRevegetasi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'rencana_revegetasi';

    /**
     * Atribut yang dapat diisi massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun',
        'januari',
        'februari',
        'maret',
        'april',
        'mei',
        'juni',
        'juli',
        'agustus',
        'september',
        'oktober',
        'november',
        'desember',
        'lokasi',
    ];

    /**
     * Casting tipe data untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun' => 'integer',
        'januari' => 'integer',
        'februari' => 'integer',
        'maret' => 'integer',
        'april' => 'integer',
        'mei' => 'integer',
        'juni' => 'integer',
        'juli' => 'integer',
        'agustus' => 'integer',
        'september' => 'integer',
        'oktober' => 'integer',
        'november' => 'integer',
        'desember' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Accessor untuk mendapatkan total target tahunan.
     *
     * @return int
     */
    public function getTotalTargetAttribute(): int
    {
        return $this->januari + $this->februari + $this->maret + 
               $this->april + $this->mei + $this->juni + 
               $this->juli + $this->agustus + $this->september + 
               $this->oktober + $this->november + $this->desember;
    }

    /**
     * Accessor untuk mendapatkan target bulanan dalam bentuk array.
     *
     * @return array
     */
    public function getTargetBulananAttribute(): array
    {
        return [
            'januari' => $this->januari,
            'februari' => $this->februari,
            'maret' => $this->maret,
            'april' => $this->april,
            'mei' => $this->mei,
            'juni' => $this->juni,
            'juli' => $this->juli,
            'agustus' => $this->agustus,
            'september' => $this->september,
            'oktober' => $this->oktober,
            'november' => $this->november,
            'desember' => $this->desember,
        ];
    }

    /**
     * Accessor untuk mendapatkan nama bulan dalam bahasa Indonesia.
     *
     * @return array
     */
    public static function getDaftarBulan(): array
    {
        return [
            'januari' => 'Januari',
            'februari' => 'Februari',
            'maret' => 'Maret',
            'april' => 'April',
            'mei' => 'Mei',
            'juni' => 'Juni',
            'juli' => 'Juli',
            'agustus' => 'Agustus',
            'september' => 'September',
            'oktober' => 'Oktober',
            'november' => 'November',
            'desember' => 'Desember',
        ];
    }

    /**
     * Scope untuk query berdasarkan tahun tertentu.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTahun($query, $year)
    {
        return $query->where('tahun', $year);
    }

    /**
     * Scope untuk query yang memiliki lokasi.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDenganLokasi($query)
    {
        return $query->whereNotNull('lokasi');
    }

    /**
     * Scope untuk query tanpa lokasi.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTanpaLokasi($query)
    {
        return $query->whereNull('lokasi');
    }

    /**
     * Mendapatkan target untuk bulan tertentu.
     *
     * @param string $bulan
     * @return int|null
     */
    public function getTargetBulan(string $bulan): ?int
    {
        $bulan = strtolower($bulan);
        $daftarBulan = array_keys(self::getDaftarBulan());
        
        if (in_array($bulan, $daftarBulan)) {
            return $this->$bulan;
        }
        
        return null;
    }

    /**
     * Memperbarui target untuk bulan tertentu.
     *
     * @param string $bulan
     * @param int $nilai
     * @return bool
     */
    public function setTargetBulan(string $bulan, int $nilai): bool
    {
        $bulan = strtolower($bulan);
        $daftarBulan = array_keys(self::getDaftarBulan());
        
        if (in_array($bulan, $daftarBulan)) {
            $this->$bulan = $nilai;
            return $this->save();
        }
        
        return false;
    }

    /**
     * Mendapatkan rata-rata target per bulan.
     *
     * @return float
     */
    public function getRataRataBulananAttribute(): float
    {
        return $this->total_target / 12;
    }
}