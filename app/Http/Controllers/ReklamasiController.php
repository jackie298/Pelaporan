<?php

namespace App\Http\Controllers;

use App\Models\Reklamasi;
use App\Exports\ReklamasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ReklamasiController extends Controller
{
    /**
     * Pesan error kustom untuk validasi (tanpa pupuk, jenis_tanaman, jumlah_tanaman)
     */
    protected function validationMessages(): array
    {
        return [
            // Tanggal
            'tanggal_reklamasi.required' => 'Tanggal reklamasi wajib diisi.',
            'tanggal_reklamasi.date' => 'Format tanggal reklamasi tidak valid.',
            'tanggal_reklamasi.before_or_equal' => 'Tanggal reklamasi tidak boleh melebihi hari ini.',
            
            // Lokasi
            'lokasi_reklamasi.required' => 'Lokasi reklamasi wajib diisi.',
            'lokasi_reklamasi.string' => 'Lokasi reklamasi harus berupa teks.',
            'lokasi_reklamasi.max' => 'Lokasi reklamasi maksimal :max karakter.',
            
            // Luas
            'luas_direklamasi.required' => 'Luas yang direklamasi wajib diisi.',
            'luas_direklamasi.numeric' => 'Luas harus berupa angka.',
            'luas_direklamasi.min' => 'Luas tidak boleh kurang dari :min.',
            
            // Jenis Kegiatan
            'jenis_kegiatan.required' => 'Jenis kegiatan wajib diisi.',
            'jenis_kegiatan.string' => 'Jenis kegiatan harus berupa teks.',
            'jenis_kegiatan.max' => 'Jenis kegiatan maksimal :max karakter.',
            
            // Metode Reklamasi
            'metode_reklamasi.required' => 'Metode reklamasi wajib diisi.',
            'metode_reklamasi.string' => 'Metode reklamasi harus berupa teks.',
            'metode_reklamasi.max' => 'Metode reklamasi maksimal :max karakter.',
            
            // Alat Berat
            'alat_berat_digunakan.string' => 'Data alat berat harus berupa teks.',
            'alat_berat_digunakan.max' => 'Data alat berat maksimal :max karakter.',
            
            // Izin Lingkungan
            'izin_lingkungan.string' => 'Data izin lingkungan harus berupa teks.',
            'izin_lingkungan.max' => 'Data izin lingkungan maksimal :max karakter.',
            
            // Status Kesesuaian
            'status_kesesuaian.required' => 'Status kesesuaian wajib dipilih.',
            'status_kesesuaian.in' => 'Pilihan status tidak valid. Pilih: sesuai atau tidak_sesuai.',
            
            // Catatan
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan maksimal :max karakter.',
        ];
    }

    /**
     * Aturan validasi untuk store & update (tanpa pupuk, jenis_tanaman, jumlah_tanaman)
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        return [
            'tanggal_reklamasi' => 'required|date|before_or_equal:today',
            'lokasi_reklamasi' => 'required|string|max:255',
            'luas_direklamasi' => 'required|numeric|min:0',
            'jenis_kegiatan' => 'required|string|max:255',
            'metode_reklamasi' => 'required|string|max:255',
            'alat_berat_digunakan' => 'nullable|string|max:500',
            'izin_lingkungan' => 'nullable|string|max:255',
            'status_kesesuaian' => 'required|in:sesuai,tidak_sesuai',
            'catatan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Tampilkan daftar data reklamasi
     */
    public function index(Request $request)
    {
        $query = Reklamasi::query();

        if ($request->filled('search')) {
            $query->where('lokasi_reklamasi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_kesesuaian', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_reklamasi', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_reklamasi', '<=', $request->tanggal_sampai);
        }

        $reklamasiData = $query->orderBy('tanggal_reklamasi', 'desc')->paginate(10);

        return view('reklamasi.index', compact('reklamasiData'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        return view('reklamasi.create');
    }

    /**
     * Simpan data reklamasi
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate(
                $this->validationRules(),
                $this->validationMessages()
            );

            Reklamasi::create([
                ...$validated,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('reklamasi')
                ->with('success', '✅ Data reklamasi berhasil disimpan.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal store reklamasi', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error store reklamasi', [
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
        $data = Reklamasi::findOrFail($id);
        return view('reklamasi.edit', compact('data'));
    }

    /**
     * Perbarui data
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Reklamasi::findOrFail($id);

            $validated = $request->validate(
                $this->validationRules(true),
                $this->validationMessages()
            );

            $data->update([
                ...$validated,
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('reklamasi')
                ->with('success', '✅ Data reklamasi berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal update reklamasi', [
                'id' => $id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error update reklamasi', [
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
            $data = Reklamasi::findOrFail($id);
            $lokasi = $data->lokasi_reklamasi;
            
            $data->delete();

            return redirect()
                ->route('reklamasi.index')
                ->with('success', "✅ Data reklamasi lokasi '{$lokasi}' berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Error delete reklamasi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Export data reklamasi ke Excel
     */
    public function export(Request $request)
    {
        try {
            $query = Reklamasi::query();

            if ($request->filled('search')) {
                $query->where('lokasi_reklamasi', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('status')) {
                $query->where('status_kesesuaian', $request->status);
            }
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal_reklamasi', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal_reklamasi', '<=', $request->tanggal_sampai);
            }

            return (new ReklamasiExport($query->get()))->download('reklamasi_export_' . date('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            Log::error('Error export reklamasi', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Gagal mengekspor data. Silakan coba lagi.');
        }
    }
}