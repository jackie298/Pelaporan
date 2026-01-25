<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentContract;
use App\Models\WorkHours;
use App\Models\Equipment;
use App\Models\WasteWaterManagement; // Tambahkan ini
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
        $labels = WorkHours::orderBy('tanggal')
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