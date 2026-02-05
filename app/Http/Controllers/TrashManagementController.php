<?php

namespace App\Http\Controllers;

use App\Models\TrashManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashManagementController extends Controller
{
    /**
     * Tampilkan daftar data pengelolaan sampah
     */
    public function index()
    {
        $trashData = TrashManagement::latest()->get();

        return view('trash-management.index', compact('trashData'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        $sumberOptions = TrashManagement::SUMBER_SAMPAH_OPTIONS;
        return view('trash-management.create', compact('sumberOptions'));
    }

    /**
     * Simpan data pengelolaan sampah
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'sumber_sampah' => 'required|in:area kantor,area site',
            'sampah_organik_terpilah' => 'nullable|integer|min:0',
            'sampah_anorganik_terpilah' => 'nullable|integer|min:0',
            'sampah_lainnya_dan_atau_residu' => 'nullable|integer|min:0',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh di masa depan',
            'sumber_sampah.required' => 'Sumber sampah harus dipilih',
            'sumber_sampah.in' => 'Sumber sampah tidak valid',
            'sampah_organik_terpilah.integer' => 'Sampah organik harus berupa angka',
            'sampah_organik_terpilah.min' => 'Sampah organik minimal 0',
            'sampah_anorganik_terpilah.integer' => 'Sampah anorganik harus berupa angka',
            'sampah_anorganik_terpilah.min' => 'Sampah anorganik minimal 0',
            'sampah_lainnya_dan_atau_residu.integer' => 'Sampah residu harus berupa angka',
            'sampah_lainnya_dan_atau_residu.min' => 'Sampah residu minimal 0',
        ]);

        // Pastikan minimal ada satu jenis sampah yang diisi
        if (empty($validated['sampah_organik_terpilah']) && 
            empty($validated['sampah_anorganik_terpilah']) && 
            empty($validated['sampah_lainnya_dan_atau_residu'])) {
            return back()
                ->withErrors(['total' => 'Minimal satu jenis sampah harus diisi'])
                ->withInput();
        }

        // Cek duplikasi data (tanggal + sumber sampah)
        $exists = TrashManagement::where('tanggal', $validated['tanggal'])
                                 ->where('sumber_sampah', $validated['sumber_sampah'])
                                 ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'tanggal' => 'Data untuk tanggal ini dengan sumber sampah yang sama sudah ada'
                ])
                ->withInput();
        }

        // Simpan data
        TrashManagement::create($validated);

        return redirect()
            ->route('trash-management')
            ->with('success', 'Data pengelolaan sampah berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $data = TrashManagement::findOrFail($id);
        $sumberOptions = TrashManagement::SUMBER_SAMPAH_OPTIONS;
        
        return view('trash-management.edit', compact('data', 'sumberOptions'));
    }

    /**
     * Perbarui data pengelolaan sampah
     */
    public function update(Request $request, $id)
    {
        $data = TrashManagement::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'sumber_sampah' => 'required|in:area kantor,area site',
            'sampah_organik_terpilah' => 'nullable|integer|min:0',
            'sampah_anorganik_terpilah' => 'nullable|integer|min:0',
            'sampah_lainnya_dan_atau_residu' => 'nullable|integer|min:0',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh di masa depan',
            'sumber_sampah.required' => 'Sumber sampah harus dipilih',
            'sumber_sampah.in' => 'Sumber sampah tidak valid',
            'sampah_organik_terpilah.integer' => 'Sampah organik harus berupa angka',
            'sampah_organik_terpilah.min' => 'Sampah organik minimal 0',
            'sampah_anorganik_terpilah.integer' => 'Sampah anorganik harus berupa angka',
            'sampah_anorganik_terpilah.min' => 'Sampah anorganik minimal 0',
            'sampah_lainnya_dan_atau_residu.integer' => 'Sampah residu harus berupa angka',
            'sampah_lainnya_dan_atau_residu.min' => 'Sampah residu minimal 0',
        ]);

        // Pastikan minimal ada satu jenis sampah yang diisi
        if (empty($validated['sampah_organik_terpilah']) && 
            empty($validated['sampah_anorganik_terpilah']) && 
            empty($validated['sampah_lainnya_dan_atau_residu'])) {
            return back()
                ->withErrors(['total' => 'Minimal satu jenis sampah harus diisi'])
                ->withInput();
        }

        // Cek duplikasi data (kecuali data ini sendiri)
        $exists = TrashManagement::where('tanggal', $validated['tanggal'])
                                 ->where('sumber_sampah', $validated['sumber_sampah'])
                                 ->where('id', '!=', $id)
                                 ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'tanggal' => 'Data untuk tanggal ini dengan sumber sampah yang sama sudah ada'
                ])
                ->withInput();
        }

        // Update data
        $data->update($validated);

        return redirect()
            ->route('trash-management')
            ->with('success', 'Data pengelolaan sampah berhasil diperbarui.');
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        $data = TrashManagement::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('trash-management')
            ->with('success', 'Data pengelolaan sampah berhasil dihapus.');
    }
}