<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardReportService
{
    public function getData(string $start, string $end): array
    {
        // Query data reklamasi berdasarkan periode
        $query = DB::table('reklamasi')
            ->whereNull('deleted_at')
            ->whereBetween('tanggal_reklamasi', [$start, $end]);

        // Statistik utama
        $total = (clone $query)->count();

        $selesai = (clone $query)
            ->where('status_kesesuaian', 'sesuai')
            ->count();

        $proses = (clone $query)
            ->where('status_kesesuaian', 'tidak_sesuai')
            ->count();

        $rataRata = (clone $query)
            ->avg('luas_direklamasi');

        // Grafik reklamasi per bulan
        $monthlyData = (clone $query)
            ->selectRaw("
                YEAR(tanggal_reklamasi) as tahun,
                MONTH(tanggal_reklamasi) as bulan,
                COUNT(*) as total
            ")
            ->groupByRaw("
                YEAR(tanggal_reklamasi),
                MONTH(tanggal_reklamasi)
            ")
            ->orderByRaw("
                YEAR(tanggal_reklamasi),
                MONTH(tanggal_reklamasi)
            ")
            ->get();

        $labels = [];
        $values = [];

        foreach ($monthlyData as $item) {
            $labels[] = sprintf(
                '%02d/%d',
                $item->bulan,
                $item->tahun
            );

            $values[] = (int) $item->total;
        }

        return [
            'start' => $start,
            'end' => $end,
            'total' => $total,
            'selesai' => $selesai,
            'proses' => $proses,
            'rata_rata' => round((float) $rataRata, 2),
            'labels' => $labels,
            'values' => $values,
        ];
    }
}