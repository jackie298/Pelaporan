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
    .form-card .form-textarea {
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
    .form-card .form-textarea:focus {
        background: #fff;
        border-color: var(--input-focus-border);
        box-shadow: 0 0 0 4px var(--input-focus-shadow);
        outline: none;
        color: #344767 !important;
    }
    .form-card .form-control::placeholder,
    .form-card .form-textarea::placeholder {
        color: #adb5bd;
        font-weight: 400;
    }
    .form-card textarea.form-control {
        min-height: 80px;
        resize: vertical;
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

    /* ===== CHARACTER COUNTER ===== */
    .char-counter {
        font-size: 0.7rem;
        color: var(--text-secondary);
        text-align: right;
        margin-top: 4px;
    }
    .char-counter.warning { color: #fb6340; }
    .char-counter.danger { color: #f5365c; font-weight: 600; }

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
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .form-card { animation: slideIn 0.4s ease forwards; }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }
    .form-card .is-invalid { animation: shake 0.3s ease; }

    /* ===== FOCUS RING FOR ACCESSIBILITY ===== */
    .form-control:focus-visible,
    .form-select:focus-visible,
    .btn:focus-visible {
        outline: 2px solid var(--input-focus-border);
        outline-offset: 2px;
    }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert-header">
        <span class="text-white">
            <i class="fas fa-plus-circle"></i>
            <strong>Tambah Data Bukaan Lahan</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="form-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-edit"></i>
                        Form Tambah Data Bukaan Lahan
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('bukaan-lahan.store') }}" method="POST" id="createForm">
                        @csrf

                        <div class="row g-3">

                            {{-- TANGGAL BUKAAN --}}
                            <div class="col-md-6">
                                <label class="form-label" for="tanggal_bukaan">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Bukaan <span class="required">*</span>
                                </label>
                                <input type="date"
                                       id="tanggal_bukaan"
                                       name="tanggal_bukaan"
                                       value="{{ old('tanggal_bukaan') }}"
                                       class="form-control @error('tanggal_bukaan') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Pilih tanggal pembukaan lahan
                                </small>
                                @error('tanggal_bukaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI BUKAAN --}}
                            <div class="col-md-6">
                                <label class="form-label" for="lokasi_bukaan">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi Bukaan <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="lokasi_bukaan"
                                       name="lokasi_bukaan"
                                       value="{{ old('lokasi_bukaan') }}"
                                       class="form-control @error('lokasi_bukaan') is-invalid @enderror"
                                       placeholder="Contoh: Blok A Pit Utara"
                                       maxlength="255">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Nama lokasi atau area pembukaan
                                </small>
                                @error('lokasi_bukaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LUAS DIBUKA --}}
                            <div class="col-md-4">
                                <label class="form-label" for="luas_dibuka">
                                    <i class="fas fa-ruler-combined"></i> Luas Dibuka (ha) <span class="required">*</span>
                                </label>
                                <input type="number"
                                       id="luas_dibuka"
                                       name="luas_dibuka"
                                       value="{{ old('luas_dibuka') }}"
                                       class="form-control @error('luas_dibuka') is-invalid @enderror"
                                       placeholder="0.00"
                                       step="0.01"
                                       min="0"
                                       oninput="formatDecimal(this)">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Masukkan dalam satuan hektar
                                </small>
                                @error('luas_dibuka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS VEGETASI AWAL --}}
                            <div class="col-md-4">
                                <label class="form-label" for="jenis_vegetasi_awal">
                                    <i class="fas fa-tree"></i> Jenis Vegetasi Awal
                                </label>
                                <input type="text"
                                       id="jenis_vegetasi_awal"
                                       name="jenis_vegetasi_awal"
                                       value="{{ old('jenis_vegetasi_awal') }}"
                                       class="form-control @error('jenis_vegetasi_awal') is-invalid @enderror"
                                       placeholder="Contoh: Hutan Sekunder"
                                       maxlength="100">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Jenis vegetasi sebelum pembukaan
                                </small>
                                @error('jenis_vegetasi_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- METODE PEMBUKAAN --}}
                            <div class="col-md-4">
                                <label class="form-label" for="metode_pembukaan">
                                    <i class="fas fa-cogs"></i> Metode Pembukaan
                                </label>
                                <input type="text"
                                    id="metode_pembukaan"
                                    name="metode_pembukaan"
                                    value="{{ old('metode_pembukaan') }}"
                                    class="form-control @error('metode_pembukaan') is-invalid @enderror"
                                    placeholder="Contoh: Mekanis, Manual, Kombinasi"
                                    maxlength="100">
                                
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Ketik metode pembukaan lahan yang digunakan
                                </small>
                                
                                @error('metode_pembukaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ALAT BERAT DIGUNAKAN --}}
                            <div class="col-md-6">
                                <label class="form-label" for="alat_berat_digunakan">
                                    <i class="fas fa-truck-monster"></i> Alat Berat Digunakan
                                </label>
                                <textarea id="alat_berat_digunakan"
                                          name="alat_berat_digunakan"
                                          rows="2"
                                          class="form-control @error('alat_berat_digunakan') is-invalid @enderror"
                                          placeholder="Contoh: Excavator PC300, Dump Truck HD785"
                                          maxlength="500"
                                          oninput="updateCharCounter(this, 'alatCounter')">{{ old('alat_berat_digunakan') }}</textarea>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <small class="form-hint">
                                        <i class="fas fa-info-circle"></i> Sebutkan jenis alat berat yang digunakan
                                    </small>
                                    <small id="alatCounter" class="char-counter">0/500</small>
                                </div>
                                @error('alat_berat_digunakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- IZIN LINGKUNGAN --}}
                            <div class="col-md-6">
                                <label class="form-label" for="izin_lingkungan">
                                    <i class="fas fa-file-contract"></i> Izin Lingkungan
                                </label>
                                <input type="text"
                                       id="izin_lingkungan"
                                       name="izin_lingkungan"
                                       value="{{ old('izin_lingkungan') }}"
                                       class="form-control @error('izin_lingkungan') is-invalid @enderror"
                                       placeholder="Contoh: SK AMDAL No. 123/2024"
                                       maxlength="255">
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Nomor atau referensi izin lingkungan
                                </small>
                                @error('izin_lingkungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS KESESUAIAN --}}
                            <div class="col-md-12">
                                <label class="form-label" for="status_kesesuaian">
                                    <i class="fas fa-clipboard-check"></i> Status Kesesuaian <span class="required">*</span>
                                </label>
                                <select id="status_kesesuaian"
                                        name="status_kesesuaian"
                                        class="form-select @error('status_kesesuaian') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="sesuai" {{ old('status_kesesuaian') == 'sesuai' ? 'selected' : '' }}>
                                        ✅ Sesuai
                                    </option>
                                    <option value="tidak_sesuai" {{ old('status_kesesuaian') == 'tidak_sesuai' ? 'selected' : '' }}>
                                        ❌ Tidak Sesuai
                                    </option>
                                </select>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Kesesuaian dengan rencana/reklamasi
                                </small>
                                @error('status_kesesuaian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="form-actions">
                            <a href="{{ route('bukaan-lahan') }}" class="btn btn-light">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Simpan Data
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
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
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
                <ul>
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
    // Auto-show error modal
    @if ($errors->any())
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    @endif

    // Format decimal input (optional enhancement)
    window.formatDecimal = function(input) {
        let value = input.value.replace(',', '.');
        if (value.includes('.')) {
            const parts = value.split('.');
            if (parts[1] && parts[1].length > 2) {
                input.value = parts[0] + '.' + parts[1].substring(0, 2);
            }
        }
    }

    // Character counter for textarea
    window.updateCharCounter = function(textarea, counterId) {
        const counter = document.getElementById(counterId);
        const current = textarea.value.length;
        const max = textarea.maxLength || 500;
        counter.textContent = `${current}/${max}`;
        
        if (current > max * 0.9) {
            counter.classList.add('warning');
            counter.classList.remove('danger');
        }
        if (current >= max) {
            counter.classList.add('danger');
            counter.classList.remove('warning');
        }
        if (current < max * 0.9) {
            counter.classList.remove('warning', 'danger');
        }
    }

    // Initialize character counters on load
    document.querySelectorAll('textarea[maxlength]').forEach(textarea => {
        const counterId = textarea.id + 'Counter';
        if (document.getElementById(counterId)) {
            updateCharCounter(textarea, counterId);
        }
    });

    // Prevent double submit
    const form = document.getElementById('createForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form?.addEventListener('submit', function() {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        }
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute; width: ${size}px; height: ${size}px;
                border-radius: 50%; background: rgba(255,255,255,0.4);
                left: ${x}px; top: ${y}px; animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `@keyframes ripple { to { transform: scale(2); opacity: 0; } }`;
    document.head.appendChild(style);
});
</script>
@endpush

@endsection