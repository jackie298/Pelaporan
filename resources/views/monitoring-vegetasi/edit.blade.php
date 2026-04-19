@extends('layouts.user_type.auth')

@section('content')

<style>
    /* ===== THEME VARIABLES (Consistent with Reference) ===== */
    :root {
        --primary-gradient: linear-gradient(135deg, #2dce89, #2dcecc);
        --info-gradient: linear-gradient(135deg, #1171ef, #0dcaf0);
        --danger-gradient: linear-gradient(135deg, #f5365c, #ec3368);
        --warning-gradient: linear-gradient(135deg, #fb6340, #fbb140);
        --secondary-gradient: linear-gradient(135deg, #67748e, #8392ab);
        --card-bg: #ffffff;
        --text-primary: #344767;
        --text-secondary: #67748e;
        --border-color: rgba(0, 0, 0, 0.1);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
        --radius: 16px;
        --radius-sm: 12px;
        --input-bg: #f8f9fa;
        --input-focus-border: #1171ef;
        --input-focus-shadow: rgba(17, 113, 239, 0.15);
    }

    /* ===== GLOBAL READABILITY ===== */
    .form-card, .form-card * { color: var(--text-primary) !important; }

    /* ===== ALERT HEADER ===== */
    .alert-header {
        background: var(--info-gradient);
        border: none;
        border-radius: var(--radius);
        padding: 14px 20px;
        margin: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }
    .alert-header::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        pointer-events: none;
    }
    .alert-header .text-white {
        position: relative; z-index: 1; font-weight: 600; font-size: 0.95rem;
        display: flex; align-items: center; gap: 8px; color: #fff !important;
    }
    .alert-header i { font-size: 1.1rem; }

    /* ===== FORM CARD ===== */
    .form-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin: 0 16px 20px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }
    .form-card:hover { box-shadow: var(--shadow-md); }

    .form-card .card-header {
        background: transparent;
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
    }
    .form-card .card-header h5 {
        color: #344767 !important;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-card .card-header h5 i { color: #1171ef; }

    .form-card .card-body { padding: 24px; }

    /* ===== FORM LABELS ===== */
    .form-card .form-label {
        color: #344767 !important;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .form-card .form-label i { color: #1171ef; font-size: 0.8rem; }
    .form-card .form-label .required { color: #f5365c; margin-left: 2px; }

    /* ===== FORM INPUTS ===== */
    .form-card .form-control,
    .form-card .form-select,
    .form-card textarea,
    .form-card .input-group-text {
        background: var(--input-bg);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.9rem;
        color: #344767 !important;
        font-weight: 500;
        transition: all 0.2s;
        width: 100%;
    }
    .form-card .form-control:focus,
    .form-card .form-select:focus,
    .form-card textarea:focus {
        background: #fff;
        border-color: var(--input-focus-border);
        box-shadow: 0 0 0 4px var(--input-focus-shadow);
        outline: none;
        color: #344767 !important;
    }
    .form-card .form-control::placeholder,
    .form-card textarea::placeholder {
        color: #adb5bd;
        font-weight: 400;
    }
    .form-card textarea {
        min-height: 80px;
        resize: vertical;
    }
    .form-card .input-group-text {
        border-right: none;
        background: var(--input-bg);
        color: #1171ef;
        width: auto;
    }
    .form-card .input-group .form-control {
        border-left: none;
    }
    .form-card .input-group .form-control:focus {
        box-shadow: none;
    }

    /* ===== VALIDATION STYLES ===== */
    .form-card .is-invalid {
        border-color: #f5365c !important;
        background-image: none !important;
    }
    .form-card .is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(245, 54, 92, 0.15) !important;
    }
    .form-card .invalid-feedback {
        display: block;
        color: #f5365c !important;
        font-size: 0.75rem;
        margin-top: 4px;
        font-weight: 500;
    }

    /* ===== INPUT HINTS ===== */
    .form-hint {
        font-size: 0.7rem;
        color: var(--text-secondary);
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .form-hint i { font-size: 0.65rem; }

    /* ===== SECTION TITLE ===== */
    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #344767 !important;
        font-weight: 700;
        font-size: 1rem;
        margin: 24px 0 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--border-color);
    }
    .section-title i { color: #1171ef; }

    /* ===== ACTION BUTTONS ===== */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
        margin-top: 20px;
    }
    .form-actions .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 24px;
        font-size: 0.9rem;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .form-actions .btn-light {
        background: #e9ecef;
        color: #344767 !important;
    }
    .form-actions .btn-light:hover {
        background: #dee2e6;
        transform: translateY(-2px);
    }
    .form-actions .btn.bg-gradient-primary {
        background: var(--primary-gradient);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
    }
    .form-actions .btn.bg-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 206, 137, 0.45);
    }
    .form-actions .btn:active { transform: translateY(0); }
    .form-actions .btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none !important; }

    /* ===== MODAL ERROR ===== */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .modal-header.bg-danger {
        background: var(--danger-gradient) !important;
        border-radius: 20px 20px 0 0;
        border: none;
        padding: 18px 24px;
    }
    .modal-title { font-weight: 700; font-size: 1.1rem; color: #fff !important; }
    .modal-body { padding: 24px; color: #344767 !important; }
    .modal-body ul { padding-left: 20px; margin: 0; }
    .modal-body li { margin-bottom: 4px; font-size: 0.9rem; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .alert-header, .form-card { margin-left: 12px; margin-right: 12px; }
        .form-card .card-body { padding: 16px; }
        .form-actions { flex-direction: column-reverse; }
        .form-actions .btn { width: 100%; justify-content: center; }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes slideIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .form-card { animation: slideIn 0.4s ease forwards; }
    @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
    .form-card .is-invalid { animation: shake 0.3s ease; }
    .form-control:focus-visible, .form-select:focus-visible, .btn:focus-visible { outline: 2px solid var(--input-focus-border); outline-offset: 2px; }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert-header">
        <span class="text-white">
            <i class="fas fa-leaf"></i>
            <strong>Edit Data Monitoring Vegetasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="form-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-edit"></i>
                        Form Edit Data Monitoring Vegetasi
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('monitoring-vegetasi.update', $data->id) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- LOKASI --}}
                            <div class="col-md-6">
                                <label class="form-label" for="lokasi">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="lokasi"
                                       name="lokasi"
                                       value="{{ old('lokasi', $data->lokasi) }}"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       placeholder="Contoh: Pit Utara, Area Reklamasi"
                                       maxlength="255">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Nama lokasi monitoring vegetasi
                                </small>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TITIK PANTAU --}}
                            <div class="col-md-6">
                                <label class="form-label" for="titik_pantau">
                                    <i class="fas fa-crosshairs"></i> Titik Pantau <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="titik_pantau"
                                       name="titik_pantau"
                                       value="{{ old('titik_pantau', $data->titik_pantau) }}"
                                       class="form-control @error('titik_pantau') is-invalid @enderror"
                                       placeholder="Contoh: TP-001, Koordinat GPS"
                                       maxlength="255">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Kode atau koordinat titik pantau
                                </small>
                                @error('titik_pantau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS TANAMAN --}}
                            <div class="col-md-12">
                                <label class="form-label" for="jenis_tanaman">
                                    <i class="fas fa-seedling"></i> Jenis Tanaman <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="jenis_tanaman"
                                       name="jenis_tanaman"
                                       value="{{ old('jenis_tanaman', $data->jenis_tanaman) }}"
                                       class="form-control @error('jenis_tanaman') is-invalid @enderror"
                                       placeholder="Contoh: Sengon, Jati, Mahoni"
                                       maxlength="255">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Spesies tanaman yang dimonitor
                                </small>
                                @error('jenis_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TAHUN --}}
                            <div class="col-md-4">
                                <label class="form-label" for="tahun">
                                    <i class="fas fa-calendar-alt"></i> Tahun Pengukuran <span class="required">*</span>
                                </label>
                                <input type="number"
                                       id="tahun"
                                       name="tahun"
                                       value="{{ old('tahun', $data->tahun) }}"
                                       class="form-control @error('tahun') is-invalid @enderror"
                                       placeholder="Contoh: 2026"
                                       min="2020"
                                       max="2099">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Tahun pelaksanaan monitoring
                                </small>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SECTION: TINGGI TRIWULAN --}}
                            <div class="col-12">
                                <h6 class="section-title">
                                    <i class="fas fa-chart-line"></i>Tinggi Tanaman per Triwulan (cm)
                                </h6>
                            </div>

                            {{-- TINGGI TRIWULAN 1 --}}
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="tinggi_triwulan1">
                                    <i class="fas fa-ruler-vertical"></i> Triwulan I
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">cm</span>
                                    <input type="number"
                                           id="tinggi_triwulan1"
                                           name="tinggi_triwulan1"
                                           value="{{ old('tinggi_triwulan1', $data->tinggi_triwulan1) }}"
                                           class="form-control @error('tinggi_triwulan1') is-invalid @enderror"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0">
                                </div>
                                @error('tinggi_triwulan1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGGI TRIWULAN 2 --}}
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="tinggi_triwulan2">
                                    <i class="fas fa-ruler-vertical"></i> Triwulan II
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">cm</span>
                                    <input type="number"
                                           id="tinggi_triwulan2"
                                           name="tinggi_triwulan2"
                                           value="{{ old('tinggi_triwulan2', $data->tinggi_triwulan2) }}"
                                           class="form-control @error('tinggi_triwulan2') is-invalid @enderror"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0">
                                </div>
                                @error('tinggi_triwulan2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGGI TRIWULAN 3 --}}
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="tinggi_triwulan3">
                                    <i class="fas fa-ruler-vertical"></i> Triwulan III
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">cm</span>
                                    <input type="number"
                                           id="tinggi_triwulan3"
                                           name="tinggi_triwulan3"
                                           value="{{ old('tinggi_triwulan3', $data->tinggi_triwulan3) }}"
                                           class="form-control @error('tinggi_triwulan3') is-invalid @enderror"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0">
                                </div>
                                @error('tinggi_triwulan3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGGI TRIWULAN 4 --}}
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="tinggi_triwulan4">
                                    <i class="fas fa-ruler-vertical"></i> Triwulan IV
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">cm</span>
                                    <input type="number"
                                           id="tinggi_triwulan4"
                                           name="tinggi_triwulan4"
                                           value="{{ old('tinggi_triwulan4', $data->tinggi_triwulan4) }}"
                                           class="form-control @error('tinggi_triwulan4') is-invalid @enderror"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0">
                                </div>
                                @error('tinggi_triwulan4')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12">
                                <label class="form-label" for="catatan">
                                    <i class="fas fa-sticky-note"></i> Catatan
                                </label>
                                <textarea id="catatan"
                                          name="catatan"
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan tambahan tentang kondisi tanaman atau pengamatan lapangan"
                                          maxlength="1000">{{ old('catatan', $data->catatan) }}</textarea>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Informasi tambahan (opsional)
                                </small>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="form-actions">
                            <a href="{{ route('monitoring-vegetasi') }}" class="btn btn-light">
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

{{-- MODAL ERROR VALIDASI --}}
@if ($errors->any())
<div class="modal fade show" id="errorModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Harap perbaiki kesalahan berikut:</p>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn bg-gradient-danger px-4" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i>Paham
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('✅ Form script loaded successfully.');

    // 1. Auto-show error modal jika validasi gagal
    @if ($errors->any())
        const errorModalEl = document.getElementById('errorModal');
        if (errorModalEl) {
            const modal = new bootstrap.Modal(errorModalEl);
            modal.show();
        }
    @endif

    // 2. Form Submission Handler (Simple & Safe)
    const form = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            // Simple loading state - biarkan form submit normal
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memperbarui...';
        });
    }

    // 3. Ripple effect for buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.disabled) return;
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute; width: ${size}px; height: ${size}px;
                border-radius: 50%; background: rgba(255,255,255,0.4);
                left: ${x}px; top: ${y}px; animation: ripple 0.6s ease-out;
                pointer-events: none; z-index: 0;
            `;
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Inject ripple animation CSS
    if (!document.getElementById('ripple-style')) {
        const style = document.createElement('style');
        style.id = 'ripple-style';
        style.textContent = `@keyframes ripple { to { transform: scale(2); opacity: 0; } }`;
        document.head.appendChild(style);
    }
});
</script>
@endpush

@endsection