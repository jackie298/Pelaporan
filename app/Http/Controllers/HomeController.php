<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapAnggaran;
use App\Models\WorkHours;
use App\Models\Equipment;
use App\Models\WasteWaterManagement;
use App\Models\Reklamasi;
use App\Models\BukaanLahan;
use App\Models\Revegetasi;
use App\Models\Nursery;
use App\Models\RencanaRevegetasi;
use App\Models\Compliance;
use App\Models\WasteB3Masuk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // --- START REKAP ANGGARAN ---

        $rekap_anggaran = RekapAnggaran::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->latest()
            ->paginate(5);

        // 1. Hitung total anggaran bulan ini saja (untuk card informasi)
        $totalAnggaranBulanIni = RekapAnggaran::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('harga');

        // 2. Hitung statistik status untuk Grafik Lingkar (Pie Chart)
        $counts = RekapAnggaran::selectRaw('LOWER(status) as status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Merge dengan default values (Agar chart tidak error jika ada status yang kosong)
        $statuscount = array_merge([
            'open' => 0,
            'close' => 0,
            'pending' => 0,
            'proses finance' => 0,
            'hold' => 0,
        ], $counts); // <-- Pastikan di sini tetap menggunakan $counts, bukan $totalAnggaranBulanIni

        // --- END REKAP ANGGARAN ---

        // Data untuk Logbook Limbah B3 di Dashboard
        $wasteB3Preview = WasteB3Masuk::query()
            ->with(['pengeluaran']) // pastikan nama relasi sesuai model Anda
            ->orderByRaw("
                CASE 
                    WHEN status IN ('belum_dikeluarkan', 'sebagian_dikeluarkan') AND maksimal_penyimpanan >= NOW() THEN 0
                    WHEN status IN ('belum_dikeluarkan', 'sebagian_dikeluarkan') AND maksimal_penyimpanan < NOW() THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('maksimal_penyimpanan', 'asc')
            ->paginate(5); // ✅ Ganti limit(5)->get() dengan paginate(5)

        // Stats dengan breakdown urgency (TETAP PAKAI count/sum, tidak terpengaruh pagination)
        $summaryStats = [
            'total' => WasteB3Masuk::count(),
            'belum_dikeluarkan' => WasteB3Masuk::whereIn('status', ['belum_dikeluarkan', 'sebagian_dikeluarkan'])->count(),
            'kadaluarsa' => WasteB3Masuk::where('maksimal_penyimpanan', '<', now())->count(),
            'total_ton' => WasteB3Masuk::sum('jumlah_ton'),
            'urgensi_tinggi' => WasteB3Masuk::whereIn('status', ['belum_dikeluarkan', 'sebagian_dikeluarkan'])
                ->whereBetween('maksimal_penyimpanan', [now(), now()->addDays(3)])->count(),
            'urgensi_sedang' => WasteB3Masuk::whereIn('status', ['belum_dikeluarkan', 'sebagian_dikeluarkan'])
                ->whereBetween('maksimal_penyimpanan', [now()->addDays(4), now()->addDays(14)])->count(),
        ];
        // END LIMBAH B3 KELUAR

        // --- START COMPLIANCE (DIPERBAIKI DENGAN PAGINATION) ---
        $compliances = Compliance::latest()->paginate(5);

        // Statistik Compliance (Tetap menggunakan query terpisah agar tidak terpengaruh limit pagination)
        $complianceStats = Compliance::selectRaw('LOWER(Status) as status, count(*) as total')
            ->groupBy('Status')
            ->pluck('total', 'status')
            ->toArray();

        $complianceCounts = array_merge([
            'open' => 0, 'pending' => 0, 'resolved' => 0, 'escalated' => 0,
        ], $complianceStats);

        // Statistik Keparahan
        $severityStats = Compliance::selectRaw('LOWER(Tingkat_keparahan) as tingkat, count(*) as total')
            ->groupBy('Tingkat_keparahan')
            ->pluck('total', 'tingkat')
            ->toArray();
        // --- END COMPLIANCE ---

        // --- START PERBAIKAN PENGELOMPOKAN ALAT ---
        $allEquipments = Equipment::all();

        $ritaseLabels = WorkHours::orderBy('tanggal')
            ->pluck('tanggal')
            ->unique()
            ->map(function ($item) {
                return \Carbon\Carbon::parse($item)->format('d M');
            })->values();

        $grupExca = $allEquipments->filter(function ($item) {
            $kode = strtoupper($item->kode);
            return str_contains($kode, 'EXC') && !str_contains($kode, 'LA') && !str_contains($kode, 'BR');
        });

        $grupPendukung = $allEquipments->filter(function ($item) {
            $kode = strtoupper($item->kode);
            return str_contains($kode, 'LA') || str_contains($kode, 'BR') || str_contains($kode, 'BD');
        });

        $grupDT = $allEquipments->filter(function ($item) {
            return str_contains(strtoupper($item->kode), 'DT');
        });

        $getChartData = function($collection) {
            $data = [];
            foreach ($collection as $item) {
                $data[$item->kode] = WorkHours::where('alat_id', $item->id)
                    ->orderBy('tanggal', 'asc')
                    ->pluck('total_jam')
                    ->toArray();
            }
            return $data;
        };

        $chartDataExca = $getChartData($grupExca);
        $chartDataPendukung = $getChartData($grupPendukung);
        $chartDataDT = $getChartData($grupDT);
        // --- END PERBAIKAN PENGELOMPOKAN ALAT ---

        // --- BUKAAN LAHAN & REKLAMASI ---
        $lastSixMonths = collect();
        for ($i = 11; $i >= 0; $i--) {
            $lastSixMonths->push(now()->subMonths($i)->format('Y-m'));
        }

        $bukaanData = BukaanLahan::selectRaw("DATE_FORMAT(tanggal_bukaan, '%Y-%m') as bulan, SUM(luas_dibuka) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $reklamasiData = Reklamasi::selectRaw("DATE_FORMAT(tanggal_reklamasi, '%Y-%m') as bulan, SUM(luas_direklamasi) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $reklamasiLabels = $lastSixMonths->map(fn($m) => Carbon::parse($m)->format('M Y'));
        $finalBukaanValues = $lastSixMonths->map(fn($m) => $bukaanData->get($m, 0));
        $finalReklamasiValues = $lastSixMonths->map(fn($m) => $reklamasiData->get($m, 0));

        // --- WASTE WATER ---
        $tujuhHariLalu = Carbon::now()->subDays(7);

        // Filter data mentah hanya yang >= 7 hari lalu
        $wasteWaterRaw = WasteWaterManagement::where('tanggal_sampling', '>=', $tujuhHariLalu)
            ->orderBy('tanggal_sampling', 'asc')
            ->get();

        // Kelompokkan data yang SUDAH difilter untuk keperluan looping chart
        $wasteWaterGroups = $wasteWaterRaw->groupBy(['lokasi_sampling', 'sampler']);

        $phLabels = $wasteWaterRaw->map(function($item) {
            return Carbon::parse($item->tanggal_sampling)->format('d/m');
        });
        $phValues = $wasteWaterRaw->pluck('ph');
        $bmAtas = 9.0; 
        $bmBawah = 6.0;

        $tssLabels = $wasteWaterRaw->map(function($item) {
            return Carbon::parse($item->tanggal_sampling)->format('d/m');
        });
        $tssValues = $wasteWaterRaw->pluck('tss');
        $bmTss = 75;

        // --- REVEGETASI & NURSERY ---
        $dataRevegetasi = Revegetasi::select('lokasi_revegetasi')
            ->selectRaw('SUM(jumlah_tanaman) as total_pohon')
            ->groupBy('lokasi_revegetasi')
            ->get();

        $revegetasiLabels = $dataRevegetasi->pluck('lokasi_revegetasi');
        $revegetasiValues = $dataRevegetasi->pluck('total_pohon');

        $nurseryData = Nursery::selectRaw('jenis_tanaman, SUM(jumlah_bibit) as total_bibit')
            ->groupBy('jenis_tanaman')
            ->get();

        $nurseryLabels = $nurseryData->pluck('jenis_tanaman')->toArray();
        $nurseryValues = $nurseryData->pluck('total_bibit')->toArray();

        $currentYear = date('Y');

        // --- RENCANA & REALISASI ---
        $bulanUrutan = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

        $rencanaLokasi = RencanaRevegetasi::tahun($currentYear)->denganLokasi()->get();

        if ($rencanaLokasi->isNotEmpty()) {
            $totalBulan = array_fill(0, 12, 0);
            foreach ($rencanaLokasi as $r) {
                foreach ($bulanUrutan as $index => $bulan) {
                    $totalBulan[$index] += (int) ($r->{$bulan} ?? 0);
                }
            }
            $dataChartRencana = $totalBulan;
        } else {
            $rencanaNasional = RencanaRevegetasi::tahun($currentYear)->tanpaLokasi()->first();
            if ($rencanaNasional) {
                $dataChartRencana = [];
                foreach ($bulanUrutan as $bulan) {
                    $dataChartRencana[] = (int) $rencanaNasional->{$bulan};
                }
            } else {
                $dataChartRencana = array_fill(0, 12, 0);
            }
        }

        $realisasiBulanan = Revegetasi::selectRaw('MONTH(tanggal_monitoring) as bulan, SUM(jumlah_tanaman) as total')
            ->whereYear('tanggal_monitoring', $currentYear)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $dataChartRealisasi = [];
        for ($m = 1; $m <= 12; $m++) {
            $dataChartRealisasi[] = $realisasiBulanan[$m] ?? 0;
        }
        $monthsFull = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        // --- PERTUMBUHAN TRIWULAN ---
        $monitoringTahunan = \App\Models\MonitoringVegetasi::selectRaw('
            AVG(tinggi_triwulan1) as avg_tw1,
            AVG(tinggi_triwulan2) as avg_tw2,
            AVG(tinggi_triwulan3) as avg_tw3,
            AVG(tinggi_triwulan4) as avg_tw4,
            COUNT(*) as total_data
        ')
        ->where('tahun', $currentYear)
        ->whereNull('deleted_at')
        ->first();

        $avgTw1 = $monitoringTahunan ? round($monitoringTahunan->avg_tw1 ?? 0, 2) : 0;
        $avgTw2 = $monitoringTahunan ? round($monitoringTahunan->avg_tw2 ?? 0, 2) : 0;
        $avgTw3 = $monitoringTahunan ? round($monitoringTahunan->avg_tw3 ?? 0, 2) : 0;
        $avgTw4 = $monitoringTahunan ? round($monitoringTahunan->avg_tw4 ?? 0, 2) : 0;

        $valuesArray = [$avgTw1, $avgTw2, $avgTw3, $avgTw4];
        $validValues = array_filter($valuesArray, fn($v) => $v !== null && $v > 0);
        $avgTahunan = count($validValues) > 0 ? round(array_sum($validValues) / count($validValues), 2) : 0;

        $values = [$avgTw1, $avgTw2, $avgTw3, $avgTw4, $avgTahunan];
        $growthLabels = ["TW1", "TW2", "TW3", "TW4", "Rata-rata Tahunan"];
        $growthColors = ['#3498db', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6'];

        // --- RETURN VIEW ---
        return view('dashboard', compact(
            'rekap_anggaran',
            'totalAnggaranBulanIni',
            'statuscount',
            'wasteB3Preview',
            'summaryStats',
            'compliances',       
            'complianceCounts',
            'severityStats',
            'ritaseLabels', 
            'grupExca', 
            'grupPendukung', 
            'grupDT',
            'chartDataExca',
            'chartDataPendukung',
            'chartDataDT', 
            'reklamasiLabels',
            'finalBukaanValues',
            'finalReklamasiValues',
            'wasteWaterGroups',
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