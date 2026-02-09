<?php

namespace App\Http\Controllers;

use App\Models\RencanaRevegetasi;
use App\Exports\RencanaRevegetasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RencanaRevegetasiController extends Controller
{
    /**
     * Tampilkan daftar rencana revegetasi (berdasarkan tahun terbaru)
     */
    public function index()
    {
       // Gunakan paginate() bukan get() untuk mendukung pagination
        $rencanaData = RencanaRevegetasi::orderBy('tahun', 'desc')
            ->paginate(10); // 10 record per halaman

        $daftarBulan = RencanaRevegetasi::getDaftarBulan();

        return view('rencana-revegetasi.index', compact('rencanaData', 'daftarBulan'));
    }

    
    /**
     * Tampilkan detail rencana revegetasi
    */
    public function show($id)
    {
        $data = RencanaRevegetasi::findOrFail($id);
        $daftarBulan = RencanaRevegetasi::getDaftarBulan();
        $targetBulanan = $data->target_bulanan;
        
        return view('rencana-revegetasi.show', compact('data', 'daftarBulan', 'targetBulanan'));
    }

    /**
     * Tampilkan form tambah rencana
     */
    public function create()
    {
        $daftarBulan = RencanaRevegetasi::getDaftarBulan();
        return view('rencana-revegetasi.create', compact('daftarBulan'));
    }

    /**
     * Simpan data rencana baru
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        try {
            DB::beginTransaction();

            // Menggunakan updateOrCreate agar tidak ada duplikasi tahun yang sama
            RencanaRevegetasi::updateOrCreate(
                [
                    'tahun' => $request->tahun,
                ],
                $validated
            );

            DB::commit();

            return redirect()
                ->route('rencana-revegetasi')
                ->with('success', 'Rencana revegetasi berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit rencana
     */
    public function edit($id)
    {
        $data = RencanaRevegetasi::findOrFail($id);
        $daftarBulan = RencanaRevegetasi::getDaftarBulan();
        
        return view('rencana-revegetasi.edit', compact('data', 'daftarBulan'));
    }

    /**
     * Perbarui data rencana
     */
    public function update(Request $request, $id)
    {
        $data = RencanaRevegetasi::findOrFail($id);

        $validated = $this->validateRequest($request, $id);

        try {
            DB::beginTransaction();

            $data->update($validated);

            DB::commit();

            return redirect()
                ->route('rencana-revegetasi')
                ->with('success', 'Rencana revegetasi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data rencana
     */
    public function destroy($id)
    {
        $data = RencanaRevegetasi::findOrFail($id);
        
        try {
            $data->delete();

            return redirect()
                ->route('rencana-revegetasi')
                ->with('success', 'Rencana revegetasi berhasil dihapus.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus rencana revegetasi: ' . $e->getMessage());
        }
    }

    /**
     * Export data rencana revegetasi ke Excel
     */
    public function export()
    {
        return (new RencanaRevegetasiExport())->download('rencana_revegetasi_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Validasi request untuk store dan update
     */
    private function validateRequest(Request $request, $id = null)
    {
        $rules = [
            'tahun' => [
                'required',
                'integer',
                'min:2020',
                'max:2099',
            ],
            'januari' => 'required|integer|min:0',
            'februari' => 'required|integer|min:0',
            'maret' => 'required|integer|min:0',
            'april' => 'required|integer|min:0',
            'mei' => 'required|integer|min:0',
            'juni' => 'required|integer|min:0',
            'juli' => 'required|integer|min:0',
            'agustus' => 'required|integer|min:0',
            'september' => 'required|integer|min:0',
            'oktober' => 'required|integer|min:0',
            'november' => 'required|integer|min:0',
            'desember' => 'required|integer|min:0',
            'lokasi' => 'nullable|string|max:255',
        ];

        // Tambahkan validasi unique jika update
        if ($id) {
            $rules['tahun'][3] = 'unique:rencana_revegetasi,tahun,' . $id;
        } else {
            $rules['tahun'][] = 'unique:rencana_revegetasi,tahun';
        }

        $messages = [
            'tahun.required' => 'Tahun harus diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 2020.',
            'tahun.max' => 'Tahun maksimal 2099.',
            'tahun.unique' => 'Rencana untuk tahun ini sudah ada.',
            '*.required' => ':attribute harus diisi.',
            '*.integer' => ':attribute harus berupa angka.',
            '*.min' => ':attribute minimal 0.',
            'lokasi.max' => 'Lokasi maksimal 255 karakter.',
        ];

        $attributes = [
            'tahun' => 'Tahun',
            'januari' => 'Target Januari',
            'februari' => 'Target Februari',
            'maret' => 'Target Maret',
            'april' => 'Target April',
            'mei' => 'Target Mei',
            'juni' => 'Target Juni',
            'juli' => 'Target Juli',
            'agustus' => 'Target Agustus',
            'september' => 'Target September',
            'oktober' => 'Target Oktober',
            'november' => 'Target November',
            'desember' => 'Target Desember',
            'lokasi' => 'Lokasi',
        ];

        return $request->validate($rules, $messages, $attributes);
    }
}