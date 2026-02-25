<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $currentFolderId = $request->query('folder_id');

        // Folder yang tampil sebagai card (hanya sub-folder dari lokasi sekarang)
        $folders = Folder::where('user_id', $user->id)
            ->where('parent_id', $currentFolderId)
            ->withCount('documents')
            ->get();

        // SEMUA folder milik user (untuk dropdown pindah file)
        $allFolders = Folder::where('user_id', $user->id)->get();

        $documents = $user->documents()
            ->where('folder_id', $currentFolderId)
            ->latest()
            ->get();

        $currentFolder = $currentFolderId ? Folder::with('parent')->find($currentFolderId) : null;

        return view('documents.index', compact(
            'documents', 
            'folders', 
            'allFolders', // Tambahkan ini
            'currentFolder', 
            'currentFolderId'
        ));
    }

    // app/Http/Controllers/Admin/DocumentController.php

    public function storeFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id' // Validasi parent_id
        ]);

        \App\Models\Folder::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id, // Ini kunci agar tidak masuk ke root
        ]);

        return redirect()->back()->with('success', 'Folder berhasil dibuat!');
    }

    /**
     * Menyimpan dokumen ke folder tertentu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,docx,doc,xls,xlsx,jpg,jpeg,png|max:10240',
            'folder_id' => 'nullable|exists:folders,id', // Validasi folder_id
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('documents', 'public');

            Document::create([
                'user_id' => auth()->id(),
                'folder_id' => $request->folder_id, // Simpan relasi folder
                'title' => $request->title,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);

            return redirect()->back()->with('success', 'Dokumen berhasil diunggah!');
        }
    }

    /**
     * Memindahkan dokumen ke folder lain.
     */
    public function move(Request $request, Document $document)
    {
        $request->validate([
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        // Proteksi kepemilikan
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        $document->update([
            'folder_id' => $request->folder_id
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil dipindahkan!');
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

    public function destroyFolder(Folder $folder)
    {
        // Pastikan folder milik user yang sedang login
        if ($folder->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil semua dokumen di dalam folder ini (termasuk sub-folder jika perlu)
        // Untuk kesederhanaan, kita hapus dokumen langsung di bawah folder ini
        $documents = $folder->documents;

        foreach ($documents as $doc) {
            // Hapus file fisik dari storage
            if (Storage::disk('public')->exists($doc->file_path)) {
                Storage::disk('public')->delete($doc->file_path);
            }
            // Hapus data dokumen di database
            $doc->delete();
        }

        // Hapus folder (sub-folder akan terhapus otomatis jika Anda menggunakan onDelete('cascade') di migrasi)
        $folder->delete();

        return redirect()->back()->with('success', 'Folder dan seluruh isinya berhasil dihapus!');
    }
}