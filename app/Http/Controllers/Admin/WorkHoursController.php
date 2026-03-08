<?php

namespace App\Http\Controllers\Admin;

use App\Models\WorkHours; // Sesuai dengan nama file dan class Anda
use App\Exports\JamKerjaExport;
use App\Models\Equipment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkHoursController extends Controller
{
    /**
     * Tampilkan daftar Jam Kerja
     */
    public function index()
    {
        $workHours = WorkHours::with('alat')->latest()->get();

        return view('work-hours.index', compact('workHours'));
    }

    /**
     * Tampilkan form tambah jam kerja
     */
    public function create()
    {
        $equipments = Equipment::all(); // Untuk dropdown alat
        return view('work-hours.create', compact('equipments'));
    }

    /**
     * Simpan data jam kerja
     */
    public function store(Request $request)
    {
        $request->validate([
            'alat_id'       => 'required|exists:equipments,id',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'required|string',
            'jam_selesai'   => 'required|string',
            'jam_istirahat' => 'nullable|numeric|min:0',
            // 'total_jam'     => 'required|numeric|min:0',
            'lokasi'        => 'nullable|string|max:255',
            'aktivitas'     => 'nullable|string',
            'catatan'       => 'nullable|string',
        ]);

        // =============================
        // SIMPAN DATABASE
        // =============================
        workhours::create([
            'alat_id'       => $request->alat_id,
            'tanggal'       => $request->tanggal,
            'jam_mulai'     => $request->jam_mulai,
            'jam_selesai'   => $request->jam_selesai,
            'jam_istirahat' => $request->jam_istirahat,
            'total_jam'     => $request->total_jam,
            'lokasi'        => $request->lokasi,
            'aktivitas'     => $request->aktivitas,
            'catatan'       => $request->catatan,
        ]);

        return redirect()
            ->route('admin.work-hours')
            ->with('success', 'Data jam kerja berhasil disimpan.');
    }

    /**
     * Tampilkan form edit jam kerja
     */
    public function edit($id)
    {
        $workHour = WorkHours::findOrFail($id);
        $equipments = Equipment::all();
        return view('work-hours.edit', compact('workHour', 'equipments'));
    }

    /**
     * Perbarui data jam kerja
     */
    public function update(Request $request, $id)
    {
        $workHour = WorkHours::findOrFail($id);

        $request->validate([
            'alat_id'       => 'required|exists:equipments,id',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'required|string',
            'jam_selesai'   => 'required|string',
            'jam_istirahat' => 'nullable|numeric|min:0',
            // 'total_jam'     => 'required|numeric|min:0',
            'lokasi'        => 'nullable|string|max:255',
            'aktivitas'     => 'nullable|string',
            'catatan'       => 'nullable|string',
        ]);

        // =============================
        // UPDATE DATABASE
        // =============================
        $workHour->update([
            'alat_id'       => $request->alat_id,
            'tanggal'       => $request->tanggal,
            'jam_mulai'     => $request->jam_mulai,
            'jam_selesai'   => $request->jam_selesai,
            'jam_istirahat' => $request->jam_istirahat,
            'total_jam'     => $request->total_jam,
            'lokasi'        => $request->lokasi,
            'aktivitas'     => $request->aktivitas,
            'catatan'       => $request->catatan,
        ]);

        return redirect()
            ->route('admin.work-hours')
            ->with('success', 'Data jam kerja berhasil diperbarui.');
    }

    /**
     * Hapus data jam kerja
     */
    public function destroy($id)
    {
        $workHour = WorkHours::findOrFail($id);
        $workHour->delete();

        return redirect()
            ->route('admin.work-hours')
            ->with('success', 'Data jam kerja berhasil dihapus.');
    }

    // Export data jam kerja
    public function export()
    {
        return (new JamKerjaExport())->download('jam_kerja.xlsx');
    }
}