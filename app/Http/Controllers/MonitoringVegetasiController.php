<?php

namespace App\Http\Controllers;

use App\Models\MonitoringVegetasi;
use App\Exports\MonitoringVegetasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MonitoringVegetasiController extends Controller
{
    /**
     * Pesan error kustom untuk validasi
     */
    protected function validationMessages(): array
    {
        return [
            // Tahun
            'tahun.required' => 'Tahun monitoring wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka bulat.',
            'tahun.min' => 'Tahun minimal :min.',
            'tahun.max' => 'Tahun maksimal :max.',
            
            // Lokasi
            'lokasi.required' => 'Lokasi monitoring wajib diisi.',
            'lokasi.string' => 'Lokasi harus berupa teks.',
            'lokasi.max' => 'Lokasi maksimal :max karakter.',
            
            // Titik Pantau
            'titik_pantau.required' => 'Titik pantau wajib diisi.',
            'titik_pantau.string' => 'Titik pantau harus berupa teks.',
            'titik_pantau.max' => 'Titik pantau maksimal :max karakter.',
            
            // Jenis Tanaman
            'jenis_tanaman.required' => 'Jenis tanaman wajib diisi.',
            'jenis_tanaman.string' => 'Jenis tanaman harus berupa teks.',
            'jenis_tanaman.max' => 'Jenis tanaman maksimal :max karakter.',
            
            // Tinggi Triwulan 1
            'tinggi_triwulan1.numeric' => 'Tinggi triwulan 1 harus berupa angka.',
            'tinggi_triwulan1.min' => 'Tinggi triwulan 1 tidak boleh kurang dari :min.',
            
            // Tinggi Triwulan 2
            'tinggi_triwulan2.numeric' => 'Tinggi triwulan 2 harus berupa angka.',
            'tinggi_triwulan2.min' => 'Tinggi triwulan 2 tidak boleh kurang dari :min.',
            
            // Tinggi Triwulan 3
            'tinggi_triwulan3.numeric' => 'Tinggi triwulan 3 harus berupa angka.',
            'tinggi_triwulan3.min' => 'Tinggi triwulan 3 tidak boleh kurang dari :min.',
            
            // Tinggi Triwulan 4
            'tinggi_triwulan4.numeric' => 'Tinggi triwulan 4 harus berupa angka.',
            'tinggi_triwulan4.min' => 'Tinggi triwulan 4 tidak boleh kurang dari :min.',
            
            // Catatan
            'catatan.string' => 'Catatan harus berupa teks.',
        ];
    }

    /**
     * Aturan validasi untuk store & update
     */
    protected function validationRules(): array
    {
        return [
            'tahun' => 'required|integer|min:2020|max:2099',
            'lokasi' => 'required|string|max:255',
            'titik_pantau' => 'required|string|max:255',
            'jenis_tanaman' => 'required|string|max:255',
            'tinggi_triwulan1' => 'nullable|numeric|min:0',
            'tinggi_triwulan2' => 'nullable|numeric|min:0',
            'tinggi_triwulan3' => 'nullable|numeric|min:0',
            'tinggi_triwulan4' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ];
    }

    /**
     * Tampilkan daftar monitoring vegetasi
     */
    public function index(Request $request)
    {
        $query = MonitoringVegetasi::with('creator');

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('titik_pantau', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_tanaman', 'like', '%' . $request->search . '%');
            });
        }

        // Pagination: 10 data per halaman, urut terbaru
        $monitoringData = $query->latest()->paginate(10);

        return view('monitoring-vegetasi.index', compact('monitoringData'));
    }

    /**
     * Tampilkan form tambah monitoring
     */
    public function create()
    {
        return view('monitoring-vegetasi.create');
    }

    /**
     * Simpan data monitoring baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate(
                $this->validationRules(),
                $this->validationMessages()
            );

            MonitoringVegetasi::create([
                ...$validated,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('monitoring-vegetasi')
                ->with('success', '✅ Data monitoring vegetasi berhasil disimpan.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal store monitoring vegetasi', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error store monitoring vegetasi', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan form edit monitoring
     */
    public function edit($id)
    {
        $data = MonitoringVegetasi::findOrFail($id);
        return view('monitoring-vegetasi.edit', compact('data'));
    }

    /**
     * Perbarui data monitoring
     */
    public function update(Request $request, $id)
    {
        try {
            $data = MonitoringVegetasi::findOrFail($id);

            $validated = $request->validate(
                $this->validationRules(),
                $this->validationMessages()
            );

            $data->update([
                ...$validated,
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('monitoring-vegetasi')
                ->with('success', '✅ Data monitoring vegetasi berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal update monitoring vegetasi', [
                'id' => $id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error update monitoring vegetasi', [
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
     * Hapus data monitoring (soft delete)
     */
    public function destroy($id)
    {
        try {
            $data = MonitoringVegetasi::findOrFail($id);
            $lokasi = $data->lokasi;
            
            $data->delete();

            return redirect()
                ->route('monitoring-vegetasi')
                ->with('success', "✅ Data monitoring vegetasi lokasi '{$lokasi}' berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Error delete monitoring vegetasi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Export data monitoring vegetasi ke Excel
     */
    public function export(Request $request)
    {
        try {
            $query = MonitoringVegetasi::query();

            if ($request->filled('search')) {
                $query->where('lokasi', 'like', '%' . $request->search . '%');
            }

            return (new MonitoringVegetasiExport($query->get()))->download('monitoring_vegetasi_export_' . date('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            Log::error('Error export monitoring vegetasi', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Gagal mengekspor data. Silakan coba lagi.');
        }
    }
}