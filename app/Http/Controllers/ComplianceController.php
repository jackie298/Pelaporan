<?php

namespace App\Http\Controllers;

use App\Models\Compliance;
use App\Exports\ComplianceExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ComplianceController extends Controller
{
    /**
     * Pesan error kustom untuk validasi
     */
    protected function validationMessages(): array
    {
        return [
            // Nama Pelapor
            'Nama_pelapor.required' => 'Nama pelapor wajib diisi.',
            'Nama_pelapor.string' => 'Nama pelapor harus berupa teks.',
            'Nama_pelapor.max' => 'Nama pelapor maksimal :max karakter.',
            
            // Departemen
            'Departemen.required' => 'Departemen wajib dipilih.',
            'Departemen.in' => 'Pilihan departemen tidak valid. Pilih: HSE, Produksi, HRD, Maintenance, atau Lainnya.',
            
            // Lokasi
            'Lokasi.required' => 'Lokasi wajib diisi.',
            'Lokasi.string' => 'Lokasi harus berupa teks.',
            'Lokasi.max' => 'Lokasi maksimal :max karakter.',
            
            // Jenis Insiden
            'Jenis_insiden.required' => 'Jenis insiden wajib diisi.',
            'Jenis_insiden.string' => 'Jenis insiden harus berupa teks.',
            'Jenis_insiden.max' => 'Jenis insiden maksimal :max karakter.',
            
            // Jenis Inspeksi
            'Jenis_inspeksi.required' => 'Jenis inspeksi wajib dipilih.',
            'Jenis_inspeksi.in' => 'Pilihan jenis inspeksi tidak valid. Pilih: Internal, Eksternal/Regulasi, atau Audit.',
            
            // Tanggal Lapor
            'Tanggal_lapor.required' => 'Tanggal pelaporan wajib diisi.',
            'Tanggal_lapor.date' => 'Format tanggal tidak valid.',
            'Tanggal_lapor.before_or_equal' => 'Tanggal pelaporan tidak boleh melebihi hari ini.',
            
            // Status
            'Status.required' => 'Status wajib dipilih.',
            'Status.in' => 'Pilihan status tidak valid. Pilih: Escalated, Pending, Resolved, atau Open.',
            
            // Tingkat Keparahan
            'Tingkat_keparahan.required' => 'Tingkat keparahan wajib dipilih.',
            'Tingkat_keparahan.in' => 'Pilihan tingkat keparahan tidak valid. Pilih: Low, Medium, High, atau Critical.',
            
            // Diselesaikan Oleh
            'Diselesaikan_oleh.required' => 'Nama penanggung jawab wajib diisi.',
            'Diselesaikan_oleh.string' => 'Nama penanggung jawab harus berupa teks.',
            'Diselesaikan_oleh.max' => 'Nama penanggung jawab maksimal :max karakter.',
            
            // File Dokumentasi
            'file_dokumentasi.array' => 'File dokumentasi harus berupa array.',
            'file_dokumentasi.max' => 'Maksimal :max file yang dapat diunggah.',
            'file_dokumentasi.*.file' => 'File harus berupa dokumen yang valid.',
            'file_dokumentasi.*.mimes' => 'Format file hanya diperbolehkan: jpg, jpeg, png, pdf.',
            'file_dokumentasi.*.max' => 'Ukuran file maksimal :max KB.',
        ];
    }

    /**
     * Aturan validasi untuk store & update
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        return [
            'Nama_pelapor' => 'required|string|max:255',
            'Departemen' => 'required|in:HSE,Produksi,HRD,Maintenance,Lainnya',
            'Lokasi' => 'required|string|max:255',
            'Jenis_insiden' => 'required|string|max:255',
            'Jenis_inspeksi' => 'required|in:Internal,"Eksternal/Regulasi",Audit',
            'Tanggal_lapor' => 'required|date|before_or_equal:today',
            'Status' => 'required|in:Escalated,Pending,Resolved,Open',
            'Tingkat_keparahan' => 'required|in:Low,Medium,High,Critical',
            'Diselesaikan_oleh' => 'required|string|max:255',
            'file_dokumentasi' => 'nullable|array|max:10',
            'file_dokumentasi.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    /**
     * Tampilkan daftar data compliance
     */
    public function index(Request $request)
    {
        $query = Compliance::query();

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Nama_pelapor', 'like', '%' . $request->search . '%')
                  ->orWhere('Lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('Jenis_insiden', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Departemen
        if ($request->filled('departemen')) {
            $query->where('Departemen', $request->departemen);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        // Filter Tanggal (Range)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('Tanggal_lapor', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('Tanggal_lapor', '<=', $request->tanggal_sampai);
        }

        // Pagination: 10 data per halaman, urut terbaru
        $compliances = $query->latest()->paginate(10);

        return view('compliance.index', compact('compliances'));
    }

    /**
     * Tampilkan form tambah data compliance
     */
    public function create()
    {
        return view('compliance.create');
    }

    /**
     * Simpan data compliance
     */
    public function store(Request $request)
    {
        try {
            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(),
                $this->validationMessages()
            );

            // Handle file upload
            $filePaths = [];
            if ($request->hasFile('file_dokumentasi')) {
                foreach ($request->file('file_dokumentasi') as $file) {
                    $path = $file->store('compliance', 'public');
                    $filePaths[] = $path;
                }
            }

            Compliance::create([
                ...$validated,
                'file_dokumentasi' => $filePaths,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('compliance')
                ->with('success', '✅ Dokumen Inspeksi berhasil disimpan.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal store Inspeksi', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error store Isnpeksi', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()
                ->withInput()
                ->with('error', '❌ Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan form edit data compliance
     */
    public function edit($id)
    {
        $data = Compliance::findOrFail($id);
        return view('compliance.edit', compact('data'));
    }

    /**
     * Perbarui data compliance
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Compliance::findOrFail($id);

            // Validasi dengan pesan kustom
            $validated = $request->validate(
                $this->validationRules(true),
                $this->validationMessages()
            );

            // Handle file upload (replace old files)
            $filePaths = $data->file_dokumentasi ?? [];
            
            if ($request->hasFile('file_dokumentasi')) {
                // Hapus file lama dari storage
                if (is_array($filePaths) && !empty($filePaths)) {
                    foreach ($filePaths as $oldFile) {
                        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                            Storage::disk('public')->delete($oldFile);
                        }
                    }
                }
                
                // Simpan file baru
                $filePaths = [];
                foreach ($request->file('file_dokumentasi') as $file) {
                    $path = $file->store('compliance', 'public');
                    $filePaths[] = $path;
                }
            }

            $data->update([
                ...$validated,
                'file_dokumentasi' => $filePaths,
                'updated_by' => Auth::id(),
            ]);

            return redirect()
                ->route('compliance')
                ->with('success', '✅ Dokumen Inspeksi berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal update Inspeksi', [
                'id' => $id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error update Inspeksi', [
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
     * Hapus data compliance (soft delete)
     */
    public function destroy($id)
    {
        try {
            $data = Compliance::findOrFail($id);
            
            // Hapus file dari storage sebelum soft delete
            if (!empty($data->file_dokumentasi) && is_array($data->file_dokumentasi)) {
                foreach ($data->file_dokumentasi as $file) {
                    if ($file && Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            
            $data->delete();

            return redirect()
                ->route('compliance')
                ->with('success', "✅ Dokumen Inspeksi berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Error delete Inspeksi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Download file dokumentasi
     */
    public function download($id, $filename)
    {
        try {
            $data = Compliance::findOrFail($id);
            $filePath = 'public/' . $filename;
            
            if (!Storage::exists($filePath)) {
                return back()->with('error', '❌ File tidak ditemukan.');
            }
            
            return Storage::download($filePath);
            
        } catch (\Exception $e) {
            Log::error('Error download file Inspeksi', [
                'id' => $id,
                'filename' => $filename,
                'message' => $e->getMessage(),
            ]);
            return back()->with('error', '❌ Gagal mengunduh file.');
        }
    }

    /**
     * Export data compliance ke Excel
     */
    public function export(Request $request)
    {
        try {
            // Terapkan filter yang sama dengan index untuk export
            $query = Compliance::query();

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('Nama_pelapor', 'like', '%' . $request->search . '%')
                      ->orWhere('Lokasi', 'like', '%' . $request->search . '%')
                      ->orWhere('Jenis_insiden', 'like', '%' . $request->search . '%');
                });
            }
            if ($request->filled('departemen')) {
                $query->where('Departemen', $request->departemen);
            }
            if ($request->filled('status')) {
                $query->where('Status', $request->status);
            }
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('Tanggal_lapor', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('Tanggal_lapor', '<=', $request->tanggal_sampai);
            }

            return Excel::download(
                new ComplianceExport($query->get()), 
                'compliance_export_' . date('Y-m-d') . '.xlsx'
            );

        } catch (\Exception $e) {
            Log::error('Error export compliance', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', '❌ Gagal mengekspor data. Silakan coba lagi.');
        }
    }
}