<?php

namespace App\Http\Controllers;

use App\Models\MonitoringVegetasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\MonitoringVegetasiExport;

class MonitoringVegetasiController extends Controller
{
    /**
     * Tampilkan daftar monitoring vegetasi
     */
    public function index()
    {
        $monitoringData = MonitoringVegetasi::with('creator')
            ->latest()
            ->get();

        return view('monitoring-vegetasi.index', compact('monitoringData'));
    }

    /**
     * Tampilkan form tambah monitoring
     */
    public function create()
    {
        return view('monitoring-vegetasi.create');
    }

    /**
     * Simpan data monitoring baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
            'titik_pantau' => 'required|string|max:255',
            'jenis_tanaman' => 'required|string|max:255',
            'tinggi_triwulan1' => 'nullable|numeric|min:0',
            'tinggi_triwulan2' => 'nullable|numeric|min:0',
            'tinggi_triwulan3' => 'nullable|numeric|min:0',
            'tinggi_triwulan4' => 'nullable|numeric|min:0',
            'tahun' => 'required|integer|min:2020|max:2099',
            'catatan' => 'nullable|string',
        ]);

        MonitoringVegetasi::create([
            'lokasi' => $request->lokasi,
            'titik_pantau' => $request->titik_pantau,
            'jenis_tanaman' => $request->jenis_tanaman,
            'tinggi_triwulan1' => $request->tinggi_triwulan1,
            'tinggi_triwulan2' => $request->tinggi_triwulan2,
            'tinggi_triwulan3' => $request->tinggi_triwulan3,
            'tinggi_triwulan4' => $request->tinggi_triwulan4,
            'tahun' => $request->tahun,
            'catatan' => $request->catatan,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('monitoring-vegetasi')
            ->with('success', 'Data monitoring vegetasi berhasil disimpan.');
    }

    /**
     * Tampilkan form edit monitoring
     */
    public function edit($id)
    {
        $data = MonitoringVegetasi::findOrFail($id);
        return view('monitoring-vegetasi.edit', compact('data'));
    }

    /**
     * Perbarui data monitoring
     */
    public function update(Request $request, $id)
    {
        $data = MonitoringVegetasi::findOrFail($id);

        $request->validate([
            'lokasi' => 'required|string|max:255',
            'titik_pantau' => 'required|string|max:255',
            'jenis_tanaman' => 'required|string|max:255',
            'tinggi_triwulan1' => 'nullable|numeric|min:0',
            'tinggi_triwulan2' => 'nullable|numeric|min:0',
            'tinggi_triwulan3' => 'nullable|numeric|min:0',
            'tinggi_triwulan4' => 'nullable|numeric|min:0',
            'tahun' => 'required|integer|min:2020|max:2099',
            'catatan' => 'nullable|string',
        ]);

        $data->update([
            'lokasi' => $request->lokasi,
            'titik_pantau' => $request->titik_pantau,
            'jenis_tanaman' => $request->jenis_tanaman,
            'tinggi_triwulan1' => $request->tinggi_triwulan1,
            'tinggi_triwulan2' => $request->tinggi_triwulan2,
            'tinggi_triwulan3' => $request->tinggi_triwulan3,
            'tinggi_triwulan4' => $request->tinggi_triwulan4,
            'tahun' => $request->tahun,
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('monitoring-vegetasi')
            ->with('success', 'Data monitoring vegetasi berhasil diperbarui.');
    }

    /**
     * Hapus data monitoring (soft delete)
     */
    public function destroy($id)
    {
        $data = MonitoringVegetasi::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('monitoring-vegetasi')
            ->with('success', 'Data monitoring vegetasi berhasil dihapus.');
    }

    public function export()
    {
        return (new MonitoringVegetasiExport())->download('monitoring_vegetasi_export.xlsx');
    }
}