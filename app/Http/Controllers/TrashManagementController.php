<?php

namespace App\Http\Controllers;

use App\Models\TrashManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashManagementController extends Controller
{
    /**
     * Tampilkan daftar data pengelolaan limbah B3
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
        return view('trash-management.create');
    }

    /**
     * Simpan data limbah B3
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_limbah_masuk'   => 'required|string',
            'kode_limbah'          => 'required|string',
            'tanggal_masuk'        => 'required|date',
            'sumber_limbah'        => 'required|string',
            'jumlah_masuk_ton'     => 'required|numeric|min:0',
            'maksimal_penyimpanan' => 'required|date|after_or_equal:tanggal_masuk',
            'tanggal_keluar'       => 'nullable|date|after_or_equal:tanggal_masuk',
            'jumlah_keluar_ton'    => 'nullable|numeric|min:0',
            'tujuan_penyerahan'    => 'nullable|string',
            'nomor_dokumen'        => 'nullable|string',
            'sisa_limbah_ton'      => 'required|numeric|min:0',
        ]);

        TrashManagement::create($request->all());

        return redirect()
            ->route('trash-management')
            ->with('success', 'Data limbah B3 berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $data = TrashManagement::findOrFail($id);
        return view('trash-management.edit', compact('data'));
    }

    /**
     * Perbarui data limbah B3
     */
    public function update(Request $request, $id)
    {
        $data = TrashManagement::findOrFail($id);

        $request->validate([
            'jenis_limbah_masuk'   => 'required|string',
            'kode_limbah'          => 'required|string',
            'tanggal_masuk'        => 'required|date',
            'sumber_limbah'        => 'required|string',
            'jumlah_masuk_ton'     => 'required|numeric|min:0',
            'maksimal_penyimpanan' => 'required|date',
            'tanggal_keluar'       => 'nullable|date',
            'jumlah_keluar_ton'    => 'nullable|numeric|min:0',
            'tujuan_penyerahan'    => 'nullable|string',
            'nomor_dokumen'        => 'nullable|string',
            'sisa_limbah_ton'      => 'required|numeric|min:0',
        ]);

        $data->update($request->all());

        return redirect()
            ->route('trash-management')
            ->with('success', 'Data limbah B3 berhasil diperbarui.');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $data = TrashManagement::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('trash-management')
            ->with('success', 'Data limbah B3 berhasil dihapus.');
    }
}