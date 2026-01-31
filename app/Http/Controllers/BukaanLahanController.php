<?php

namespace App\Http\Controllers;

use App\Models\BukaanLahan;
use App\Exports\BukaanLahanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukaanLahanController extends Controller
{
    /**
     * Tampilkan daftar data bukaan lahan
     */
    public function index()
    {
        $bukaanLahanData = BukaanLahan::with('creator')
            ->latest()
            ->get();

        return view('bukaan-lahan.index', compact('bukaanLahanData'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        return view('bukaan-lahan.create');
    }

    /**
     * Simpan data bukaan lahan
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_bukaan' => 'required|date',
            'lokasi_bukaan' => 'required|string|max:255',
            'luas_dibuka' => 'required|numeric|min:0',
            'jenis_vegetasi_awal' => 'required|string|max:255',
            'metode_pembukaan' => 'required|string|max:255',
            'alat_berat_digunakan' => 'nullable|string',
            'izin_lingkungan' => 'nullable|string|max:255',
            'status_kesesuaian' => 'required|in:sesuai,tidak_sesuai',
        ]);

        BukaanLahan::create([
            'tanggal_bukaan' => $request->tanggal_bukaan,
            'lokasi_bukaan' => $request->lokasi_bukaan,
            'luas_dibuka' => $request->luas_dibuka,
            'jenis_vegetasi_awal' => $request->jenis_vegetasi_awal,
            'metode_pembukaan' => $request->metode_pembukaan,
            'alat_berat_digunakan' => $request->alat_berat_digunakan,
            'izin_lingkungan' => $request->izin_lingkungan,
            'status_kesesuaian' => $request->status_kesesuaian,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('bukaan-lahan')
            ->with('success', 'Data bukaan lahan berhasil disimpan.');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $data = BukaanLahan::findOrFail($id);
        return view('bukaan-lahan.edit', compact('data'));
    }

    /**
     * Perbarui data
     */
    public function update(Request $request, $id)
    {
        $data = BukaanLahan::findOrFail($id);

        $request->validate([
            'tanggal_bukaan' => 'required|date',
            'lokasi_bukaan' => 'required|string|max:255',
            'luas_dibuka' => 'required|numeric|min:0',
            'jenis_vegetasi_awal' => 'required|string|max:255',
            'metode_pembukaan' => 'required|string|max:255',
            'alat_berat_digunakan' => 'nullable|string',
            'izin_lingkungan' => 'nullable|string|max:255',
            'status_kesesuaian' => 'required|in:sesuai,tidak_sesuai',
        ]);

        $data->update([
            'tanggal_bukaan' => $request->tanggal_bukaan,
            'lokasi_bukaan' => $request->lokasi_bukaan,
            'luas_dibuka' => $request->luas_dibuka,
            'jenis_vegetasi_awal' => $request->jenis_vegetasi_awal,
            'metode_pembukaan' => $request->metode_pembukaan,
            'alat_berat_digunakan' => $request->alat_berat_digunakan,
            'izin_lingkungan' => $request->izin_lingkungan,
            'status_kesesuaian' => $request->status_kesesuaian,
        ]);

        return redirect()
            ->route('bukaan-lahan')
            ->with('success', 'Data bukaan lahan berhasil diperbarui.');
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        $data = BukaanLahan::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('bukaan-lahan')
            ->with('success', 'Data bukaan lahan berhasil dihapus.');
    }

    // Export data bukaan lahan
    public function export()
    {
        return (new BukaanLahanExport())->download('bukaan_lahan_export.xlsx');
    }
}