<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentContract;
use App\Models\workhours;
use App\Models\Equipment;
use App\Models\WasteWaterManagement;
use App\Models\Reklamasi;
use App\Models\BukaanLahan;
use App\Models\Revegetasi;
use App\Models\Nursery;
use App\Models\RencanaRevegetasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $documentContracts = DocumentContract::all();

        $statuscount = [
            'open' => DocumentContract::where('status', 'open')->count(),
            'close' => DocumentContract::where('status', 'close')->count(),
            'pending' => DocumentContract::where('status', 'pending')->count(),
            'proses finance' => DocumentContract::where('status', 'proses finance')->count(),
            'hold' => DocumentContract::where('status', 'hold')->count(),
        ];

        $kodealat = Equipment::pluck('kode', 'id')->toArray();

        // Data Work Hours (Grafik Existing)
        $ritaseLabels = workhours::orderBy('tanggal')
                ->pluck('tanggal')
                ->unique()
                ->map(function ($item) {
                    return Carbon::parse($item)->format('d M');
                })->values();

        $chartData = [];
        foreach ($kodealat as $id => $kode) {
            $chartData[$kode] = WorkHours::where('alat_id', $id)
                ->orderBy('tanggal', 'asc')
                ->pluck('total_jam')
                ->toArray();
        }

        // 1. Ambil data 6 bulan terakhir
        $lastSixMonths = collect();
        for ($i = 11; $i >= 0; $i--) {
            $lastSixMonths->push(now()->subMonths($i)->format('Y-m'));
        }

        // 2. Query Luas Bukaan Lahan per Bulan
        $bukaanData = BukaanLahan::selectRaw("DATE_FORMAT(tanggal_bukaan, '%Y-%m') as bulan, SUM(luas_dibuka) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // 3. Query Luas Reklamasi per Bulan
        $reklamasiData = Reklamasi::selectRaw("DATE_FORMAT(tanggal_reklamasi, '%Y-%m') as bulan, SUM(luas_direklamasi) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // 4. Mapping data agar sesuai dengan urutan bulan (mengisi 0 jika data kosong)
        $reklamasiLabels = $lastSixMonths->map(fn($m) => Carbon::parse($m)->format('M Y'));
        $finalBukaanValues = $lastSixMonths->map(fn($m) => $bukaanData->get($m, 0));
        $finalReklamasiValues = $lastSixMonths->map(fn($m) => $reklamasiData->get($m, 0));

        // --- TAMBAHAN UNTUK WASTE WATER (pH AIR) ---
        $wasteWaterRaw = WasteWaterManagement::orderBy('tanggal_sampling', 'asc')->get();

        $phLabels = $wasteWaterRaw->map(function($item) {
            return Carbon::parse($item->tanggal_sampling)->format('d/m');
        });

        $phValues = $wasteWaterRaw->pluck('ph');
        
        // Ambil nilai ambang batas (Misal dari config atau hardcode sesuai standar lingkungan)
        $bmAtas = 9.0; 
        $bmBawah = 6.0;

        // Di dalam public function index() HomeController
        $wasteWaterRaw = WasteWaterManagement::orderBy('tanggal_sampling', 'asc')->get();

        $tssLabels = $wasteWaterRaw->map(function($item) {
            return Carbon::parse($item->tanggal_sampling)->format('d/m');
        });

        $tssValues = $wasteWaterRaw->pluck('tss'); // Mengambil kolom tss
        $bmTss = 200; // Baku Mutu TSS adalah 200 mg/L

        // Mengambil data jumlah tanaman dikelompokkan berdasarkan lokasi
        $dataRevegetasi = Revegetasi::select('lokasi_revegetasi')
            ->selectRaw('SUM(jumlah_tanaman) as total_pohon')
            ->groupBy('lokasi_revegetasi')
            ->get();

        $revegetasiLabels = $dataRevegetasi->pluck('lokasi_revegetasi'); // Sumbu X
        $revegetasiValues = $dataRevegetasi->pluck('total_pohon');      // Sumbu Y

        // Ambil data Nursery
        $nurseryData = Nursery::selectRaw('jenis_tanaman, SUM(jumlah_bibit) as total_bibit')
            ->groupBy('jenis_tanaman')
            ->get();

        $nurseryLabels = $nurseryData->pluck('jenis_tanaman')->toArray();
        $nurseryValues = $nurseryData->pluck('total_bibit')->toArray();

        $currentYear = date('Y');

        // ========================================
        // PERBAIKAN: DATA RENCANA & REALISASI REVEGETASI
        // ========================================
        
        // 1. Definisikan urutan bulan yang konsisten
        $bulanUrutan = [
            'januari', 'februari', 'maret', 'april', 'mei', 'juni',
            'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
        ];

        // 2. Ambil data rencana tahunan (dengan lokasi) - AGREGASI SEMUA LOKASI
        $rencanaLokasi = RencanaRevegetasi::tahun($currentYear)
            ->denganLokasi()
            ->get();

        // 3. Agregasi data rencana dari semua lokasi
        if ($rencanaLokasi->isNotEmpty()) {
            $totalBulan = array_fill(0, 12, 0);

            foreach ($rencanaLokasi as $r) {
                foreach ($bulanUrutan as $index => $bulan) {
                    $totalBulan[$index] += (int) ($r->{$bulan} ?? 0);
                }
            }
            
            $dataChartRencana = $totalBulan;
        } else {
            // Jika tidak ada data lokasi, coba ambil rencana nasional (lokasi = NULL)
            $rencanaNasional = RencanaRevegetasi::tahun($currentYear)
                ->tanpaLokasi()
                ->first();

            if ($rencanaNasional) {
                $dataChartRencana = [];
                foreach ($bulanUrutan as $bulan) {
                    $dataChartRencana[] = (int) $rencanaNasional->{$bulan};
                }
            } else {
                $dataChartRencana = array_fill(0, 12, 0);
            }
        }

        // 4. Ambil data realisasi bulanan
        $realisasiBulanan = Revegetasi::selectRaw('MONTH(tanggal_monitoring) as bulan, SUM(jumlah_tanaman) as total')
            ->whereYear('tanggal_monitoring', $currentYear)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // 5. Siapkan data realisasi dengan urutan bulan yang pasti
        $dataChartRealisasi = [];
        for ($m = 1; $m <= 12; $m++) {
            $dataChartRealisasi[] = $realisasiBulanan[$m] ?? 0;
        }

        // 6. Siapkan label bulan untuk chart
        $monthsFull = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        // ========================================
        // END: PERBAIKAN DATA REVEGETASI
        // ========================================

        // === GRAFIK: RATA-RATA PERTUMBUHAN PER TRIWULAN + RATA-RATA TAHUNAN ===
        $currentYear = date('Y');

        // Ambil data monitoring vegetasi untuk tahun ini (hanya data aktif)
        $monitoringTahunan = \App\Models\MonitoringVegetasi::selectRaw('
            AVG(tinggi_triwulan1) as avg_tw1,
            AVG(tinggi_triwulan2) as avg_tw2,
            AVG(tinggi_triwulan3) as avg_tw3,
            AVG(tinggi_triwulan4) as avg_tw4,
            COUNT(*) as total_data
        ')
        ->where('tahun', $currentYear)
        ->whereNull('deleted_at') // Hanya data aktif (belum dihapus)
        ->first();


        // Ambil rata-rata per triwulan (default 0 jika null)
        $avgTw1 = $monitoringTahunan ? round($monitoringTahunan->avg_tw1 ?? 0, 2) : 0;
        $avgTw2 = $monitoringTahunan ? round($monitoringTahunan->avg_tw2 ?? 0, 2) : 0;
        $avgTw3 = $monitoringTahunan ? round($monitoringTahunan->avg_tw3 ?? 0, 2) : 0;
        $avgTw4 = $monitoringTahunan ? round($monitoringTahunan->avg_tw4 ?? 0, 2) : 0;

        // Hitung rata-rata tahunan (rata-rata dari 4 triwulan yang valid)
        $valuesArray = [$avgTw1, $avgTw2, $avgTw3, $avgTw4];
        $validValues = array_filter($valuesArray, fn($v) => $v !== null && $v > 0);

        if (count($validValues) > 0) {
            $avgTahunan = round(array_sum($validValues) / count($validValues), 2);
        } else {
            $avgTahunan = 0;
        }

        // Data untuk chart: [TW1, TW2, TW3, TW4, Rata-rata Tahun]
        $values = [$avgTw1, $avgTw2, $avgTw3, $avgTw4, $avgTahunan];

        // Label untuk chart
        $growthLabels = ["TW1", "TW2", "TW3", "TW4", "Rata-rata Tahunan"];

        // Warna untuk setiap bar
        $growthColors = [
            '#3498db', // TW1 - Biru
            '#2ecc71', // TW2 - Hijau
            '#f39c12', // TW3 - Orange
            '#e74c3c', // TW4 - Merah
            '#9b59b6'  // Rata-rata - Ungu
        ];

        return view('dashboard', compact(
            'documentContracts', 
            'statuscount', 
            'kodealat', 
            'ritaseLabels', 
            'chartData',
            'reklamasiLabels',
            'finalBukaanValues',
            'finalReklamasiValues',
            'phLabels', 
            'phValues', 
            'bmAtas',   
            'bmBawah',
            'tssLabels', 
            'tssValues', 
            'bmTss',
            'revegetasiLabels',
            'revegetasiValues',
            'nurseryLabels',
            'nurseryValues',
            'monthsFull',
            'dataChartRencana',
            'dataChartRealisasi',
            'values',
            'growthLabels',
            'currentYear'   
        ));
    }
}