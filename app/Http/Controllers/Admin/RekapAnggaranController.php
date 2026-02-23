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

        return view('admin.rekap-anggaran.index', compact(
            'rekap_anggaran',
            'totalNilaiKontrak'
        ));
    }

    /**
     * Tampilkan form tambah kontrak
     */
    public function create()
    {
        return view('admin.rekap-anggaran.add');
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
            'file_kontrak'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // =============================
        // Upload File
        // =============================
        $filePath = null;

        if ($request->hasFile('file_kontrak')) {
            $filePath = $request->file('file_kontrak')
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
        $rekap_anggaran = RekapAnggaran::findOrFail($id);
        return view('admin.rekap-anggaran.edit', compact('rekap_anggaran'));
    }

    /**
    * Update kontrak
    */
    public function update(Request $request, $id)
    {
        $rekap_anggaran = RekapAnggaran::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'realisasi'       => 'required|string|max:255',
            'keterangan_jasa' => 'required|string',
            'harga'           => 'required|numeric|min:0',
            'status'          => 'required|in:open,close,pending,proses finance,hold',
            'file_kontrak'    => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_kontrak')) {
            // Hapus file lama jika ada
            if ($rekap_anggaran->file_kontrak) {
                Storage::disk('public')->delete($rekap_anggaran->file_kontrak);
            }
            // Simpan file baru
            $data['file_kontrak'] = $request->file('file_kontrak')->store('rekap_anggaran', 'public');
        } else {
            // Tetap gunakan file yang lama jika tidak ada upload baru
            $data['file_kontrak'] = $rekap_anggaran->file_kontrak;
        }

        $rekap_anggaran->update($data);

        return redirect()->route('admin.rekap-anggaran')->with('success', 'Berhasil diperbarui.');
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
