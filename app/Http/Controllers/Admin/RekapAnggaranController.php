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
    public function index()
    {
        $rekap_anggaran = RekapAnggaran::latest()->paginate(10);
        $totalNilaiKontrak = RekapAnggaran::sum('harga');

        return view('admin.rekap-anggaran.index', compact('rekap_anggaran', 'totalNilaiKontrak'));
    }

    public function create()
    {
        return view('admin.rekap-anggaran.add');
    }

    /**
     * Validasi Reusable (Untuk mempermudah maintenance)
     */
    protected function validationRules($isUpdate = false)
    {
        return [
            'nama'            => 'required|string|max:255',
            'realisasi'       => 'required|string|max:255',
            'keterangan_jasa' => 'required|string|min:10',
            'harga'           => 'required|numeric|min:0',
            'status'          => 'required|in:open,close,pending,proses finance,hold',
            'keterangan'      => 'nullable|string',
            'uraian_rkab'     => 'nullable|string',
            'file_kontrak'    => $isUpdate ? 'nullable|file|mimes:pdf,doc,docx|max:5120' : 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ];
    }

    protected function validationMessages()
    {
        return [
            'nama.required'             => 'Nama kontrak tidak boleh kosong.',
            'nama.max'                  => 'Nama kontrak terlalu panjang (maksimal 255 karakter).',
            'realisasi.required'        => 'Nomor realisasi wajib diisi.',
            'keterangan_jasa.required'  => 'Detail keterangan jasa pekerjaan wajib diisi.',
            'keterangan_jasa.min'       => 'Keterangan jasa minimal berisi 10 karakter.',
            'harga.required'            => 'Nilai harga/anggaran wajib diisi.',
            'harga.numeric'             => 'Harga harus berupa angka tanpa titik atau koma.',
            'harga.min'                 => 'Harga tidak boleh minus.',
            'status.required'           => 'Silakan pilih status kontrak saat ini.',
            'status.in'                 => 'Status yang dipilih tidak valid.',
            'file_kontrak.mimes'        => 'Format berkas tidak didukung. Gunakan format: PDF, DOC, atau DOCX.',
            'file_kontrak.max'          => 'Ukuran berkas terlalu besar. Maksimal adalah 5MB.',
            'file_kontrak.file'         => 'Input harus berupa berkas dokumen.',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            $filePath = null;
            if ($request->hasFile('file_kontrak')) {
                // Beri nama file unik agar tidak tertukar
                $file = $request->file('file_kontrak');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('rekap_anggaran', $filename, 'public');
            }

            RekapAnggaran::create(array_merge($validated, ['file_kontrak' => $filePath]));

            return redirect()
                ->route('admin.rekap-anggaran')
                ->with('success', 'Data kontrak "' . $request->nama . '" berhasil disimpan ke sistem.');

        } catch (\Exception $e) {
            Log::error("Error Store Rekap Anggaran: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data. Silakan hubungi admin atau coba lagi nanti.');
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
        
        // Gabungkan rules tambahan untuk update jika ada
        $validated = $request->validate($this->validationRules(true), $this->validationMessages());

        try {
            if ($request->hasFile('file_kontrak')) {
                // Hapus file lama jika ada
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

            return back()->with('success', 'Data kontrak berhasil dihapus dari database.');
        } catch (\Exception $e) {
            Log::error("Error Delete Rekap Anggaran: " . $e->getMessage());
            return back()->with('error', 'Data gagal dihapus karena masih digunakan di bagian lain atau masalah server.');
        }
    }

    public function export()
    {
        return (new RekapAnggaranExport())->download('rekap_anggaran_'.date('Ymd').'.xlsx');
    }
}