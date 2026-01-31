<?php

namespace App\Http\Controllers;

use App\Models\Reklamasi;
use App\Exports\ReklamasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReklamasiController extends Controller
{
    /**
     * Tampilkan daftar data reklamasi
     */
    public function index()
    {
        $reklamasiData = Reklamasi::with('creator')
            ->latest()
            ->get();

        return view('reklamasi.index', compact('reklamasiData'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        return view('reklamasi.create');
    }

    /**
     * Simpan data reklamasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_reklamasi' => 'required|date',
            'lokasi_reklamasi' => 'required|string|max:255',
            'luas_direklamasi' => 'required|numeric|min:0',
            'jenis_kegiatan' => 'required|string|max:255',
            'metode_reklamasi' => 'required|string|max:255',
            'jenis_tanaman' => 'required|in:pionir,lokal,covercrop',
            'pupuk' => 'required|string|max:255',
            'jumlah_tanaman' => 'required|integer|min:0',         
            'alat_berat_digunakan' => 'nullable|string',
            'izin_lingkungan' => 'nullable|string|max:255',
            'status_kesesuaian' => 'required|in:sesuai,tidak_sesuai',
            'catatan' => 'nullable|string',
        ]);

        Reklamasi::create([
            'tanggal_reklamasi' => $request->tanggal_reklamasi,
            'lokasi_reklamasi' => $request->lokasi_reklamasi,
            'luas_direklamasi' => $request->luas_direklamasi,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'metode_reklamasi' => $request->metode_reklamasi,
            'jenis_tanaman' => $request->jenis_tanaman,
            'pupuk' => $request->pupuk,
            'jumlah_tanaman' => $request->jumlah_tanaman,
            'alat_berat_digunakan' => $request->alat_berat_digunakan,
            'izin_lingkungan' => $request->izin_lingkungan,
            'status_kesesuaian' => $request->status_kesesuaian,
            'catatan' => $request->catatan,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('reklamasi')
            ->with('success', 'Data reklamasi berhasil disimpan.');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $data = Reklamasi::findOrFail($id);
        return view('reklamasi.edit', compact('data'));
    }

    /**
     * Perbarui data
     */
    public function update(Request $request, $id)
    {
        $data = Reklamasi::findOrFail($id);

        $request->validate([
            'tanggal_reklamasi' => 'required|date',
            'lokasi_reklamasi' => 'required|string|max:255',
            'luas_direklamasi' => 'required|numeric|min:0',
            'jenis_kegiatan' => 'required|string|max:255',
            'metode_reklamasi' => 'required|string|max:255',
            'jenis_tanaman' => 'required|in:pionir,lokal,covercrop',
            'pupuk' => 'required|string|max:255',
            'jumlah_tanaman' => 'required|integer|min:0',
            'alat_berat_digunakan' => 'nullable|string',
            'izin_lingkungan' => 'nullable|string|max:255',
            'status_kesesuaian' => 'required|in:sesuai,tidak_sesuai',
            'catatan' => 'nullable|string',
        ]);

        $data->update([
            'tanggal_reklamasi' => $request->tanggal_reklamasi,
            'lokasi_reklamasi' => $request->lokasi_reklamasi,
            'luas_direklamasi' => $request->luas_direklamasi,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'metode_reklamasi' => $request->metode_reklamasi,
            'jenis_tanaman' => $request->jenis_tanaman,
            'pupuk' => $request->pupuk,
            'jumlah_tanaman' => $request->jumlah_tanaman,
            'alat_berat_digunakan' => $request->alat_berat_digunakan,
            'izin_lingkungan' => $request->izin_lingkungan,
            'status_kesesuaian' => $request->status_kesesuaian,
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('reklamasi')
            ->with('success', 'Data reklamasi berhasil diperbarui.');
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        $data = Reklamasi::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('reklamasi')
            ->with('success', 'Data reklamasi berhasil dihapus.');
    }

    // Export data reklamasi
    public function export()
    {
        return (new ReklamasiExport())->download('reklamasi_export.xlsx');
    }
}