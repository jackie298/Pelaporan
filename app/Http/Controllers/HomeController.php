<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentContract;
use App\Models\workhours;
use App\Models\Equipment;
use App\Models\WasteWaterManagement;
use App\Models\Reklamasi;
use App\Models\BukaanLahan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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
        $labels = workhours::orderBy('tanggal')
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
        for ($i = 5; $i >= 0; $i--) {
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

        return view('dashboard', compact(
            'documentContracts', 
            'statuscount', 
            'kodealat', 
            'labels', 
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
            'bmTss'   
        ));
    }
}