<?php

namespace App\Http\Controllers;

use App\Models\RencanaRevegetasi;
use App\Exports\RencanaRevegetasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RencanaRevegetasiController extends Controller
{
    /**
     * Pesan error kustom untuk validasi
     */
    protected function validationMessages(): array
    {
        return [
            // Tahun
            'tahun.required' => 'Tahun rencana wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal :min.',
            'tahun.max' => 'Tahun maksimal :max.',
            'tahun.unique' => 'Rencana untuk tahun :input sudah terdaftar. Silakan edit data yang ada.',
            
            // Target Bulanan
            'januari.required' => 'Target bulan Januari wajib diisi.',
            'januari.integer' => 'Target Januari harus berupa angka.',
            'januari.min' => 'Target Januari tidak boleh kurang dari :min.',
            
            'februari.required' => 'Target bulan Februari wajib diisi.',
            'februari.integer' => 'Target Februari harus berupa angka.',
            'februari.min' => 'Target Februari tidak boleh kurang dari :min.',
            
            'maret.required' => 'Target bulan Maret wajib diisi.',
            'maret.integer' => 'Target Maret harus berupa angka.',
            'maret.min' => 'Target Maret tidak boleh kurang dari :min.',
            
            'april.required' => 'Target bulan April wajib diisi.',
            'april.integer' => 'Target April harus berupa angka.',
            'april.min' => 'Target April tidak boleh kurang dari :min.',
            
            'mei.required' => 'Target bulan Mei wajib diisi.',
            'mei.integer' => 'Target Mei harus berupa angka.',
            'mei.min' => 'Target Mei tidak boleh kurang dari :min.',
            
            'juni.required' => 'Target bulan Juni wajib diisi.',
            'juni.integer' => 'Target Juni harus berupa angka.',
            'juni.min' => 'Target Juni tidak boleh kurang dari :min.',
            
            'juli.required' => 'Target bulan Juli wajib diisi.',
            'juli.integer' => 'Target Juli harus berupa angka.',
            'juli.min' => 'Target Juli tidak boleh kurang dari :min.',
            
            'agustus.required' => 'Target bulan Agustus wajib diisi.',
            'agustus.integer' => 'Target Agustus harus berupa angka.',
            'agustus.min' => 'Target Agustus tidak boleh kurang dari :min.',
            
            'september.required' => 'Target bulan September wajib diisi.',
            'september.integer' => 'Target September harus berupa angka.',
            'september.min' => 'Target September tidak boleh kurang dari :min.',
            
            'oktober.required' => 'Target bulan Oktober wajib diisi.',
            'oktober.integer' => 'Target Oktober harus berupa angka.',
            'oktober.min' => 'Target Oktober tidak boleh kurang dari :min.',
            
            'november.required' => 'Target bulan November wajib diisi.',
            'november.integer' => 'Target November harus berupa angka.',
            'november.min' => 'Target November tidak boleh kurang dari :min.',
            
            'desember.required' => 'Target bulan Desember wajib diisi.',
            'desember.integer' => 'Target Desember harus berupa angka.',
            'desember.min' => 'Target Desember tidak boleh kurang dari :min.',
            
            // Lokasi
            'lokasi.string' => 'Lokasi harus berupa teks.',
            'lokasi.max' => 'Lokasi maksimal :max karakter.',
        ];
    }

    /**
     * Aturan validasi untuk store & update
     */
    protected function validationRules(bool $isUpdate = false, $id = null): array
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

        // Tambahkan validasi unique untuk tahun
        if ($isUpdate && $id) {
            $rules['tahun'][] = 'unique:rencana_revegetasi,tahun,' . $id;
        } else {
            $rules['tahun'][] = 'unique:rencana_revegetasi,tahun';
        }

        return $rules;
    }

    /**
     * Tampilkan daftar rencana revegetasi
     */
    public function index(Request $request)
    {
        $query = RencanaRevegetasi::query();

        // 1. Filter Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // 2. Filter Pencarian (Lokasi)
        if ($request->filled('search')) {
            $query->where('lokasi', 'like', '%' . $request->search . '%');
        }

        // 3. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination: 10 data per halaman, urut tahun terbaru
        $rencanaData = $query->orderBy('tahun', 'desc')->paginate(10);

        // Daftar bulan untuk display
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
        try {
            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(),
                $this->validationMessages()
            );

            DB::beginTransaction();

            // Menggunakan updateOrCreate agar tidak ada duplikasi tahun yang sama
            $rencana = RencanaRevegetasi::updateOrCreate(
                ['tahun' => $validated['tahun']],
                [
                    ...$validated,
                    'updated_by' => Auth::id(),
                ]
            );

            // Set created_by hanya jika record baru
            if ($rencana->wasRecentlyCreated) {
                $rencana->update(['created_by' => Auth::id()]);
            }

            DB::commit();

            return redirect()
                ->route('rencana-revegetasi')
                ->with('success', '✅ Rencana revegetasi tahun ' . $validated['tahun'] . ' berhasil disimpan.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal store rencana revegetasi', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
                'tahun' => $request->tahun,
            ]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error store rencana revegetasi', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
                'tahun' => $request->tahun,
            ]);
            return back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
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
        try {
            $data = RencanaRevegetasi::findOrFail($id);

            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(true, $id),
                $this->validationMessages()
            );

            DB::beginTransaction();

            $data->update([
                ...$validated,
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            return redirect()
                ->route('rencana-revegetasi')
                ->with('success', '✅ Rencana revegetasi tahun ' . $data->tahun . ' berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal update rencana revegetasi', [
                'id' => $id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error update rencana revegetasi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Hapus data rencana
     */
    public function destroy($id)
    {
        try {
            $data = RencanaRevegetasi::findOrFail($id);
            $tahun = $data->tahun;
            
            $data->delete();

            return redirect()
                ->route('rencana-revegetasi')
                ->with('success', "✅ Rencana revegetasi tahun '{$tahun}' berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Error delete rencana revegetasi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Export data rencana revegetasi ke Excel
     */
    public function export(Request $request)
    {
        try {
            // Terapkan filter yang sama dengan index untuk export
            $query = RencanaRevegetasi::query();

            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }
            if ($request->filled('search')) {
                $query->where('lokasi', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $data = $query->orderBy('tahun', 'desc')->get();

            return (new RencanaRevegetasiExport($data))->download('rencana_revegetasi_export_' . date('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            Log::error('Error export rencana revegetasi', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Gagal mengekspor data. Silakan coba lagi.');
        }
    }
}