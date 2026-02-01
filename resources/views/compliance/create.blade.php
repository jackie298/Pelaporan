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
    .preview-box.document {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    .preview-box.document i {
        font-size: 2.5rem;
    }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-3 mx-md-4" role="alert">
        <span class="text-white">
            <strong>Tambah Dokumen Compliance</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-3 mx-md-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Dokumen Compliance</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('compliance.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">

                            {{-- NAMA PELAPOR --}}
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Nama Pelapor <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="Nama_pelapor"
                                       value="{{ old('Nama_pelapor') }}"
                                       class="form-control @error('Nama_pelapor') is-invalid @enderror"
                                       placeholder="Nama pelapor"
                                       required>
                                @error('Nama_pelapor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DEPARTEMEN --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Departemen <span class="text-danger">*</span></label>
                                <select name="Departemen"
                                        class="form-select @error('Departemen') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="HSE" {{ old('Departemen') == 'HSE' ? 'selected' : '' }}>
                                        HSE
                                    </option>
                                    <option value="Produksi" {{ old('Departemen') == 'Produksi' ? 'selected' : '' }}>
                                        Produksi
                                    </option>
                                    <option value="HRD" {{ old('Departemen') == 'HRD' ? 'selected' : '' }}>
                                        HRD
                                    </option>
                                    <option value="Maintenance" {{ old('Departemen') == 'Maintenance' ? 'selected' : '' }}>
                                        Maintenance
                                    </option>
                                    <option value="Lainnya" {{ old('Departemen') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>
                                @error('Departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Lokasi <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="Lokasi"
                                       value="{{ old('Lokasi') }}"
                                       class="form-control @error('Lokasi') is-invalid @enderror"
                                       placeholder="Lokasi kejadian"
                                       required>
                                @error('Lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TANGGAL LAPOR --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Tanggal Lapor <span class="text-danger">*</span></label>
                                <input type="date"
                                       name="Tanggal_lapor"
                                       value="{{ old('Tanggal_lapor', date('Y-m-d')) }}"
                                       class="form-control @error('Tanggal_lapor') is-invalid @enderror"
                                       required>
                                @error('Tanggal_lapor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS INSIDEN --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Jenis Insiden <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="Jenis_insiden"
                                       value="{{ old('Jenis_insiden') }}"
                                       class="form-control @error('Jenis_insiden') is-invalid @enderror"
                                       placeholder="Contoh: Kecelakaan Kerja, Tumpahan Minyak"
                                       required>
                                @error('Jenis_insiden')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS INSPESI --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Jenis Inspeksi <span class="text-danger">*</span></label>
                                <select name="Jenis_inspeksi"
                                        class="form-select @error('Jenis_inspeksi') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Jenis Inspeksi --</option>
                                    <option value="Internal" {{ old('Jenis_inspeksi') == 'Internal' ? 'selected' : '' }}>
                                        Internal
                                    </option>
                                    <option value="Eksternal/Regulasi" {{ old('Jenis_inspeksi') == 'Eksternal/Regulasi' ? 'selected' : '' }}>
                                        Eksternal / Regulasi
                                    </option>
                                    <option value="Audit" {{ old('Jenis_inspeksi') == 'Audit' ? 'selected' : '' }}>
                                        Audit
                                    </option>
                                </select>
                                @error('Jenis_inspeksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                                <select name="Status"
                                        class="form-select @error('Status') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Escalated" {{ old('Status') == 'Escalated' ? 'selected' : '' }}>
                                        Ditingkatkan
                                    </option>
                                    <option value="Pending" {{ old('Status') == 'Pending' ? 'selected' : '' }}>
                                        Tertunda
                                    </option>
                                    <option value="Resolved" {{ old('Status') == 'Resolved' ? 'selected' : '' }}>
                                        Diselesaikan
                                    </option>
                                    <option value="Open" {{ old('Status') == 'Open' ? 'selected' : '' }}>
                                        Terbuka
                                    </option>
                                </select>
                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGKAT KEPARAHAN --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label font-weight-bold">Tingkat Keparahan <span class="text-danger">*</span></label>
                                <select name="Tingkat_keparahan"
                                        class="form-select @error('Tingkat_keparahan') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Low" {{ old('Tingkat_keparahan') == 'Low' ? 'selected' : '' }}>
                                        Rendah
                                    </option>
                                    <option value="Medium" {{ old('Tingkat_keparahan') == 'Medium' ? 'selected' : '' }}>
                                        Sedang
                                    </option>
                                    <option value="High" {{ old('Tingkat_keparahan') == 'High' ? 'selected' : '' }}>
                                        Tinggi
                                    </option>
                                    <option value="Critical" {{ old('Tingkat_keparahan') == 'Critical' ? 'selected' : '' }}>
                                        Kritis
                                    </option>
                                </select>
                                @error('Tingkat_keparahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DISELESAIKAN OLEH --}}
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Diselesaikan Oleh <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="Diselesaikan_oleh"
                                       value="{{ old('Diselesaikan_oleh') }}"
                                       class="form-control @error('Diselesaikan_oleh') is-invalid @enderror"
                                       placeholder="Nama yang menyelesaikan"
                                       required>
                                @error('Diselesaikan_oleh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FILE DOKUMENTASI (MULTIPLE) --}}
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Upload File Dokumentasi (Bisa pilih banyak)</label>
                                <input type="file"
                                       id="file_input"
                                       name="file_dokumentasi[]"
                                       class="form-control @error('file_dokumentasi') is-invalid @enderror @error('file_dokumentasi.*') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       multiple>
                                
                                <div id="image-preview-container"></div>

                                <small class="form-text text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i> Format: JPG, JPEG, PNG, PDF | Maks: 2 MB per file | Maksimal 10 file.
                                </small>

                                @error('file_dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('file_dokumentasi.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 mt-4">
                            <a href="{{ route('compliance') }}" class="btn btn-light">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i> Simpan Dokumen
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

    // 2. Preview File sebelum upload
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
                    div.className = 'preview-box document shadow-sm';
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