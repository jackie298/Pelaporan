<?php

namespace App\Http\Controllers;

use App\Models\Nursery;
use App\Exports\NurseryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseryController extends Controller
{
    /**
     * Tampilkan daftar data pembibitan
     */
    public function index()
    {
        $nurseryData = Nursery::with('creator')
            ->latest()
            ->get();

        return view('nursery.index', compact('nurseryData'));
    }

    /**
     * Tampilkan form tambah data pembibitan
     */
    public function create()
    {
        return view('nursery.create');
    }

    /**
     * Simpan data pembibitan
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_tanaman' => 'required|string|max:255',
            'jumlah_bibit' => 'required|integer|min:1',
            'tanggal_penyemaian' => 'required|date',
            'lokasi_pembibitan' => 'required|string|max:255',
            'status_pertumbuhan' => 'required|in:bagus,sedang,buruk',
            'persentase_keberhasilan' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
            'estimasi_siap_tanam' => 'nullable|date|after_or_equal:tanggal_penyemaian',
        ]);

        Nursery::create([
            'jenis_tanaman' => $request->jenis_tanaman,
            'jumlah_bibit' => $request->jumlah_bibit,
            'tanggal_penyemaian' => $request->tanggal_penyemaian,
            'lokasi_pembibitan' => $request->lokasi_pembibitan,
            'status_pertumbuhan' => $request->status_pertumbuhan,
            'persentase_keberhasilan' => $request->persentase_keberhasilan,
            'catatan' => $request->catatan,
            'estimasi_siap_tanam' => $request->estimasi_siap_tanam,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('nursery')
            ->with('success', 'Data pembibitan berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data pembibitan
     */
    public function edit($id)
    {
        $data = Nursery::findOrFail($id);
        return view('nursery.edit', compact('data'));
    }

    /**
     * Perbarui data pembibitan
     */
    public function update(Request $request, $id)
    {
        $data = Nursery::findOrFail($id);

        $request->validate([
            'jenis_tanaman' => 'required|string|max:255',
            'jumlah_bibit' => 'required|integer|min:1',
            'tanggal_penyemaian' => 'required|date',
            'lokasi_pembibitan' => 'required|string|max:255',
            'status_pertumbuhan' => 'required|in:bagus,sedang,buruk',
            'persentase_keberhasilan' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
            'estimasi_siap_tanam' => 'nullable|date|after_or_equal:tanggal_penyemaian',
        ]);

        $data->update([
            'jenis_tanaman' => $request->jenis_tanaman,
            'jumlah_bibit' => $request->jumlah_bibit,
            'tanggal_penyemaian' => $request->tanggal_penyemaian,
            'lokasi_pembibitan' => $request->lokasi_pembibitan,
            'status_pertumbuhan' => $request->status_pertumbuhan,
            'persentase_keberhasilan' => $request->persentase_keberhasilan,
            'catatan' => $request->catatan,
            'estimasi_siap_tanam' => $request->estimasi_siap_tanam,
        ]);

        return redirect()
            ->route('nursery')
            ->with('success', 'Data pembibitan berhasil diperbarui.');
    }

    /**
     * Hapus data pembibitan (soft delete)
     */
    public function destroy($id)
    {
        $data = Nursery::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('nursery')
            ->with('success', 'Data pembibitan berhasil dihapus.');
    }

    // Export data pembibitan
    public function export()
    {
        return (new NurseryExport())->download('nursery_export.xlsx');
    }
}