<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteB3;

class WasteB3Controller extends Controller
{
    /**
     * Tampilkan daftar data pengelolaan limbah B3
     */
    public function index()
    {
        $wasteB3 = WasteB3::latest()->get();

        return view('waste-b3.index', compact('wasteB3'));
    }

    /**
     * Tampilkan form tambah data
     */
    public function create()
    {
        return view('waste-b3.create');
    }

    /**
     * Simpan data limbah B3
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_limbah_masuk'   => 'required|string|max:255',
            'kode_limbah'          => 'required|string|max:50',
            'tanggal_masuk'        => 'required|date',
            'sumber_limbah'        => 'required|string|max:255',
            'jumlah_masuk_ton'     => 'required|numeric|min:0',
            'maksimal_penyimpanan' => 'required|date|after_or_equal:tanggal_masuk',
            'tanggal_keluar'       => 'nullable|date|after_or_equal:tanggal_masuk',
            'jumlah_keluar_ton'    => 'nullable|numeric|min:0|max:'.$request->jumlah_masuk_ton,
            'tujuan_penyerahan'    => 'nullable|string|max:255',
            'nomor_dokumen'        => 'nullable|string|max:100',
            'sisa_limbah_ton'      => 'required|numeric|min:0|max:'.$request->jumlah_masuk_ton,
        ], [
            'jenis_limbah_masuk.required' => 'Jenis limbah harus diisi',
            'jenis_limbah_masuk.string' => 'Jenis limbah harus berupa teks',
            'kode_limbah.required' => 'Kode limbah harus diisi',
            'kode_limbah.string' => 'Kode limbah harus berupa teks',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid',
            'sumber_limbah.required' => 'Sumber limbah harus diisi',
            'sumber_limbah.string' => 'Sumber limbah harus berupa teks',
            'jumlah_masuk_ton.required' => 'Jumlah masuk harus diisi',
            'jumlah_masuk_ton.numeric' => 'Jumlah masuk harus berupa angka',
            'jumlah_masuk_ton.min' => 'Jumlah masuk minimal 0',
            'maksimal_penyimpanan.required' => 'Maksimal penyimpanan harus diisi',
            'maksimal_penyimpanan.date' => 'Format tanggal maksimal penyimpanan tidak valid',
            'maksimal_penyimpanan.after_or_equal' => 'Maksimal penyimpanan tidak boleh kurang dari tanggal masuk',
            'tanggal_keluar.date' => 'Format tanggal keluar tidak valid',
            'tanggal_keluar.after_or_equal' => 'Tanggal keluar tidak boleh kurang dari tanggal masuk',
            'jumlah_keluar_ton.numeric' => 'Jumlah keluar harus berupa angka',
            'jumlah_keluar_ton.min' => 'Jumlah keluar minimal 0',
            'jumlah_keluar_ton.max' => 'Jumlah keluar tidak boleh lebih dari jumlah masuk',
            'tujuan_penyerahan.string' => 'Tujuan penyerahan harus berupa teks',
            'nomor_dokumen.string' => 'Nomor dokumen harus berupa teks',
            'sisa_limbah_ton.required' => 'Sisa limbah harus diisi',
            'sisa_limbah_ton.numeric' => 'Sisa limbah harus berupa angka',
            'sisa_limbah_ton.min' => 'Sisa limbah minimal 0',
            'sisa_limbah_ton.max' => 'Sisa limbah tidak boleh lebih dari jumlah masuk',
        ]);

        // Validasi logika bisnis
        $sisa = $request->sisa_limbah_ton ?? 0;
        $jumlahMasuk = $request->jumlah_masuk_ton;
        $jumlahKeluar = $request->jumlah_keluar_ton ?? 0;

        if (abs($sisa - ($jumlahMasuk - $jumlahKeluar)) > 0.001) {
            $sisa = $jumlahMasuk - $jumlahKeluar;
            $request->merge(['sisa_limbah_ton' => $sisa]);
        }

        // Validasi jika ada data keluar
        if ($request->filled('tanggal_keluar') || $request->filled('jumlah_keluar_ton') || $request->filled('tujuan_penyerahan')) {
            if (!$request->filled('tanggal_keluar')) {
                return back()->withErrors(['tanggal_keluar' => 'Tanggal keluar harus diisi jika ada data pengeluaran'])->withInput();
            }
            if (!$request->filled('jumlah_keluar_ton')) {
                return back()->withErrors(['jumlah_keluar_ton' => 'Jumlah keluar harus diisi jika ada data pengeluaran'])->withInput();
            }
            if (!$request->filled('tujuan_penyerahan')) {
                return back()->withErrors(['tujuan_penyerahan' => 'Tujuan penyerahan harus diisi jika ada data pengeluaran'])->withInput();
            }
        }

        // Validasi konsistensi jumlah
        if ($jumlahKeluar > $jumlahMasuk) {
            return back()->withErrors([
                'jumlah_keluar_ton' => 'Jumlah keluar tidak boleh lebih besar dari jumlah masuk'
            ])->withInput();
        }

        if ($sisa > $jumlahMasuk) {
            return back()->withErrors([
                'sisa_limbah_ton' => 'Sisa limbah tidak boleh lebih besar dari jumlah masuk'
            ])->withInput();
        }

        // Hitung ulang sisa untuk memastikan konsistensi
        $sisaCalculated = $jumlahMasuk - $jumlahKeluar;
        if (abs($sisa - $sisaCalculated) > 0.001) {
            return back()->withErrors([
                'sisa_limbah_ton' => 'Sisa limbah tidak sesuai dengan perhitungan (Jumlah Masuk - Jumlah Keluar)'
            ])->withInput();
        }

        WasteB3::create($request->all());

        return redirect()
            ->route('waste-b3')
            ->with('success', 'Data limbah B3 berhasil disimpan.');
    }

    /**
     * Tampilkan form edit data
     */
    public function edit($id)
    {
        $data = WasteB3::findOrFail($id);
        return view('waste-b3.edit', compact('data'));
    }

    /**
     * Perbarui data limbah B3
     */
    public function update(Request $request, $id)
    {
        $data = WasteB3::findOrFail($id);

        $request->validate([
            'jenis_limbah_masuk'   => 'required|string|max:255',
            'kode_limbah'          => 'required|string|max:50',
            'tanggal_masuk'        => 'required|date',
            'sumber_limbah'        => 'required|string|max:255',
            'jumlah_masuk_ton'     => 'required|numeric|min:0',
            'maksimal_penyimpanan' => 'required|date|after_or_equal:tanggal_masuk',
            'tanggal_keluar'       => 'nullable|date|after_or_equal:tanggal_masuk',
            'jumlah_keluar_ton'    => 'nullable|numeric|min:0|max:'.$request->jumlah_masuk_ton,
            'tujuan_penyerahan'    => 'nullable|string|max:255',
            'nomor_dokumen'        => 'nullable|string|max:100',
            'sisa_limbah_ton'      => 'required|numeric|min:0|max:'.$request->jumlah_masuk_ton,
        ], [
            'jenis_limbah_masuk.required' => 'Jenis limbah harus diisi',
            'jenis_limbah_masuk.string' => 'Jenis limbah harus berupa teks',
            'kode_limbah.required' => 'Kode limbah harus diisi',
            'kode_limbah.string' => 'Kode limbah harus berupa teks',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid',
            'sumber_limbah.required' => 'Sumber limbah harus diisi',
            'sumber_limbah.string' => 'Sumber limbah harus berupa teks',
            'jumlah_masuk_ton.required' => 'Jumlah masuk harus diisi',
            'jumlah_masuk_ton.numeric' => 'Jumlah masuk harus berupa angka',
            'jumlah_masuk_ton.min' => 'Jumlah masuk minimal 0',
            'maksimal_penyimpanan.required' => 'Maksimal penyimpanan harus diisi',
            'maksimal_penyimpanan.date' => 'Format tanggal maksimal penyimpanan tidak valid',
            'maksimal_penyimpanan.after_or_equal' => 'Maksimal penyimpanan tidak boleh kurang dari tanggal masuk',
            'tanggal_keluar.date' => 'Format tanggal keluar tidak valid',
            'tanggal_keluar.after_or_equal' => 'Tanggal keluar tidak boleh kurang dari tanggal masuk',
            'jumlah_keluar_ton.numeric' => 'Jumlah keluar harus berupa angka',
            'jumlah_keluar_ton.min' => 'Jumlah keluar minimal 0',
            'jumlah_keluar_ton.max' => 'Jumlah keluar tidak boleh lebih dari jumlah masuk',
            'tujuan_penyerahan.string' => 'Tujuan penyerahan harus berupa teks',
            'nomor_dokumen.string' => 'Nomor dokumen harus berupa teks',
            'sisa_limbah_ton.required' => 'Sisa limbah harus diisi',
            'sisa_limbah_ton.numeric' => 'Sisa limbah harus berupa angka',
            'sisa_limbah_ton.min' => 'Sisa limbah minimal 0',
            'sisa_limbah_ton.max' => 'Sisa limbah tidak boleh lebih dari jumlah masuk',
        ]);

        // Validasi logika bisnis
        $jumlahMasuk = $request->jumlah_masuk_ton;
        $jumlahKeluar = $request->jumlah_keluar_ton ?? 0;
        $sisa = $request->sisa_limbah_ton;

        if (abs($sisa - ($jumlahMasuk - $jumlahKeluar)) > 0.001) {
            $sisa = $jumlahMasuk - $jumlahKeluar;
            $request->merge(['sisa_limbah_ton' => $sisa]);
        }
        

        // Validasi jika ada data keluar
        if ($request->filled('tanggal_keluar') || $request->filled('jumlah_keluar_ton') || $request->filled('tujuan_penyerahan')) {
            if (!$request->filled('tanggal_keluar')) {
                return back()->withErrors(['tanggal_keluar' => 'Tanggal keluar harus diisi jika ada data pengeluaran'])->withInput();
            }
            if (!$request->filled('jumlah_keluar_ton')) {
                return back()->withErrors(['jumlah_keluar_ton' => 'Jumlah keluar harus diisi jika ada data pengeluaran'])->withInput();
            }
            if (!$request->filled('tujuan_penyerahan')) {
                return back()->withErrors(['tujuan_penyerahan' => 'Tujuan penyerahan harus diisi jika ada data pengeluaran'])->withInput();
            }
        }

        // Validasi konsistensi jumlah
        if ($jumlahKeluar > $jumlahMasuk) {
            return back()->withErrors([
                'jumlah_keluar_ton' => 'Jumlah keluar tidak boleh lebih besar dari jumlah masuk'
            ])->withInput();
        }

        if ($sisa > $jumlahMasuk) {
            return back()->withErrors([
                'sisa_limbah_ton' => 'Sisa limbah tidak boleh lebih besar dari jumlah masuk'
            ])->withInput();
        }

        // Hitung ulang sisa untuk memastikan konsistensi
        $sisaCalculated = $jumlahMasuk - $jumlahKeluar;
        if (abs($sisa - $sisaCalculated) > 0.001) {
            return back()->withErrors([
                'sisa_limbah_ton' => 'Sisa limbah tidak sesuai dengan perhitungan (Jumlah Masuk - Jumlah Keluar)'
            ])->withInput();
        }

        $data->update($request->all());

        return redirect()
            ->route('waste-b3')
            ->with('success', 'Data limbah B3 berhasil diperbarui.');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $data = WasteB3::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('waste-b3')
            ->with('success', 'Data limbah B3 berhasil dihapus.');
    }
}