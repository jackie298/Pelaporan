<?php

namespace App\Http\Controllers;

use App\Models\Nursery;
use App\Exports\NurseryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class NurseryController extends Controller
{
    /**
     * Pesan error kustom untuk validasi
     */
    protected function validationMessages(): array
    {
        return [
            // Jenis Tanaman
            'jenis_tanaman.required' => 'Jenis tanaman wajib diisi.',
            'jenis_tanaman.string' => 'Jenis tanaman harus berupa teks.',
            'jenis_tanaman.max' => 'Jenis tanaman maksimal :max karakter.',
            
            // Jumlah Bibit
            'jumlah_bibit.required' => 'Jumlah bibit wajib diisi.',
            'jumlah_bibit.integer' => 'Jumlah bibit harus berupa angka bulat.',
            'jumlah_bibit.min' => 'Jumlah bibit minimal :min.',
            
            // Tanggal Penyemaian
            'tanggal_penyemaian.required' => 'Tanggal penyemaian wajib diisi.',
            'tanggal_penyemaian.date' => 'Format tanggal penyemaian tidak valid.',
            'tanggal_penyemaian.before_or_equal' => 'Tanggal penyemaian tidak boleh melebihi hari ini.',
            
            // Lokasi Pembibitan
            'lokasi_pembibitan.required' => 'Lokasi pembibitan wajib diisi.',
            'lokasi_pembibitan.string' => 'Lokasi pembibitan harus berupa teks.',
            'lokasi_pembibitan.max' => 'Lokasi pembibitan maksimal :max karakter.',
            
            // Status Pertumbuhan
            'status_pertumbuhan.required' => 'Status pertumbuhan wajib dipilih.',
            'status_pertumbuhan.in' => 'Pilihan status tidak valid. Pilih: bagus, sedang, atau buruk.',
            
            // Persentase Keberhasilan
            'persentase_keberhasilan.numeric' => 'Persentase keberhasilan harus berupa angka.',
            'persentase_keberhasilan.min' => 'Persentase tidak boleh kurang dari :min.',
            'persentase_keberhasilan.max' => 'Persentase tidak boleh lebih dari :max.',
            
            // Estimasi Siap Tanam
            'estimasi_siap_tanam.date' => 'Format tanggal estimasi tidak valid.',
            'estimasi_siap_tanam.after_or_equal' => 'Estimasi siap tanam tidak boleh sebelum tanggal penyemaian.',
            
            // Catatan
            'catatan.string' => 'Catatan harus berupa teks.',
        ];
    }

    /**
     * Aturan validasi untuk store & update
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        return [
            'jenis_tanaman' => 'required|string|max:255',
            'jumlah_bibit' => 'required|integer|min:1',
            'tanggal_penyemaian' => 'required|date|before_or_equal:today',
            'lokasi_pembibitan' => 'required|string|max:255',
            'status_pertumbuhan' => 'required|in:bagus,sedang,buruk',
            'persentase_keberhasilan' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
            'estimasi_siap_tanam' => 'nullable|date|after_or_equal:tanggal_penyemaian',
        ];
    }

    /**
     * Tampilkan daftar data pembibitan
     */
    public function index(Request $request)
    {
        $query = Nursery::with('creator');

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('jenis_tanaman', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi_pembibitan', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status_pertumbuhan', $request->status);
        }

        // Pagination: 10 data per halaman, urut terbaru
        $nurseryData = $query->latest()->paginate(10);

        return view('nursery.index', compact('nurseryData'));
    }

    /**
     * Tampilkan form tambah data pembibitan
     */
    public function create()
    {
        return view('nursery.create');
    }

    /**
     * Simpan data pembibitan
     */
    public function store(Request $request)
    {
        try {
            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(),
                $this->validationMessages()
            );

            Nursery::create([
                ...$validated,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('nursery')
                ->with('success', '✅ Data pembibitan berhasil disimpan.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal store nursery', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error store nursery', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan form edit data pembibitan
     */
    public function edit($id)
    {
        $data = Nursery::findOrFail($id);
        return view('nursery.edit', compact('data'));
    }

    /**
     * Perbarui data pembibitan
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Nursery::findOrFail($id);

            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(true),
                $this->validationMessages()
            );

            $data->update([
                ...$validated,
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('nursery')
                ->with('success', '✅ Data pembibitan berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal update nursery', [
                'id' => $id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error update nursery', [
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
     * Hapus data pembibitan (soft delete)
     */
    public function destroy($id)
    {
        try {
            $data = Nursery::findOrFail($id);
            $jenis = $data->jenis_tanaman;
            
            $data->delete();

            return redirect()
                ->route('nursery')
                ->with('success', "✅ Data pembibitan '{$jenis}' berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Error delete nursery', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Export data pembibitan ke Excel
     */
    public function export(Request $request)
    {
        try {
            // Terapkan filter yang sama dengan index untuk export
            $query = Nursery::query();

            if ($request->filled('search')) {
                $query->where('jenis_tanaman', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('status')) {
                $query->where('status_pertumbuhan', $request->status);
            }

            return (new NurseryExport($query->get()))->download('nursery_export_' . date('Y-m-d') . '.xlsx');

        } catch (\Exception $e) {
            Log::error('Error export nursery', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Gagal mengekspor data. Silakan coba lagi.');
        }
    }
}