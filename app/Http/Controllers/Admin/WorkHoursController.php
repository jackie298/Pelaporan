<?php

namespace App\Http\Controllers\Admin;

use App\Models\WorkHours; 
use App\Exports\JamKerjaExport;
use App\Models\Equipment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WorkHoursController extends Controller
{
    /**
     * Tampilkan daftar Jam Kerja dengan filter & pagination
     */
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $searchFilter = $request->get('search');
        $tanggalDari = $request->get('tanggal_dari');
        $tanggalSampai = $request->get('tanggal_sampai');

        // Query dasar dengan eager loading relasi 'alat'
        $query = WorkHours::with('alat');

        // Apply filters
        if ($searchFilter) {
            $query->whereHas('alat', function($q) use ($searchFilter) {
                $q->where('nama', 'like', "%{$searchFilter}%")
                  ->orWhere('kode', 'like', "%{$searchFilter}%");
            });
        }

        if ($tanggalDari) {
            $query->whereDate('tanggal', '>=', $tanggalDari);
        }
        
        if ($tanggalSampai) {
            $query->whereDate('tanggal', '<=', $tanggalSampai);
        }

        // Pagination dengan 15 item per page
        $workHours = $query->latest()->paginate(15);

        // Summary statistics untuk cards (query terpisah, tanpa filter pagination)
        $summaryStats = [
            'total' => WorkHours::count(),
            'total_hours' => WorkHours::sum('total_jam') ?? 0,
            'avg_hours' => WorkHours::avg('total_jam') ?? 0,
            'active_equipment' => WorkHours::select('alat_id')->distinct()->whereNotNull('alat_id')->count(),
        ];

        return view('work-hours.index', compact(
            'workHours',
            'summaryStats',
            'searchFilter',
            'tanggalDari',
            'tanggalSampai'
        ));
    }

    /**
     * Tampilkan form tambah jam kerja
     */
    public function create()
    {
        // ✅ Gunakan get() untuk mendapatkan full model objects
        $equipments = Equipment::where('status', '!=', 'tidak_aktif')
                            ->orderBy('nama')
                            ->get(); // ← Bukan pluck()
        
        return view('work-hours.create', compact('equipments'));
    }

    /**
     * Simpan data jam kerja
     */
    public function store(Request $request)
    {
        // Normalisasi format waktu (hapus detik jika ada)
        if ($request->has('jam_mulai')) {
            $request->merge(['jam_mulai' => substr($request->jam_mulai, 0, 5)]);
        }
        if ($request->has('jam_selesai')) {
            $request->merge(['jam_selesai' => substr($request->jam_selesai, 0, 5)]);
        }

        $validated = $request->validate([
            'alat_id'       => ['required', 'exists:equipments,id'],
            'tanggal'       => ['required', 'date', 'before_or_equal:today'],
            'jam_mulai'     => ['required', 'date_format:H:i'],
            'jam_selesai'   => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'jam_istirahat' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'lokasi'        => ['nullable', 'string', 'max:255'],
            'aktivitas'     => ['nullable', 'string', 'max:500'],
            'catatan'       => ['nullable', 'string', 'max:500'],
        ], [
            'jam_mulai.date_format' => 'Format jam harus HH:MM (contoh: 08:00)',
            'jam_selesai.date_format' => 'Format jam harus HH:MM (contoh: 17:00)',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
        ]);

        // ✅ MANUAL CALCULATION - Lebih akurat
        $jamMulai = $validated['jam_mulai']; // Format: "07:33"
        $jamSelesai = $validated['jam_selesai']; // Format: "16:09"
        $jamIstirahat = floatval($validated['jam_istirahat'] ?? 0);
        
        // Parse jam dan menit
        [$mulaiHour, $mulaiMinute] = explode(':', $jamMulai);
        [$selesaiHour, $selesaiMinute] = explode(':', $jamSelesai);
        
        // Konversi ke menit total dari tengah malam
        $mulaiTotalMinutes = ($mulaiHour * 60) + $mulaiMinute;
        $selesaiTotalMinutes = ($selesaiHour * 60) + $selesaiMinute;
        
        // Hitung durasi dalam menit
        $durasiMenit = $selesaiTotalMinutes - $mulaiTotalMinutes;
        
        // Handle overnight shift (jika perlu)
        if ($durasiMenit < 0) {
            $durasiMenit += (24 * 60); // Tambah 1 hari dalam menit
        }
        
        // Konversi ke jam
        $durasiJam = $durasiMenit / 60;
        
        // Kurangi waktu istirahat
        $totalJam = max(0, $durasiJam - $jamIstirahat);
        
        $validated['total_jam'] = round($totalJam, 2);
        $validated['created_by'] = Auth::id();

        // Cek duplikasi
        $isDuplicate = WorkHours::where('alat_id', $validated['alat_id'])
                                ->whereDate('tanggal', $validated['tanggal'])
                                ->exists();
        
        if ($isDuplicate) {
            return back()
                ->withErrors(['tanggal' => 'Data jam kerja untuk equipment ini pada tanggal ' . \Carbon\Carbon::parse($validated['tanggal'])->format('d M Y') . ' sudah terdaftar.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated) {
            WorkHours::create($validated);
        });

        return redirect()
            ->route('admin.work-hours')
            ->with('success', 'Data jam kerja berhasil disimpan.');
    }

    /**
     * Tampilkan form edit jam kerja
     */
    public function edit($id)
    {
       $workHour = WorkHours::with('alat')->findOrFail($id);
    
        // ✅ Gunakan get() untuk mendapatkan full model objects
        $equipments = Equipment::where('status', '!=', 'tidak_aktif')
                            ->orderBy('nama')
                            ->get();
        
        return view('work-hours.edit', compact('workHour', 'equipments'));
    }

    /**
     * Perbarui data jam kerja
     */
    public function update(Request $request, $id)
    {
        $workHour = WorkHours::findOrFail($id);

        // Normalisasi format waktu
        if ($request->has('jam_mulai')) {
            $request->merge(['jam_mulai' => substr($request->jam_mulai, 0, 5)]);
        }
        if ($request->has('jam_selesai')) {
            $request->merge(['jam_selesai' => substr($request->jam_selesai, 0, 5)]);
        }

        $validated = $request->validate([
            'alat_id'       => ['required', 'exists:equipments,id'],
            'tanggal'       => ['required', 'date', 'before_or_equal:today'],
            'jam_mulai'     => ['required', 'date_format:H:i'],
            'jam_selesai'   => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'jam_istirahat' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'lokasi'        => ['nullable', 'string', 'max:255'],
            'aktivitas'     => ['nullable', 'string', 'max:500'],
            'catatan'       => ['nullable', 'string', 'max:500'],
        ], [
            'jam_mulai.date_format' => 'Format jam harus HH:MM (contoh: 08:00)',
            'jam_selesai.date_format' => 'Format jam harus HH:MM (contoh: 17:00)',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
        ]);

        // ✅ MANUAL CALCULATION - Sama seperti store()
        $jamMulai = $validated['jam_mulai'];
        $jamSelesai = $validated['jam_selesai'];
        $jamIstirahat = floatval($validated['jam_istirahat'] ?? 0);
        
        // Parse jam dan menit
        [$mulaiHour, $mulaiMinute] = explode(':', $jamMulai);
        [$selesaiHour, $selesaiMinute] = explode(':', $jamSelesai);
        
        // Konversi ke menit total
        $mulaiTotalMinutes = ($mulaiHour * 60) + $mulaiMinute;
        $selesaiTotalMinutes = ($selesaiHour * 60) + $selesaiMinute;
        
        // Hitung durasi
        $durasiMenit = $selesaiTotalMinutes - $mulaiTotalMinutes;
        
        // Handle overnight
        if ($durasiMenit < 0) {
            $durasiMenit += (24 * 60);
        }
        
        // Konversi ke jam dan kurangi istirahat
        $durasiJam = $durasiMenit / 60;
        $totalJam = max(0, $durasiJam - $jamIstirahat);
        
        $validated['total_jam'] = round($totalJam, 2);

        // Cek duplikasi (kecuali record ini)
        $isDuplicate = WorkHours::where('alat_id', $validated['alat_id'])
                                ->whereDate('tanggal', $validated['tanggal'])
                                ->where('id', '!=', $id)
                                ->exists();
        
        if ($isDuplicate) {
            return back()
                ->withErrors(['tanggal' => 'Data jam kerja untuk equipment ini pada tanggal ' . \Carbon\Carbon::parse($validated['tanggal'])->format('d M Y') . ' sudah terdaftar.'])
                ->withInput();
        }

        DB::transaction(function () use ($workHour, $validated) {
            $workHour->update($validated);
        });

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

        // Validasi opsional: cek apakah ada relasi yang bergantung
        // if ($workHour->someRelation()->count() > 0) {
        //     return redirect()
        //         ->route('admin.work-hours')
        //         ->with('error', 'Data tidak dapat dihapus karena memiliki keterkaitan.');
        // }

        DB::transaction(function () use ($workHour) {
            $workHour->delete();
        });

        return redirect()
            ->route('admin.work-hours')
            ->with('success', 'Data jam kerja berhasil dihapus.');
    }

    /**
     * Export data jam kerja ke Excel
     */
    public function export(Request $request)
    {
        // Optional: Apply filters from request for export
        return (new JamKerjaExport($request->all()))
            ->download('jam_kerja_export_' . date('Ymd') . '.xlsx');
    }
}