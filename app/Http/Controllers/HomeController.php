<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentContract;
use App\Models\WorkHours;
use App\Models\Equipment;
use App\Models\WasteWatermanagement;
use App\Models\BukaanLahan;
use App\Models\Reklamasi;
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
        $waterData = \App\Models\WasteWatermanagement::orderBy('tanggal_sampling', 'asc')->get();

        $labelsPh = $waterData->pluck('tanggal_sampling')->map(function ($item) {
            return \Carbon\Carbon::parse($item)->format('d M');
        })->values();

        $dataPh = $waterData->pluck('ph')->toArray(); // Pastikan nama kolom di DB sesuai
        $lokasiPh = $waterData->pluck('lokasi_sampling')->toArray();

        $labelstss = $waterData->pluck('tanggal_sampling')->map(function ($item) {
            return \Carbon\Carbon::parse($item)->format('d M');
        })->values();
        $dataTss = $waterData->pluck('tss')->toArray(); // Pastikan nama kolom di DB sesuai
        $lokasiTss = $waterData->pluck('lokasi_sampling')->toArray();


        $bukaanlahan = \App\Models\BukaanLahan::all();
        $bukaanlahanData = BukaanLahan::orderBy('tanggal_bukaan', 'asc')->get();
        $labelsbukaanlahan = $bukaanlahanData->pluck('tanggal_bukaan')->map(function ($item) {
            return \Carbon\Carbon::parse($item)->format('d M');
        })->values();
        $luasbukaanlahan = $bukaanlahanData->pluck('luas_dibuka')->toArray();


        $reklamasi = \App\Models\Reklamasi::all();
        $reklamasiData = Reklamasi::orderBy('tanggal_reklamasi', 'asc')->get();
        $labelsReklamasi = $reklamasiData->pluck('tanggal_reklamasi')->map(function ($item) {
            return \Carbon\Carbon::parse($item)->format('d M');
        })->values();

        $luasReklamasi = $reklamasiData->pluck('luas_direklamasi')->toArray();

        return view('dashboard', compact('documentContracts', 'statuscount', 'kodealat', 'jamkerja', 'labels', 'chartData', 'reklamasi', 'labelsReklamasi', 'luasReklamasi', 'labelsPh', 'dataPh', 'lokasiPh', 'bukaanlahan', 'labelsbukaanlahan', 'luasbukaanlahan', 'labelstss', 'dataTss', 'lokasiTss'));
    }

    public function getChartData(Request $request)
    {
        $query = Reklamasi::query();

        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }
        
        if ($request->lokasi) {
            $query->where('lokasi', $request->lokasi);
        }

        $data = $query->orderBy('tanggal', 'asc')->get();

        return response()->json([
            'labels' => $data->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M Y')),
            'values' => $data->pluck('luas_tanah') // Pastikan nama kolom di DB adalah luas_tanah
        ]);
    }
}