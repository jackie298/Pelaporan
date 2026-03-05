<?php

namespace App\Http\Controllers;

use App\Models\WasteWaterManagement;
use App\Exports\WasteWaterExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WasteWaterManagementController extends Controller
{
    /**
     * Tampilkan daftar data pengelolaan air limbah
     */
   public function index(Request $request)
    {
        $query = WasteWaterManagement::with('creator');

        // Filter Lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi_sampling', $request->lokasi);
        }

        // Filter Sampler (Inlet/Outlet)
        if ($request->filled('sampler')) {
            $query->where('sampler', $request->sampler);
        }

        // Filter Rentang Tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_sampling', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_sampling', '<=', $request->tanggal_sampai);
        }

        $wasteWaterData = $query->latest('tanggal_sampling')
                                ->paginate(10)
                                ->withQueryString(); // Menjaga filter tetap ada saat pindah halaman pagination

        return view('waste-water-management.index', compact('wasteWaterData'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        return view('waste-water-management.create');
    }

    /**
     * Simpan data pengelolaan air limbah
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_sampling'   => 'required|date|before_or_equal:today',
            'lokasi_sampling'    => 'required|in:Settling Pond Rey Nabila,Settling Pond Jetty Lama',
            'sampler'            => 'required|in:inlet,outlet',
            'cuaca'              => 'nullable|string|max:100',
            'ph'                 => 'nullable|numeric|min:0|max:14',
            'tss'                => 'nullable|numeric|min:0',
            'debit_air'          => 'nullable|numeric|min:0',
            'status_kesesuaian'  => 'required|in:memenuhi,tidak_memenuhi',
            'catatan'            => 'nullable|string|max:500',
        ], [
            'tanggal_sampling.required' => 'Tanggal sampling wajib diisi.',
            'tanggal_sampling.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
            'lokasi_sampling.required'  => 'Lokasi sampling wajib dipilih.',
            'sampler.required'          => 'Titik sampler (Inlet/Outlet) wajib dipilih.',
            'ph.numeric'                => 'Nilai pH harus berupa angka.',
            'ph.max'                    => 'Nilai pH tidak boleh lebih dari 14.',
            'tss.numeric'               => 'Nilai TSS harus berupa angka.',
            'debit_air.numeric'         => 'Nilai debit air harus berupa angka.',
            'status_kesesuaian.required' => 'Status kesesuaian wajib ditentukan.',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $validated['created_by'] = Auth::id();
                WasteWaterManagement::create($validated);
            });

            return redirect()
                ->route('waste-water-management')
                ->with('success', 'Data pemantauan air limbah berhasil disimpan.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $wasteWater = WasteWaterManagement::findOrFail($id);
        return view('waste-water-management.edit', compact('wasteWater'));
    }

    /**
     * Perbarui data pengelolaan air limbah
     */
    public function update(Request $request, $id)
    {
        $wasteWater = WasteWaterManagement::findOrFail($id);

        $validated = $request->validate([
            'tanggal_sampling'   => 'required|date|before_or_equal:today',
            'lokasi_sampling'    => 'required|in:Settling Pond Rey Nabila,Settling Pond Jetty Lama',
            'sampler'            => 'required|in:inlet,outlet',
            'cuaca'              => 'nullable|string|max:100',
            'ph'                 => 'nullable|numeric|min:0|max:14',
            'tss'                => 'nullable|numeric|min:0',
            'debit_air'          => 'nullable|numeric|min:0',
            'status_kesesuaian'  => 'required|in:memenuhi,tidak_memenuhi',
            'catatan'            => 'nullable|string|max:500',
        ], [
            'lokasi_sampling.required'  => 'Lokasi sampling wajib dipilih.',
            'sampler.required'          => 'Titik sampler (Inlet/Outlet) wajib dipilih.',
            'status_kesesuaian.required' => 'Status kesesuaian wajib ditentukan.',
        ]);

        try {
            DB::transaction(function () use ($wasteWater, $validated) {
                $wasteWater->update($validated);
            });

            return redirect()
                ->route('waste-water-management')
                ->with('success', 'Data pemantauan air limbah berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        try {
            $data = WasteWaterManagement::findOrFail($id);
            $data->delete();

            return redirect()
                ->route('waste-water-management')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Export data ke Excel
     */
    public function export()
    {
        try {
            return (new WasteWaterExport())->download('laporan_pemantauan_air_limbah.xlsx');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data.');
        }
    }
}