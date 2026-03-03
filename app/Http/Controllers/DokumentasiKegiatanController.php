<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DokumentasiKegiatan;
use App\Exports\DokumentasiKegiatanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumentasiKegiatanController extends Controller
{
    /**
     * Tampilkan daftar dokumentasi kegiatan
     */
    public function index(Request $request)
    {
        // 1. Ambil input filter dari request
        $search = $request->get('search');
        $jenisFilter = $request->get('jenis_kegiatan');
        $tanggalDari = $request->get('tanggal_dari');
        $tanggalSampai = $request->get('tanggal_sampai');

        $query = DokumentasiKegiatan::with('creator');

        // 2. Apply Filter Pencarian (Judul atau Lokasi)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // 3. Filter berdasarkan Jenis Kegiatan
        if ($jenisFilter) {
            $query->where('jenis_kegiatan', $jenisFilter);
        }

        // 4. Filter Rentang Tanggal
        if ($tanggalDari && $tanggalSampai) {
            $query->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);
        } elseif ($tanggalDari) {
            $query->where('tanggal', '>=', $tanggalDari);
        } elseif ($tanggalSampai) {
            $query->where('tanggal', '<=', $tanggalSampai);
        }

        // 5. Paginate dengan withQueryString() agar filter tidak hilang saat pindah halaman
        $dokumentasi = $query->latest()->paginate(10)->appends(request()->query());

        return view('dokumentasi-kegiatan.index', compact(
            'dokumentasi',
            'search',
            'jenisFilter',
            'tanggalDari',
            'tanggalSampai'
        ));
    }

    /**
     * Tampilkan form tambah dokumentasi
     */
    public function create()
    {
        return view('dokumentasi-kegiatan.create');
    }

    /**
     * Simpan data dokumentasi kegiatan
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'tanggal'           => 'required|date',
            'lokasi'            => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'jenis_kegiatan'    => 'required|string|max:100',
            
            // PERBAIKAN DI SINI:
            'file_dokumentasi'   => 'required|array', // Pastikan input adalah array
            'file_dokumentasi.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048', // Validasi tiap file di dalam array
        ]);

        // Handle upload multiple files
        $filePath = [];
        if ($request->hasFile('file_dokumentasi')) {
            foreach ($request->file('file_dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                $filePath[] = $path;
            }
        }

        DokumentasiKegiatan::create([
            'judul'             => $request->judul,
            'tanggal'           => $request->tanggal,
            'lokasi'            => $request->lokasi,
            'deskripsi'         => $request->deskripsi,
            'jenis_kegiatan'    => $request->jenis_kegiatan,
            'file_dokumentasi'  => $filePath, // Model akan otomatis mengubah array ke JSON karena casting
            'created_by'        => Auth::id(),
        ]);

        return redirect()
            ->route('dokumentasi-kegiatan')
            ->with('success', 'Dokumentasi kegiatan berhasil disimpan.');
    }

    /**
     * Tampilkan form edit dokumentasi
     */
    public function edit($id)
    {
        $dokumentasi = DokumentasiKegiatan::findOrFail($id);
        return view('dokumentasi-kegiatan.edit', compact('dokumentasi'));
    }

    public function gallery()
    {
        $dokumentasiData = DokumentasiKegiatan::with('creator')
            ->latest()
            ->paginate(12); // 12 item per halaman

        return view('dokumentasi-kegiatan.gallery', compact('dokumentasiData'));
    }

    /**
     * Perbarui data dokumentasi
     */
    public function update(Request $request, $id)
    {
        $dokumentasi = DokumentasiKegiatan::findOrFail($id);

        $request->validate([
            'judul'             => 'required|string|max:255',
            'tanggal'           => 'required|date',
            'lokasi'            => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'jenis_kegiatan'    => 'required|string|max:100',
            
            // PERBAIKAN DI SINI JUGA:
            'file_dokumentasi'   => 'nullable|array',
            'file_dokumentasi.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = $dokumentasi->file_dokumentasi;

        if ($request->hasFile('file_dokumentasi')) {
            // Hapus file lama jika ada upload baru
            if (is_array($filePath)) {
                foreach ($filePath as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }

            // Simpan file baru
            $filePath = [];
            foreach ($request->file('file_dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                $filePath[] = $path;
            }
        }

        $dokumentasi->update([
            'judul'             => $request->judul,
            'tanggal'           => $request->tanggal,
            'lokasi'            => $request->lokasi,
            'deskripsi'         => $request->deskripsi,
            'jenis_kegiatan'    => $request->jenis_kegiatan,
            'file_dokumentasi'  => $filePath,
        ]);

        return redirect()
            ->route('dokumentasi-kegiatan')
            ->with('success', 'Dokumentasi kegiatan berhasil diperbarui.');
    }
    /**
     * Hapus data dokumentasi (soft delete)
     */
    public function destroy($id)
    {
        $dokumentasi = DokumentasiKegiatan::findOrFail($id);
        $dokumentasi->delete(); // Soft delete karena menggunakan SoftDeletes

        return redirect()
            ->route('dokumentasi-kegiatan')
            ->with('success', 'Dokumentasi kegiatan berhasil dihapus.');
    }

    // Export data dokumentasi kegiatan
    public function export()    
    {
        return (new DokumentasiKegiatanExport())->download('dokumentasi_kegiatan_export.xlsx');
    }
}