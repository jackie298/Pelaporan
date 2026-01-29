<?php

namespace App\Http\Controllers;

use App\Models\Compliance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplianceController extends Controller
{
    /**
     * Tampilkan daftar dokumen compliance
     */
    public function index()
    {
        $compliances = Compliance::latest()->get();
        
        return view('compliance.index', compact('compliances'));
    }

    /**
     * Tampilkan form tambah dokumen compliance
     */
    public function create()
    {
        return view('compliance.create');
    }

    /**
     * Simpan dokumen compliance
     */
    public function store(Request $request)
    {
        $request->validate([
            'ReportedBy' => 'required|string|max:255',
            'Departemen' => 'required|in:HSE,Produksi,HRD,Maintenance,Lainnya',
            'Location' => 'required|string|max:255',
            'IncidentType' => 'required|string|max:255',
            'ComplianceType' => 'required|in:Internal,"Eksternal/Regulasi",Audit',
            'Date_reported' => 'required|date',
            'Status' => 'required|in:Escalated,Pending,Resolved,Open',
            'Severity' => 'required|in:Low,Medium,High,Critical',
            'ResolvedBy' => 'required|string|max:255',
        ]);

        Compliance::create([
            'ReportedBy' => $request->ReportedBy,
            'Departemen' => $request->Departemen,
            'Location' => $request->Location,
            'IncidentType' => $request->IncidentType,
            'ComplianceType' => $request->ComplianceType,
            'Date_reported' => $request->Date_reported,
            'Status' => $request->Status,
            'Severity' => $request->Severity,
            'ResolvedBy' => $request->ResolvedBy,
        ]);

        return redirect()
            ->route('compliance')
            ->with('success', 'Dokumen compliance berhasil disimpan.');
    }

    /**
     * Tampilkan form edit dokumen compliance
     */
    public function edit($id)
    {
        $data = Compliance::findOrFail($id);
        return view('compliance.edit', compact('data'));
    }

    /**
     * Perbarui dokumen compliance
     */
    public function update(Request $request, $id)
    {
        $data = Compliance::findOrFail($id);

        $request->validate([
            'ReportedBy' => 'required|string|max:255',
            'Departemen' => 'required|in:HSE,Produksi,HRD,Maintenance,Lainnya',
            'Location' => 'required|string|max:255',
            'IncidentType' => 'required|string|max:255',
            'ComplianceType' => 'required|in:Internal,"Eksternal/Regulasi",Audit',
            'Date_reported' => 'required|date',
            'Status' => 'required|in:Escalated,Pending,Resolved,Open',
            'Severity' => 'required|in:Low,Medium,High,Critical',
            'ResolvedBy' => 'required|string|max:255',
        ]);

        $data->update([
            'ReportedBy' => $request->ReportedBy,
            'Departemen' => $request->Departemen,
            'Location' => $request->Location,
            'IncidentType' => $request->IncidentType,
            'ComplianceType' => $request->ComplianceType,
            'Date_reported' => $request->Date_reported,
            'Status' => $request->Status,
            'Severity' => $request->Severity,
            'ResolvedBy' => $request->ResolvedBy,
        ]);

        return redirect()
            ->route('compliance')
            ->with('success', 'Dokumen compliance berhasil diperbarui.');
    }

    /**
     * Hapus dokumen compliance
     */
    public function destroy($id)
    {
        $data = Compliance::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('compliance')
            ->with('success', 'Dokumen compliance berhasil dihapus.');
    }
}