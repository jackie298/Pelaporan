<?php

namespace App\Http\Controllers\Admin;

use App\Models\DocumentContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentContractController extends Controller
{
    /**
     * Tampilkan daftar kontrak
     */
    public function index()
    {
        $contracts = DocumentContract::latest()->get();

        // HITUNG TOTAL NILAI KONTRAK
        $totalNilaiKontrak = $contracts->sum('harga');

        return view('admin.document-contract', compact(
            'contracts',
            'totalNilaiKontrak'
        ));
    }

    /**
     * Tampilkan form tambah kontrak
     */
    public function create()
    {
        return view('admin.add-document-contract');
    }

    /**
     * Simpan data kontrak
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'realisasi'        => 'required|string|max:255',
            'keterangan_jasa'  => 'required|string',
            'harga'            => 'required|numeric|min:0',
            'status'           => 'required|in:aktif,selesai,batal',
            'keterangan'       => 'nullable|string',
            'uraian_rkab'      => 'nullable|string',
            'file_kontrak'     => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // =============================
        // Upload File
        // =============================
        $filePath = null;

        if ($request->hasFile('file_kontrak')) {
            $filePath = $request->file('file_kontrak')
                                ->store('contracts', 'public');
        }

        // =============================
        // SIMPAN DATABASE
        // =============================
        DocumentContract::create([
            'nama' => $request->nama,
            'realisasi' => $request->realisasi,
            'keterangan_jasa' => $request->keterangan_jasa,
            'harga' => $request->harga,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'uraian_rkab' => $request->uraian_rkab,
            'file_kontrak' => $filePath,
        ]);

        return redirect()
            ->route('admin.document-contract')
            ->with('success', 'Document Contract berhasil disimpan.');
    }

    /**
    * Form edit kontrak
    */
    public function edit($id)
    {
        $contract = DocumentContract::findOrFail($id);
        return view('admin.edit-document-contract', compact('contract'));
    }

    /**
    * Update kontrak
    */
    public function update(Request $request, $id)
    {
        $contract = DocumentContract::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'realisasi'        => 'required|string|max:255',
            'keterangan_jasa'  => 'required|string',
            'harga'            => 'required|numeric|min:0',
            'status'           => 'required|in:aktif,selesai,batal',
            'keterangan'       => 'nullable|string',
            'uraian_rkab'      => 'nullable|string',
            'file_kontrak'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // upload file baru (jika ada)
        if ($request->hasFile('file_kontrak')) {
            if ($contract->file_kontrak) {
                Storage::disk('public')->delete($contract->file_kontrak);
            }

            $contract->file_kontrak = $request->file('file_kontrak')
                ->store('contracts', 'public');
        }

        $contract->update($request->except('file_kontrak'));

        return redirect()
            ->route('admin.document-contract')
            ->with('success', 'Document Contract berhasil diperbarui.');
    }

    /**
    * Hapus kontrak
    */
    public function destroy($id)
    {
        $contract = DocumentContract::findOrFail($id);

        if ($contract->file_kontrak) {
            Storage::disk('public')->delete($contract->file_kontrak);
        }

        $contract->delete();

        return back()->with('success', 'Document Contract berhasil dihapus.');
    }
}
