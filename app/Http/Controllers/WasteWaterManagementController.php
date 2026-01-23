<?php

namespace App\Http\Controllers;

use App\Models\WasteWaterManagement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasteWaterManagementController extends Controller
{
    /**
     * Tampilkan daftar data pengelolaan air limbah
     */
    public function index()
    {
        $wasteWaterData = WasteWaterManagement::with('creator')
            ->latest()
            ->get();

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
        $request->validate([
            'tanggal_sampling'   => 'required|date',
            'lokasi_sampling'    => 'required|string|max:255',
            'ph'                 => 'nullable|numeric|min:0|max:14',
            'tss'                => 'nullable|numeric|min:0',
            'status_kesesuaian'  => 'required|in:memenuhi,tidak_memenuhi',
            'catatan'            => 'nullable|string',
        ]);

        WasteWaterManagement::create([
            'tanggal_sampling'   => $request->tanggal_sampling,
            'lokasi_sampling'    => $request->lokasi_sampling,
            'ph'                 => $request->ph,
            'tss'                => $request->tss,
            'status_kesesuaian'  => $request->status_kesesuaian,
            'catatan'            => $request->catatan,
            'created_by'         => Auth::id(), // Otomatis ambil user login
        ]);

        return redirect()
            ->route('waste-water-management')
            ->with('success', 'Data pengelolaan air limbah berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $data = WasteWaterManagement::findOrFail($id);
        return view('waste-water-management.edit', compact('data'));
    }

    /**
     * Perbarui data pengelolaan air limbah
     */
    public function update(Request $request, $id)
    {
        $data = WasteWaterManagement::findOrFail($id);

        $request->validate([
            'tanggal_sampling'   => 'required|date',
            'lokasi_sampling'    => 'required|string|max:255',
            'ph'                 => 'nullable|numeric|min:0|max:14',
            'tss'                => 'nullable|numeric|min:0',
            'status_kesesuaian'  => 'required|in:memenuhi,tidak_memenuhi',
            'catatan'            => 'nullable|string',
        ]);

        $data->update([
            'tanggal_sampling'   => $request->tanggal_sampling,
            'lokasi_sampling'    => $request->lokasi_sampling,
            'ph'                 => $request->ph,
            'tss'                => $request->tss,
            'status_kesesuaian'  => $request->status_kesesuaian,
            'catatan'            => $request->catatan,
            // created_by tidak diubah
        ]);

        return redirect()
            ->route('waste-water-management')
            ->with('success', 'Data pengelolaan air limbah berhasil diperbarui.');
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        $data = WasteWaterManagement::findOrFail($id);
        $data->delete(); // Soft delete karena menggunakan SoftDeletes

        return redirect()
            ->route('waste-water-management')
            ->with('success', 'Data pengelolaan air limbah berhasil dihapus.');
    }
}