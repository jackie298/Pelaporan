@extends('layouts.user_type.auth')

@section('content')

<style>
    /* CSS Tambahan untuk Preview Multiple File */
    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }
    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #0d4435;
        aspect-ratio: 1/1;
    }
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-item.document {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    .preview-item.document i {
        font-size: 2.5rem;
    }
    .file-badge {
        font-size: 0.7rem;
        background: #0d4435;
        color: white;
        padding: 4px 8px;
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        opacity: 0.9;
    }
    .alert-info-custom {
        background-color: #e7f3ff;
        border-left: 4px solid #2196F3;
        padding: 12px;
        margin-top: 10px;
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-3 mx-md-4" role="alert">
        <span class="text-white">
            <strong>Edit Dokumen Compliance</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-3 mx-md-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Dokumen Compliance</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('compliance.update', $data->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- NAMA PELAPOR --}}
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Nama Pelapor <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="Nama_pelapor"
                                       value="{{ old('Nama_pelapor', $data->Nama_pelapor) }}"
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
                                    <option value="HSE" {{ old('Departemen', $data->Departemen) == 'HSE' ? 'selected' : '' }}>
                                        HSE
                                    </option>
                                    <option value="Produksi" {{ old('Departemen', $data->Departemen) == 'Produksi' ? 'selected' : '' }}>
                                        Produksi
                                    </option>
                                    <option value="HRD" {{ old('Departemen', $data->Departemen) == 'HRD' ? 'selected' : '' }}>
                                        HRD
                                    </option>
                                    <option value="Maintenance" {{ old('Departemen', $data->Departemen) == 'Maintenance' ? 'selected' : '' }}>
                                        Maintenance
                                    </option>
                                    <option value="Lainnya" {{ old('Departemen', $data->Departemen) == 'Lainnya' ? 'selected' : '' }}>
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
                                       value="{{ old('Lokasi', $data->Lokasi) }}"
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
                                       value="{{ old('Tanggal_lapor', $data->Tanggal_lapor?->format('Y-m-d')) }}"
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
                                       value="{{ old('Jenis_insiden', $data->Jenis_insiden) }}"
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
                                    <option value="Internal" {{ old('Jenis_inspeksi', $data->Jenis_inspeksi) == 'Internal' ? 'selected' : '' }}>
                                        Internal
                                    </option>
                                    <option value="Eksternal/Regulasi" {{ old('Jenis_inspeksi', $data->Jenis_inspeksi) == 'Eksternal/Regulasi' ? 'selected' : '' }}>
                                        Eksternal / Regulasi
                                    </option>
                                    <option value="Audit" {{ old('Jenis_inspeksi', $data->Jenis_inspeksi) == 'Audit' ? 'selected' : '' }}>
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
                                    <option value="Escalated" {{ old('Status', $data->Status) == 'Escalated' ? 'selected' : '' }}>
                                        Ditingkatkan
                                    </option>
                                    <option value="Pending" {{ old('Status', $data->Status) == 'Pending' ? 'selected' : '' }}>
                                        Tertunda
                                    </option>
                                    <option value="Resolved" {{ old('Status', $data->Status) == 'Resolved' ? 'selected' : '' }}>
                                        Diselesaikan
                                    </option>
                                    <option value="Open" {{ old('Status', $data->Status) == 'Open' ? 'selected' : '' }}>
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
                                    <option value="Low" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'Low' ? 'selected' : '' }}>
                                        Rendah
                                    </option>
                                    <option value="Medium" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'Medium' ? 'selected' : '' }}>
                                        Sedang
                                    </option>
                                    <option value="High" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'High' ? 'selected' : '' }}>
                                        Tinggi
                                    </option>
                                    <option value="Critical" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'Critical' ? 'selected' : '' }}>
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
                                       value="{{ old('Diselesaikan_oleh', $data->Diselesaikan_oleh) }}"
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
                                       name="file_dokumentasi[]"
                                       class="form-control @error('file_dokumentasi') is-invalid @enderror @error('file_dokumentasi.*') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       multiple>

                                <small class="form-text text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i> Format: JPG, JPEG, PNG, PDF | Maks: 2 MB per file | Maksimal 10 file.
                                </small>

                                {{-- Tampilkan daftar file lama --}}
                                @if($data->file_dokumentasi && is_array($data->file_dokumentasi) && count($data->file_dokumentasi) > 0)
                                    <div class="mt-4">
                                        <p class="mb-2 font-weight-bold" style="font-size: 0.85rem;">File saat ini ({{ count($data->file_dokumentasi) }} item):</p>
                                        <div class="preview-container">
                                            @foreach($data->file_dokumentasi as $path)
                                                @php $ext = pathinfo($path, PATHINFO_EXTENSION); @endphp
                                                <div class="preview-item {{ in_array(strtolower($ext), ['jpg', 'jpeg', 'png']) ? '' : 'document' }}">
                                                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                        <img src="{{ asset('storage/' . $path) }}" alt="Preview">
                                                    @else
                                                        <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                    @endif
                                                    <div class="file-badge text-truncate px-1">{{ basename($path) }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="alert-info-custom mt-2">
                                            <i class="fas fa-info-circle me-1"></i> <strong>Catatan:</strong> Mengupload file baru akan menggantikan <strong>seluruh</strong> file lama di atas.
                                        </div>
                                    </div>
                                @endif

                                @error('file_dokumentasi')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('file_dokumentasi.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 mt-4">
                            <a href="{{ route('compliance') }}" class="btn btn-light">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i> Update Dokumen
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