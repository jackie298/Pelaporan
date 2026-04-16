<?php

namespace App\Http\Controllers;

use App\Models\WasteB3Masuk;
use App\Models\WasteB3Keluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // ✅ Tambahkan ini

class WasteB3MasukController extends Controller
{
    /**
     * Tampilkan daftar data limbah B3 masuk
     */
    public function index(Request $request)
    {
        // Filter berdasarkan status
        $statusFilter = $request->get('status');
        $jenisFilter = $request->get('jenis');
        $sumberFilter = $request->get('sumber');
        $tanggalDari = $request->get('tanggal_dari');
        $tanggalSampai = $request->get('tanggal_sampai');

        $query = WasteB3Masuk::with('creator', 'pengeluaran');

        // Apply filters
        if ($statusFilter) {
            $query->status($statusFilter);
        }

        if ($jenisFilter) {
            $query->where('jenis_limbah', 'like', "%{$jenisFilter}%");
        }

        if ($sumberFilter) {
            $query->where('sumber_limbah', 'like', "%{$sumberFilter}%");
        }

        if ($tanggalDari && $tanggalSampai) {
            $query->tanggalMasukAntara($tanggalDari, $tanggalSampai);
        } elseif ($tanggalDari) {
            $query->where('tanggal_masuk', '>=', $tanggalDari);
        } elseif ($tanggalSampai) {
            $query->where('tanggal_masuk', '<=', $tanggalSampai);
        }

        $wasteB3Masuk = $query->latest()->paginate(15);

        $summaryStats = [
            'total' => WasteB3Masuk::count(),
            'belum_dikeluarkan' => WasteB3Masuk::where('status', 'belum_dikeluarkan')->count(),
            'kadaluarsa' => WasteB3Masuk::where('status', 'kadaluarsa')->count(),
            'total_ton' => WasteB3Masuk::sum('jumlah_ton'),
        ];
        
        // Options untuk filter dropdown status saja
        $statusOptions = WasteB3Masuk::STATUS_OPTIONS;

        return view('waste-b3.masuk.index', compact(
            'wasteB3Masuk', 
            'statusOptions',
            'statusFilter',
            'jenisFilter',
            'sumberFilter',
            'tanggalDari',
            'tanggalSampai',
            'summaryStats'
        ));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        $statusOptions = WasteB3Masuk::STATUS_OPTIONS;
        
        return view('waste-b3.masuk.create', compact('statusOptions'));
    }

    /**
     * Simpan data limbah B3 masuk
     */
    public function store(Request $request)
    {
        // 1. Ubah input kode_limbah menjadi uppercase di awal
        if ($request->has('kode_limbah')) {
            $request->merge([
                'kode_limbah' => strtoupper($request->kode_limbah)
            ]);
        }

        $validated = $request->validate([
            'jenis_limbah' => 'required|string|max:100',
            'kode_limbah' => 'required|string|max:50',
            'tanggal_masuk' => 'required|date|before_or_equal:today',
            'sumber_limbah' => 'required|string|max:100',
            'jumlah_ton' => 'required|numeric|min:0.001|max:999999.99',
            'maksimal_penyimpanan' => 'required|date|after:tanggal_masuk',
            'nomor_manifest' => 'nullable|string|max:100',
            'berita_acara' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // ✅ Validasi file (10MB)
            'catatan' => 'nullable|string|max:500',
        ], [
            'jenis_limbah.required' => 'Jenis limbah harus diisi',
            'jenis_limbah.string' => 'Jenis limbah harus berupa teks',
            'jenis_limbah.max' => 'Jenis limbah maksimal 100 karakter',
            'kode_limbah.required' => 'Kode limbah harus diisi',
            'kode_limbah.max' => 'Kode limbah maksimal 50 karakter',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
            'tanggal_masuk.before_or_equal' => 'Tanggal tidak boleh di masa depan',
            'sumber_limbah.required' => 'Sumber limbah harus diisi',
            'sumber_limbah.string' => 'Sumber limbah harus berupa teks',
            'sumber_limbah.max' => 'Sumber limbah maksimal 100 karakter',
            'jumlah_ton.required' => 'Jumlah ton harus diisi',
            'jumlah_ton.numeric' => 'Jumlah ton harus berupa angka',
            'jumlah_ton.min' => 'Jumlah ton minimal 0.001',
            'jumlah_ton.max' => 'Jumlah ton maksimal 999.999,99 ton',
            'maksimal_penyimpanan.required' => 'Tanggal maksimal penyimpanan harus diisi',
            'maksimal_penyimpanan.date' => 'Format tanggal tidak valid',
            'maksimal_penyimpanan.after' => 'Tanggal maksimal penyimpanan harus setelah tanggal masuk',
            'nomor_manifest.max' => 'Nomor manifest maksimal 100 karakter',
            'berita_acara.file' => 'Berita acara harus berupa file',
            'berita_acara.mimes' => 'Format file berita acara harus: pdf, jpg, jpeg, png',
            'berita_acara.max' => 'Ukuran file berita acara maksimal 10MB',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        $validated['created_by'] = Auth::id();

        // ✅ Handle upload file berita_acara
        if ($request->hasFile('berita_acara')) {
            $validated['berita_acara'] = $this->handleFileUpload($request->file('berita_acara'));
        }

        DB::transaction(function () use ($validated) {
            WasteB3Masuk::create($validated);
        });

        return redirect()
            ->route('waste-b3')
            ->with('success', 'Data limbah B3 masuk berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $data = WasteB3Masuk::with('pengeluaran')->findOrFail($id);
        $statusOptions = WasteB3Masuk::STATUS_OPTIONS;
        
        return view('waste-b3.masuk.edit', compact('data', 'statusOptions'));
    }

    /**
     * Perbarui data limbah B3 masuk
     */
    public function update(Request $request, $id)
    {
        $data = WasteB3Masuk::findOrFail($id);

        // 1. Ubah input menjadi uppercase
        if ($request->has('kode_limbah')) {
            $request->merge([
                'kode_limbah' => strtoupper($request->kode_limbah)
            ]);
        }

        $validated = $request->validate([
            'jenis_limbah' => 'required|string|max:100',
            'kode_limbah' => 'required|string|max:50',
            'tanggal_masuk' => 'required|date|before_or_equal:today',
            'sumber_limbah' => 'required|string|max:100',
            'jumlah_ton' => 'required|numeric|min:0.001|max:999999.99',
            'maksimal_penyimpanan' => 'required|date|after:tanggal_masuk',
            'nomor_manifest' => 'nullable|string|max:100',
            'berita_acara' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // ✅ Validasi file
            'catatan' => 'nullable|string|max:500',
        ], [
            'jenis_limbah.required' => 'Jenis limbah harus diisi',
            'jenis_limbah.string' => 'Jenis limbah harus berupa teks',
            'jenis_limbah.max' => 'Jenis limbah maksimal 100 karakter',
            'kode_limbah.required' => 'Kode limbah harus diisi',
            'kode_limbah.max' => 'Kode limbah maksimal 50 karakter',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
            'tanggal_masuk.before_or_equal' => 'Tanggal tidak boleh di masa depan',
            'sumber_limbah.required' => 'Sumber limbah harus diisi',
            'sumber_limbah.string' => 'Sumber limbah harus berupa teks',
            'sumber_limbah.max' => 'Sumber limbah maksimal 100 karakter',
            'jumlah_ton.required' => 'Jumlah ton harus diisi',
            'jumlah_ton.numeric' => 'Jumlah ton harus berupa angka',
            'jumlah_ton.min' => 'Jumlah ton minimal 0.001',
            'jumlah_ton.max' => 'Jumlah ton maksimal 999.999,99 ton',
            'maksimal_penyimpanan.required' => 'Tanggal maksimal penyimpanan harus diisi',
            'maksimal_penyimpanan.date' => 'Format tanggal tidak valid',
            'maksimal_penyimpanan.after' => 'Tanggal maksimal penyimpanan harus setelah tanggal masuk',
            'nomor_manifest.max' => 'Nomor manifest maksimal 100 karakter',
            'berita_acara.file' => 'Berita acara harus berupa file',
            'berita_acara.mimes' => 'Format file berita acara harus: pdf, jpg, jpeg, png',
            'berita_acara.max' => 'Ukuran file berita acara maksimal 10MB',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        // Validasi jumlah_ton jika sudah ada pengeluaran
        if ($data->pengeluaran()->count() > 0 && $data->jumlah_ton != $validated['jumlah_ton']) {
            return back()->withErrors(['jumlah_ton' => 'Jumlah ton tidak dapat diubah karena sudah ada riwayat pengeluaran'])->withInput();
        }

        // ✅ Handle upload file berita_acara (update)
        if ($request->hasFile('berita_acara')) {
            // Hapus file lama jika ada
            if ($data->berita_acara) {
                $this->deleteFile($data->berita_acara);
            }
            // Upload file baru
            $validated['berita_acara'] = $this->handleFileUpload($request->file('berita_acara'));
        }

        DB::transaction(function () use ($data, $validated) {
            $data->update($validated);
        });

        return redirect()
            ->route('waste-b3')
            ->with('success', 'Data limbah B3 masuk berhasil diperbarui.');
    }

    /**
     * Hapus data (soft delete)
     */
    public function destroy($id)
    {
        $data = WasteB3Masuk::with('pengeluaran')->findOrFail($id);

        // Validasi: Tidak bisa hapus jika sudah ada pengeluaran
        if ($data->pengeluaran()->count() > 0) {
            return redirect()
                ->route('waste-b3')
                ->with('error', 'Data tidak dapat dihapus karena sudah ada riwayat pengeluaran.');
        }

        // ✅ Hapus file berita_acara jika ada
        if ($data->berita_acara) {
            $this->deleteFile($data->berita_acara);
        }

        $data->delete();

        return redirect()
            ->route('waste-b3')
            ->with('success', 'Data limbah B3 masuk berhasil dihapus.');
    }

    /**
     * Tampilkan detail data limbah B3 masuk
     */
    public function show($id)
    {
        $data = WasteB3Masuk::with(['creator', 'pengeluaran'])->findOrFail($id);
        
        return view('waste-b3.masuk.show', compact('data'));
    }

    // ========================================
    // ✅ HELPER METHODS FOR FILE HANDLING
    // ========================================

    /**
     * Handle file upload dengan nama unik
     */
    private function handleFileUpload($file)
    {
        $folder = 'public/waste-b3/berita-acara';
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        
        // Simpan file
        $file->storeAs($folder, $filename);
        
        return $filename;
    }

    /**
     * Hapus file dari storage
     */
    private function deleteFile($filename)
    {
        $path = 'public/waste-b3/berita-acara/' . $filename;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    /**
     * Export data ke Excel (opsional)
     */
    public function export(Request $request)
    {
        // Implementasi export jika diperlukan
    }
}