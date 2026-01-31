<?php

namespace App\Http\Controllers;

use App\Models\Revegetasi;
use App\Http\Controllers\Controller;
use App\Exports\RevegetasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevegetasiController extends Controller
{
    /**
     * Tampilkan daftar data revegetasi
     */
    public function index()
    {
        $revegetasiData = Revegetasi::with('creator')
            ->latest()
            ->get();

        return view('revegetasi.index', compact('revegetasiData'));
    }

    /**
     * Tampilkan form tambah data revegetasi
     */
    public function create()
    {
        return view('revegetasi.create');
    }

    /**
     * Simpan data revegetasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_monitoring' => 'required|date',
            'lokasi_revegetasi'  => 'required|string|max:255',
            'luas_area'          => 'required|numeric|min:0',
            'jenis_vegetasi'     => 'required|in:pionir,lokal,covercrop',
            'jenis_tanaman'   => 'nullable|string|max:255',
            'jumlah_tanaman'     => 'nullable|integer|min:0',
            'tingkat_keberhasilan' => 'required|in:rendah,sedang,tinggi',
            'kondisi_tanah'      => 'nullable|string|max:255',
            'metode_penanaman'   => 'nullable|string|max:255',
            'catatan'            => 'nullable|string',
        ]);

        Revegetasi::create([
            'tanggal_monitoring' => $request->tanggal_monitoring,
            'lokasi_revegetasi'  => $request->lokasi_revegetasi,
            'luas_area'          => $request->luas_area,
            'jenis_vegetasi'     => $request->jenis_vegetasi,
            'jenis_tanaman'      => $request->jenis_tanaman,
            'jumlah_tanaman'     => $request->jumlah_tanaman,
            'tingkat_keberhasilan' => $request->tingkat_keberhasilan,
            'kondisi_tanah'      => $request->kondisi_tanah,
            'metode_penanaman'   => $request->metode_penanaman,
            'catatan'            => $request->catatan,
            'created_by'         => Auth::id(), // Otomatis ambil user login
        ]);

        return redirect()
            ->route('admin.revegetasi')
            ->with('success', 'Data revegetasi berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data revegetasi
     */
    public function edit($id)
    {
        $data = Revegetasi::findOrFail($id);
        return view('revegetasi.edit', compact('data'));
    }

    /**
     * Perbarui data revegetasi
     */
    public function update(Request $request, $id)
    {
        $data = Revegetasi::findOrFail($id);

        $request->validate([
            'tanggal_monitoring' => 'required|date',
            'lokasi_revegetasi'  => 'required|string|max:255',
            'luas_area'          => 'required|numeric|min:0',
            'jenis_vegetasi'     => 'required|in:pionir,lokal,covercrop',
            'jenis_tanaman'   => 'nullable|string|max:255',
            'jumlah_tanaman'     => 'nullable|integer|min:0',
            'tingkat_keberhasilan' => 'required|in:rendah,sedang,tinggi',
            'kondisi_tanah'      => 'nullable|string|max:255',
            'metode_penanaman'   => 'nullable|string|max:255',
            'catatan'            => 'nullable|string',
        ]);

        $data->update([
            'tanggal_monitoring' => $request->tanggal_monitoring,
            'lokasi_revegetasi'  => $request->lokasi_revegetasi,
            'luas_area'          => $request->luas_area,
            'jenis_vegetasi'     => $request->jenis_vegetasi,
            'jenis_tanaman'      => $request->jenis_tanaman,
            'jumlah_tanaman'     => $request->jumlah_tanaman,
            'tingkat_keberhasilan' => $request->tingkat_keberhasilan,
            'kondisi_tanah'      => $request->kondisi_tanah,
            'metode_penanaman'   => $request->metode_penanaman,
            'catatan'            => $request->catatan,
        ]);

        return redirect()
            ->route('revegetasi')
            ->with('success', 'Data revegetasi berhasil diperbarui.');
    }

    /**
     * Hapus data revegetasi (soft delete)
     */
    public function destroy($id)
    {
        $data = Revegetasi::findOrFail($id);
        $data->delete(); // Soft delete karena menggunakan SoftDeletes

        return redirect()
            ->route('revegetasi')
            ->with('success', 'Data revegetasi berhasil dihapus.');
    }

    // Export data revegetasi
    public function export()
    {
        return (new RevegetasiExport())->download('revegetasi.xlsx');
    }
}