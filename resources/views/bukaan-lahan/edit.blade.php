@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Data Bukaan Lahan</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Data Bukaan Lahan</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('bukaan-lahan.update', $data->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- TANGGAL BUKAAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Bukaan</label>
                                <input type="date"
                                       name="tanggal_bukaan"
                                       value="{{ old('tanggal_bukaan', $data->tanggal_bukaan?->format('Y-m-d')) }}"
                                       class="form-control @error('tanggal_bukaan') is-invalid @enderror">

                                @error('tanggal_bukaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI BUKAAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Bukaan</label>
                                <input type="text"
                                       name="lokasi_bukaan"
                                       value="{{ old('lokasi_bukaan', $data->lokasi_bukaan) }}"
                                       class="form-control @error('lokasi_bukaan') is-invalid @enderror"
                                       placeholder="Contoh: Blok A Pit Utara">

                                @error('lokasi_bukaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LUAS DIBUKA --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Luas Dibuka (ha)</label>
                                <input type="number"
                                       step="0.01"
                                       name="luas_dibuka"
                                       value="{{ old('luas_dibuka', $data->luas_dibuka) }}"
                                       class="form-control @error('luas_dibuka') is-invalid @enderror"
                                       placeholder="Contoh: 8.50">

                                @error('luas_dibuka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS VEGETASI AWAL --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Vegetasi Awal</label>
                                <input type="text"
                                       name="jenis_vegetasi_awal"
                                       value="{{ old('jenis_vegetasi_awal', $data->jenis_vegetasi_awal) }}"
                                       class="form-control @error('jenis_vegetasi_awal') is-invalid @enderror"
                                       placeholder="Contoh: Hutan Sekunder">

                                @error('jenis_vegetasi_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- METODE PEMBUKAAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Metode Pembukaan</label>
                                <input type="text"
                                       name="metode_pembukaan"
                                       value="{{ old('metode_pembukaan', $data->metode_pembukaan) }}"
                                       class="form-control @error('metode_pembukaan') is-invalid @enderror"
                                       placeholder="Contoh: Mekanis">

                                @error('metode_pembukaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ALAT BERAT DIGUNAKAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alat Berat Digunakan</label>
                                <textarea name="alat_berat_digunakan"
                                          rows="2"
                                          class="form-control @error('alat_berat_digunakan') is-invalid @enderror"
                                          placeholder="Contoh: Excavator PC300, Dump Truck HD785">{{ old('alat_berat_digunakan', $data->alat_berat_digunakan) }}</textarea>

                                @error('alat_berat_digunakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- IZIN LINGKUNGAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Izin Lingkungan</label>
                                <input type="text"
                                       name="izin_lingkungan"
                                       value="{{ old('izin_lingkungan', $data->izin_lingkungan) }}"
                                       class="form-control @error('izin_lingkungan') is-invalid @enderror"
                                       placeholder="Contoh: SK AMDAL No. 123/2024">

                                @error('izin_lingkungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS KESESUAIAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Status Kesesuaian</label>
                                <select name="status_kesesuaian"
                                        class="form-select @error('status_kesesuaian') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="sesuai" {{ old('status_kesesuaian', $data->status_kesesuaian) == 'sesuai' ? 'selected' : '' }}>
                                        Sesuai
                                    </option>
                                    <option value="tidak_sesuai" {{ old('status_kesesuaian', $data->status_kesesuaian) == 'tidak_sesuai' ? 'selected' : '' }}>
                                        Tidak Sesuai
                                    </option>
                                </select>

                                @error('status_kesesuaian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('bukaan-lahan') }}"
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

@endsection