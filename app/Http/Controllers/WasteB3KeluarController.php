<?php

namespace App\Http\Controllers;

use App\Models\WasteB3Masuk;
use App\Models\WasteB3Keluar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WasteB3KeluarController extends Controller
{
    /**
     * Tampilkan daftar data limbah B3 keluar
     */
    public function index(Request $request)
    {
        // Filter berdasarkan limbah masuk ID (jika ada)
        $masukId = $request->get('masuk_id');
        $tujuanFilter = $request->get('tujuan');
        $tanggalDari = $request->get('tanggal_dari');
        $tanggalSampai = $request->get('tanggal_sampai');

        $query = WasteB3Keluar::with('limbahMasuk');

        // Apply filters
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

        // Ambil data limbah masuk untuk dropdown filter
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
     * Tampilkan form tambah data
     */
    public function create1(Request $request)
    {
        // ✅ INISIALISASI VARIABEL DI LUAR BLOK IF-ELSE
        $masukId = $request->get('masuk_id');
        $limbahMasuk = null;
        $limbahMasukOptions = collect(); // ✅ Default: collection kosong

        if ($masukId) {
            // ✅ Cari limbah masuk dengan ID yang dipilih
            $limbahMasuk = WasteB3Masuk::with('pengeluaran')->find($masukId);
            
            // ✅ Validasi: Cek apakah limbah ditemukan
            if (!$limbahMasuk) {
                return redirect()
                    ->route('waste-b3.index')
                    ->with('error', 'Limbah B3 dengan ID ' . $masukId . ' tidak ditemukan');
            }
            
            // ✅ Validasi: Cek apakah masih bisa dikeluarkan
            if (!$limbahMasuk->can_be_dikeluarkan) {
                return redirect()
                    ->route('waste-b3.index')
                    ->with('error', 'Limbah ini tidak dapat dikeluarkan. Status: ' . $limbahMasuk->status_label);
            }
        } else {
            // ✅ Ambil data limbah yang masih bisa dikeluarkan (untuk dropdown)
            $limbahMasukOptions = WasteB3Masuk::where('status', '!=', 'sudah_dikeluarkan')
                ->where('jumlah_tersisa_ton', '>', 0)
                ->orderBy('tanggal_masuk', 'desc')
                ->get(['id', 'jenis_limbah', 'kode_limbah', 'jumlah_tersisa_ton', 'status']);
        }

        // ✅ RETURN VIEW DENGAN ARRAY ASOSIATIF (LEBIH AMAN)
        return view('waste-b3.keluar.create1', [
            'limbahMasuk' => $limbahMasuk,
            'limbahMasukOptions' => $limbahMasukOptions,
        ]);
    }
    /**
     * Tampilkan form tambah data
     */
    public function create(Request $request)
    {
        // ✅ INISIALISASI VARIABEL DI LUAR BLOK IF-ELSE
        $masukId = $request->get('masuk_id');
        $limbahMasuk = null;
        $limbahMasukOptions = collect(); // ✅ Default: collection kosong

        if ($masukId) {
            // ✅ Cari limbah masuk dengan ID yang dipilih
            $limbahMasuk = WasteB3Masuk::with('pengeluaran')->find($masukId);
            
            // ✅ Validasi: Cek apakah limbah ditemukan
            if (!$limbahMasuk) {
                return redirect()
                    ->route('waste-b3.index')
                    ->with('error', 'Limbah B3 dengan ID ' . $masukId . ' tidak ditemukan');
            }
            
            // ✅ Validasi: Cek apakah masih bisa dikeluarkan
            if (!$limbahMasuk->can_be_dikeluarkan) {
                return redirect()
                    ->route('waste-b3.index')
                    ->with('error', 'Limbah ini tidak dapat dikeluarkan. Status: ' . $limbahMasuk->status_label);
            }
        } else {
            // ✅ Ambil data limbah yang masih bisa dikeluarkan (untuk dropdown)
            $limbahMasukOptions = WasteB3Masuk::where('status', '!=', 'sudah_dikeluarkan')
                ->where('jumlah_tersisa_ton', '>', 0)
                ->orderBy('tanggal_masuk', 'desc')
                ->get(['id', 'jenis_limbah', 'kode_limbah', 'jumlah_tersisa_ton', 'status']);
        }

        // ✅ RETURN VIEW DENGAN ARRAY ASOSIATIF (LEBIH AMAN)
        return view('waste-b3.keluar.create', [
            'limbahMasuk' => $limbahMasuk,
            'limbahMasukOptions' => $limbahMasukOptions,
        ]);
}



    /**
     * Simpan data limbah B3 keluar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_b3_masuk_id' => 'required|exists:waste_b3_masuk,id',
            'tanggal_keluar' => 'required|date|before_or_equal:today',
            'jumlah_keluar_ton' => 'required|numeric|min:0.01|max:999999.99',
            'tujuan_penyerahan' => 'required|string|max:200',
            'nomor_dokumen_keluar' => 'required|string|max:100',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'catatan' => 'nullable|string|max:500',
        ], [
            'waste_b3_masuk_id.required' => 'Limbah masuk harus dipilih',
            'waste_b3_masuk_id.exists' => 'Limbah masuk tidak valid',
            'tanggal_keluar.required' => 'Tanggal keluar harus diisi',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
            'tanggal_keluar.before_or_equal' => 'Tanggal tidak boleh di masa depan',
            'jumlah_keluar_ton.required' => 'Jumlah keluar harus diisi',
            'jumlah_keluar_ton.numeric' => 'Jumlah keluar harus berupa angka',
            'jumlah_keluar_ton.min' => 'Jumlah keluar minimal 0.01',
            'jumlah_keluar_ton.max' => 'Jumlah keluar maksimal 999.999,99 ton',
            'tujuan_penyerahan.required' => 'Tujuan penyerahan harus diisi',
            'tujuan_penyerahan.string' => 'Tujuan penyerahan harus berupa teks',
            'tujuan_penyerahan.max' => 'Tujuan penyerahan maksimal 200 karakter',
            'nomor_dokumen_keluar.required' => 'Nomor dokumen harus diisi',
            'nomor_dokumen_keluar.string' => 'Nomor dokumen harus berupa teks',
            'nomor_dokumen_keluar.max' => 'Nomor dokumen maksimal 100 karakter',
            'file_dokumen.file' => 'File dokumen harus berupa file',
            'file_dokumen.mimes' => 'File dokumen harus berformat PDF, JPG, JPEG, atau PNG',
            'file_dokumen.max' => 'Ukuran file dokumen maksimal 5MB',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        // Cek apakah limbah masuk masih bisa dikeluarkan
        $limbahMasuk = WasteB3Masuk::findOrFail($validated['waste_b3_masuk_id']);
        
        if (!$limbahMasuk->can_be_dikeluarkan) {
            return back()
                ->withErrors([
                    'waste_b3_masuk_id' => 'Limbah ini tidak dapat dikeluarkan. Status: ' . $limbahMasuk->status_label
                ])
                ->withInput();
        }

        // Validasi: Jumlah keluar tidak boleh melebihi sisa limbah
        if ($validated['jumlah_keluar_ton'] > $limbahMasuk->sisa_limbah) {
            return back()
                ->withErrors([
                    'jumlah_keluar_ton' => 'Jumlah keluar (' . number_format($validated['jumlah_keluar_ton'], 2) . ' ton) melebihi sisa limbah (' . number_format($limbahMasuk->sisa_limbah, 2) . ' ton)'
                ])
                ->withInput();
        }

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = 'waste-b3/' . date('Y-m-d') . '/' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public', $filename);
            $validated['file_dokumen'] = str_replace('public/', '', $path);
        }

        // Simpan data
        DB::transaction(function () use ($validated) {
            WasteB3Keluar::create($validated);
        });

        return redirect()
            ->route('waste-b3-keluar')
            ->with('success', 'Data limbah B3 keluar berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $data = WasteB3Keluar::with('limbahMasuk')->findOrFail($id);
        
        // Ambil data limbah masuk untuk referensi
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
            'jumlah_keluar_ton' => 'required|numeric|min:0.01|max:999999.99',
            'tujuan_penyerahan' => 'required|string|max:200',
            'nomor_dokumen_keluar' => 'required|string|max:100',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Validasi jumlah keluar
        $perubahanJumlah = $validated['jumlah_keluar_ton'] - $data->jumlah_keluar_ton;
        
        if ($perubahanJumlah > 0 && $perubahanJumlah > $limbahMasukAwal->sisa_limbah) {
            return back()->withErrors([
                'jumlah_keluar_ton' => 'Jumlah keluar melebihi sisa limbah yang tersedia'
            ])->withInput();
        }

        // Handle file upload (replace file lama)
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($data->file_dokumen && Storage::disk('public')->exists($data->file_dokumen)) {
                Storage::disk('public')->delete($data->file_dokumen);
            }

            $file = $request->file('file_dokumen');
            $filename = 'waste-b3/' . now()->format('Y-m-d') . '/' . time() . '_' . 
                        Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . 
                        '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public', $filename);
            $validated['file_dokumen'] = str_replace('public/', '', $path);
        }

        DB::transaction(function () use ($data, $validated, $limbahMasukAwal, $perubahanJumlah) {
            // Update stok limbah masuk
            if ($perubahanJumlah != 0) {
                $limbahMasukAwal->update([
                    'jumlah_tersisa_ton' => $limbahMasukAwal->jumlah_tersisa_ton - $perubahanJumlah
                ]);
            }
            
            // Update data pengeluaran
            $data->update($validated);
        });

        return redirect()
            ->route('waste-b3-keluar')
            ->with('success', 'Data limbah B3 keluar berhasil diperbarui.');
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        $data = WasteB3Keluar::with('limbahMasuk')->findOrFail($id);

        // Hapus file dokumen jika ada
        if ($data->file_dokumen && Storage::disk('public')->exists($data->file_dokumen)) {
            Storage::disk('public')->delete($data->file_dokumen);
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
     * Download file dokumen
     */
    public function downloadDokumen($id)
    {
        $data = WasteB3Keluar::findOrFail($id);
        
        if (!$data->file_dokumen || !Storage::disk('public')->exists($data->file_dokumen)) {
            abort(404, 'File dokumen tidak ditemukan');
        }
        
        $filePath = Storage::disk('public')->path($data->file_dokumen);
        
        return response()->download($filePath, basename($data->file_dokumen));
    }

    /**
     * Preview file dokumen (untuk PDF/Image)
     */
    // public function previewDokumen($id)
    // {
    //     $data = WasteB3Keluar::findOrFail($id);
        
    //     if (!$data->file_dokumen || !Storage::disk('public')->exists($data->file_dokumen)) {
    //         abort(404, 'File dokumen tidak ditemukan');
    //     }
        
    //     $filePath = Storage::disk('public')->path($data->file_dokumen);
    //     $mimeType = Storage::disk('public')->mimeType($data->file_dokumen);
        
    //     return response()->file($filePath, [
    //         'Content-Type' => $mimeType,
    //         'Content-Disposition' => 'inline; filename="' . basename($data->file_dokumen) . '"'
    //     ]);
    // }
}