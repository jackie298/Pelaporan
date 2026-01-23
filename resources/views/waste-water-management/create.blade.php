@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Data Pengelolaan Air Limbah</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Data Air Limbah</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('waste-water-management.store') }}"
                          method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- TANGGAL SAMPLING --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Sampling</label>
                                <input type="date"
                                       name="tanggal_sampling"
                                       value="{{ old('tanggal_sampling') }}"
                                       class="form-control @error('tanggal_sampling') is-invalid @enderror">

                                @error('tanggal_sampling')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI SAMPLING --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Sampling</label>
                                <input type="text"
                                       name="lokasi_sampling"
                                       value="{{ old('lokasi_sampling') }}"
                                       class="form-control @error('lokasi_sampling') is-invalid @enderror"
                                       placeholder="Contoh: Outfall IPAL, Sungai Hilir">

                                @error('lokasi_sampling')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PH --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">pH</label>
                                <input type="number"
                                       step="0.1"
                                       name="ph"
                                       value="{{ old('ph') }}"
                                       class="form-control @error('ph') is-invalid @enderror"
                                       placeholder="Rentang 0.0 - 14.0">

                                @error('ph')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TSS --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">TSS (mg/L)</label>
                                <input type="number"
                                       step="0.01"
                                       name="tss"
                                       value="{{ old('tss') }}"
                                       class="form-control @error('tss') is-invalid @enderror"
                                       placeholder="Total Suspended Solids">

                                @error('tss')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS KESESUAIAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status Kesesuaian</label>
                                <select name="status_kesesuaian"
                                        class="form-select @error('status_kesesuaian') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="memenuhi" {{ old('status_kesesuaian') == 'memenuhi' ? 'selected' : '' }}>
                                        Memenuhi Baku Mutu
                                    </option>
                                    <option value="tidak_memenuhi" {{ old('status_kesesuaian') == 'tidak_memenuhi' ? 'selected' : '' }}>
                                        Tidak Memenuhi Baku Mutu
                                    </option>
                                </select>

                                @error('status_kesesuaian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan inspeksi atau kondisi khusus">{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('waste-water-management') }}"
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