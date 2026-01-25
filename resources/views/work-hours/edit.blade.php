@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Jam Kerja</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Data Jam Kerja</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.work-hours.update', $workHour->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- ALAT --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alat</label>
                                <select name="alat_id"
                                        class="form-select @error('alat_id') is-invalid @enderror">
                                    <option value="">-- Pilih Alat --</option>
                                    @foreach ($equipments as $eq)
                                        <option value="{{ $eq->id }}" {{ old('alat_id', $workHour->alat_id) == $eq->id ? 'selected' : '' }}>
                                            {{ $eq->kode }} - {{ $eq->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('alat_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TANGGAL --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date"
                                       name="tanggal"
                                       value="{{ old('tanggal', $workHour->tanggal?->format('Y-m-d')) }}"
                                       class="form-control @error('tanggal') is-invalid @enderror">

                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JAM MULAI --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time"
                                       name="jam_mulai"
                                       value="{{ old('jam_mulai', $workHour->jam_mulai) }}"
                                       class="form-control @error('jam_mulai') is-invalid @enderror">

                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JAM SELESAI --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time"
                                       name="jam_selesai"
                                       value="{{ old('jam_selesai', $workHour->jam_selesai) }}"
                                       class="form-control @error('jam_selesai') is-invalid @enderror">

                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JAM ISTIRAHAT --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jam Istirahat (jam)</label>
                                <input type="number"
                                       step="0.1"
                                       name="jam_istirahat"
                                       value="{{ old('jam_istirahat', $workHour->jam_istirahat) }}"
                                       class="form-control @error('jam_istirahat') is-invalid @enderror"
                                       placeholder="Contoh: 1 atau 0.5">

                                @error('jam_istirahat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TOTAL JAM --}}
                            <input type="number"
                                   step="0.01"
                                   name="total_jam"
                                   value="{{ old('total_jam', $workHour->total_jam) }}"
                                   class="form-control @error('total_jam') is-invalid @enderror"
                                   placeholder="Akan dihitung otomatis"
                                   readonly>

                            {{-- LOKASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text"
                                       name="lokasi"
                                       value="{{ old('lokasi', $workHour->lokasi) }}"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       placeholder="Lokasi operasional">

                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- AKTIVITAS --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Aktivitas</label>
                                <textarea name="aktivitas"
                                          rows="2"
                                          class="form-control @error('aktivitas') is-invalid @enderror"
                                          placeholder="Deskripsi kegiatan">{{ old('aktivitas', $workHour->aktivitas) }}</textarea>

                                @error('aktivitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="2"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan tambahan">{{ old('catatan', $workHour->catatan) }}</textarea>

                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.work-hours') }}"
                               class="btn btn-light me-2">
                                Batal
                            </a>

                            <button type="submit" class="btn bg-gradient-primary">
                                Update
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

</div>

{{-- MODAL ERROR VALIDASI --}}
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Terjadi Kesalahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('errorModal')).show();
});
</script>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jamMulai = document.querySelector('[name="jam_mulai"]');
    const jamSelesai = document.querySelector('[name="jam_selesai"]');
    const jamIstirahat = document.querySelector('[name="jam_istirahat"]');
    const totalJam = document.querySelector('[name="total_jam"]');

    // Fungsi hitung total jam kerja
    function hitungTotalJam() {
        if (!jamMulai.value || !jamSelesai.value) {
            totalJam.value = '';
            return;
        }

        // Parsing jam & menit
        const [startH, startM] = jamMulai.value.split(':').map(Number);
        const [endH, endM] = jamSelesai.value.split(':').map(Number);

        // Konversi ke menit
        let startMin = startH * 60 + startM;
        let endMin = endH * 60 + endM;

        // Handle kasus shift malam (misal: 22:00 - 06:00)
        if (endMin <= startMin) {
            endMin += 24 * 60; // Tambah 1 hari dalam menit
        }

        // Hitung durasi kerja (dalam jam)
        const durasiKerja = (endMin - startMin) / 60;
        const istirahat = parseFloat(jamIstirahat.value) || 0;
        const total = durasiKerja - istirahat;

        // Tampilkan dengan 2 desimal
        totalJam.value = total.toFixed(2);
    }

    // Pasang event listener
    jamMulai?.addEventListener('change', hitungTotalJam);
    jamSelesai?.addEventListener('change', hitungTotalJam);
    jamIstirahat?.addEventListener('input', hitungTotalJam);

    // Hitung saat halaman dimuat (jika ada old() value)
    setTimeout(hitungTotalJam, 100);
});
</script>
@endpush

@endsection