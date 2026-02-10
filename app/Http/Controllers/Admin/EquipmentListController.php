<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Exports\AlatExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentListController extends Controller
{
    /**
     * Tampilkan daftar Alat dengan fitur pencarian berdasarkan jenis
     */
    public function index(Request $request)
    {
        $searchJenis = $request->query('jenis', '');
        
        $query = Equipment::query();
        
        // Filter berdasarkan jenis alat (case-insensitive partial match)
        if ($searchJenis) {
            $query->where('jenis', 'like', '%' . $searchJenis . '%');
        }
        
        $equipment = $query->latest()->get();
        $totalEquipment = Equipment::count(); // Total semua equipment
        $filteredCount = $equipment->count(); // Jumlah yang difilter
        
        $jenisList = Equipment::select('jenis')
                        ->distinct()
                        ->orderBy('jenis')
                        ->pluck('jenis')
                        ->filter()
                        ->values();

        return view('equipment-list.index', compact(
            'equipment', 
            'searchJenis', 
            'jenisList',
            'totalEquipment',
            'filteredCount'
        ));
    }

    /**
     * Tampilkan form tambah alat
     */
    public function create()
    {
        return view('equipment-list.create');
    }

    /**
     * Simpan data alat (equipment)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'             => 'required|string|max:255',
            'kode'             => 'required|string|max:100|unique:equipments',
            'jenis'            => 'required|string|max:100',
            'merk'             => 'nullable|string|max:100',
            'tahun'            => 'nullable|integer|min:1900|max:' . date('Y'),
            'no_polisi'        => 'nullable|string|max:50',
            'no_mesin'         => 'nullable|string|max:100',
            'status'           => 'nullable|string|max:50',
            'lokasi_sekarang'  => 'nullable|string|max:255',
            'catatan'          => 'nullable|string',
        ]);

        // =============================
        // SIMPAN DATABASE
        // =============================
        Equipment::create([
            'nama'            => $request->nama,
            'kode'            => $request->kode,
            'jenis'           => $request->jenis,
            'merk'            => $request->merk,
            'tahun'           => $request->tahun,
            'no_polisi'       => strtoupper($request->no_polisi),
            'no_mesin'        => $request->no_mesin,
            'status'          => $request->status,
            'lokasi_sekarang' => $request->lokasi_sekarang,
            'catatan'         => $request->catatan,
        ]);

        return redirect()
            ->route('admin.equipment-list')
            ->with('success', 'Data alat berhasil disimpan.');
    }

    /**
     * Tampilkan form edit alat
     */
    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);

        return view('equipment-list.edit', compact('equipment'));
    }

    /**
     * Perbarui data alat
     */
    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $request->validate([
            'nama'             => 'required|string|max:255',
            'kode'             => 'required|string|max:100|unique:equipments,kode,' . $id,
            'jenis'            => 'required|string|max:100',
            'merk'             => 'nullable|string|max:100',
            'tahun'            => 'nullable|integer|min:1900|max:' . date('Y'),
            'no_polisi'        => 'nullable|string|max:50',
            'no_mesin'         => 'nullable|string|max:100',
            'status'           => 'nullable|string|max:50',
            'lokasi_sekarang'  => 'nullable|string|max:255',
            'catatan'          => 'nullable|string',
        ]);

        // =============================
        // UPDATE DATABASE
        // =============================
        $equipment->update([
            'nama'            => $request->nama,
            'kode'            => $request->kode,
            'jenis'           => $request->jenis,
            'merk'            => $request->merk,
            'tahun'           => $request->tahun,
            'no_polisi'       => strtoupper($request->no_polisi),
            'no_mesin'        => $request->no_mesin,
            'status'          => $request->status,
            'lokasi_sekarang' => $request->lokasi_sekarang,
            'catatan'         => $request->catatan,
        ]);

        return redirect()
            ->route('admin.equipment-list')
            ->with('success', 'Data alat berhasil diperbarui.');
    }

    /**
     * Hapus data alat
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()
            ->route('admin.equipment-list')
            ->with('success', 'Data alat berhasil dihapus.');
    }

    // Export data alat
    public function export()
    {
        return (new AlatExport())->download('alat_export.xlsx');
    }

}