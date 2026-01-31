<?php

namespace App\Http\Controllers\Admin;
use App\Models\RekapAnggaran;
use App\Models\RekapAnggaranExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekapAnggaranController extends Controller
{
    /**
     * Tampilkan daftar kontrak
     */
    public function index()
    {
        $rekap_anggaran = RekapAnggaran::latest()->get();

        // HITUNG TOTAL NILAI KONTRAK
        $totalNilaiKontrak = $rekap_anggaran->sum('harga');

        return view('admin.rekap-anggaran', compact(
            'rekap_anggaran',
            'totalNilaiKontrak'
        ));
    }

    /**
     * Tampilkan form tambah kontrak
     */
    public function create()
    {
        return view('admin.add-rekap-anggaran');
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
            'status'           => 'required|in:open,close,pending,proses finance,hold',
            'keterangan'       => 'nullable|string',
            'uraian_rkab'      => 'nullable|string',
            'file_kontrak'     => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // =============================
        // Upload File
        // =============================
        $filePath = null;

        if ($request->hasFile('file_rekap_anggaran')) {
            $filePath = $request->file('file_rekap_anggaran')
                                ->store('rekap_anggaran', 'public');
        }

        // =============================
        // SIMPAN DATABASE
        // =============================
        RekapAnggaran::create([
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
            ->route('admin.rekap-anggaran')
            ->with('success', 'Document Rekap Anggaran berhasil disimpan.');
    }

    /**
    * Form edit kontrak
    */
    public function edit($id)
    {
        $contract = RekapAnggaran::findOrFail($id);
        return view('admin.edit-rekap-anggaran', compact('rekap_anggaran'));
    }

    /**
    * Update kontrak
    */
    public function update(Request $request, $id)
    {
        $rekap_anggaran = RekapAnggaran::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'realisasi'        => 'required|string|max:255',
            'keterangan_jasa'  => 'required|string',
            'harga'            => 'required|numeric|min:0',
            'status'           => 'required|in:open,close,pending,proses finance,hold',
            'keterangan'       => 'nullable|string',
            'uraian_rkab'      => 'nullable|string',
            'file_kontrak'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // upload file baru (jika ada)
        if ($request->hasFile('file_rekap_anggaran')) {
            if ($rekap_anggaran->file_rekap_anggaran) {
                Storage::disk('public')->delete($rekap_anggaran->file_rekap_anggaran);
            }

            $rekap_anggaran->file_rekap_anggaran = $request->file('file_rekap_anggaran')
                ->store('rekap_anggaran', 'public');
        }

        $rekap_anggaran->update($request->except('file_rekap_anggaran'));

        return redirect()
            ->route('admin.rekap-anggaran')
            ->with('success', 'Document Rekap Anggaran berhasil diperbarui.');
    }

    /**
    * Hapus kontrak
    */
    public function destroy($id)
    {
        $rekap_anggaran = RekapAnggaran::findOrFail($id);

        if ($rekap_anggaran->file_rekap_anggaran) {
            Storage::disk('public')->delete($rekap_anggaran->file_rekap_anggaran);
        }

        $rekap_anggaran->delete();

        return back()->with('success', 'Document Rekap Anggaran berhasil dihapus.');
    }

    // Export data rekap anggaran
    public function export()
    {
        return (new RekapAnggaranExport())->download('rekap_anggaran.xlsx');
    }
}
