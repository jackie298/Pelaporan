@extends('layouts.user_type.auth')

@section('content')

<style>
    /* ===== THEME VARIABLES (Consistent with Create Page) ===== */
    :root {
        --primary-gradient: linear-gradient(135deg, #2dce89, #2dcecc);
        --info-gradient: linear-gradient(135deg, #1171ef, #0dcaf0);
        --danger-gradient: linear-gradient(135deg, #f5365c, #ec3368);
        --card-bg: #ffffff;
        --text-primary: #344767;
        --text-secondary: #67748e;
        --border-color: rgba(0, 0, 0, 0.1);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
        --radius: 16px;
        --input-bg: #f8f9fa;
        --input-focus-border: #1171ef;
    }

    /* ===== GLOBAL ===== */
    .form-card, .form-card * { color: var(--text-primary) !important; }

    /* ===== ALERT HEADER ===== */
    .alert-header {
        background: var(--info-gradient); border: none; border-radius: var(--radius);
        padding: 14px 20px; margin: 16px; display: flex; align-items: center; gap: 10px;
        box-shadow: var(--shadow-md);
    }
    .alert-header .text-white {
        font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; color: #fff !important;
    }

    /* ===== FORM CARD ===== */
    .form-card {
        background: var(--card-bg); border-radius: var(--radius);
        border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);
        margin: 0 16px 20px;
    }
    .form-card .card-header {
        background: transparent; border-bottom: 1px solid var(--border-color); padding: 20px 24px;
    }
    .form-card .card-header h5 {
        color: #344767 !important; font-weight: 700; font-size: 1.1rem; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .form-card .card-header h5 i { color: #1171ef; }
    .form-card .card-body { padding: 24px; }

    /* ===== FORM LABELS & INPUTS ===== */
    .form-card .form-label {
        color: #344767 !important; font-weight: 700; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 6px;
        display: flex; align-items: center; gap: 4px;
    }
    .form-card .form-label i { color: #1171ef; font-size: 0.8rem; }
    .form-card .form-label .required { color: #f5365c; margin-left: 2px; }

    .form-card .form-control, .form-card .form-select, .form-card textarea {
        background: var(--input-bg); border: 2px solid var(--border-color);
        border-radius: 10px; padding: 10px 14px; font-size: 0.9rem;
        color: #344767 !important; font-weight: 500; transition: all 0.2s; width: 100%;
    }
    .form-card .form-control:focus, .form-card .form-select:focus, .form-card textarea:focus {
        background: #fff; border-color: var(--input-focus-border);
        box-shadow: 0 0 0 4px rgba(17, 113, 239, 0.15); outline: none;
    }
    .form-card textarea { min-height: 80px; resize: vertical; }

    /* ===== VALIDATION ===== */
    .form-card .is-invalid { border-color: #f5365c !important; }
    .form-card .invalid-feedback {
        display: block; color: #f5365c !important; font-size: 0.75rem; margin-top: 4px; font-weight: 500;
    }

    /* ===== ACTION BUTTONS ===== */
    .form-actions {
        display: flex; justify-content: flex-end; gap: 12px;
        padding-top: 20px; border-top: 1px solid var(--border-color); margin-top: 20px;
    }
    .form-actions .btn {
        border-radius: 10px; font-weight: 600; padding: 10px 24px; font-size: 0.9rem;
        border: none; display: inline-flex; align-items: center; gap: 6px;
    }
    .form-actions .btn-light { background: #e9ecef; color: #344767 !important; }
    .form-actions .btn.bg-gradient-primary {
        background: var(--primary-gradient); color: #fff !important;
    }
    .form-actions .btn:disabled { opacity: 0.7; cursor: not-allowed; }

    /* ===== MODAL ===== */
    .modal-content { border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .modal-header.bg-danger {
        background: var(--danger-gradient) !important; border-radius: 20px 20px 0 0; border: none; padding: 18px 24px;
    }
    .modal-title { font-weight: 700; font-size: 1.1rem; color: #fff !important; }
    .modal-body { padding: 24px; color: #344767 !important; }
    .modal-body ul { padding-left: 20px; margin: 0; }

    @media (max-width: 767px) {
        .alert-header, .form-card { margin-left: 12px; margin-right: 12px; }
        .form-actions { flex-direction: column-reverse; }
        .form-actions .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert-header">
        <span class="text-white">
            <i class="fas fa-leaf"></i>
            <strong>Edit Data Reklamasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <div class="card-header">
                    <h5><i class="fas fa-edit"></i> Form Edit Data Reklamasi</h5>
                </div>

                <div class="card-body">
                    {{-- FORM: Method PUT untuk update --}}
                    <form action="{{ route('reklamasi.update', $data->id) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- TANGGAL --}}
                            <div class="col-md-6">
                                <label class="form-label" for="tanggal_reklamasi">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Reklamasi <span class="required">*</span>
                                </label>
                                <input type="date" id="tanggal_reklamasi" name="tanggal_reklamasi" 
                                       value="{{ old('tanggal_reklamasi', $data->tanggal_reklamasi?->format('Y-m-d')) }}"
                                       class="form-control @error('tanggal_reklamasi') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}">
                                @error('tanggal_reklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-md-6">
                                <label class="form-label" for="lokasi_reklamasi">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi Reklamasi <span class="required">*</span>
                                </label>
                                <input type="text" id="lokasi_reklamasi" name="lokasi_reklamasi" 
                                       value="{{ old('lokasi_reklamasi', $data->lokasi_reklamasi) }}"
                                       class="form-control @error('lokasi_reklamasi') is-invalid @enderror"
                                       placeholder="Contoh: Pit Utara">
                                @error('lokasi_reklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LUAS --}}
                            <div class="col-md-4">
                                <label class="form-label" for="luas_direklamasi">
                                    <i class="fas fa-ruler-combined"></i> Luas (ha) <span class="required">*</span>
                                </label>
                                <input type="number" id="luas_direklamasi" name="luas_direklamasi" 
                                       value="{{ old('luas_direklamasi', $data->luas_direklamasi) }}"
                                       class="form-control @error('luas_direklamasi') is-invalid @enderror"
                                       placeholder="0.00" step="0.01" min="0">
                                @error('luas_direklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS KEGIATAN --}}
                            <div class="col-md-4">
                                <label class="form-label" for="jenis_kegiatan">
                                    <i class="fas fa-tasks"></i> Jenis Kegiatan <span class="required">*</span>
                                </label>
                                <input type="text" id="jenis_kegiatan" name="jenis_kegiatan" 
                                       value="{{ old('jenis_kegiatan', $data->jenis_kegiatan) }}"
                                       class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                       placeholder="Contoh: Penimbunan">
                                @error('jenis_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- METODE REKLAMASI --}}
                            <div class="col-md-4">
                                <label class="form-label" for="metode_reklamasi">
                                    <i class="fas fa-cogs"></i> Metode Reklamasi <span class="required">*</span>
                                </label>
                                <input type="text" id="metode_reklamasi" name="metode_reklamasi" 
                                       value="{{ old('metode_reklamasi', $data->metode_reklamasi) }}"
                                       class="form-control @error('metode_reklamasi') is-invalid @enderror"
                                       placeholder="Contoh: Mekanis">
                                @error('metode_reklamasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ALAT BERAT --}}
                            <div class="col-md-6">
                                <label class="form-label" for="alat_berat_digunakan">
                                    <i class="fas fa-truck-monster"></i> Alat Berat Digunakan
                                </label>
                                <textarea id="alat_berat_digunakan" name="alat_berat_digunakan" rows="2"
                                          class="form-control @error('alat_berat_digunakan') is-invalid @enderror"
                                          placeholder="Contoh: Dozer D85">{{ old('alat_berat_digunakan', $data->alat_berat_digunakan) }}</textarea>
                                @error('alat_berat_digunakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- IZIN LINGKUNGAN --}}
                            <div class="col-md-6">
                                <label class="form-label" for="izin_lingkungan">
                                    <i class="fas fa-file-contract"></i> Izin Lingkungan
                                </label>
                                <input type="text" id="izin_lingkungan" name="izin_lingkungan" 
                                       value="{{ old('izin_lingkungan', $data->izin_lingkungan) }}"
                                       class="form-control @error('izin_lingkungan') is-invalid @enderror"
                                       placeholder="Contoh: SK AMDAL No. 123">
                                @error('izin_lingkungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-6">
                                <label class="form-label" for="status_kesesuaian">
                                    <i class="fas fa-clipboard-check"></i> Status Kesesuaian <span class="required">*</span>
                                </label>
                                <select id="status_kesesuaian" name="status_kesesuaian" 
                                        class="form-select @error('status_kesesuaian') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="sesuai" {{ old('status_kesesuaian', $data->status_kesesuaian) == 'sesuai' ? 'selected' : '' }}>✅ Sesuai</option>
                                    <option value="tidak_sesuai" {{ old('status_kesesuaian', $data->status_kesesuaian) == 'tidak_sesuai' ? 'selected' : '' }}>❌ Tidak Sesuai</option>
                                </select>
                                @error('status_kesesuaian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-6">
                                <label class="form-label" for="catatan">
                                    <i class="fas fa-sticky-note"></i> Catatan
                                </label>
                                <textarea id="catatan" name="catatan" rows="2"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan tambahan">{{ old('catatan', $data->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="form-actions">
                            {{-- PERBAIKAN: Gunakan route('reklamasi.index') --}}
                            <a href="{{ route('reklamasi') }}" class="btn btn-light">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ERROR --}}
@if ($errors->any())
<div class="modal fade show" id="errorModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white"><i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Harap perbaiki kesalahan berikut:</p>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn bg-gradient-danger px-4" data-bs-dismiss="modal">Paham</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Auto-show modal error jika ada validasi gagal
    @if ($errors->any())
        const modal = new bootstrap.Modal(document.getElementById('errorModal'));
        modal.show();
    @endif

    // 2. Simple loading state untuk tombol submit
    const form = document.getElementById('editForm');
    const btn = document.getElementById('submitBtn');
    
    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memperbarui...';
        });
    }
});
</script>
@endpush

@endsection