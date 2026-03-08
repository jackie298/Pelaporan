<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Exports\AlatExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EquipmentListController extends Controller
{
    /**
     * Tampilkan daftar equipment dengan fitur filter & pagination
     */
    public function index(Request $request)
    {
        // ✅ Stats dihitung dari query TERPISAH (tanpa filter)
        $equipmentModel = new \App\Models\Equipment();
        
        $summaryStats = [
            'total' => $equipmentModel::count(),
            'tersedia' => $equipmentModel::where('status', 'tersedia')->count(),
            'dipakai' => $equipmentModel::where('status', 'dipakai')->count(),
            'maintenance' => $equipmentModel::whereIn('status', ['perawatan', 'rusak'])->count(),
        ];

        // ✅ Filter untuk table display
        $searchFilter = $request->get('search');
        $jenisFilter = $request->get('jenis');
        $statusFilter = $request->get('status');

        $query = $equipmentModel::query();

        if ($searchFilter) {
            $query->where(function($q) use ($searchFilter) {
                $q->where('nama', 'like', "%{$searchFilter}%")
                ->orWhere('kode', 'like', "%{$searchFilter}%")
                ->orWhere('merk', 'like', "%{$searchFilter}%");
            });
        }
        if ($jenisFilter) {
            $query->where('jenis', 'like', "%{$jenisFilter}%");
        }
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $equipment = $query->latest()->paginate(15);

        // ✅ Options untuk dropdown
        $statusOptions = $equipmentModel::STATUS_OPTIONS ?? [
            'tersedia' => 'Tersedia',
            'dipakai' => 'Dipakai', 
            'perawatan' => 'Perawatan',
            'rusak' => 'Rusak',
            'tidak_aktif' => 'Tidak Aktif',
        ];

        $jenisList = $equipmentModel::select('jenis')
                        ->distinct()
                        ->whereNotNull('jenis')
                        ->where('jenis', '!=', '')
                        ->orderBy('jenis')
                        ->pluck('jenis');

        return view('equipment-list.index', compact(
            'equipment',
            'summaryStats', 
            'statusOptions',
            'jenisList',
            'searchFilter',
            'jenisFilter', 
            'statusFilter'
        ));
    }

    /**
     * Tampilkan form tambah equipment
     */
    public function create()
    {
        $statusOptions = Equipment::STATUS_OPTIONS ?? [
            'tersedia' => 'Tersedia',
            'dipakai' => 'Dipakai',
            'perawatan' => 'Perawatan',
            'rusak' => 'Rusak',
            'tidak_aktif' => 'Tidak Aktif',
        ];

        return view('equipment-list.create', compact('statusOptions'));
    }

    /**
     * Simpan data equipment baru
     */
    public function store(Request $request)
    {
        // Uppercase fields yang perlu distandarisasi
        if ($request->has('kode')) {
            $request->merge(['kode' => strtoupper(trim($request->kode))]);
        }
        if ($request->has('no_polisi')) {
            $request->merge(['no_polisi' => strtoupper(trim($request->no_polisi))]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:100|unique:equipments,kode',
            'jenis' => 'required|string|max:100',
            'merk' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:1900|max:' . date('Y'),
            'no_polisi' => 'nullable|string|max:50',
            'no_mesin' => 'nullable|string|max:100',
            'status' => ['nullable', Rule::in(array_keys(Equipment::STATUS_OPTIONS ?? []))],
            'lokasi_sekarang' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:500',
        ], [
            // Custom error messages
            'nama.required' => 'Nama equipment harus diisi',
            'nama.max' => 'Nama equipment maksimal 255 karakter',
            'kode.required' => 'Kode equipment harus diisi',
            'kode.unique' => 'Kode equipment sudah terdaftar di sistem',
            'kode.max' => 'Kode equipment maksimal 100 karakter',
            'jenis.required' => 'Jenis equipment harus diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun minimal 1900',
            'tahun.max' => 'Tahun tidak boleh melebihi tahun sekarang',
            'no_polisi.max' => 'Nomor polisi maksimal 50 karakter',
            'no_mesin.max' => 'Nomor mesin maksimal 100 karakter',
            'lokasi_sekarang.max' => 'Lokasi maksimal 255 karakter',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        // Cek duplikasi kode (case-insensitive)
        $isDuplicate = Equipment::whereRaw('LOWER(kode) = ?', [strtolower($validated['kode'])])->exists();
        if ($isDuplicate) {
            return back()
                ->withErrors(['kode' => 'Kode equipment ' . $validated['kode'] . ' sudah terdaftar di sistem.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated) {
            Equipment::create($validated);
        });

        return redirect()
            ->route('admin.equipment-list')
            ->with('success', 'Data equipment berhasil disimpan.');
    }

    /**
     * Tampilkan form edit equipment
     */
    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $statusOptions = Equipment::STATUS_OPTIONS ?? [
            'tersedia' => 'Tersedia',
            'dipakai' => 'Dipakai',
            'perawatan' => 'Perawatan',
            'rusak' => 'Rusak',
            'tidak_aktif' => 'Tidak Aktif',
        ];

        return view('equipment-list.edit', compact('equipment', 'statusOptions'));
    }

    /**
     * Update data equipment
     */
    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        // Uppercase fields yang perlu distandarisasi
        if ($request->has('kode')) {
            $request->merge(['kode' => strtoupper(trim($request->kode))]);
        }
        if ($request->has('no_polisi')) {
            $request->merge(['no_polisi' => strtoupper(trim($request->no_polisi))]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => ['required', 'string', 'max:100', Rule::unique('equipments', 'kode')->ignore($id)],
            'jenis' => 'required|string|max:100',
            'merk' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:1900|max:' . date('Y'),
            'no_polisi' => 'nullable|string|max:50',
            'no_mesin' => 'nullable|string|max:100',
            'status' => ['nullable', Rule::in(array_keys(Equipment::STATUS_OPTIONS ?? []))],
            'lokasi_sekarang' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:500',
        ], [
            'nama.required' => 'Nama equipment harus diisi',
            'nama.max' => 'Nama equipment maksimal 255 karakter',
            'kode.required' => 'Kode equipment harus diisi',
            'kode.unique' => 'Kode equipment sudah digunakan oleh data lain',
            'kode.max' => 'Kode equipment maksimal 100 karakter',
            'jenis.required' => 'Jenis equipment harus diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun minimal 1900',
            'tahun.max' => 'Tahun tidak boleh melebihi tahun sekarang',
            'no_polisi.max' => 'Nomor polisi maksimal 50 karakter',
            'no_mesin.max' => 'Nomor mesin maksimal 100 karakter',
            'lokasi_sekarang.max' => 'Lokasi maksimal 255 karakter',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        // Cek duplikasi kode (case-insensitive) kecuali milik record ini
        $isDuplicate = Equipment::whereRaw('LOWER(kode) = ?', [strtolower($validated['kode'])])
                                ->where('id', '!=', $id)
                                ->exists();
        if ($isDuplicate) {
            return back()
                ->withErrors(['kode' => 'Kode equipment ' . $validated['kode'] . ' sudah digunakan oleh data lain.'])
                ->withInput();
        }

        DB::transaction(function () use ($equipment, $validated) {
            $equipment->update($validated);
        });

        return redirect()
            ->route('admin.equipment-list')
            ->with('success', 'Data equipment berhasil diperbarui.');
    }

    /**
     * Hapus data equipment
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);

        // Validasi: Cek apakah equipment sedang dipakai atau memiliki relasi terkait
        // Contoh: jika ada model Usage/Log yang merujuk ke equipment ini
        // if ($equipment->usages()->count() > 0) {
        //     return redirect()
        //         ->route('admin.equipment-list')
        //         ->with('error', 'Equipment tidak dapat dihapus karena memiliki riwayat penggunaan.');
        // }

        DB::transaction(function () use ($equipment) {
            $equipment->delete();
        });

        return redirect()
            ->route('admin.equipment-list')
            ->with('success', 'Data equipment berhasil dihapus.');
    }

    /**
     * Export data equipment ke Excel
     */
    public function export()
    {
        return (new AlatExport())->download('equipment_export_' . date('Ymd') . '.xlsx');
    }
}