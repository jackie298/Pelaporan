<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DokumentasiKegiatan;
use App\Exports\DokumentasiKegiatanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DokumentasiKegiatanController extends Controller
{
    /**
     * Tampilkan daftar dokumentasi kegiatan
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $jenisFilter = $request->get('jenis_kegiatan');
        $tanggalDari = $request->get('tanggal_dari');
        $tanggalSampai = $request->get('tanggal_sampai');

        $query = DokumentasiKegiatan::with('creator');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        if ($jenisFilter) {
            $query->where('jenis_kegiatan', $jenisFilter);
        }

        if ($tanggalDari && $tanggalSampai) {
            $query->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);
        } elseif ($tanggalDari) {
            $query->where('tanggal', '>=', $tanggalDari);
        } elseif ($tanggalSampai) {
            $query->where('tanggal', '<=', $tanggalSampai);
        }

        $dokumentasi = $query->latest()->paginate(10)->withQueryString();

        return view('dokumentasi-kegiatan.index', compact(
            'dokumentasi', 'search', 'jenisFilter', 'tanggalDari', 'tanggalSampai'
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
        $validated = $request->validate([
            'judul'             => 'required|string|max:255',
            'tanggal'           => 'required|date|before_or_equal:today',
            'lokasi'            => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'jenis_kegiatan'    => 'required|string|max:100',
            'file_dokumentasi'   => 'required|array|min:1',
            'file_dokumentasi.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'judul.required'            => 'Judul kegiatan wajib diisi.',
            'tanggal.required'          => 'Tanggal kegiatan wajib diisi.',
            'tanggal.before_or_equal'   => 'Tanggal tidak boleh di masa depan.',
            'lokasi.required'           => 'Lokasi kegiatan wajib diisi.',
            'deskripsi.required'        => 'Deskripsi kegiatan wajib diisi.',
            'jenis_kegiatan.required'   => 'Jenis kegiatan wajib dipilih.',
            'file_dokumentasi.required' => 'Minimal upload satu file dokumentasi.',
            'file_dokumentasi.*.mimes'  => 'Format file harus JPG, JPEG, PNG, atau PDF.',
            'file_dokumentasi.*.max'    => 'Ukuran masing-masing file maksimal 5MB.',
        ]);

        try {
            DB::beginTransaction();

            $filePaths = [];
            if ($request->hasFile('file_dokumentasi')) {
                foreach ($request->file('file_dokumentasi') as $file) {
                    $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('dokumentasi', $filename, 'public');
                    $filePaths[] = $path;
                }
            }

            DokumentasiKegiatan::create([
                'judul'            => $validated['judul'],
                'tanggal'          => $validated['tanggal'],
                'lokasi'           => $validated['lokasi'],
                'deskripsi'        => $validated['deskripsi'],
                'jenis_kegiatan'   => $validated['jenis_kegiatan'],
                'file_dokumentasi' => $filePaths,
                'created_by'       => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('dokumentasi-kegiatan')
                ->with('success', 'Dokumentasi kegiatan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file yang terlanjur terupload jika DB gagal
            foreach ($filePaths as $path) {
                Storage::disk('public')->delete($path);
            }
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Perbarui data dokumentasi
     */
    public function update(Request $request, $id)
    {
        $dokumentasi = DokumentasiKegiatan::findOrFail($id);

        $validated = $request->validate([
            'judul'             => 'required|string|max:255',
            'tanggal'           => 'required|date|before_or_equal:today',
            'lokasi'            => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'jenis_kegiatan'    => 'required|string|max:100',
            'file_dokumentasi'   => 'nullable|array',
            'file_dokumentasi.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'judul.required'    => 'Judul kegiatan wajib diisi.',
            'tanggal.required'  => 'Tanggal wajib diisi.',
            'file_dokumentasi.*.max' => 'File tidak boleh lebih dari 5MB.',
        ]);

        try {
            DB::beginTransaction();

            $newFilePaths = $dokumentasi->file_dokumentasi;

            if ($request->hasFile('file_dokumentasi')) {
                // Hapus file lama secara fisik
                if (is_array($dokumentasi->file_dokumentasi)) {
                    foreach ($dokumentasi->file_dokumentasi as $oldFile) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }

                // Upload file baru
                $newFilePaths = [];
                foreach ($request->file('file_dokumentasi') as $file) {
                    $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('dokumentasi', $filename, 'public');
                    $newFilePaths[] = $path;
                }
            }

            $dokumentasi->update([
                'judul'            => $validated['judul'],
                'tanggal'          => $validated['tanggal'],
                'lokasi'           => $validated['lokasi'],
                'deskripsi'        => $validated['deskripsi'],
                'jenis_kegiatan'   => $validated['jenis_kegiatan'],
                'file_dokumentasi' => $newFilePaths,
            ]);

            DB::commit();
            return redirect()->route('dokumentasi-kegiatan')
                ->with('success', 'Dokumentasi kegiatan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus data dokumentasi (soft delete)
     */
    public function destroy($id)
    {
        try {
            $dokumentasi = DokumentasiKegiatan::findOrFail($id);
            $dokumentasi->delete(); 

            return redirect()->route('dokumentasi-kegiatan')
                ->with('success', 'Dokumentasi kegiatan berhasil dipindahkan ke sampah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Tampilkan Gallery
     */
    public function gallery(Request $request)
    {
        $query = DokumentasiKegiatan::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $dokumentasiData = $query->latest()->paginate(12)->withQueryString();

        return view('dokumentasi-kegiatan.gallery', compact('dokumentasiData'));
    }

    public function export()    
    {
        return (new DokumentasiKegiatanExport())->download('dokumentasi_kegiatan_export.xlsx');
    }
}