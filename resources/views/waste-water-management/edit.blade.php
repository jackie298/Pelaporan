@extends('layouts.user_type.auth')

@section('content')

<style>
    /* ===== THEME VARIABLES ===== */
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
        --border-focus: rgba(17, 113, 239, 0.5);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.15);
        --radius: 16px;
        --radius-sm: 12px;
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== PAGE HEADER ALERT ===== */
    .page-alert {
        background: var(--warning-gradient);
        border: none;
        border-radius: var(--radius);
        padding: 16px 24px;
        margin: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .page-alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
        pointer-events: none;
    }

    .page-alert .alert-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        position: relative;
        z-index: 1;
    }

    .page-alert .text-white {
        position: relative;
        z-index: 1;
        font-weight: 600;
        font-size: 1rem;
        color: #fff !important;
    }

    /* ===== FORM CARD ===== */
    .form-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin: 0 16px 24px;
        overflow: hidden;
        transition: var(--transition);
    }

    .form-card:hover {
        box-shadow: var(--shadow-md);
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #f8f9fa, #fff);
        border-bottom: 1px solid var(--border-color);
        padding: 24px;
        position: relative;
    }

    .form-card .card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 24px;
        right: 24px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    }

    .form-card .card-header h5 {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0 0 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card .card-header h5 i {
        color: #fb6340;
        font-size: 1.3rem;
    }

    .form-card .card-header p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.5;
    }

    .form-card .card-body {
        padding: 28px 24px;
    }

    /* ===== FORM GROUP ===== */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group .form-label {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-group .form-label i {
        color: #1171ef;
        font-size: 0.9rem;
        width: 16px;
        text-align: center;
    }

    .form-group .form-label .required {
        color: #f5365c;
        margin-left: 2px;
    }

    /* ===== FORM INPUTS ===== */
    .form-control,
    .form-select {
        background: #f8f9fa;
        border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        color: var(--text-primary);
        font-weight: 500;
        transition: var(--transition);
        height: auto;
        min-height: 48px;
    }

    .form-control:focus,
    .form-select:focus {
        background: #fff;
        border-color: #1171ef;
        box-shadow: 0 0 0 4px rgba(17, 113, 239, 0.15);
        outline: none;
        color: var(--text-primary);
    }

    .form-control::placeholder {
        color: var(--text-secondary);
        font-weight: 400;
        opacity: 0.7;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #f5365c;
        background-image: none;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #f5365c;
        box-shadow: 0 0 0 4px rgba(245, 54, 92, 0.15);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2367748e' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px 12px;
        padding-right: 40px;
        cursor: pointer;
    }

    .form-select option {
        padding: 12px 16px;
        color: var(--text-primary);
        background: #fff;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
        line-height: 1.6;
    }

    /* ===== RADIO BUTTONS - SAMPLER ===== */
    .radio-group {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .radio-option {
        position: relative;
        flex: 1;
        min-width: 120px;
        max-width: 180px;
    }

    .radio-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .radio-option label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        background: #f8f9fa;
        border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition);
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-primary);
        user-select: none;
    }

    .radio-option label i {
        font-size: 1rem;
        transition: var(--transition);
    }

    .radio-option input[type="radio"]:checked + label {
        background: var(--primary-gradient);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
    }

    .radio-option input[type="radio"]:checked + label i {
        color: #fff;
    }

    .radio-option label:hover {
        border-color: #1171ef;
        background: rgba(17, 113, 239, 0.05);
    }

    .radio-option input[type="radio"]:checked + label:hover {
        background: var(--primary-gradient);
        border-color: transparent;
    }

    /* ===== SECTION DIVIDER ===== */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 28px 0;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .section-divider::before,
    .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    }

    .section-divider i {
        color: #1171ef;
        font-size: 0.9rem;
    }

    /* ===== ERROR MESSAGES ===== */
    .invalid-feedback,
    .text-danger {
        color: #f5365c !important;
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .invalid-feedback::before,
    .text-danger::before {
        content: '⚠';
        font-size: 0.75rem;
    }

    /* ===== ACTION BUTTONS ===== */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding-top: 24px;
        margin-top: 24px;
        border-top: 1px solid var(--border-color);
    }

    .btn {
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 12px 28px;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }

    .btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::after {
        left: 100%;
    }

    .btn-light {
        background: #e9ecef;
        color: var(--text-primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .btn-light:hover {
        background: #dee2e6;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        color: var(--text-primary);
    }

    .btn.bg-gradient-warning {
        background: var(--warning-gradient);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(251, 99, 64, 0.3);
    }

    .btn.bg-gradient-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 99, 64, 0.45);
    }

    .btn.bg-gradient-warning:active {
        transform: translateY(0);
    }

    .btn i {
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .btn:hover i {
        transform: translateX(2px);
    }

    /* ===== DELETE BUTTON ===== */
    .btn-delete {
        background: var(--danger-gradient);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(245, 54, 92, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 54, 92, 0.45);
    }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header.bg-danger {
        background: var(--danger-gradient) !important;
        border-radius: 20px 20px 0 0;
        border: none;
        padding: 20px 24px;
    }

    .modal-header.bg-warning {
        background: var(--warning-gradient) !important;
        border-radius: 20px 20px 0 0;
        border: none;
        padding: 20px 24px;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-body p {
        color: var(--text-primary);
        font-size: 0.95rem;
        margin-bottom: 16px;
    }

    .modal-body ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .modal-body ul li {
        padding: 10px 16px;
        background: rgba(245, 54, 92, 0.08);
        border-left: 3px solid #f5365c;
        border-radius: 0 8px 8px 0;
        margin-bottom: 8px;
        color: var(--text-primary);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .modal-body ul li:last-child {
        margin-bottom: 0;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 16px 24px;
        justify-content: flex-end;
    }

    .modal-footer .btn {
        padding: 10px 24px;
        font-size: 0.9rem;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-card {
        animation: slideIn 0.4s ease forwards;
    }

    .form-group {
        animation: slideIn 0.3s ease forwards;
        animation-delay: calc(var(--i, 0) * 0.05s);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .page-alert,
        .form-card {
            margin-left: 12px;
            margin-right: 12px;
        }

        .form-card .card-header,
        .form-card .card-body {
            padding: 20px 16px;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .radio-group {
            flex-direction: column;
        }

        .radio-option {
            max-width: 100%;
        }

        .section-divider {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 575px) {
        .form-card .card-header h5 {
            font-size: 1.1rem;
        }

        .form-control,
        .form-select {
            font-size: 0.9rem;
            padding: 10px 14px;
        }

        .btn {
            padding: 10px 24px;
            font-size: 0.85rem;
        }
    }

    /* ===== FOCUS VISIBILITY ===== */
    .form-control:focus-visible,
    .form-select:focus-visible,
    .btn:focus-visible {
        outline: 2px solid #1171ef;
        outline-offset: 2px;
    }

    /* ===== HELPER CLASSES ===== */
    .text-muted {
        color: var(--text-secondary) !important;
    }

    .fw-medium {
        font-weight: 500 !important;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    /* ===== READ-ONLY BADGE ===== */
    .readonly-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(17, 113, 239, 0.1);
        color: #1171ef;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 8px;
    }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="page-alert" role="alert">
        <div class="alert-icon">
            <i class="fas fa-edit"></i>
        </div>
        <span class="text-white">
            <strong>Edit Data Pengelolaan Air Limbah</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card form-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-clipboard-check"></i>
                        Form Edit Data Air Limbah
                    </h5>
                    <p class="mb-0">Perbarui parameter pemantauan air limbah sesuai hasil pengukuran terbaru.</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('waste-water-management.update', $wasteWater->id) }}" method="POST" id="wasteWaterForm">
                        @csrf
                        @method('PUT')

                        {{-- SECTION: INFORMASI UMUM --}}
                        <div class="section-divider">
                            <i class="fas fa-info-circle"></i>
                            <span>Informasi Umum</span>
                        </div>

                        <div class="row">
                            {{-- TANGGAL SAMPLING --}}
                            <div class="col-md-6 form-group" style="--i: 1">
                                <label class="form-label">
                                    <i class="fas fa-calendar"></i>
                                    Tanggal Sampling
                                    <span class="required">*</span>
                                </label>
                                <input type="date"
                                    name="tanggal_sampling"
                                    value="{{ old('tanggal_sampling', \Carbon\Carbon::parse($wasteWater->tanggal_sampling)->format('Y-m-d')) }}"
                                    class="form-control @error('tanggal_sampling') is-invalid @enderror"
                                    required>
                                @error('tanggal_sampling')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI SAMPLING --}}
                            <div class="col-md-6 form-group" style="--i: 2">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Lokasi Sampling
                                    <span class="required">*</span>
                                </label>
                                <select name="lokasi_sampling"
                                        class="form-select @error('lokasi_sampling') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Lokasi --</option>
                                    <option value="Settling Pond Rey Nabila" {{ old('lokasi_sampling', $wasteWater->lokasi_sampling) == 'Settling Pond Rey Nabila' ? 'selected' : '' }}>
                                        Settling Pond Rey Nabila
                                    </option>
                                    <option value="Settling Pond Jetty Lama" {{ old('lokasi_sampling', $wasteWater->lokasi_sampling) == 'Settling Pond Jetty Lama' ? 'selected' : '' }}>
                                        Settling Pond Jetty Lama
                                    </option>
                                </select>
                                @error('lokasi_sampling')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TITIK SAMPLER (INLET/OUTLET) --}}
                            <div class="col-md-6 form-group" style="--i: 3">
                                <label class="form-label">
                                    <i class="fas fa-bullseye"></i>
                                    Titik Sampler
                                    <span class="required">*</span>
                                </label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" name="sampler" id="inlet" value="inlet" {{ old('sampler', $wasteWater->sampler) == 'inlet' ? 'checked' : '' }} required>
                                        <label for="inlet">
                                            <i class="fas fa-arrow-down"></i>
                                            Inlet
                                        </label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" name="sampler" id="outlet" value="outlet" {{ old('sampler', $wasteWater->sampler) == 'outlet' ? 'checked' : '' }} required>
                                        <label for="outlet">
                                            <i class="fas fa-arrow-up"></i>
                                            Outlet
                                        </label>
                                    </div>
                                </div>
                                @error('sampler')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CUACA --}}
                            <div class="col-md-6 form-group" style="--i: 4">
                                <label class="form-label">
                                    <i class="fas fa-cloud-sun"></i>
                                    Kondisi Cuaca
                                </label>
                                <input type="text"
                                       name="cuaca"
                                       value="{{ old('cuaca', $wasteWater->cuaca) }}"
                                       class="form-control @error('cuaca') is-invalid @enderror"
                                       placeholder="Cerah / Hujan / Berawan">
                                @error('cuaca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- SECTION: PARAMETER KUALITAS AIR --}}
                        <div class="section-divider">
                            <i class="fas fa-flask"></i>
                            <span>Parameter Kualitas Air</span>
                        </div>

                        <div class="row">
                            {{-- PH --}}
                            <div class="col-md-4 form-group" style="--i: 5">
                                <label class="form-label">
                                    <i class="fas fa-tint"></i>
                                    pH
                                </label>
                                <input type="number" 
                                       step="0.1" 
                                       min="0" 
                                       max="14"
                                       name="ph"
                                       value="{{ old('ph', $wasteWater->ph) }}"
                                       class="form-control @error('ph') is-invalid @enderror"
                                       placeholder="0.0 - 14.0">
                                @error('ph')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted" style="font-size: 0.75rem;">Range normal: 6.0 - 9.0</small>
                            </div>

                            {{-- TSS --}}
                            <div class="col-md-4 form-group" style="--i: 6">
                                <label class="form-label">
                                    <i class="fas fa-weight-hanging"></i>
                                    TSS (mg/L)
                                </label>
                                <input type="number" 
                                       step="0.01" 
                                       min="0"
                                       name="tss"
                                       value="{{ old('tss', $wasteWater->tss) }}"
                                       class="form-control @error('tss') is-invalid @enderror"
                                       placeholder="Contoh: 50.00">
                                @error('tss')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted" style="font-size: 0.75rem;">Baku mutu: ≤ 100 mg/L</small>
                            </div>

                            {{-- DEBIT AIR --}}
                            <div class="col-md-4 form-group" style="--i: 7">
                                <label class="form-label">
                                    <i class="fas fa-water"></i>
                                    Debit Air (m³/s)
                                </label>
                                <input type="number" 
                                       step="0.01" 
                                       min="0"
                                       name="debit_air"
                                       value="{{ old('debit_air', $wasteWater->debit_air) }}"
                                       class="form-control @error('debit_air') is-invalid @enderror"
                                       placeholder="Contoh: 0.25">
                                @error('debit_air')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- SECTION: STATUS & CATATAN --}}
                        <div class="section-divider">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Status & Catatan</span>
                        </div>

                        <div class="row">
                            {{-- STATUS KESESUAIAN --}}
                            <div class="col-md-6 form-group" style="--i: 8">
                                <label class="form-label">
                                    <i class="fas fa-check-circle"></i>
                                    Status Kesesuaian
                                    <span class="required">*</span>
                                </label>
                                <select name="status_kesesuaian"
                                        class="form-select @error('status_kesesuaian') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="memenuhi" {{ old('status_kesesuaian', $wasteWater->status_kesesuaian) == 'memenuhi' ? 'selected' : '' }}>
                                        ✅ Memenuhi Baku Mutu
                                    </option>
                                    <option value="tidak_memenuhi" {{ old('status_kesesuaian', $wasteWater->status_kesesuaian) == 'tidak_memenuhi' ? 'selected' : '' }}>
                                        ❌ Tidak Memenuhi Baku Mutu
                                    </option>
                                </select>
                                @error('status_kesesuaian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-6 form-group" style="--i: 9">
                                <label class="form-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Catatan Tambahan
                                </label>
                                <textarea name="catatan" 
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan', $wasteWater->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="form-actions">
                            <a href="{{ route('waste-water-management') }}" class="btn btn-light">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-warning">
                                <i class="fas fa-sync-alt"></i> Update Data
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
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Input Tidak Valid
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fw-medium mb-3">Silakan periksa kembali kolom berikut:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-check"></i> Mengerti
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show error modal if validation errors exist
    @if ($errors->any())
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    @endif

    // Auto-focus first invalid field
    const firstInvalid = document.querySelector('.is-invalid');
    if (firstInvalid) {
        firstInvalid.focus();
        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Add visual feedback on form submit
    const form = document.getElementById('wasteWaterForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupdate...';
            }
        });
    }

    // Real-time validation feedback
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Close delete modal after showing error to prevent conflict
    const deleteModalEl = document.getElementById('deleteModal');
    if (deleteModalEl && @json($errors->any())) {
        const deleteModal = bootstrap.Modal.getInstance(deleteModalEl);
        if (deleteModal) deleteModal.hide();
    }
});
</script>

@endsection