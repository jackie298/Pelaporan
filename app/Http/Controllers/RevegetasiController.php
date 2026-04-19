<?php

namespace App\Http\Controllers;

use App\Models\Revegetasi;
use App\Exports\RevegetasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RevegetasiController extends Controller
{
    /**
     * Pesan error kustom untuk validasi
     */
    protected function validationMessages(): array
    {
        return [
            // Tanggal Monitoring
            'tanggal_monitoring.required' => 'Tanggal monitoring wajib diisi.',
            'tanggal_monitoring.date' => 'Format tanggal monitoring tidak valid.',
            'tanggal_monitoring.before_or_equal' => 'Tanggal monitoring tidak boleh melebihi hari ini.',
            
            // Lokasi Revegetasi
            'lokasi_revegetasi.required' => 'Lokasi revegetasi wajib diisi.',
            'lokasi_revegetasi.string' => 'Lokasi revegetasi harus berupa teks.',
            'lokasi_revegetasi.max' => 'Lokasi revegetasi maksimal :max karakter.',
            
            // Luas Area
            'luas_area.required' => 'Luas area wajib diisi.',
            'luas_area.numeric' => 'Luas area harus berupa angka.',
            'luas_area.min' => 'Luas area tidak boleh kurang dari :min.',
            
            // Jenis Vegetasi
            'jenis_vegetasi.required' => 'Jenis vegetasi wajib diisi.',
            'jenis_vegetasi.string' => 'Jenis vegetasi harus berupa teks.',
            'jenis_vegetasi.max' => 'Jenis vegetasi maksimal :max karakter.',
            
            // Jenis Tanaman
            'jenis_tanaman.string' => 'Jenis tanaman harus berupa teks.',
            'jenis_tanaman.max' => 'Jenis tanaman maksimal :max karakter.',
            
            // Jumlah Tanaman
            'jumlah_tanaman.integer' => 'Jumlah tanaman harus berupa angka bulat.',
            'jumlah_tanaman.min' => 'Jumlah tanaman tidak boleh kurang dari :min.',
            
            // Tingkat Keberhasilan
            'tingkat_keberhasilan.required' => 'Tingkat keberhasilan wajib dipilih.',
            'tingkat_keberhasilan.in' => 'Pilihan tingkat keberhasilan tidak valid. Pilih: rendah, sedang, atau tinggi.',
            
            // Kondisi Tanah
            'kondisi_tanah.string' => 'Kondisi tanah harus berupa teks.',
            'kondisi_tanah.max' => 'Kondisi tanah maksimal :max karakter.',
            
            // Metode Penanaman
            'metode_penanaman.string' => 'Metode penanaman harus berupa teks.',
            'metode_penanaman.max' => 'Metode penanaman maksimal :max karakter.',
            
            // Catatan
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan maksimal :max karakter.',
        ];
    }

    /**
     * Aturan validasi untuk store & update
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        return [
            'tanggal_monitoring' => 'required|date|before_or_equal:today',
            'lokasi_revegetasi' => 'required|string|max:255',
            'luas_area' => 'required|numeric|min:0',
            'jenis_vegetasi' => 'required|string|max:255',
            'jenis_tanaman' => 'nullable|string|max:255',
            'jumlah_tanaman' => 'nullable|integer|min:0',
            'tingkat_keberhasilan' => 'required|in:rendah,sedang,tinggi',
            'kondisi_tanah' => 'nullable|string|max:255',
            'metode_penanaman' => 'nullable|string|max:255',
            'catatan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Tampilkan daftar data revegetasi
     */
    public function index(Request $request)
    {
        $query = Revegetasi::query();

        // 1. Filter Pencarian (Lokasi)
        if ($request->filled('search')) {
            $query->where('lokasi_revegetasi', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Tingkat Keberhasilan
        if ($request->filled('keberhasilan')) {
            $query->where('tingkat_keberhasilan', $request->keberhasilan);
        }

        // 3. Filter Tanggal (Range)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_monitoring', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_monitoring', '<=', $request->tanggal_sampai);
        }

        // Pagination: 10 data per halaman, urut terbaru
        $revegetasiData = $query->orderBy('tanggal_monitoring', 'desc')->paginate(10);

        return view('revegetasi.index', compact('revegetasiData'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        return view('revegetasi.create');
    }

    /**
     * Simpan data revegetasi
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
            Revegetasi::create([
                ...$validated,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('revegetasi')
                ->with('success', '✅ Data revegetasi berhasil disimpan.');

        } catch (ValidationException $e) {
            // Log error validasi untuk debugging
            Log::warning('Validasi gagal store revegetasi', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e; // Laravel akan handle redirect + error otomatis
        } catch (\Exception $e) {
            Log::error('Error store revegetasi', [
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
        $data = Revegetasi::findOrFail($id);
        return view('revegetasi.edit', compact('data'));
    }

    /**
     * Perbarui data
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Revegetasi::findOrFail($id);

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
                ->route('revegetasi')
                ->with('success', '✅ Data revegetasi berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal update revegetasi', [
                'id' => $id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error update revegetasi', [
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
            $data = Revegetasi::findOrFail($id);
            $lokasi = $data->lokasi_revegetasi;
            
            $data->delete();

            return redirect()
                ->route('revegetasi')
                ->with('success', "✅ Data revegetasi lokasi '{$lokasi}' berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Error delete revegetasi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Export data revegetasi ke Excel
     */
    public function export(Request $request)
    {
        try {
            // Terapkan filter yang sama dengan index untuk export
            $query = Revegetasi::query();

            if ($request->filled('search')) {
                $query->where('lokasi_revegetasi', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('keberhasilan')) {
                $query->where('tingkat_keberhasilan', $request->keberhasilan);
            }
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal_monitoring', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal_monitoring', '<=', $request->tanggal_sampai);
            }

            return (new RevegetasiExport($query->get()))->download('revegetasi_export_' . date('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            Log::error('Error export revegetasi', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Gagal mengekspor data. Silakan coba lagi.');
        }
    }
}