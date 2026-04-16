<?php

namespace App\Http\Controllers;

use App\Models\WasteB3Masuk;
use App\Models\WasteB3Keluar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WasteB3KeluarController extends Controller
{
    /**
     * Tampilkan daftar data limbah B3 keluar
     */
    public function index(Request $request)
    {
        $masukId = $request->get('masuk_id');
        $tujuanFilter = $request->get('tujuan');
        $tanggalDari = $request->get('tanggal_dari');
        $tanggalSampai = $request->get('tanggal_sampai');

        $query = WasteB3Keluar::with('limbahMasuk');

        if ($masukId) {
            $query->limbahMasuk($masukId);
        }
        if ($tujuanFilter) {
            $query->tujuanPenyerahan($tujuanFilter);
        }
        if ($tanggalDari && $tanggalSampai) {
            $query->tanggalKeluarAntara($tanggalDari, $tanggalSampai);
        } elseif ($tanggalDari) {
            $query->where('tanggal_keluar', '>=', $tanggalDari);
        } elseif ($tanggalSampai) {
            $query->where('tanggal_keluar', '<=', $tanggalSampai);
        }

        $wasteB3Keluar = $query->latest()->paginate(15);

        $limbahMasukOptions = WasteB3Masuk::where('status', '!=', 'sudah_dikeluarkan')
            ->orderBy('tanggal_masuk', 'desc')
            ->get(['id', 'jenis_limbah', 'kode_limbah']);

        return view('waste-b3.keluar.index', compact(
            'wasteB3Keluar',
            'limbahMasukOptions',
            'masukId',
            'tujuanFilter',
            'tanggalDari',
            'tanggalSampai'
        ));
    }

    /**
     * ✅ CREATE1: Form cepat dengan limbah sudah dipilih (via URL ?masuk_id=X)
     */
    public function create1(Request $request)
    {
        $masukId = $request->get('masuk_id');
        
        if (!$masukId) {
            return redirect()->route('waste-b3-keluar.create')
                ->with('info', 'Silakan pilih limbah yang akan dikeluarkan.');
        }

        $limbahMasuk = WasteB3Masuk::with('pengeluaran')->find($masukId);
        
        if (!$limbahMasuk) {
            return redirect()->route('waste-b3.index')
                ->with('error', 'Limbah B3 dengan ID ' . $masukId . ' tidak ditemukan.');
        }
        
        if (!$limbahMasuk->can_be_dikeluarkan) {
            return redirect()->route('waste-b3.index')
                ->with('error', 'Limbah ini tidak dapat dikeluarkan. Status: ' . $limbahMasuk->status_label);
        }

        return view('waste-b3.keluar.create1', [
            'limbahMasuk' => $limbahMasuk,
            'limbahMasukOptions' => collect([$limbahMasuk]),
            'isPreselected' => true,
        ]);
    }

    /**
     * ✅ CREATE: Form standar dengan dropdown pilihan limbah
     */
    public function create(Request $request)
    {
        $masukId = $request->get('masuk_id');
        $limbahMasuk = null;
        $limbahMasukOptions = collect();

        if ($masukId) {
            $limbahMasuk = WasteB3Masuk::with('pengeluaran')->find($masukId);
            
            if ($limbahMasuk && $limbahMasuk->can_be_dikeluarkan) {
                $limbahMasukOptions = collect([$limbahMasuk]);
            } else {
                $limbahMasuk = null;
                $limbahMasukOptions = $this->getAvailableWasteOptions();
            }
        } else {
            $limbahMasukOptions = $this->getAvailableWasteOptions();
        }

        return view('waste-b3.keluar.create', [
            'limbahMasuk' => $limbahMasuk,
            'limbahMasukOptions' => $limbahMasukOptions,
            'isPreselected' => false,
        ]);
    }

    /**
     * Helper: Ambil opsi limbah yang tersedia untuk dropdown
     */
    private function getAvailableWasteOptions()
    {
        return WasteB3Masuk::where('status', '!=', 'sudah_dikeluarkan')
            ->where('jumlah_tersisa_ton', '>', 0)
            ->orderBy('tanggal_masuk', 'desc')
            ->get(['id', 'jenis_limbah', 'kode_limbah', 'jumlah_tersisa_ton', 'status']);
    }

    /**
     * Simpan data limbah B3 keluar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_b3_masuk_id' => 'required|exists:waste_b3_masuk,id',
            'tanggal_keluar' => 'required|date|before_or_equal:today',
            'jumlah_keluar_ton' => 'required|numeric|min:0.001|max:999999.999',
            'tujuan_penyerahan' => 'required|string|max:200',
            'nomor_dokumen_keluar' => 'required|string|max:100',
            'berita_acara' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'catatan' => 'nullable|string|max:500',
        ], [
            'waste_b3_masuk_id.required' => 'Limbah masuk harus dipilih',
            'waste_b3_masuk_id.exists' => 'Limbah masuk tidak valid',
            'tanggal_keluar.required' => 'Tanggal keluar harus diisi',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
            'tanggal_keluar.before_or_equal' => 'Tanggal tidak boleh di masa depan',
            'jumlah_keluar_ton.required' => 'Jumlah keluar harus diisi',
            'jumlah_keluar_ton.numeric' => 'Jumlah keluar harus berupa angka',
            'jumlah_keluar_ton.min' => 'Jumlah keluar minimal 0.001',
            'jumlah_keluar_ton.max' => 'Jumlah keluar maksimal 999.999,999 ton',
            'tujuan_penyerahan.required' => 'Tujuan penyerahan harus diisi',
            'tujuan_penyerahan.string' => 'Tujuan penyerahan harus berupa teks',
            'tujuan_penyerahan.max' => 'Tujuan penyerahan maksimal 200 karakter',
            'nomor_dokumen_keluar.required' => 'Nomor dokumen harus diisi',
            'nomor_dokumen_keluar.string' => 'Nomor dokumen harus berupa teks',
            'nomor_dokumen_keluar.max' => 'Nomor dokumen maksimal 100 karakter',
            'berita_acara.file' => 'Berita acara harus berupa file',
            'berita_acara.mimes' => 'Format berita acara harus: pdf, jpg, jpeg, png',
            'berita_acara.max' => 'Ukuran file berita acara maksimal 10MB',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        $limbahMasuk = WasteB3Masuk::findOrFail($validated['waste_b3_masuk_id']);
        
        if (!$limbahMasuk->can_be_dikeluarkan) {
            return back()
                ->withErrors([
                    'waste_b3_masuk_id' => 'Limbah ini tidak dapat dikeluarkan. Status: ' . $limbahMasuk->status_label
                ])
                ->withInput();
        }

        // Validasi: Jumlah keluar tidak boleh melebihi sisa limbah
        if ((float)$validated['jumlah_keluar_ton'] > (float)$limbahMasuk->sisa_limbah) {
            return back()
                ->withErrors([
                    'jumlah_keluar_ton' => 'Jumlah keluar (' . number_format($validated['jumlah_keluar_ton'], 3, ',', '.') . ' ton) melebihi sisa limbah (' . number_format($limbahMasuk->sisa_limbah, 3, ',', '.') . ' ton)'
                ])
                ->withInput();
        }

        // ✅ Handle file upload SEBELUM transaksi (simpan nama file sementara)
        $uploadedFileName = null;
        if ($request->hasFile('berita_acara')) {
            $uploadedFileName = $this->handleBeritaAcaraUpload($request->file('berita_acara'));
            $validated['berita_acara'] = $uploadedFileName;
        }

        try {
            DB::transaction(function () use ($validated) {
                WasteB3Keluar::create($validated);
            });

            return redirect()
                ->route('waste-b3-keluar')
                ->with('success', 'Data limbah B3 keluar berhasil disimpan.');
                
        } catch (\Exception $e) {
            // ✅ ROLLBACK: Hapus file jika database gagal menyimpan
            if ($uploadedFileName) {
                $this->deleteBeritaAcaraFile($uploadedFileName);
                Log::warning('File deleted due to transaction failure', ['filename' => $uploadedFileName]);
            }

            Log::error('WasteB3Keluar store failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withErrors(['system' => 'Gagal menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $data = WasteB3Keluar::with('limbahMasuk')->findOrFail($id);
        $limbahMasuk = $data->limbahMasuk;

        return view('waste-b3.keluar.edit', compact('data', 'limbahMasuk'));
    }

    /**
     * Perbarui data limbah B3 keluar
     */
    public function update(Request $request, $id)
    {
        $data = WasteB3Keluar::with('limbahMasuk')->findOrFail($id);
        $limbahMasukAwal = $data->limbahMasuk;

        $validated = $request->validate([
            'waste_b3_masuk_id' => 'required|exists:waste_b3_masuk,id',
            'tanggal_keluar' => 'required|date|before_or_equal:today',
            'jumlah_keluar_ton' => 'required|numeric|min:0.001|max:999999.999',
            'tujuan_penyerahan' => 'required|string|max:200',
            'nomor_dokumen_keluar' => 'required|string|max:100',
            'berita_acara' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'catatan' => 'nullable|string|max:500',
        ], [
            // ✅ Lengkap seperti di store()
            'waste_b3_masuk_id.required' => 'Limbah masuk harus dipilih',
            'waste_b3_masuk_id.exists' => 'Limbah masuk tidak valid',
            'tanggal_keluar.required' => 'Tanggal keluar harus diisi',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
            'tanggal_keluar.before_or_equal' => 'Tanggal tidak boleh di masa depan',
            'jumlah_keluar_ton.required' => 'Jumlah keluar harus diisi',
            'jumlah_keluar_ton.numeric' => 'Jumlah keluar harus berupa angka',
            'jumlah_keluar_ton.min' => 'Jumlah keluar minimal 0.001',
            'jumlah_keluar_ton.max' => 'Jumlah keluar maksimal 999.999,999 ton',
            'tujuan_penyerahan.required' => 'Tujuan penyerahan harus diisi',
            'tujuan_penyerahan.string' => 'Tujuan penyerahan harus berupa teks',
            'tujuan_penyerahan.max' => 'Tujuan penyerahan maksimal 200 karakter',
            'nomor_dokumen_keluar.required' => 'Nomor dokumen harus diisi',
            'nomor_dokumen_keluar.string' => 'Nomor dokumen harus berupa teks',
            'nomor_dokumen_keluar.max' => 'Nomor dokumen maksimal 100 karakter',
            'berita_acara.file' => 'Berita acara harus berupa file',
            'berita_acara.mimes' => 'Format berita acara harus: pdf, jpg, jpeg, png',
            'berita_acara.max' => 'Ukuran file berita acara maksimal 10MB',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        // Validasi perubahan jumlah
        $perubahanJumlah = (float)$validated['jumlah_keluar_ton'] - (float)$data->jumlah_keluar_ton;
        
        if ($perubahanJumlah > 0 && $perubahanJumlah > $limbahMasukAwal->sisa_limbah) {
            return back()->withErrors([
                'jumlah_keluar_ton' => 'Jumlah keluar melebihi sisa limbah yang tersedia'
            ])->withInput();
        }

        // ✅ Handle file upload: berita_acara (update)
        $newFileName = null;
        $oldFileName = null;
        
        if ($request->hasFile('berita_acara')) {
            // Simpan nama file lama untuk dihapus nanti jika sukses
            if ($data->berita_acara) {
                $oldFileName = $data->berita_acara;
            }
            // Upload file baru
            $newFileName = $this->handleBeritaAcaraUpload($request->file('berita_acara'));
            $validated['berita_acara'] = $newFileName;
        }

        try {
            DB::transaction(function () use ($data, $validated, $limbahMasukAwal, $perubahanJumlah, $oldFileName) {
                // Update stok limbah masuk jika jumlah berubah
                if ($perubahanJumlah != 0) {
                    $limbahMasukAwal->update([
                        'jumlah_tersisa_ton' => $limbahMasukAwal->jumlah_tersisa_ton - $perubahanJumlah
                    ]);
                }
                
                // Update data pengeluaran
                $data->update($validated);
            });

            // ✅ Hapus file lama HANYA jika transaksi sukses
            if ($oldFileName && $newFileName) {
                $this->deleteBeritaAcaraFile($oldFileName);
            }

            return redirect()
                ->route('waste-b3-keluar')
                ->with('success', 'Data limbah B3 keluar berhasil diperbarui.');
                
        } catch (\Exception $e) {
            // ✅ ROLLBACK: Hapus file BARU jika transaksi gagal (file lama masih aman)
            if ($newFileName) {
                $this->deleteBeritaAcaraFile($newFileName);
                Log::warning('New file deleted due to transaction failure', ['filename' => $newFileName]);
            }

            Log::error('WasteB3Keluar update failed', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return back()
                ->withErrors(['system' => 'Gagal memperbarui data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        $data = WasteB3Keluar::with('limbahMasuk')->findOrFail($id);

        // ✅ Hapus file berita_acara jika ada
        if ($data->berita_acara) {
            $this->deleteBeritaAcaraFile($data->berita_acara);
        }

        $data->delete();

        return redirect()
            ->route('waste-b3-keluar')
            ->with('success', 'Data limbah B3 keluar berhasil dihapus.');
    }

    /**
     * Tampilkan detail data limbah B3 keluar
     */
    public function show($id)
    {
        $data = WasteB3Keluar::with('limbahMasuk')->findOrFail($id);
        return view('waste-b3.keluar.show', compact('data'));
    }

    /**
     * Download file berita acara
     */
    public function downloadBeritaAcara($id)
    {
        $data = WasteB3Keluar::findOrFail($id);
        
        if (!$data->berita_acara) {
            abort(404, 'File berita acara tidak ditemukan');
        }
        
        $filePath = Storage::path('public/waste-b3/berita-acara-keluar/' . $data->berita_acara);
        
        if (!Storage::exists('public/waste-b3/berita-acara-keluar/' . $data->berita_acara)) {
            abort(404, 'File berita acara tidak ditemukan di storage');
        }
        
        return response()->download($filePath, $data->berita_acara);
    }

    // ========================================
    // ✅ HELPER METHODS FOR FILE HANDLING
    // ========================================

    private function handleBeritaAcaraUpload($file)
    {
        $folder = 'public/waste-b3/berita-acara-keluar';
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $file->storeAs($folder, $filename);
        return $filename;
    }

    private function deleteBeritaAcaraFile($filename)
    {
        $path = 'public/waste-b3/berita-acara-keluar/' . $filename;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}