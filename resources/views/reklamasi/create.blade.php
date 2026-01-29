@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Data Reklamasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Data Reklamasi</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('reklamasi.store') }}"
                          method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- TANGGAL REKLAMASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Reklamasi</label>
                                <input type="date"
                                       name="tanggal_reklamasi"
                                       value="{{ old('tanggal_reklamasi') }}"
                                       class="form-control @error('tanggal_reklamasi') is-invalid @enderror">

                                @error('tanggal_reklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI REKLAMASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Reklamasi</label>
                                <input type="text"
                                       name="lokasi_reklamasi"
                                       value="{{ old('lokasi_reklamasi') }}"
                                       class="form-control @error('lokasi_reklamasi') is-invalid @enderror"
                                       placeholder="Contoh: Pit Utara, Area Penutupan">

                                @error('lokasi_reklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LUAS DIREKLAMASI --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Luas Direklamasi (ha)</label>
                                <input type="number"
                                       step="0.01"
                                       name="luas_direklamasi"
                                       value="{{ old('luas_direklamasi') }}"
                                       class="form-control @error('luas_direklamasi') is-invalid @enderror"
                                       placeholder="Contoh: 12.50">

                                @error('luas_direklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS KEGIATAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Kegiatan</label>
                                <input type="text"
                                       name="jenis_kegiatan"
                                       value="{{ old('jenis_kegiatan') }}"
                                       class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                       placeholder="Contoh: Penimbunan, Perataan Lahan">

                                @error('jenis_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- METODE REKLAMASI --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Metode Reklamasi</label>
                                <input type="text"
                                       name="metode_reklamasi"
                                       value="{{ old('metode_reklamasi') }}"
                                       class="form-control @error('metode_reklamasi') is-invalid @enderror"
                                       placeholder="Contoh: Mekanis, Manual">

                                @error('metode_reklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- JENIS TANAMAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Tanaman</label>
                                <select name="jenis_tanaman"
                                        class="form-select @error('jenis_tanaman') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Tanaman --</option>
                                    <option value="pionir" {{ old('jenis_tanaman') == 'pionir' ? 'selected' : '' }}>
                                        Pionir
                                    </option>
                                    <option value="lokal" {{ old('jenis_tanaman') == 'lokal' ? 'selected' : '' }}>
                                        Lokal
                                    </option>
                                    <option value="covercrop" {{ old('jenis_tanaman') == 'covercrop' ? 'selected' : '' }}>
                                        Covercrop
                                    </option>
                                </select>
                                @error('jenis_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PUPUK --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pupuk</label>
                                <input type="text"
                                       name="pupuk"
                                       value="{{ old('pupuk') }}"
                                       class="form-control @error('pupuk') is-invalid @enderror"
                                       placeholder="Contoh: Urea, SP36">

                                @error('pupuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JUMLAH TANAMAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Tanaman</label>
                                <input type="number"
                                       name="jumlah_tanaman"
                                       value="{{ old('jumlah_tanaman') }}"
                                       class="form-control @error('jumlah_tanaman') is-invalid @enderror"
                                       placeholder="Contoh: 100">

                                @error('jumlah_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ALAT BERAT DIGUNAKAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alat Berat Digunakan</label>
                                <textarea name="alat_berat_digunakan"
                                          rows="2"
                                          class="form-control @error('alat_berat_digunakan') is-invalid @enderror"
                                          placeholder="Contoh: Dozer D85, Grader GD825">{{ old('alat_berat_digunakan') }}</textarea>

                                @error('alat_berat_digunakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- IZIN LINGKUNGAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Izin Lingkungan</label>
                                <input type="text"
                                       name="izin_lingkungan"
                                       value="{{ old('izin_lingkungan') }}"
                                       class="form-control @error('izin_lingkungan') is-invalid @enderror"
                                       placeholder="Contoh: SK Reklamasi No. 456/2024">

                                @error('izin_lingkungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS KESESUAIAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Kesesuaian</label>
                                <select name="status_kesesuaian"
                                        class="form-select @error('status_kesesuaian') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="sesuai" {{ old('status_kesesuaian') == 'sesuai' ? 'selected' : '' }}>
                                        Sesuai
                                    </option>
                                    <option value="tidak_sesuai" {{ old('status_kesesuaian') == 'tidak_sesuai' ? 'selected' : '' }}>
                                        Tidak Sesuai
                                    </option>
                                </select>

                                @error('status_kesesuaian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="2"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan inspeksi">{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('reklamasi') }}"
                               class="btn btn-light me-2">
                                Batal
                            </a>

                            <button type="submit" class="btn bg-gradient-primary">
                                Simpan
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

@endsection