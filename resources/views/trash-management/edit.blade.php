@extends('layouts.user_type.auth')

@section('content')

<style>
    /* ===== THEME VARIABLES (Same as Index/Create) ===== */
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
    }

    /* ===== GLOBAL ===== */
    * { box-sizing: border-box; }
    .form-page { color: var(--text-primary) !important; }
    .form-page *, .form-page *::before, .form-page *::after { color: inherit; }

    /* ===== ALERT BAR ===== */
    .alert-bar {
        background: var(--warning-gradient);
        border: none; border-radius: var(--radius);
        padding: 14px 20px; margin: 16px;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: var(--shadow-md);
        position: relative; overflow: hidden;
    }
    .alert-bar::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        pointer-events: none;
    }
    .alert-bar .text-white {
        position: relative; z-index: 1;
        font-weight: 600; font-size: 0.95rem;
        display: flex; align-items: center; gap: 8px;
        color: #fff !important;
    }
    .alert-bar .text-white i { font-size: 1.1rem; }
    .alert-bar .badge-id {
        background: rgba(255,255,255,0.2);
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 600;
    }

    /* ===== FORM CARD ===== */
    .form-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin: 0 16px 20px;
        transition: box-shadow 0.3s ease;
        overflow: hidden;
    }
    .form-card:hover { box-shadow: var(--shadow-md); }

    .form-card .card-header {
        background: transparent;
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
    }
    .form-card .card-header h5 {
        margin: 0; font-weight: 700; font-size: 1.1rem;
        color: var(--text-primary) !important;
        display: flex; align-items: center; gap: 8px;
    }
    .form-card .card-header h5 i { color: #fb6340; }
    
    .form-card .card-header .meta-info {
        display: flex; align-items: center; gap: 12px;
        flex-wrap: wrap;
    }
    .form-card .card-header .meta-info .meta-item {
        display: flex; align-items: center; gap: 4px;
        font-size: 0.8rem; color: var(--text-secondary);
    }
    .form-card .card-header .meta-info .meta-item i {
        color: #67748e; font-size: 0.85rem;
    }

    .form-card .card-body { padding: 24px; }

    /* ===== FORM INPUTS ===== */
    .form-label {
        color: var(--text-primary) !important;
        font-weight: 700; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.3px;
        margin-bottom: 6px; display: flex; align-items: center; gap: 4px;
    }
    .form-label i { color: #1171ef; font-size: 0.8rem; }
    .form-label .required { color: #f5365c; margin-left: 2px; }
    .form-label .optional { 
        color: var(--text-secondary); 
        font-weight: 400; text-transform: none; margin-left: 4px;
    }

    .form-control, .form-select {
        background: #f8f9fa;
        border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.9rem;
        color: var(--text-primary) !important;
        font-weight: 500;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        background: #fff;
        border-color: #1171ef;
        box-shadow: 0 0 0 4px rgba(17, 113, 239, 0.15);
        outline: none;
        color: var(--text-primary) !important;
    }
    .form-control::placeholder { color: #adb5bd; font-weight: 400; }
    .form-control[readonly] {
        background: #e9ecef !important;
        cursor: not-allowed;
        color: var(--text-secondary) !important;
    }

    /* Input with icon */
    .input-with-icon { position: relative; }
    .input-with-icon .form-control { padding-left: 38px; }
    .input-with-icon .input-icon {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #adb5bd; font-size: 0.9rem;
        pointer-events: none;
    }
    .input-with-icon .form-control:focus + .input-icon,
    .input-with-icon .form-control:focus ~ .input-icon {
        color: #1171ef;
    }

    /* ===== WEIGHT INPUTS GRID ===== */
    .weight-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }
    .weight-card {
        background: linear-gradient(135deg, #f8f9fa, #fff);
        border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 16px;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }
    .weight-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: var(--secondary-gradient);
    }
    .weight-card.organik::before { background: var(--info-gradient); }
    .weight-card.anorganik::before { background: var(--warning-gradient); }
    .weight-card.residu::before { background: var(--danger-gradient); }

    .weight-card:hover {
        border-color: #1171ef;
        box-shadow: 0 4px 16px rgba(17, 113, 239, 0.1);
        transform: translateY(-2px);
    }

    .weight-card .weight-label {
        display: flex; align-items: center; gap: 6px;
        font-weight: 700; font-size: 0.8rem;
        color: var(--text-primary) !important;
        margin-bottom: 8px; text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .weight-card .weight-label i {
        width: 20px; height: 20px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; color: #fff;
    }
    .weight-card.organik .weight-label i { background: #1171ef; }
    .weight-card.anorganik .weight-label i { background: #fb6340; }
    .weight-card.residu .weight-label i { background: #f5365c; }

    .weight-card .weight-input {
        width: 100%; padding: 8px 12px;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px; font-size: 1.1rem;
        font-weight: 700; text-align: center;
        background: #fff; color: var(--text-primary) !important;
        transition: all 0.2s;
    }
    .weight-card .weight-input:focus {
        border-color: #1171ef;
        box-shadow: 0 0 0 3px rgba(17, 113, 239, 0.15);
        outline: none;
    }
    .weight-card .weight-unit {
        text-align: center; font-size: 0.75rem;
        color: var(--text-secondary); margin-top: 4px;
        font-weight: 600; text-transform: uppercase;
    }
    
    /* Original value hint for edit mode */
    .weight-card .original-value {
        text-align: center; font-size: 0.7rem;
        color: #67748e; margin-top: 2px; font-style: italic;
    }
    .weight-card .original-value.changed {
        color: #fb6340; font-weight: 600;
    }

    /* ===== TOTAL DISPLAY ===== */
    .total-display {
        background: linear-gradient(135deg, rgba(45, 206, 137, 0.1), rgba(45, 206, 204, 0.1));
        border: 2px solid rgba(45, 206, 137, 0.3);
        border-radius: 12px;
        padding: 16px 20px;
        margin: 20px 0;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
    }
    .total-display .total-label {
        display: flex; align-items: center; gap: 8px;
        font-weight: 700; font-size: 0.9rem;
        color: var(--text-primary) !important;
    }
    .total-display .total-label i { color: #2dce89; font-size: 1.1rem; }
    
    .total-display .total-value {
        font-size: 1.5rem; font-weight: 800;
        color: #2dce89 !important;
        background: rgba(45, 206, 137, 0.15);
        padding: 8px 20px; border-radius: 10px;
        min-width: 100px; text-align: center;
        transition: all 0.2s;
    }
    .total-display .total-value.updated {
        animation: pulse 0.3s ease;
        background: rgba(45, 206, 137, 0.25);
    }
    
    .total-display .total-comparison {
        font-size: 0.8rem; color: var(--text-secondary);
        display: flex; align-items: center; gap: 4px;
    }
    .total-display .total-comparison .diff-positive {
        color: #2dce89; font-weight: 600;
    }
    .total-display .total-comparison .diff-negative {
        color: #f5365c; font-weight: 600;
    }
    
    .total-display .total-hint {
        font-size: 0.75rem; color: var(--text-secondary);
        width: 100%; text-align: center; margin-top: 4px;
    }

    /* ===== TEXTAREA ===== */
    textarea.form-control {
        min-height: 100px; resize: vertical;
        line-height: 1.5;
    }

    /* ===== ERROR STYLES ===== */
    .is-invalid {
        border-color: #f5365c !important;
        background-image: none !important;
    }
    .is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(245, 54, 92, 0.15) !important;
    }
    .invalid-feedback {
        display: block; font-size: 0.75rem;
        color: #f5365c !important; margin-top: 4px;
        font-weight: 500;
    }

    /* ===== ACTION BUTTONS ===== */
    .form-actions {
        display: flex; justify-content: flex-end;
        align-items: center; gap: 12px;
        padding-top: 20px; border-top: 1px solid var(--border-color);
        margin-top: 20px; flex-wrap: wrap;
    }
    .btn {
        border-radius: 10px; font-weight: 600;
        padding: 10px 24px; font-size: 0.9rem;
        transition: all 0.2s; border: none;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn i { font-size: 0.95rem; font-weight: 700; }
    
    .btn-light {
        background: #e9ecef; color: var(--text-primary) !important;
    }
    .btn-light:hover {
        background: #dee2e6; transform: translateY(-2px);
    }
    
    .btn.bg-gradient-primary {
        background: var(--primary-gradient);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
    }
    .btn.bg-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 206, 137, 0.45);
    }
    .btn.bg-gradient-primary:disabled {
        opacity: 0.6; cursor: not-allowed; transform: none;
    }
    
    .btn-outline-danger {
        border: 2px solid #f5365c; color: #f5365c !important;
        background: transparent;
    }
    .btn-outline-danger:hover {
        background: #f5365c; color: #fff !important;
        transform: translateY(-2px);
    }

    /* ===== CHANGE INDICATOR ===== */
    .change-indicator {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 0.7rem; color: #fb6340;
        margin-left: 8px; font-weight: 600;
        opacity: 0; transition: opacity 0.2s;
    }
    .change-indicator.visible { opacity: 1; }
    .change-indicator i { font-size: 0.75rem; }

    /* ===== MODAL ERROR ===== */
    .modal-content {
        border-radius: 20px !important; border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .modal-header.bg-gradient-danger {
        background: var(--danger-gradient) !important;
        border-radius: 20px 20px 0 0; border: none;
        padding: 18px 24px;
    }
    .modal-title { font-weight: 700; font-size: 1.1rem; color: #fff !important; }
    .modal-body { padding: 24px; text-align: center; }
    .modal-body .alert-danger {
        background: rgba(245, 54, 92, 0.08);
        border-color: rgba(245, 54, 92, 0.3);
        color: var(--text-primary) !important;
    }
    .list-group-item {
        background: transparent !important;
        color: #f5365c !important; padding: 6px 0 !important;
    }
    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 16px 24px; gap: 10px;
    }
    .modal-footer .btn { padding: 10px 24px; border-radius: 10px; }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .form-card { animation: fadeInUp 0.4s ease-out; }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }
    .input-shake { animation: shake 0.3s ease; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767px) {
        .alert-bar { flex-direction: column; gap: 8px; text-align: center; }
        .alert-bar .badge-id { width: 100%; justify-content: center; }
        .form-card { margin-left: 12px; margin-right: 12px; }
        .form-card .card-body { padding: 16px; }
        .form-card .card-header { flex-direction: column; align-items: flex-start; }
        .weight-grid { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column-reverse; }
        .form-actions .btn { width: 100%; justify-content: center; }
        .total-display { flex-direction: column; text-align: center; }
    }

    /* ===== TOOLTIPS ===== */
    [title] { position: relative; cursor: help; }
    [title]:hover::after {
        content: attr(title);
        position: absolute; bottom: 100%; left: 50%;
        transform: translateX(-50%) translateY(-8px);
        background: #344767; color: #fff !important;
        padding: 6px 12px; border-radius: 8px;
        font-size: 0.75rem; font-weight: 500;
        white-space: nowrap; z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        pointer-events: none; opacity: 0;
        animation: tooltipFade 0.2s ease forwards;
    }
    @keyframes tooltipFade {
        to { opacity: 1; transform: translateX(-50%) translateY(-12px); }
    }
</style>

<div class="form-page">
    
    {{-- 🔔 Alert Header - Edit Mode --}}
    <div class="alert-bar">
        <span class="text-white">
            <i class="fas fa-pen-to-square"></i>
            <strong>Edit Data Pengelolaan Sampah</strong>
            <span class="badge-id">#{{ $data->id }}</span>
        </span>
    </div>

    {{-- 📋 Form Card --}}
    <div class="form-card">
        <div class="card-header">
            <h5><i class="fas fa-clipboard-check"></i>Edit Data</h5>
            <div class="meta-info">
                <span class="meta-item">
                    <i class="fas fa-calendar"></i>
                    Dibuat: {{ $data->created_at?->translatedFormat('d M Y H:i') ?? '-' }}
                </span>
                @if($data->updated_at?->diffInMinutes($data->created_at) > 0)
                <span class="meta-item">
                    <i class="fas fa-history"></i>
                    Diupdate: {{ $data->updated_at?->translatedFormat('d M Y H:i') ?? '-' }}
                </span>
                @endif
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('trash-management.update', $data->id) }}" 
                  method="POST" 
                  id="trashForm" 
                  novalidate>
                @csrf
                @method('PUT')

                <div class="row g-4">
                    
                    {{-- ROW 1: Tanggal & Sumber --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i> Tanggal <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <input type="date" name="tanggal" 
                                   value="{{ old('tanggal', $data->tanggal?->format('Y-m-d')) }}"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   required max="{{ date('Y-m-d') }}"
                                   title="Tanggal tidak boleh di masa depan"
                                   data-original="{{ $data->tanggal?->format('Y-m-d') }}">
                            <i class="fas fa-calendar input-icon"></i>
                        </div>
                        <span class="change-indicator" id="tanggalChanged">
                            <i class="fas fa-circle"></i> Diubah
                        </span>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-layer-group"></i> Sumber Sampah <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <select name="sumber_sampah" 
                                    class="form-select @error('sumber_sampah') is-invalid @enderror"
                                    required
                                    data-original="{{ $data->sumber_sampah }}">
                                <option value="">-- Pilih Sumber --</option>
                                @foreach($sumberOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('sumber_sampah', $data->sumber_sampah) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down input-icon" style="right: 12px; left: auto;"></i>
                        </div>
                        <span class="change-indicator" id="sumberChanged">
                            <i class="fas fa-circle"></i> Diubah
                        </span>
                        @error('sumber_sampah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ROW 2: Weight Inputs (Cards) with Original Values --}}
                    <div class="col-12">
                        <label class="form-label mb-2">
                            <i class="fas fa-weight-hanging"></i> Berat Sampah (kg)
                            <small class="optional">(Isi minimal satu jenis)</small>
                        </label>
                        
                        <div class="weight-grid">
                            {{-- Organik --}}
                            <div class="weight-card organik">
                                <div class="weight-label">
                                    <i>🌱</i> Organik Terpilah
                                </div>
                                <input type="number" name="sampah_organik_terpilah" 
                                       class="weight-input" 
                                       value="{{ old('sampah_organik_terpilah', $data->sampah_organik_terpilah ?? '') }}"
                                       min="0" placeholder="0"
                                       title="Sisa makanan, daun, dll"
                                       data-original="{{ $data->sampah_organik_terpilah ?? 0 }}">
                                <div class="weight-unit">Kilogram</div>
                                @if($data->sampah_organik_terpilah !== null)
                                    <small class="original-value" id="organikOriginal">
                                        Sebelumnya: {{ number_format($data->sampah_organik_terpilah, 0, ',', '.') }} kg
                                    </small>
                                @endif
                                @error('sampah_organik_terpilah')
                                    <small class="text-danger d-block mt-1" style="font-size: 0.7rem;">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Anorganik --}}
                            <div class="weight-card anorganik">
                                <div class="weight-label">
                                    <i>♻️</i> Anorganik Terpilah
                                </div>
                                <input type="number" name="sampah_anorganik_terpilah" 
                                       class="weight-input" 
                                       value="{{ old('sampah_anorganik_terpilah', $data->sampah_anorganik_terpilah ?? '') }}"
                                       min="0" placeholder="0"
                                       title="Plastik, kertas, logam, dll"
                                       data-original="{{ $data->sampah_anorganik_terpilah ?? 0 }}">
                                <div class="weight-unit">Kilogram</div>
                                @if($data->sampah_anorganik_terpilah !== null)
                                    <small class="original-value" id="anorganikOriginal">
                                        Sebelumnya: {{ number_format($data->sampah_anorganik_terpilah, 0, ',', '.') }} kg
                                    </small>
                                @endif
                                @error('sampah_anorganik_terpilah')
                                    <small class="text-danger d-block mt-1" style="font-size: 0.7rem;">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Residu --}}
                            <div class="weight-card residu">
                                <div class="weight-label">
                                    <i>🗑️</i> Lainnya / Residu
                                </div>
                                <input type="number" name="sampah_lainnya_dan_atau_residu" 
                                       class="weight-input" 
                                       value="{{ old('sampah_lainnya_dan_atau_residu', $data->sampah_lainnya_dan_atau_residu ?? '') }}"
                                       min="0" placeholder="0"
                                       title="Sampah B3, residu, dll"
                                       data-original="{{ $data->sampah_lainnya_dan_atau_residu ?? 0 }}">
                                <div class="weight-unit">Kilogram</div>
                                @if($data->sampah_lainnya_dan_atau_residu !== null)
                                    <small class="original-value" id="residuOriginal">
                                        Sebelumnya: {{ number_format($data->sampah_lainnya_dan_atau_residu, 0, ',', '.') }} kg
                                    </small>
                                @endif
                                @error('sampah_lainnya_dan_atau_residu')
                                    <small class="text-danger d-block mt-1" style="font-size: 0.7rem;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ROW 3: Total Display with Comparison --}}
                    <div class="col-12">
                        <div class="total-display">
                            <div class="total-label">
                                <i class="fas fa-calculator"></i>
                                <span>Total Sampah Terkumpul</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <div class="total-value" id="totalValue">
                                    {{ number_format(($data->sampah_organik_terpilah ?? 0) + ($data->sampah_anorganik_terpilah ?? 0) + ($data->sampah_lainnya_dan_atau_residu ?? 0), 0, ',', '.') }}
                                </div>
                                @php
                                    $originalTotal = ($data->sampah_organik_terpilah ?? 0) + ($data->sampah_anorganik_terpilah ?? 0) + ($data->sampah_lainnya_dan_atau_residu ?? 0);
                                @endphp
                                <span class="total-comparison" id="totalComparison" style="display:none;">
                                    <i class="fas fa-arrow-right"></i>
                                    <span id="totalDiff"></span>
                                </span>
                            </div>
                            <small class="total-hint">
                                <i class="fas fa-info-circle me-1"></i>
                                Total dihitung otomatis • Nilai awal: {{ number_format($originalTotal, 0, ',', '.') }} kg
                            </small>
                        </div>
                        {{-- Hidden input for backend --}}
                        <input type="hidden" name="total" id="totalInput" 
                               value="{{ $originalTotal }}">
                    </div>

                    {{-- ROW 4: Catatan --}}
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-sticky-note"></i> Catatan Tambahan
                            <small class="optional">(Opsional)</small>
                        </label>
                        <textarea name="catatan" 
                                  class="form-control @error('catatan') is-invalid @enderror"
                                  rows="3" 
                                  placeholder="Contoh: Perubahan alasan, kondisi khusus, dll..."
                                  data-original="{{ $data->catatan }}">{{ old('catatan', $data->catatan) }}</textarea>
                        <span class="change-indicator" id="catatanChanged">
                            <i class="fas fa-circle"></i> Diubah
                        </span>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="form-actions">
                    <a href="{{ route('trash-management') }}" class="btn btn-light">
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

{{-- ❌ Error Validation Modal --}}
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-danger border-0 py-4">
                <div class="d-flex align-items-center">
                    <div class="bg-white rounded-circle p-3 me-3">
                        <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold">
                            <i class="fas fa-times-circle me-2"></i>Validasi Gagal
                        </h5>
                        <p class="mb-0 text-white-50 small">Mohon perbaiki kesalahan berikut</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger border border-danger rounded-3 p-4 mb-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <i class="fas fa-info-circle fa-lg text-danger"></i>
                        </div>
                        <div class="flex-grow-1 text-start">
                            <h6 class="alert-heading fw-bold mb-3">Daftar Kesalahan:</h6>
                            <div class="list-group list-group-flush">
                                @foreach ($errors->all() as $error)
                                    <div class="list-group-item border-0 p-2 ps-0">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-times-circle me-2 mt-1 text-danger"></i>
                                            <span class="fw-medium">{{ $error }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-3">
                <div class="w-100 d-flex flex-column flex-md-row justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Form
                    </button>
                    <button type="button" class="btn btn-danger px-4" onclick="window.location.reload()">
                        <i class="fas fa-redo me-1"></i>Reset Form
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('errorModal'));
    modal.show();
});
</script>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('trashForm');
    const inputs = {
        tanggal: document.querySelector('[name="tanggal"]'),
        sumber: document.querySelector('[name="sumber_sampah"]'),
        organik: document.querySelector('[name="sampah_organik_terpilah"]'),
        anorganik: document.querySelector('[name="sampah_anorganik_terpilah"]'),
        residu: document.querySelector('[name="sampah_lainnya_dan_atau_residu"]'),
        catatan: document.querySelector('[name="catatan"]')
    };
    const totalDisplay = document.getElementById('totalValue');
    const totalInput = document.getElementById('totalInput');
    const totalComparison = document.getElementById('totalComparison');
    const totalDiff = document.getElementById('totalDiff');
    const submitBtn = document.getElementById('submitBtn');
    
    // Original total for comparison
    const originalTotal = {{ ($data->sampah_organik_terpilah ?? 0) + ($data->sampah_anorganik_terpilah ?? 0) + ($data->sampah_lainnya_dan_atau_residu ?? 0) }};

    // Format angka dengan pemisah ribuan
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    // Hitung dan update total
    function calculateTotal() {
        const values = [inputs.organik, inputs.anorganik, inputs.residu]
            .map(input => parseInt(input?.value) || 0)
            .map(v => v >= 0 ? v : 0);
        
        const total = values.reduce((a, b) => a + b, 0);
        
        // Update display dengan animasi
        totalDisplay.textContent = formatNumber(total);
        totalInput.value = total;
        
        // Show comparison if changed
        if (total !== originalTotal) {
            const diff = total - originalTotal;
            const sign = diff > 0 ? '+' : '';
            const className = diff > 0 ? 'diff-positive' : 'diff-negative';
            const icon = diff > 0 ? '📈' : '📉';
            
            totalDiff.innerHTML = `<span class="${className}">${icon} ${sign}${formatNumber(diff)} kg</span>`;
            totalComparison.style.display = 'flex';
        } else {
            totalComparison.style.display = 'none';
        }
        
        // Animasi pulse saat berubah
        totalDisplay.classList.add('updated');
        setTimeout(() => totalDisplay.classList.remove('updated'), 300);
        
        return total;
    }

    // Track changes for indicator
    function checkChange(input, indicatorId) {
        if (!input || !indicatorId) return;
        const original = input.dataset.original;
        const current = input.value;
        const indicator = document.getElementById(indicatorId);
        
        if (indicator) {
            if (original !== undefined && current !== original) {
                indicator.classList.add('visible');
            } else {
                indicator.classList.remove('visible');
            }
        }
    }

    // Attach event listeners for calculation
    [inputs.organik, inputs.anorganik, inputs.residu].forEach(input => {
        input?.addEventListener('input', calculateTotal);
        input?.addEventListener('change', calculateTotal);
        input?.addEventListener('blur', function() {
            if (this.value && parseInt(this.value) < 0) {
                this.value = 0;
                this.classList.add('input-shake');
                setTimeout(() => this.classList.remove('input-shake'), 300);
            }
        });
    });

    // Attach change tracking
    if (inputs.tanggal) {
        inputs.tanggal.addEventListener('change', () => checkChange(inputs.tanggal, 'tanggalChanged'));
    }
    if (inputs.sumber) {
        inputs.sumber.addEventListener('change', () => checkChange(inputs.sumber, 'sumberChanged'));
    }
    if (inputs.catatan) {
        inputs.catatan.addEventListener('input', () => checkChange(inputs.catatan, 'catatanChanged'));
    }
    [inputs.organik, inputs.anorganik, inputs.residu].forEach((input, idx) => {
        const ids = ['organikOriginal', 'anorganikOriginal', 'residuOriginal'];
        input?.addEventListener('input', function() {
            const original = this.dataset.original;
            const el = document.getElementById(ids[idx]);
            if (el && original !== undefined) {
                if (this.value != original) {
                    el.classList.add('changed');
                    el.textContent = `Berubah dari: ${formatNumber(original)} kg`;
                } else {
                    el.classList.remove('changed');
                    el.textContent = `Sebelumnya: ${formatNumber(original)} kg`;
                }
            }
        });
    });

    // Initial calculation
    calculateTotal();

    // Form submission with SweetAlert confirmation
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const total = calculateTotal();
        
        // Validasi minimal satu jenis sampah
        if (total === 0) {
            Swal.fire({
                icon: 'warning',
                title: '⚠️ Data Belum Lengkap',
                html: '<p class="text-start">Minimal satu jenis sampah harus diisi!</p>',
                confirmButtonText: 'OK, Saya Paham',
                confirmButtonColor: '#f5365c',
                customClass: { confirmButton: 'btn btn-danger px-4' }
            });
            return;
        }

        // Check if anything actually changed
        const hasChanges = 
            inputs.tanggal?.value !== inputs.tanggal?.dataset.original ||
            inputs.sumber?.value !== inputs.sumber?.dataset.original ||
            inputs.organik?.value != inputs.organik?.dataset.original ||
            inputs.anorganik?.value != inputs.anorganik?.dataset.original ||
            inputs.residu?.value != inputs.residu?.dataset.original ||
            inputs.catatan?.value !== inputs.catatan?.dataset.original;

        if (!hasChanges) {
            Swal.fire({
                icon: 'info',
                title: 'ℹ️ Tidak Ada Perubahan',
                html: '<p class="text-start">Data yang Anda masukkan sama dengan data yang sudah tersimpan.</p>',
                confirmButtonText: 'Kembali',
                confirmButtonColor: '#67748e',
                customClass: { confirmButton: 'btn btn-secondary px-4' }
            });
            return;
        }

        // Konfirmasi update
        const tanggal = inputs.tanggal?.value || '';
        const sumber = inputs.sumber?.options[inputs.sumber?.selectedIndex]?.text || '';
        
        Swal.fire({
            title: '📋 Konfirmasi Update',
            html: `
                <div class="text-start small">
                    <p class="mb-2"><strong>ID Data:</strong> #{{ $data->id }}</p>
                    <table class="table table-borderless mb-0">
                        <tr><td class="text-muted">Tanggal</td><td><strong>${tanggal}</strong></td></tr>
                        <tr><td class="text-muted">Sumber</td><td><strong>${sumber}</strong></td></tr>
                        <tr><td class="text-muted">Organik</td><td>${formatNumber(parseInt(inputs.organik.value)||0)} kg</td></tr>
                        <tr><td class="text-muted">Anorganik</td><td>${formatNumber(parseInt(inputs.anorganik.value)||0)} kg</td></tr>
                        <tr><td class="text-muted">Residu</td><td>${formatNumber(parseInt(inputs.residu.value)||0)} kg</td></tr>
                        <tr class="border-top"><td class="text-muted"><strong>Total</strong></td><td><strong class="text-success">${formatNumber(total)} kg</strong></td></tr>
                    </table>
                    ${total !== originalTotal ? `<p class="mt-2 text-muted small"><i class="fas fa-info-circle"></i> Total berubah dari ${formatNumber(originalTotal)} kg menjadi ${formatNumber(total)} kg</p>` : ''}
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '✅ Ya, Update Sekarang',
            cancelButtonText: '❌ Batal',
            confirmButtonColor: '#2dce89',
            cancelButtonColor: '#67748e',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-success px-4 me-2',
                cancelButton: 'btn btn-secondary px-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
                
                // Submit form
                form.submit();
            }
        });
    });
});
</script>
@endpush

@endsection