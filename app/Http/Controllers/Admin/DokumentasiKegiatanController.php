<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumentasiKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumentasiKegiatanController extends Controller
{
    /**
     * Tampilkan daftar dokumentasi kegiatan
     */
    public function index()
    {
        $dokumentasi = DokumentasiKegiatan::with('creator')
            ->latest()
            ->get();

        return view('dokumentasi-kegiatan.index', compact('dokumentasi'));
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
            'file_dokumentasi'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle upload file (jika ada)
        $filePath = null;
        if ($request->hasFile('file_dokumentasi')) {
            $filePath = $request->file('file_dokumentasi')->store('dokumentasi', 'public');
        }

        // Simpan ke database
        DokumentasiKegiatan::create([
            'judul'             => $request->judul,
            'tanggal'           => $request->tanggal,
            'lokasi'            => $request->lokasi,
            'deskripsi'         => $request->deskripsi,
            'jenis_kegiatan'    => $request->jenis_kegiatan,
            'file_dokumentasi'  => $filePath,
            'created_by'        => Auth::id(), // Otomatis ambil user login
        ]);

        return redirect()
            ->route('admin.dokumentasi-kegiatan')
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
            'file_dokumentasi'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle upload file baru (opsional: ganti file lama)
        $filePath = $dokumentasi->file_dokumentasi;
        if ($request->hasFile('file_dokumentasi')) {
            // Hapus file lama jika perlu (opsional)
            // Storage::disk('public')->delete($dokumentasi->file_dokumentasi);

            $filePath = $request->file('file_dokumentasi')->store('dokumentasi', 'public');
        }

        $dokumentasi->update([
            'judul'             => $request->judul,
            'tanggal'           => $request->tanggal,
            'lokasi'            => $request->lokasi,
            'deskripsi'         => $request->deskripsi,
            'jenis_kegiatan'    => $request->jenis_kegiatan,
            'file_dokumentasi'  => $filePath,
            // created_by tidak diubah
        ]);

        return redirect()
            ->route('admin.dokumentasi-kegiatan')
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
            ->route('admin.dokumentasi-kegiatan')
            ->with('success', 'Dokumentasi kegiatan berhasil dihapus.');
    }
}