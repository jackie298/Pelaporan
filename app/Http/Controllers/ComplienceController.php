<?php

namespace App\Http\Controllers;

use App\Models\Complience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplienceController extends Controller
{
    /**
     * Tampilkan daftar dokumen compliance
     */
    public function index()
    {
        $compliences = Complience::with('creator')
            ->latest()
            ->get();

        return view('complience.index', compact('compliences'));
    }

    /**
     * Tampilkan form tambah dokumen compliance
     */
    public function create()
    {
        return view('complience.create');
    }

    /**
     * Simpan dokumen compliance baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_terbit' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:tanggal_terbit',
            'status' => 'required|in:Aktif,Kadaluarsa,Menunggu,Ditolak',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // max 10MB
        ]);

        $data = [
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_terbit' => $request->tanggal_terbit,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'file_dokumen' => '#', // default placeholder
            'created_by' => Auth::id(),
        ];

        // Jika ada file diupload
        if ($request->hasFile('file_dokumen')) {
            $path = $request->file('file_dokumen')->store('complience', 'public');
            $data['file_dokumen'] = $path;
        }

        Complience::create($data);

        return redirect()
            ->route('complience')
            ->with('success', 'Dokumen compliance berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $complience = Complience::findOrFail($id);
        return view('complience.edit', compact('complience'));
    }

    /**
     * Perbarui data compliance
     */
    public function update(Request $request, $id)
    {
        $complience = Complience::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_terbit' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:tanggal_terbit',
            'status' => 'required|in:Aktif,Kadaluarsa,Menunggu,Ditolak',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = [
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_terbit' => $request->tanggal_terbit,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        // Handle upload file baru
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika bukan placeholder
            if ($complience->file_dokumen !== '#' && Storage::disk('public')->exists($complience->file_dokumen)) {
                Storage::disk('public')->delete($complience->file_dokumen);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('complience', 'public');
        }

        $complience->update($data);

        return redirect()
            ->route('complience')
            ->with('success', 'Dokumen compliance berhasil diperbarui.');
    }

    /**
     * Hapus data (soft delete jika pakai softDeletes, atau hard delete)
     */
    public function destroy($id)
    {
        $complience = Complience::findOrFail($id);

        // Hapus file fisik jika ada
        if ($complience->file_dokumen !== '#' && Storage::disk('public')->exists($complience->file_dokumen)) {
            Storage::disk('public')->delete($complience->file_dokumen);
        }

        $complience->delete();

        return redirect()
            ->route('complience')
            ->with('success', 'Dokumen compliance berhasil dihapus.');
    }
}