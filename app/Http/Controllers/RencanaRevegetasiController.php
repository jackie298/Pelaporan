<?php

namespace App\Http\Controllers;

use App\Models\RencanaRevegetasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RencanaRevegetasiController extends Controller
{
    /**
     * Tampilkan daftar rencana revegetasi (berdasarkan tahun terbaru)
     */
    public function index()
    {
        $rencanaData = RencanaRevegetasi::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'asc')
            ->get();

        return view('rencana-revegetasi.index', compact('rencanaData'));
    }

    /**
     * Tampilkan form tambah rencana
     */
    public function create()
    {
        return view('rencana-revegetasi.create');
    }

    /**
     * Simpan data rencana baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun'        => 'required|integer|min:2020|max:2099',
            'bulan'        => 'required|integer|between:1,12',
            'target_bibit' => 'required|integer|min:0',
            'lokasi'       => 'nullable|string|max:255',
        ]);

        // Menggunakan updateOrCreate agar tidak ada duplikasi tahun-bulan yang sama
        RencanaRevegetasi::updateOrCreate(
            [
                'tahun' => $request->tahun,
                'bulan' => $request->bulan,
            ],
            [
                'target_bibit' => $request->target_bibit,
                'lokasi'       => $request->lokasi,
            ]
        );

        return redirect()
            ->route('rencana-revegetasi')
            ->with('success', 'Rencana revegetasi berhasil disimpan.');
    }

    /**
     * Tampilkan form edit rencana
     */
    public function edit($id)
    {
        $data = RencanaRevegetasi::findOrFail($id);
        return view('rencana-revegetasi.edit', compact('data'));
    }

    /**
     * Perbarui data rencana
     */
    public function update(Request $request, $id)
    {
        $data = RencanaRevegetasi::findOrFail($id);

        $request->validate([
            'tahun'        => 'required|integer|min:2020|max:2099',
            'bulan'        => 'required|integer|between:1,12',
            'target_bibit' => 'required|integer|min:0',
            'lokasi'       => 'nullable|string|max:255',
        ]);

        $data->update([
            'tahun'        => $request->tahun,
            'bulan'        => $request->bulan,
            'target_bibit' => $request->target_bibit,
            'lokasi'       => $request->lokasi,
        ]);

        return redirect()
            ->route('rencana-revegetasi')
            ->with('success', 'Rencana revegetasi berhasil diperbarui.');
    }

    /**
     * Hapus data rencana
     */
    public function destroy($id)
    {
        $data = RencanaRevegetasi::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('rencana-revegetasi')
            ->with('success', 'Rencana revegetasi berhasil dihapus.');
    }
}