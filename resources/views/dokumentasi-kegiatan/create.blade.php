@extends('layouts.user_type.auth')

@section('content')

<style>
    /* CSS untuk preview foto yang baru dipilih */
    #image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }
    .preview-box {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #0d4435;
        aspect-ratio: 1/1;
    }
    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

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
                                <label class="form-label font-weight-bold">Judul Kegiatan</label>
                                <input type="text" name="judul" value="{{ old('judul') }}"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       placeholder="Contoh: Inspeksi Harian Alat Berat">
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- TANGGAL --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                       class="form-control @error('tanggal') is-invalid @enderror">
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       placeholder="Contoh: Area Tambang Selatan">
                                @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- JENIS KEGIATAN --}}
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Jenis / Unit Kegiatan</label>
                                <input type="text" name="jenis_kegiatan" value="{{ old('jenis_kegiatan') }}"
                                       class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                       placeholder="Contoh: Inspeksi, Maintenance, Operasional">
                                @error('jenis_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror"
                                          placeholder="Uraikan kegiatan secara lengkap">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- FILE DOKUMENTASI (MULTIPLE) --}}
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Upload Foto Dokumentasi (Bisa pilih banyak)</label>
                                <input type="file"
                                       id="file_input"
                                       name="file_dokumentasi[]" 
                                       class="form-control @error('file_dokumentasi') is-invalid @enderror @error('file_dokumentasi.*') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       multiple> {{-- KUNCI UTAMA --}}

                                <div id="image-preview-container"></div> {{-- Tempat preview foto --}}

                                <small class="form-text text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i> Format: JPG, JPEG, PNG, PDF | Maks: 2 MB per file.
                                </small>

                                @error('file_dokumentasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('file_dokumentasi.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 mt-4">
                            <a href="{{ route('admin.dokumentasi-kegiatan') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary">Simpan Dokumentasi</button>
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
            <div class="modal-header bg-danger text-white">
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
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Tampilkan Modal Error jika ada validasi gagal
    @if ($errors->any())
        new bootstrap.Modal(document.getElementById('errorModal')).show();
    @endif

    // 2. Preview Foto sebelum upload (UX tambahan agar user yakin fotonya sudah terpilih)
    const fileInput = document.getElementById('file_input');
    const previewContainer = document.getElementById('image-preview-container');

    fileInput.addEventListener('change', function() {
        previewContainer.innerHTML = ''; // Reset preview
        const files = this.files;

        if (files) {
            [...files].forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'preview-box shadow-sm';
                        div.innerHTML = `<img src="${e.target.result}">`;
                        previewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    const div = document.createElement('div');
                    div.className = 'preview-box shadow-sm d-flex align-items-center justify-content-center bg-light';
                    div.innerHTML = `<i class="fas fa-file-pdf fa-3x text-danger"></i>`;
                    previewContainer.appendChild(div);
                }
            });
        }
    });
});
</script>
@endpush

@endsection