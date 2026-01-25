<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentContract;
use App\Models\WorkHours;
use App\Models\Equipment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PDF;

class HomeController extends Controller
{
    public function home()
    {
        return redirect('dashboard');
    }

    public function index()
    {
        $documentContracts = DocumentContract::all();

        $statuscount = [
            'aktif' => DocumentContract::where('status', 'aktif')->count(),
            'selesai' => DocumentContract::where('status', 'selesai')->count(),
            'batal' => DocumentContract::where('status', 'batal')->count(),
        ];

        

        $kodealat = \App\Models\Equipment::pluck('kode', 'id')->toArray();

        $labels = \App\Models\WorkHours::orderBy('tanggal')
                ->pluck('tanggal')
                ->unique()
                ->map(function ($item) {
                    return $item->format('d M');
                })->values();

        $jamkerja = \App\Models\WorkHours::all();

        $chartData = [];
        foreach ($kodealat as $id => $kode) {
            $chartData[$kode] = \App\Models\WorkHours::where('alat_id', $id)
                ->orderBy('tanggal', 'asc')
                ->pluck('total_jam')
                ->toArray();
        }

        return view('dashboard', compact('documentContracts', 'statuscount', 'kodealat', 'jamkerja', 'labels', 'chartData'));
    }
}
