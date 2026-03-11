<?php

namespace App\Http\Controllers\Admin;

use App\Models\RekapAnggaran;
use App\Exports\RekapAnggaranExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RekapAnggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = RekapAnggaran::query();

        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('periode', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('periode', $request->tahun);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rekap_anggaran = $query->latest('periode')->paginate(10)->withQueryString();
        $totalNilaiKontrak = $query->sum('harga');

        return view('admin.rekap-anggaran.index', compact('rekap_anggaran', 'totalNilaiKontrak'));
    }

    public function create()
    {
        return view('admin.rekap-anggaran.add');
    }

    /**
     * Validasi Reusable
     */
    protected function validationRules($isUpdate = false)
    {
        return [
            'nama'            => 'required|string|max:255',
            'realisasi'       => 'required|numeric|min:0|max:100', 
            'keterangan_jasa' => 'required|string|min:10',
            'harga'           => 'required|numeric|min:0',
            'status'          => 'required|in:open,close,pending,proses finance,hold',
            'keterangan'      => 'nullable|string',
            'uraian_rkab'     => 'nullable|string',
            'periode'         => 'nullable|date',
            'file_kontrak'    => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:10240',
        ];
    }

    protected function validationMessages()
    {
        return [
            'nama.required'             => 'Nama kontrak tidak boleh kosong.',
            'realisasi.required'        => 'Realisasi wajib diisi.',
            'realisasi.numeric'         => 'Realisasi harus berupa angka.',
            'realisasi.min'             => 'Realisasi minimal adalah 0%.',
            'realisasi.max'             => 'Realisasi maksimal adalah 100%.',
            'keterangan_jasa.required'  => 'Detail keterangan jasa pekerjaan wajib diisi.',
            'harga.required'            => 'Nilai harga/anggaran wajib diisi.',
            'status.required'           => 'Silakan pilih status kontrak saat ini.',
            'file_kontrak.mimes'        => 'Format berkas tidak didukung.',
            'file_kontrak.max'          => 'Ukuran berkas maksimal 10MB.',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            $filePath = null;
            if ($request->hasFile('file_kontrak')) {
                $file = $request->file('file_kontrak');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('rekap_anggaran', $filename, 'public');
            }

            RekapAnggaran::create(array_merge($validated, ['file_kontrak' => $filePath]));

            return redirect()
                ->route('admin.rekap-anggaran')
                ->with('success', 'Data kontrak "' . $request->nama . '" berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error("Error Store Rekap Anggaran: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $rekap_anggaran = RekapAnggaran::findOrFail($id);
        return view('admin.rekap-anggaran.edit', compact('rekap_anggaran'));
    }

    public function update(Request $request, $id)
    {
        $rekap_anggaran = RekapAnggaran::findOrFail($id);
        $validated = $request->validate($this->validationRules(true), $this->validationMessages());

        try {
            if ($request->hasFile('file_kontrak')) {
                if ($rekap_anggaran->file_kontrak && Storage::disk('public')->exists($rekap_anggaran->file_kontrak)) {
                    Storage::disk('public')->delete($rekap_anggaran->file_kontrak);
                }
                
                $file = $request->file('file_kontrak');
                $filename = time() . '_' . $file->getClientOriginalName();
                $validated['file_kontrak'] = $file->storeAs('rekap_anggaran', $filename, 'public');
            }

            $rekap_anggaran->update($validated);

            return redirect()
                ->route('admin.rekap-anggaran')
                ->with('success', 'Perubahan pada kontrak "' . $rekap_anggaran->nama . '" berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error("Error Update Rekap Anggaran: " . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi masalah saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $rekap_anggaran = RekapAnggaran::findOrFail($id);
            if ($rekap_anggaran->file_kontrak && Storage::disk('public')->exists($rekap_anggaran->file_kontrak)) {
                Storage::disk('public')->delete($rekap_anggaran->file_kontrak);
            }
            $rekap_anggaran->delete();
            return back()->with('success', 'Data kontrak berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error Delete Rekap Anggaran: " . $e->getMessage());
            return back()->with('error', 'Data gagal dihapus.');
        }
    }


    public function export()
    {
        return (new RekapAnggaranExport())->download('rekap_anggaran_'.date('Ymd').'.xlsx');
    }
}