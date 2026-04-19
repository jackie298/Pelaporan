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
use App\Models\TrashManagement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // ========================================
        // 📊 REKAP ANGGARAN
        // ========================================
        $rekap_anggaran = RekapAnggaran::whereMonth('periode', Carbon::now()->month)
            ->whereYear('periode', Carbon::now()->year)
            ->latest()
            ->paginate(5);

        $totalAnggaranBulanIni = RekapAnggaran::whereMonth('periode', Carbon::now()->month)
            ->whereYear('periode', Carbon::now()->year)
            ->sum('harga');

        $counts = RekapAnggaran::selectRaw('LOWER(status) as status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statuscount = array_merge([
            'open' => 0, 'close' => 0, 'pending' => 0, 'proses finance' => 0, 'hold' => 0,
        ], $counts);

        // ========================================
        // 🗑️ LIMBAH B3 - DASHBOARD PREVIEW
        // ========================================
        $wasteB3Preview = WasteB3Masuk::query()
            ->with(['pengeluaran'])
            ->orderByRaw("
                CASE 
                    WHEN status IN ('belum_dikeluarkan', 'sebagian_dikeluarkan') AND maksimal_penyimpanan >= NOW() THEN 0
                    WHEN status IN ('belum_dikeluarkan', 'sebagian_dikeluarkan') AND maksimal_penyimpanan < NOW() THEN 1
                    ELSE 2 
                END
            ")
            ->orderBy('maksimal_penyimpanan', 'asc')
            ->paginate(5);

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

        // ========================================
        // ✅ COMPLIANCE - DASHBOARD PREVIEW
        // ========================================
        $compliances = Compliance::latest()->paginate(5);

        $complianceStats = Compliance::selectRaw('LOWER(Status) as status, count(*) as total')
            ->groupBy('Status')
            ->pluck('total', 'status')
            ->toArray();

        $complianceCounts = array_merge([
            'open' => 0, 'pending' => 0, 'resolved' => 0, 'escalated' => 0,
        ], $complianceStats);

        $severityStats = Compliance::selectRaw('LOWER(Tingkat_keparahan) as tingkat, count(*) as total')
            ->groupBy('Tingkat_keparahan')
            ->pluck('total', 'tingkat')
            ->toArray();

        // ========================================
        // 🔧 WORK HOURS & EQUIPMENT CHARTS
        // ========================================
        $allEquipments = Equipment::all();

        $ritaseLabels = WorkHours::orderBy('tanggal')
            ->pluck('tanggal')
            ->unique()
            ->map(fn($item) => Carbon::parse($item)->format('d M'))->values();

        $grupExca = $allEquipments->filter(fn($item) => 
            str_contains(strtoupper($item->kode), 'EXC') && 
            !str_contains(strtoupper($item->kode), 'LA') && 
            !str_contains(strtoupper($item->kode), 'BR')
        );

        $grupPendukung = $allEquipments->filter(fn($item) => 
            str_contains(strtoupper($item->kode), 'LA') || 
            str_contains(strtoupper($item->kode), 'BR') || 
            str_contains(strtoupper($item->kode), 'BD')
        );

        $grupDT = $allEquipments->filter(fn($item) => 
            str_contains(strtoupper($item->kode), 'DT')
        );

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

        // ========================================
        // 🌱 BUKAAN LAHAN & REKLAMASI
        // ========================================
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

        // ========================================
        // 💧 WASTE WATER MANAGEMENT
        // ========================================
        $tujuhHariLalu = Carbon::now()->subDays(7);

        $wasteWaterRaw = WasteWaterManagement::where('tanggal_sampling', '>=', $tujuhHariLalu)
            ->orderBy('tanggal_sampling', 'asc')
            ->get();

        $wasteWaterGroups = $wasteWaterRaw->groupBy(['lokasi_sampling', 'sampler']);

        $phLabels = $wasteWaterRaw->map(fn($item) => Carbon::parse($item->tanggal_sampling)->format('d/m'));
        $phValues = $wasteWaterRaw->pluck('ph');
        $bmAtas = 9.0;
        $bmBawah = 6.0;

        $tssLabels = $wasteWaterRaw->map(fn($item) => Carbon::parse($item->tanggal_sampling)->format('d/m'));
        $tssValues = $wasteWaterRaw->pluck('tss');
        $bmTss = 75;

        // ========================================
        // 🌿 REVEGETASI & NURSERY
        // ========================================
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

        // ========================================
        // 📈 RENCANA vs REALISASI
        // ========================================
        $bulanUrutan = ['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'];

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
        $monthsFull = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];

        // ========================================
        // 📊 PERTUMBUHAN TRIWULAN
        // ========================================
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
        $growthLabels = ["TW1","TW2","TW3","TW4","Rata-rata Tahunan"];

        // ========================================
        // 🗑️ WASTE MANAGEMENT - LENGKAP
        // ========================================

        // A. Stats Cards
        $wasteStats = [
            'total_hari_ini' => TrashManagement::whereDate('tanggal', now())
                ->sum(DB::raw('COALESCE(sampah_organik_terpilah,0) + COALESCE(sampah_anorganik_terpilah,0) + COALESCE(sampah_lainnya_dan_atau_residu,0)')),
            
            'total_bulan_ini' => TrashManagement::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum(DB::raw('COALESCE(sampah_organik_terpilah,0) + COALESCE(sampah_anorganik_terpilah,0) + COALESCE(sampah_lainnya_dan_atau_residu,0)')),
            
            'total_semua' => TrashManagement::sum(
                DB::raw('COALESCE(sampah_organik_terpilah,0) + COALESCE(sampah_anorganik_terpilah,0) + COALESCE(sampah_lainnya_dan_atau_residu,0)')
            ),
            
            'last_entry' => TrashManagement::withTrashed()
                ->latest('tanggal')->first(),
        ];

        // B. Pie Chart: Komposisi Jenis Sampah
        $wasteComposition = TrashManagement::selectRaw(
            'SUM(sampah_organik_terpilah) as organik, 
            SUM(sampah_anorganik_terpilah) as anorganik, 
            SUM(sampah_lainnya_dan_atau_residu) as residu'
        )->first();

        $wasteTypeLabels = ['Organik', 'Anorganik', 'Residu'];
        $wasteTypeValues = [
            $wasteComposition->organik ?? 0,
            $wasteComposition->anorganik ?? 0,
            $wasteComposition->residu ?? 0,
        ];
        $wasteTypeColors = ['#2dce89', '#1171ef', '#f5365c'];

        // C. Line Chart: Tren 30 Hari Terakhir
        $last30Days = collect();
        for ($i = 29; $i >= 0; $i--) {
            $last30Days->push(now()->subDays($i)->format('Y-m-d'));
        }

        $wasteTrendRaw = TrashManagement::selectRaw(
            "tanggal, 
            SUM(COALESCE(sampah_organik_terpilah,0) + COALESCE(sampah_anorganik_terpilah,0) + COALESCE(sampah_lainnya_dan_atau_residu,0)) as total"
        )
        ->whereBetween('tanggal', [now()->subDays(29), now()])
        ->groupBy('tanggal')
        ->pluck('total', 'tanggal');

        $wasteTrendLabels = $last30Days->map(fn($d) => Carbon::parse($d)->format('d/m'))->toArray();
        $wasteTrendValues = $last30Days->map(fn($d) => $wasteTrendRaw->get($d, 0))->toArray();

        // D. Bar Chart: Perbandingan Sumber Sampah
        $wasteBySource = TrashManagement::selectRaw(
            "sumber_sampah, 
            SUM(COALESCE(sampah_organik_terpilah,0) + COALESCE(sampah_anorganik_terpilah,0) + COALESCE(sampah_lainnya_dan_atau_residu,0)) as total"
        )
        ->groupBy('sumber_sampah')
        ->pluck('total', 'sumber_sampah');

        $wasteSourceLabels = collect(TrashManagement::SUMBER_SAMPAH_OPTIONS ?? ['area kantor', 'area site'])
            ->map(fn($label) => ucfirst(str_replace('area ', '', $label)))->values()->toArray();
            
        $wasteSourceValues = [
            $wasteBySource->get('area kantor', 0),
            $wasteBySource->get('area site', 0),
        ];
        $wasteSourceColors = ['#1171ef', '#fb6340'];

        // E. Recent Entries for Preview Table
        $wasteRecent = TrashManagement::latest('tanggal')->limit(5)->get();

        // F. 📊 Chart Bulanan: Area Kantor vs Site (Menggunakan $monthsFull yang sudah ada)
        // Data Area Kantor per bulan
        $wasteKantorBulanan = TrashManagement::selectRaw('MONTH(tanggal) as bulan, 
            SUM(COALESCE(sampah_organik_terpilah,0) + COALESCE(sampah_anorganik_terpilah,0) + COALESCE(sampah_lainnya_dan_atau_residu,0)) as total')
            ->whereYear('tanggal', $currentYear)
            ->whereRaw('LOWER(sumber_sampah) = ?', ['area kantor'])
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $wasteKantorValues = [];
        for($m = 1; $m <= 12; $m++) {
            $wasteKantorValues[] = $wasteKantorBulanan[$m] ?? 0;
        }

        // Data Area Site per bulan
        $wasteSiteBulanan = TrashManagement::selectRaw('MONTH(tanggal) as bulan, 
            SUM(COALESCE(sampah_organik_terpilah,0) + COALESCE(sampah_anorganik_terpilah,0) + COALESCE(sampah_lainnya_dan_atau_residu,0)) as total')
            ->whereYear('tanggal', $currentYear)
            ->whereRaw('LOWER(sumber_sampah) = ?', ['area site'])
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $wasteSiteValues = [];
        for($m = 1; $m <= 12; $m++) {
            $wasteSiteValues[] = $wasteSiteBulanan[$m] ?? 0;
        }

        // ========================================
        // 🎯 RETURN VIEW WITH ALL DATA
        // ========================================
        return view('dashboard', compact(
            // Rekap Anggaran
            'rekap_anggaran',
            'totalAnggaranBulanIni',
            'statuscount',
            
            // Waste B3
            'wasteB3Preview',
            'summaryStats',
            
            // Compliance
            'compliances',
            'complianceCounts',
            'severityStats',
            
            // Work Hours & Equipment
            'ritaseLabels',
            'grupExca',
            'grupPendukung',
            'grupDT',
            'chartDataExca',
            'chartDataPendukung',
            'chartDataDT',
            
            // Bukaan Lahan & Reklamasi
            'reklamasiLabels',
            'finalBukaanValues',
            'finalReklamasiValues',
            
            // Waste Water
            'wasteWaterGroups',
            'phLabels',
            'phValues',
            'bmAtas',
            'bmBawah',
            'tssLabels',
            'tssValues',
            'bmTss',
            
            // Revegetasi & Nursery
            'revegetasiLabels',
            'revegetasiValues',
            'nurseryLabels',
            'nurseryValues',
            'currentYear',
            
            // Rencana vs Realisasi
            'monthsFull',
            'dataChartRencana',
            'dataChartRealisasi',
            
            // Pertumbuhan Triwulan
            'values',
            'growthLabels',
            
            // 🗑️ Waste Management (NEW!)
            'wasteStats',
            'wasteTypeLabels',
            'wasteTypeValues',
            'wasteTypeColors',
            'wasteTrendLabels',
            'wasteTrendValues',
            'wasteSourceLabels',
            'wasteSourceValues',
            'wasteSourceColors',
            'wasteRecent',
            'wasteKantorValues',
            'wasteSiteValues',
            'monthsFull',
        ));
    }
}