<?php

namespace App\Http\Controllers;

use App\Models\BukaanLahan;
use App\Exports\BukaanLahanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BukaanLahanController extends Controller
{
    /**
     * Pesan error kustom untuk validasi
     */
    protected function validationMessages(): array
    {
        return [
            // Tanggal
            'tanggal_bukaan.required' => 'Tanggal bukaan lahan wajib diisi.',
            'tanggal_bukaan.date' => 'Format tanggal bukaan tidak valid.',
            'tanggal_bukaan.before_or_equal' => 'Tanggal bukaan tidak boleh melebihi hari ini.',
            
            // Lokasi
            'lokasi_bukaan.required' => 'Lokasi bukaan wajib diisi.',
            'lokasi_bukaan.string' => 'Lokasi bukaan harus berupa teks.',
            'lokasi_bukaan.max' => 'Lokasi bukaan maksimal :max karakter.',
            
            // Luas
            'luas_dibuka.required' => 'Luas yang dibuka wajib diisi.',
            'luas_dibuka.numeric' => 'Luas harus berupa angka.',
            'luas_dibuka.min' => 'Luas tidak boleh kurang dari :min.',
            
            // Jenis Vegetasi Awal
            'jenis_vegetasi_awal.required' => 'Jenis vegetasi awal wajib diisi.',
            'jenis_vegetasi_awal.string' => 'Jenis vegetasi awal harus berupa teks.',
            'jenis_vegetasi_awal.max' => 'Jenis vegetasi awal maksimal :max karakter.',
            
            // Metode Pembukaan
            'metode_pembukaan.required' => 'Metode pembukaan wajib diisi.',
            'metode_pembukaan.string' => 'Metode pembukaan harus berupa teks.',
            'metode_pembukaan.max' => 'Metode pembukaan maksimal :max karakter.',
            
            // Alat Berat
            'alat_berat_digunakan.string' => 'Data alat berat harus berupa teks.',
            'alat_berat_digunakan.max' => 'Data alat berat maksimal :max karakter.',
            
            // Izin Lingkungan
            'izin_lingkungan.string' => 'Data izin lingkungan harus berupa teks.',
            'izin_lingkungan.max' => 'Data izin lingkungan maksimal :max karakter.',
            
            // Status Kesesuaian
            'status_kesesuaian.required' => 'Status kesesuaian wajib dipilih.',
            'status_kesesuaian.in' => 'Pilihan status tidak valid. Pilih: sesuai atau tidak_sesuai.',
        ];
    }

    /**
     * Aturan validasi untuk store & update
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        return [
            'tanggal_bukaan' => 'required|date|before_or_equal:today',
            'lokasi_bukaan' => 'required|string|max:255',
            'luas_dibuka' => 'required|numeric|min:0',
            'jenis_vegetasi_awal' => 'required|string|max:255',
            'metode_pembukaan' => 'required|string|max:255',
            'alat_berat_digunakan' => 'nullable|string|max:500',
            'izin_lingkungan' => 'nullable|string|max:255',
            'status_kesesuaian' => 'required|in:sesuai,tidak_sesuai',
        ];
    }

    /**
     * Tampilkan daftar data bukaan lahan
     */
    public function index(Request $request)
    {
        $query = BukaanLahan::query();

        // 1. Filter Pencarian (Lokasi)
        if ($request->filled('search')) {
            $query->where('lokasi_bukaan', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Status
        if ($request->filled('status')) {
            $query->where('status_kesesuaian', $request->status);
        }

        // 3. Filter Tanggal (Range)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_bukaan', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_bukaan', '<=', $request->tanggal_sampai);
        }

        // Pagination: 10 data per halaman, urut terbaru
        $bukaanLahanData = $query->orderBy('tanggal_bukaan', 'desc')->paginate(10);

        return view('bukaan-lahan.index', compact('bukaanLahanData'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        return view('bukaan-lahan.create');
    }

    /**
     * Simpan data bukaan lahan
     */
    public function store(Request $request)
    {
        try {
            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(),
                $this->validationMessages()
            );

            // Buat data baru
            BukaanLahan::create([
                ...$validated,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('bukaan-lahan')
                ->with('success', '✅ Data bukaan lahan berhasil disimpan.');

        } catch (ValidationException $e) {
            // Log error validasi untuk debugging
            Log::warning('Validasi gagal store bukaan lahan', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e; // Laravel akan handle redirect + error otomatis
        } catch (\Exception $e) {
            Log::error('Error store bukaan lahan', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $data = BukaanLahan::findOrFail($id);
        return view('bukaan-lahan.edit', compact('data'));
    }

    /**
     * Perbarui data
     */
    public function update(Request $request, $id)
    {
        try {
            $data = BukaanLahan::findOrFail($id);

            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(true),
                $this->validationMessages()
            );

            // Update data
            $data->update([
                ...$validated,
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('bukaan-lahan')
                ->with('success', '✅ Data bukaan lahan berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal update bukaan lahan', [
                'id' => $id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error update bukaan lahan', [
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
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        try {
            $data = BukaanLahan::findOrFail($id);
            $lokasi = $data->lokasi_bukaan;
            
            $data->delete();

            return redirect()
                ->route('bukaan-lahan')
                ->with('success', "✅ Data bukaan lahan lokasi '{$lokasi}' berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Error delete bukaan lahan', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Export data bukaan lahan ke Excel
     */
    public function export(Request $request)
    {
        try {
            // Terapkan filter yang sama dengan index untuk export
            $query = BukaanLahan::query();

            if ($request->filled('search')) {
                $query->where('lokasi_bukaan', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('status')) {
                $query->where('status_kesesuaian', $request->status);
            }
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal_bukaan', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal_bukaan', '<=', $request->tanggal_sampai);
            }

            return (new BukaanLahanExport($query->get()))->download('bukaan_lahan_export_' . date('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            Log::error('Error export bukaan lahan', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Gagal mengekspor data. Silakan coba lagi.');
        }
    }
}