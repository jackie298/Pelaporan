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
            'ReportedBy' => 'required|string|max:255',
            'Departemen' => 'required|string|max:100',
            'Location' => 'nullable|string|max:100',
            'IncidentType' => 'required|string|max:100',
            'ComplianceType' => 'required|string|max:100',
            'Date_reported' => 'required|date',
            'Status' => 'required|in:Escalated,Pending,Resolved,Open',
            'Severity' => 'required|in:Low,Medium,High,Critical',
            'ResolvedBy' => 'nullable|string|max:255',
        ]);

        $data = [
            'ReportedBy' => $request->ReportedBy,
            'Departemen' => $request->Departemen,
            'Location' => $request->Location,
            'IncidentType' => $request->IncidentType,
            'ComplianceType' => $request->ComplianceType,
            'Date_reported' => $request->Date_reported,
            'Status' => $request->Status, 
            'Severity' => $request->Severity,
            'ResolvedBy' => $request->ResolvedBy,
            'created_by' => Auth::id(),
        ];

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
            'ReportedBy' => 'required|string|max:255',
            'Departemen' => 'required|string|max:100',
            'Location' => 'nullable|string|max:100',
            'IncidentType' => 'required|string|max:100',
            'ComplianceType' => 'required|string|max:100',
            'Date_reported' => 'required|date',
            'Status' => 'required|in:Escalated,Pending,Resolved,Open',
            'Severity' => 'required|in:Low,Medium,High,Critical',
            'ResolvedBy' => 'nullable|string|max:255',
        ]);
        $data = [
            'ReportedBy' => $request->ReportedBy,
            'Departemen' => $request->Departemen,
            'Location' => $request->Location,
            'IncidentType' => $request->IncidentType,
            'ComplianceType' => $request->ComplianceType,
            'Date_reported' => $request->Date_reported,
            'Status' => $request->Status,
            'Severity' => $request->Severity,
            'ResolvedBy' => $request->ResolvedBy,
        ];

       
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

        $complience->delete();

        return redirect()
            ->route('complience')
            ->with('success', 'Dokumen compliance berhasil dihapus.');
    }
}