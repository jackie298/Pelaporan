@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-3 mx-md-4" role="alert">
        <span class="text-white">
            <strong>Tambah Dokumentasi Kegiatan</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-3 mx-md-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Dokumentasi Kegiatan</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.dokumentasi-kegiatan.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">

                            {{-- JUDUL --}}
                            <div class="col-12">
                                <label class="form-label">Judul</label>
                                <input type="text"
                                       name="judul"
                                       value="{{ old('judul') }}"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       placeholder="Contoh: Inspeksi Harian Alat Berat">

                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TANGGAL --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date"
                                       name="tanggal"
                                       value="{{ old('tanggal') }}"
                                       class="form-control @error('tanggal') is-invalid @enderror">

                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text"
                                       name="lokasi"
                                       value="{{ old('lokasi') }}"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       placeholder="Contoh: Area Tambang Selatan">

                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS KEGIATAN --}}
                            <div class="col-12">
                                <label class="form-label">Jenis Kegiatan</label>
                                <input type="text"
                                       name="jenis_kegiatan"
                                       value="{{ old('jenis_kegiatan') }}"
                                       class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                       placeholder="Contoh: Inspeksi, Maintenance, Operasional">

                                @error('jenis_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi"
                                          rows="4"
                                          class="form-control @error('deskripsi') is-invalid @enderror"
                                          placeholder="Uraikan kegiatan secara lengkap">{{ old('deskripsi') }}</textarea>

                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FILE DOKUMENTASI --}}
                            <div class="col-12">
                                <label class="form-label">File Dokumentasi (Foto/Laporan)</label>
                                <input type="file"
                                       name="file_dokumentasi"
                                       class="form-control @error('file_dokumentasi') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf">

                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, PDF | Maks: 2 MB
                                </small>

                                @error('file_dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 mt-4">
                            <a href="{{ route('admin.dokumentasi-kegiatan') }}"
                               class="btn btn-light">
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