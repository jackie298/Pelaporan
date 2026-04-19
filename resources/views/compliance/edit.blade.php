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
    .form-card textarea {
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

    /* ===== FILE UPLOAD STYLING ===== */
    .form-card .file-upload-wrapper {
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        background: var(--input-bg);
        transition: all 0.2s;
        cursor: pointer;
    }
    .form-card .file-upload-wrapper:hover,
    .form-card .file-upload-wrapper.dragover {
        border-color: var(--input-focus-border);
        background: rgba(17, 113, 239, 0.05);
    }
    .form-card .file-upload-wrapper i {
        font-size: 2rem;
        color: #1171ef;
        margin-bottom: 8px;
    }
    .form-card .file-upload-wrapper input[type="file"] {
        display: none;
    }
    .form-card .file-upload-label {
        display: block;
        cursor: pointer;
        color: var(--text-primary);
        font-weight: 500;
    }
    .form-card .file-upload-label:hover {
        color: var(--input-focus-border);
    }

    /* ===== EXISTING FILES PREVIEW ===== */
    .existing-files-section {
        margin-top: 20px;
        padding: 16px;
        background: rgba(17, 113, 239, 0.05);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    .existing-files-section .section-title {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-primary);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .existing-files-section .section-title i {
        color: #1171ef;
    }

    /* ===== PREVIEW GRID ===== */
    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }
    .preview-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid var(--border-color);
        aspect-ratio: 1/1;
        background: #fff;
        transition: all 0.2s;
    }
    .preview-item:hover {
        border-color: var(--input-focus-border);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .preview-item.document {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }
    .preview-item.document i {
        font-size: 2rem;
        color: #dc3545;
    }
    .file-badge {
        font-size: 0.65rem;
        background: rgba(13, 68, 53, 0.9);
        color: white;
        padding: 4px 6px;
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== NEW FILES PREVIEW ===== */
    #new-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        margin-top: 16px;
    }
    .new-preview-box {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid var(--input-focus-border);
        aspect-ratio: 1/1;
        background: #fff;
        animation: slideIn 0.3s ease;
    }
    .new-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .new-preview-box.document {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }
    .new-preview-box.document i {
        font-size: 2rem;
        color: #dc3545;
    }
    .preview-remove {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(245, 54, 92, 0.9);
        color: #fff;
        border: none;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        z-index: 2;
    }
    .preview-remove:hover {
        background: #dc3545;
        transform: scale(1.1);
    }

    /* ===== ALERT INFO ===== */
    .alert-info-custom {
        background: rgba(17, 113, 239, 0.1);
        border-left: 4px solid #1171ef;
        padding: 12px 16px;
        margin-top: 12px;
        font-size: 0.8rem;
        border-radius: 0 8px 8px 0;
        color: var(--text-primary);
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .alert-info-custom i {
        color: #1171ef;
        margin-top: 2px;
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
        .preview-container, #new-preview-container { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 480px) {
        .preview-container, #new-preview-container { grid-template-columns: repeat(2, 1fr); }
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
            <i class="fas fa-clipboard-check"></i>
            <strong>Edit Dokumen Compliance</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="form-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-edit"></i>
                        Form Edit Dokumen Compliance
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('compliance.update', $data->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- NAMA PELAPOR --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Nama_pelapor">
                                    <i class="fas fa-user"></i> Nama Pelapor <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="Nama_pelapor"
                                       name="Nama_pelapor"
                                       value="{{ old('Nama_pelapor', $data->Nama_pelapor) }}"
                                       class="form-control @error('Nama_pelapor') is-invalid @enderror"
                                       placeholder="Nama lengkap pelapor"
                                       maxlength="255"
                                       required>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Nama orang yang melaporkan insiden
                                </small>
                                @error('Nama_pelapor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DEPARTEMEN --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Departemen">
                                    <i class="fas fa-building"></i> Departemen <span class="required">*</span>
                                </label>
                                <select id="Departemen"
                                        name="Departemen"
                                        class="form-select @error('Departemen') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="HSE" {{ old('Departemen', $data->Departemen) == 'HSE' ? 'selected' : '' }}>🛡️ HSE</option>
                                    <option value="Produksi" {{ old('Departemen', $data->Departemen) == 'Produksi' ? 'selected' : '' }}>🏭 Produksi</option>
                                    <option value="HRD" {{ old('Departemen', $data->Departemen) == 'HRD' ? 'selected' : '' }}>👥 HRD</option>
                                    <option value="Maintenance" {{ old('Departemen', $data->Departemen) == 'Maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                                    <option value="Lainnya" {{ old('Departemen', $data->Departemen) == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                </select>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Departemen pelapor
                                </small>
                                @error('Departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Lokasi">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="Lokasi"
                                       name="Lokasi"
                                       value="{{ old('Lokasi', $data->Lokasi) }}"
                                       class="form-control @error('Lokasi') is-invalid @enderror"
                                       placeholder="Contoh: Pit Utara, Area Reklamasi"
                                       maxlength="255"
                                       required>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Lokasi kejadian insiden
                                </small>
                                @error('Lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TANGGAL LAPOR --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Tanggal_lapor">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Lapor <span class="required">*</span>
                                </label>
                                <input type="date"
                                       id="Tanggal_lapor"
                                       name="Tanggal_lapor"
                                       value="{{ old('Tanggal_lapor', $data->Tanggal_lapor?->format('Y-m-d')) }}"
                                       class="form-control @error('Tanggal_lapor') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Tanggal pelaporan insiden
                                </small>
                                @error('Tanggal_lapor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS INSIDEN --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Jenis_insiden">
                                    <i class="fas fa-exclamation-triangle"></i> Jenis Insiden <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="Jenis_insiden"
                                       name="Jenis_insiden"
                                       value="{{ old('Jenis_insiden', $data->Jenis_insiden) }}"
                                       class="form-control @error('Jenis_insiden') is-invalid @enderror"
                                       placeholder="Contoh: Kecelakaan Kerja, Tumpahan Minyak"
                                       maxlength="255"
                                       required>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Deskripsi singkat jenis insiden
                                </small>
                                @error('Jenis_insiden')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS INSPESI --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Jenis_inspeksi">
                                    <i class="fas fa-search"></i> Jenis Inspeksi <span class="required">*</span>
                                </label>
                                <select id="Jenis_inspeksi"
                                        name="Jenis_inspeksi"
                                        class="form-select @error('Jenis_inspeksi') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Jenis Inspeksi --</option>
                                    <option value="Internal" {{ old('Jenis_inspeksi', $data->Jenis_inspeksi) == 'Internal' ? 'selected' : '' }}>🏢 Internal</option>
                                    <option value="Eksternal/Regulasi" {{ old('Jenis_inspeksi', $data->Jenis_inspeksi) == 'Eksternal/Regulasi' ? 'selected' : '' }}>🌐 Eksternal / Regulasi</option>
                                    <option value="Audit" {{ old('Jenis_inspeksi', $data->Jenis_inspeksi) == 'Audit' ? 'selected' : '' }}>📋 Audit</option>
                                </select>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Jenis inspeksi yang dilakukan
                                </small>
                                @error('Jenis_inspeksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Status">
                                    <i class="fas fa-flag"></i> Status <span class="required">*</span>
                                </label>
                                <select id="Status"
                                        name="Status"
                                        class="form-select @error('Status') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Escalated" {{ old('Status', $data->Status) == 'Escalated' ? 'selected' : '' }}>🔴 Escalated</option>
                                    <option value="Pending" {{ old('Status', $data->Status) == 'Pending' ? 'selected' : '' }}>🟡 Pending</option>
                                    <option value="Resolved" {{ old('Status', $data->Status) == 'Resolved' ? 'selected' : '' }}>🟢 Resolved</option>
                                    <option value="Open" {{ old('Status', $data->Status) == 'Open' ? 'selected' : '' }}>🔵 Open</option>
                                </select>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Status penanganan insiden
                                </small>
                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGKAT KEPARAHAN --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Tingkat_keparahan">
                                    <i class="fas fa-chart-line"></i> Tingkat Keparahan <span class="required">*</span>
                                </label>
                                <select id="Tingkat_keparahan"
                                        name="Tingkat_keparahan"
                                        class="form-select @error('Tingkat_keparahan') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Low" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'Low' ? 'selected' : '' }}>🟢 Rendah</option>
                                    <option value="Medium" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'Medium' ? 'selected' : '' }}>🟡 Sedang</option>
                                    <option value="High" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'High' ? 'selected' : '' }}>🟠 Tinggi</option>
                                    <option value="Critical" {{ old('Tingkat_keparahan', $data->Tingkat_keparahan) == 'Critical' ? 'selected' : '' }}>🔴 Kritis</option>
                                </select>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Evaluasi tingkat keparahan insiden
                                </small>
                                @error('Tingkat_keparahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DISELESAIKAN OLEH --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="Diselesaikan_oleh">
                                    <i class="fas fa-user-check"></i> Diselesaikan Oleh <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="Diselesaikan_oleh"
                                       name="Diselesaikan_oleh"
                                       value="{{ old('Diselesaikan_oleh', $data->Diselesaikan_oleh) }}"
                                       class="form-control @error('Diselesaikan_oleh') is-invalid @enderror"
                                       placeholder="Nama penanggung jawab penyelesaian"
                                       maxlength="255"
                                       required>
                                <small class="form-hint">
                                    <i class="fas fa-info-circle"></i> Nama yang bertanggung jawab menyelesaikan
                                </small>
                                @error('Diselesaikan_oleh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FILE DOKUMENTASI (MULTIPLE) --}}
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-file-upload"></i> Upload File Dokumentasi
                                </label>
                                
                                <label class="file-upload-wrapper" for="file_input">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <div class="file-upload-label">
                                        Klik atau drag file baru ke sini
                                    </div>
                                    <small class="form-hint mt-2">
                                        <i class="fas fa-info-circle"></i> Format: JPG, JPEG, PNG, PDF | Maks: 2 MB/file | Maksimal 10 file
                                    </small>
                                    <input type="file"
                                           id="file_input"
                                           name="file_dokumentasi[]"
                                           class="@error('file_dokumentasi') is-invalid @enderror @error('file_dokumentasi.*') is-invalid @enderror"
                                           accept=".jpg,.jpeg,.png,.pdf"
                                           multiple>
                                </label>

                                {{-- Preview file baru yang dipilih --}}
                                <div id="new-preview-container"></div>

                                {{-- Tampilkan file lama yang sudah tersimpan --}}
                                @if($data->file_dokumentasi && is_array($data->file_dokumentasi) && count($data->file_dokumentasi) > 0)
                                    <div class="existing-files-section">
                                        <p class="section-title">
                                            <i class="fas fa-folder-open"></i> File Tersimpan ({{ count($data->file_dokumentasi) }})
                                        </p>
                                        <div class="preview-container">
                                            @foreach($data->file_dokumentasi as $path)
                                                @php $ext = pathinfo($path, PATHINFO_EXTENSION); @endphp
                                                <div class="preview-item {{ in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']) ? '' : 'document' }}" title="{{ basename($path) }}">
                                                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ asset('storage/' . $path) }}" alt="{{ basename($path) }}" onerror="this.src='{{ asset('assets/img/default-image.png') }}'">
                                                    @elseif($ext === 'pdf')
                                                        <i class="fas fa-file-pdf"></i>
                                                    @else
                                                        <i class="fas fa-file"></i>
                                                    @endif
                                                    <div class="file-badge">{{ \Str::limit(basename($path), 15) }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="alert-info-custom">
                                            <i class="fas fa-info-circle"></i> 
                                            <strong>Catatan:</strong> Mengupload file baru akan menggantikan <strong>seluruh</strong> file lama di atas.
                                        </div>
                                    </div>
                                @endif

                                @error('file_dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('file_dokumentasi.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="form-actions">
                            <a href="{{ route('compliance') }}" class="btn btn-light">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Update Dokumen
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
    console.log('✅ Edit form script loaded successfully.');

    // 1. Auto-show error modal jika validasi gagal
    @if ($errors->any())
        const errorModalEl = document.getElementById('errorModal');
        if (errorModalEl) {
            const modal = new bootstrap.Modal(errorModalEl);
            modal.show();
        }
    @endif

    // 2. File Preview dengan Drag & Drop untuk file BARU
    const fileInput = document.getElementById('file_input');
    const newPreviewContainer = document.getElementById('new-preview-container');
    const uploadWrapper = document.querySelector('.file-upload-wrapper');

    // Preview new files
    function previewNewFiles(files) {
        newPreviewContainer.innerHTML = '';
        
        [...files].forEach((file, index) => {
            const div = document.createElement('div');
            div.className = 'new-preview-box shadow-sm';
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="preview-remove" data-index="${index}" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    newPreviewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                div.className += ' document';
                div.innerHTML = `
                    <i class="fas fa-file-pdf"></i>
                    <button type="button" class="preview-remove" data-index="${index}" title="Hapus">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                newPreviewContainer.appendChild(div);
            } else {
                div.className += ' document';
                div.innerHTML = `
                    <i class="fas fa-file"></i>
                    <button type="button" class="preview-remove" data-index="${index}" title="Hapus">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                newPreviewContainer.appendChild(div);
            }
        });
    }

    // Handle file selection for new files
    fileInput?.addEventListener('change', function() {
        if (this.files.length > 0) {
            previewNewFiles(this.files);
        }
    });

    // Handle remove from new preview
    newPreviewContainer?.addEventListener('click', function(e) {
        if (e.target.closest('.preview-remove')) {
            e.preventDefault();
            const btn = e.target.closest('.preview-remove');
            const index = parseInt(btn.getAttribute('data-index'));
            
            // Remove from DataTransfer
            const dt = new DataTransfer();
            const files = fileInput.files;
            for (let i = 0; i < files.length; i++) {
                if (i !== index) dt.items.add(files[i]);
            }
            fileInput.files = dt.files;
            
            // Re-render preview
            previewNewFiles(fileInput.files);
        }
    });

    // Drag & Drop support for new files
    if (uploadWrapper && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadWrapper.addEventListener(eventName, () => {
                uploadWrapper.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadWrapper.addEventListener(eventName, () => {
                uploadWrapper.classList.remove('dragover');
            }, false);
        });

        uploadWrapper.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            previewNewFiles(files);
        }, false);

        // Click to open file picker
        uploadWrapper.addEventListener('click', (e) => {
            if (!e.target.closest('.preview-remove')) {
                fileInput.click();
            }
        });
    }

    // 3. Form Submission Handler (Simple & Safe)
    const form = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            // Simple loading state - biarkan form submit normal
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memperbarui...';
        });
    }

    // 4. Ripple effect for buttons
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