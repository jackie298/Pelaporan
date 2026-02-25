<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // 1. Menampilkan daftar dokumen milik user yang sedang login
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $documents = $user->documents()->latest()->get();
        
        return view('documents.index', compact('documents'));
    }

    // 2. Proses Upload Dokumen
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => [
                'required',
                'file',
                // Tambahkan mimes excel
                'mimes:pdf,docx,jpg,png,xls,xlsx', 
                'max:10240' // Contoh: saya naikkan jadi 10MB karena file excel seringkali berat
            ],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('documents', 'public');

            Document::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'category' => $request->category,
            ]);

            return redirect()->route('documents')->with('success', 'File Excel berhasil diunggah!');
        }
    }

    // 3. Proses Download Dokumen
    public function download(Document $document)
    {
        // Pastikan hanya pemilik yang bisa download (Security Check)
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        return response()->download(storage_path('app/public/' . $document->file_path), $document->original_name);
    }

    // 4. Hapus Dokumen
    public function destroy(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        // Hapus file fisik dari storage
        Storage::disk('public')->delete($document->file_path);
        
        // Hapus data dari database
        $document->delete();

        return redirect()->back()->with('success', 'Dokumen telah dihapus.');
    }

    public function preview(Document $document)
    {
        // Security check: Pastikan hanya pemilik yang bisa melihat
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        // Mengambil path lengkap file
        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return view('documents.preview', compact('document'));
    }
}