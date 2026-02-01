<?php

namespace App\Http\Controllers;

use App\Models\Compliance;
use App\Exports\ComplianceExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ComplianceController extends Controller
{
    public function index()
    {
        $compliances = Compliance::latest()->get();
        
        return view('compliance.index', compact('compliances'));
    }

    public function create()
    {
        return view('compliance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama_pelapor' => 'required|string|max:255',
            'Departemen' => 'required|in:HSE,Produksi,HRD,Maintenance,Lainnya',
            'Lokasi' => 'required|string|max:255',
            'Jenis_insiden' => 'required|string|max:255',
            'Jenis_inspeksi' => 'required|in:Internal,"Eksternal/Regulasi",Audit',
            'Tanggal_lapor' => 'required|date',
            'Status' => 'required|in:Escalated,Pending,Resolved,Open',
            'Tingkat_keparahan' => 'required|in:Low,Medium,High,Critical',
            'Diselesaikan_oleh' => 'required|string|max:255',
            'file_dokumentasi' => 'nullable|array|max:10', // Maksimal 10 file
            'file_dokumentasi.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB per file
        ]);

        $filePaths = [];

        if ($request->hasFile('file_dokumentasi')) {
            foreach ($request->file('file_dokumentasi') as $file) {
                $path = $file->store('compliance', 'public');
                $filePaths[] = $path;
            }
        }

        Compliance::create([
            'Nama_pelapor' => $request->Nama_pelapor,
            'Departemen' => $request->Departemen,
            'Lokasi' => $request->Lokasi,
            'Jenis_insiden' => $request->Jenis_insiden,
            'Jenis_inspeksi' => $request->Jenis_inspeksi,
            'Tanggal_lapor' => $request->Tanggal_lapor,
            'Status' => $request->Status,
            'Tingkat_keparahan' => $request->Tingkat_keparahan,
            'Diselesaikan_oleh' => $request->Diselesaikan_oleh,
            'file_dokumentasi' => $filePaths,
        ]);

        return redirect()
            ->route('compliance')
            ->with('success', 'Dokumen compliance berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = Compliance::findOrFail($id);
        return view('compliance.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Compliance::findOrFail($id);

        $request->validate([
            'Nama_pelapor' => 'required|string|max:255',
            'Departemen' => 'required|in:HSE,Produksi,HRD,Maintenance,Lainnya',
            'Lokasi' => 'required|string|max:255',
            'Jenis_insiden' => 'required|string|max:255',
            'Jenis_inspeksi' => 'required|in:Internal,"Eksternal/Regulasi",Audit',
            'Tanggal_lapor' => 'required|date',
            'Status' => 'required|in:Escalated,Pending,Resolved,Open',
            'Tingkat_keparahan' => 'required|in:Low,Medium,High,Critical',
            'Diselesaikan_oleh' => 'required|string|max:255',
            'file_dokumentasi' => 'nullable|array|max:10',
            'file_dokumentasi.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePaths = $data->file_dokumentasi ?? [];

        if ($request->hasFile('file_dokumentasi')) {
            // Hapus file lama
            if (is_array($filePaths)) {
                foreach ($filePaths as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
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
            'Nama_pelapor' => $request->Nama_pelapor,
            'Departemen' => $request->Departemen,
            'Lokasi' => $request->Lokasi,
            'Jenis_insiden' => $request->Jenis_insiden,
            'Jenis_inspeksi' => $request->Jenis_inspeksi,
            'Tanggal_lapor' => $request->Tanggal_lapor,
            'Status' => $request->Status,
            'Tingkat_keparahan' => $request->Tingkat_keparahan,
            'Diselesaikan_oleh' => $request->Diselesaikan_oleh,
            'file_dokumentasi' => $filePaths,
        ]);

        return redirect()
            ->route('compliance')
            ->with('success', 'Dokumen compliance berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Compliance::findOrFail($id);
        
        // Hapus semua file
        if (is_array($data->file_dokumentasi)) {
            foreach ($data->file_dokumentasi as $file) {
                Storage::disk('public')->delete($file);
            }
        }
        
        $data->delete();

        return redirect()
            ->route('compliance')
            ->with('success', 'Dokumen compliance berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new ComplianceExport, 'compliance_export.xlsx');
    }
}