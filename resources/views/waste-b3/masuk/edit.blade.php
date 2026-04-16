@extends('layouts.user_type.auth')

@section('content')
<style>
    /* ===== MODERN SOFT UI - EDIT FORM MASUK ===== */
    :root {
        --primary-gradient: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
        --surface-blur: rgba(255, 255, 255, 0.95);
    }

    .main-content-wrapper { 
        padding: 1.5rem; 
        animation: fadeIn 0.5s ease; 
    }
    @keyframes fadeIn { 
        from { opacity: 0; transform: translateY(10px); } 
        to { opacity: 1; transform: translateY(0); } 
    }

    /* Header dengan Gradient */
    .custom-header {
        background: var(--primary-gradient);
        border-radius: 1.25rem;
        padding: 2.5rem 2rem 5rem 2rem;
        margin-bottom: -4rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 26px -4px rgba(121, 40, 202, 0.3);
    }
    .custom-header::before,
    .custom-header::after {
        content: '';
        position: absolute;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }
    .custom-header::before { top: -30%; right: -5%; width: 250px; height: 250px; }
    .custom-header::after { bottom: -20%; left: -10%; width: 180px; height: 180px; animation-delay: -4s; }
    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(-15px, 10px) scale(1.08); }
    }

    /* Card Form dengan Glassmorphism */
    .form-card {
        background: var(--surface-blur);
        backdrop-filter: blur(10px);
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .form-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 25px 35px 0 rgba(0,0,0,0.08);
    }

    /* Label & Input Custom */
    .form-label-custom {
        font-size: 0.7rem;
        font-weight: 700;
        color: #67748e;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }

    .input-group-custom {
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        border: 1px solid #d2d6da;
        background: #fff;
        overflow: hidden;
    }
    .input-group-custom:focus-within {
        border-color: #7928ca;
        box-shadow: 0 0 0 3px rgba(121, 40, 202, 0.15);
    }
    .input-group-custom .form-control,
    .input-group-custom textarea {
        border: none;
        box-shadow: none;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        background: transparent;
    }
    .input-group-custom textarea { resize: vertical; min-height: 80px; }
    .input-group-custom .form-control:read-only {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        color: #67748e;
        cursor: not-allowed;
        opacity: 1;
    }

    /* Readonly Badge */
    .readonly-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: rgba(245, 57, 57, 0.1);
        color: #f53939;
        padding: 0.2rem 0.5rem;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 600;
        margin-top: 0.35rem;
    }

    /* Section Divider */
    .section-divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        color: #67748e;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .section-divider::before,
    .section-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e9ecef;
    }
    .section-divider span {
        padding: 0 1rem;
        color: #7928ca;
    }

    /* Stock Info Box */
    .stock-info-box {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border: 1px solid rgba(121, 40, 202, 0.2);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
    }
    .stock-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px dashed #e9ecef;
    }
    .stock-item:last-child { border-bottom: none; }
    .stock-label { font-size: 0.75rem; color: #67748e; font-weight: 600; }
    .stock-value { font-weight: 700; color: #344767; }
    .stock-value.warning { color: #f53939; }
    .stock-value.success { color: #17ad37; }

    /* Preview Sidebar */
    .preview-card {
        background: var(--surface-blur);
        backdrop-filter: blur(10px);
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
    }
    .preview-item {
        padding: 0.75rem 0;
        border-bottom: 1px dashed #e9ecef;
    }
    .preview-item:last-child { border-bottom: none; }
    .preview-label { font-size: 0.7rem; color: #67748e; font-weight: 600; text-transform: uppercase; }
    .preview-value { font-weight: 600; color: #344767; word-break: break-word; }
    .preview-value.changed {
        color: #7928ca;
        position: relative;
    }
    .preview-value.changed::after {
        content: '✎';
        position: absolute;
        right: 0;
        font-size: 0.6rem;
        color: #f53939;
        opacity: 0.7;
    }
    
    /* Buttons */
    .btn-round { border-radius: 0.75rem; padding: 0.6rem 1.5rem; font-weight: 600; }
    .btn-gradient-primary {
        background: var(--primary-gradient);
        border: none;
        color: #fff;
    }
    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(121, 40, 202, 0.4);
    }
    .btn-outline-soft {
        border: 1px solid #d2d6da;
        color: #67748e;
        border-radius: 0.75rem;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-outline-soft:hover {
        border-color: #7928ca;
        color: #7928ca;
        background: rgba(121, 40, 202, 0.05);
    }

    /* Alert Custom */
    .alert-soft {
        border-radius: 1rem;
        border: none;
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
    }
    .alert-soft-info { background: rgba(33, 82, 255, 0.1); color: #344767; }
    .alert-soft-warning { background: rgba(245, 57, 57, 0.1); color: #344767; }

    /* Validasi State */
    .is-invalid-custom { 
        border-color: #fd5c70 !important; 
        background-color: rgba(253, 92, 112, 0.05);
    }
    .invalid-feedback-custom { 
        color: #fd5c70; 
        font-size: 0.75rem; 
        margin-top: 4px; 
        display: none; 
        font-weight: 600;
    }
    .is-invalid-custom + .invalid-feedback-custom { display: block; }

    /* Status Badge Preview */
    .status-badge-preview {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        background: rgba(33, 82, 255, 0.1);
        color: #2152ff;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* Pengeluaran Warning */
    .pengeluaran-warning {
        background: linear-gradient(145deg, #fff8e6, #fff);
        border-left: 4px solid #fbcf33;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    /* File Preview Box */
    .file-preview-box {
        background: #f8f9fa;
        border: 1px dashed #d2d6da;
        border-radius: 0.75rem;
        padding: 0.75rem;
        margin-top: 0.5rem;
    }
    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: #fff;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .file-preview-item:last-child { margin-bottom: 0; }
    .file-preview-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(121, 40, 202, 0.1);
        border-radius: 0.35rem;
        color: #7928ca;
    }
    .file-preview-info { flex: 1; min-width: 0; }
    .file-preview-name {
        font-size: 0.75rem;
        font-weight: 600;
        color: #344767;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
    .file-preview-meta {
        font-size: 0.65rem;
        color: #67748e;
    }
    .file-preview-actions {
        display: flex;
        gap: 0.25rem;
    }
    .file-action-btn {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.35rem;
        background: #f0f2f5;
        color: #67748e;
        transition: all 0.2s;
        border: none;
        font-size: 0.7rem;
    }
    .file-action-btn:hover { background: #e9ecef; color: #344767; }
    .file-action-btn.danger:hover { background: #fee2e2; color: #dc2626; }

    /* Responsive */
    @media (max-width: 991px) {
        .preview-card { position: static; margin-top: 1rem; }
        .custom-header { padding: 1.5rem; }
    }

    /* Utility */
    .text-gradient-primary {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .border-soft { border-color: rgba(0,0,0,0.08) !important; }
    .ls-1 { letter-spacing: 1px; }
</style>

<div class="main-content-wrapper">
    <!-- Page Header -->
    <div class="custom-header">
        <div class="d-flex align-items-center">
            <a href="{{ route('waste-b3') }}" class="btn btn-link text-white p-0 me-3 shadow-none" title="Kembali">
                <i class="fas fa-chevron-left fa-lg"></i>
            </a>
            <div>
                <h4 class="text-white font-weight-bolder mb-0">
                    <i class="fas fa-pen-to-square me-2"></i>Edit Limbah B3 Masuk
                </h4>
                <p class="text-white text-xs opacity-8 mb-0">
                    Perbarui data limbah B3 #{{ $data->id }} di Tempat Penyimpanan Sementara (TPS).
                </p>
            </div>
        </div>
    </div>

    <div class="row px-3 mt-n4">
        <!-- Form Section -->
        <div class="col-lg-8 mb-4">
            <div class="card form-card p-4">
                <form action="{{ route('waste-b3.update', $data->id) }}" method="POST" id="wasteForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- Warning: Sudah Ada Pengeluaran --}}
                        @if($data->pengeluaran->count() > 0)
                        <div class="col-12 mb-3">
                            <div class="pengeluaran-warning d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle fa-lg me-3 mt-1"></i>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Data Memiliki Riwayat Pengeluaran</h6>
                                    <p class="text-xs mb-2">
                                        Record ini sudah memiliki <strong>{{ $data->pengeluaran->count() }} pengeluaran</strong> terkait.
                                    </p>
                                    <ul class="text-xxs mb-0 ps-3">
                                        <li>Field <strong>Jumlah Ton</strong> dikunci dan tidak dapat diubah</li>
                                        <li>Field lain tetap dapat diedit sesuai kebutuhan</li>
                                        <li>Perubahan akan mempengaruhi status dan perhitungan stok</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Stock Info Box --}}
                        <div class="col-12 mb-4">
                            <label class="form-label-custom"><i class="fas fa-balance-scale me-1"></i>Informasi Stok</label>
                            <div class="stock-info-box">
                                <div class="stock-item">
                                    <span class="stock-label">Jumlah Masuk Awal</span>
                                    <span class="stock-value">{{ $data->jumlah_ton_formatted }}</span>
                                </div>
                                <div class="stock-item">
                                    <span class="stock-label">Sudah Dikeluarkan</span>
                                    <span class="stock-value warning">- {{ number_format($data->jumlah_dikeluarkan, 2, ',', '.') }} ton</span>
                                </div>
                                <div class="stock-item border-top pt-2 mt-2">
                                    <span class="stock-label">Sisa Limbah Saat Ini</span>
                                    <span class="stock-value {{ $data->sisa_limbah > 0 ? 'warning' : 'success' }}">
                                        {{ $data->sisa_limbah_formatted }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: Identitas Limbah --}}
                        <div class="col-12 mb-2">
                            <div class="section-divider"><span><i class="fas fa-cube me-1"></i>Identitas Limbah</span></div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-tag me-1"></i>Jenis Limbah B3</label>
                            <div class="input-group-custom">
                                <input type="text" name="jenis_limbah" id="jenis_limbah" class="form-control" 
                                       placeholder="Contoh: Oli Bekas, Baterai..." 
                                       value="{{ old('jenis_limbah', $data->jenis_limbah) }}" maxlength="100" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-barcode me-1"></i>Kode Limbah</label>
                            <div class="input-group-custom">
                                <input type="text" name="kode_limbah" id="kode_limbah" class="form-control" 
                                       placeholder="Contoh: B3-OLI-001" 
                                       value="{{ old('kode_limbah', $data->kode_limbah) }}" maxlength="50" required>
                            </div>
                            <small class="text-xxs text-muted ps-1 mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>Kombinasi Kode + Tanggal tidak boleh duplikat
                            </small>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-map-pin me-1"></i>Sumber Limbah</label>
                            <div class="input-group-custom">
                                <input type="text" name="sumber_limbah" id="sumber_limbah" class="form-control" 
                                       placeholder="Contoh: Workshop, Laboratorium..." 
                                       value="{{ old('sumber_limbah', $data->sumber_limbah) }}" maxlength="100" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-file-alt me-1"></i>Nomor Manifest</label>
                            <div class="input-group-custom">
                                <input type="text" name="nomor_manifest" id="nomor_manifest" class="form-control" 
                                       placeholder="Contoh: MNF-B3-2024-001" 
                                       value="{{ old('nomor_manifest', $data->nomor_manifest) }}" maxlength="100">
                            </div>
                            <small class="text-xxs text-muted ps-1 mt-1 d-block">Opsional</small>
                        </div>

                        {{-- SECTION: Waktu & Jumlah --}}
                        <div class="col-12 mb-2">
                            <div class="section-divider"><span><i class="fas fa-calendar-alt me-1"></i>Waktu & Volume</span></div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom"><i class="far fa-calendar me-1"></i>Tanggal Masuk</label>
                            <div class="input-group-custom">
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" 
                                       value="{{ old('tanggal_masuk', $data->tanggal_masuk?->format('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom"><i class="fas fa-weight-hanging me-1"></i>Jumlah (Ton)</label>
                            <div class="input-group-custom" id="jumlah_group">
                                <input type="number" step="any" name="jumlah_ton" id="jumlah_ton" class="form-control" 
                                       placeholder="0.00" value="{{ old('jumlah_ton', $data->jumlah_ton) }}" 
                                       {{ $data->pengeluaran->count() > 0 ? 'readonly' : '' }} required>
                                @if($data->pengeluaran->count() > 0)
                                    <span class="input-group-text"><i class="fas fa-lock text-secondary"></i></span>
                                @endif
                            </div>
                            @if($data->pengeluaran->count() > 0)
                                <span class="readonly-badge"><i class="fas fa-lock"></i>Terkunci</span>
                            @endif
                            <div id="jumlah-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Minimal 0.001 ton
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom"><i class="fas fa-hourglass-end me-1"></i>Batas Penyimpanan</label>
                            <div class="input-group-custom" id="batas_group">
                                <input type="date" name="maksimal_penyimpanan" id="maksimal_penyimpanan" class="form-control" 
                                       value="{{ old('maksimal_penyimpanan', $data->maksimal_penyimpanan?->format('Y-m-d')) }}" required>
                            </div>
                            <div id="batas-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Harus setelah tanggal masuk
                            </div>
                        </div>

                        {{-- SECTION: Berita Acara --}}
                        <div class="col-12 mb-2">
                            <div class="section-divider"><span><i class="fas fa-file-signature me-1"></i>Dokumen</span></div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">
                                <i class="fas fa-file-signature me-1"></i>Berita Acara
                            </label>
                            <div class="input-group-custom">
                                <input type="file" name="berita_acara" id="berita_acara" class="form-control" 
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <small class="text-xxs text-muted ps-1 mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>Opsional. Format: PDF, JPG, PNG (Maks. 10MB)
                            </small>
                            @error('berita_acara')
                                <div class="invalid-feedback-custom" style="display:block;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror

                            {{-- Preview File Lama --}}
                            @if($data->berita_acara)
                            <div class="file-preview-box" id="existing_file_preview">
                                <div class="file-preview-item">
                                    <div class="file-preview-icon">
                                        <i class="fas fa-file-{{ pathinfo($data->berita_acara, PATHINFO_EXTENSION) == 'pdf' ? 'pdf' : 'image' }}"></i>
                                    </div>
                                    <div class="file-preview-info">
                                        <div class="file-preview-name" title="{{ $data->berita_acara }}">
                                            {{ $data->berita_acara }}
                                        </div>
                                        <div class="file-preview-meta">
                                            <i class="fas fa-check-circle text-success me-1"></i>File tersimpan
                                        </div>
                                    </div>
                                    <div class="file-preview-actions">
                                        <a href="{{ Storage::url('waste-b3/berita-acara/' . $data->berita_acara) }}" 
                                           target="_blank" 
                                           class="file-action-btn" 
                                           title="Lihat File">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="file-action-btn danger" id="remove_file_btn" title="Hapus File">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="keep_existing_file" id="keep_existing_file" value="1">
                                <small class="text-xxs text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Upload file baru untuk mengganti, atau klik <strong>🗑️</strong> untuk menghapus.
                                </small>
                            </div>
                            @endif
                        </div>

                        {{-- SECTION: Catatan --}}
                        <div class="col-12 mb-2">
                            <div class="section-divider"><span><i class="fas fa-sticky-note me-1"></i>Catatan</span></div>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label-custom"><i class="fas fa-comment-alt me-1"></i>Catatan Tambahan</label>
                            <div class="input-group-custom">
                                <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Informasi tambahan...">{{ old('catatan', $data->catatan) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Info Status -->
                    <div class="alert-soft alert-soft-info mb-4 d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <p class="text-xs mb-0">
                            <strong>Status Saat Ini:</strong> 
                            <span class="status-badge-preview">
                                <i class="fas fa-circle"></i>{{ $data->status_label }}
                            </span>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>Terakhir update: {{ $data->updated_at?->format('d/m/Y H:i') }}
                            </small>
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('waste-b3') }}" class="btn btn-outline-soft mb-0">
                            <i class="fas fa-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" id="submitBtn" class="btn btn-gradient-primary btn-round mb-0">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Live Preview Sidebar -->
        <div class="col-lg-4">
            <div class="card preview-card p-4">
                <h6 class="font-weight-bolder mb-3 text-gradient-primary">
                    <i class="fas fa-eye me-2"></i>Live Preview
                </h6>
                
                <div class="p-3 bg-white border-radius-lg shadow-sm border-soft">
                    <p class="text-xxs font-weight-bolder text-muted mb-3 text-uppercase ls-1">Ringkasan Perubahan</p>
                    
                    <div class="preview-item">
                        <span class="preview-label d-block">Jenis Limbah</span>
                        <span id="view_jenis" class="preview-value {{ $data->jenis_limbah != old('jenis_limbah') && old('jenis_limbah') ? 'changed' : '' }}">
                            {{ old('jenis_limbah', $data->jenis_limbah) }}
                        </span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label d-block">Kode Limbah</span>
                        <span id="view_kode" class="preview-value text-primary {{ $data->kode_limbah != old('kode_limbah') && old('kode_limbah') ? 'changed' : '' }}">
                            {{ old('kode_limbah', $data->kode_limbah) }}
                        </span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label d-block">Sumber</span>
                        <span id="view_sumber" class="preview-value {{ $data->sumber_limbah != old('sumber_limbah') && old('sumber_limbah') ? 'changed' : '' }}">
                            {{ old('sumber_limbah', $data->sumber_limbah) }}
                        </span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Tanggal Masuk</span>
                        <span id="view_tgl_masuk" class="preview-value {{ $data->tanggal_masuk?->format('Y-m-d') != old('tanggal_masuk') && old('tanggal_masuk') ? 'changed' : '' }}">
                            {{ \Carbon\Carbon::parse(old('tanggal_masuk', $data->tanggal_masuk))->format('d/m/Y') }}
                        </span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Volume</span>
                        <span id="view_jumlah" class="preview-value text-danger">
                            {{ number_format(old('jumlah_ton', $data->jumlah_ton), 3, ',', '.') }} Ton
                            @if($data->pengeluaran->count() > 0)
                                <i class="fas fa-lock text-secondary ms-1" title="Terkunci"></i>
                            @endif
                        </span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Batas Simpan</span>
                        <span id="view_batas" class="preview-value {{ $data->maksimal_penyimpanan?->format('Y-m-d') != old('maksimal_penyimpanan') && old('maksimal_penyimpanan') ? 'changed' : '' }}">
                            {{ \Carbon\Carbon::parse(old('maksimal_penyimpanan', $data->maksimal_penyimpanan))->format('d/m/Y') }}
                        </span>
                    </div>

                    {{-- Preview Berita Acara di Sidebar --}}
                    <div class="preview-item" id="preview_berita_acara_wrapper" style="{{ $data->berita_acara ? '' : 'display: none;' }}">
                        <span class="preview-label d-block">Berita Acara</span>
                        <span id="view_berita_acara" class="preview-value d-block text-truncate" style="max-width: 100%;">
                            <i class="fas fa-paperclip me-1"></i>
                            <span id="view_berita_acara_name">{{ $data->berita_acara ?? '' }}</span>
                            <span id="view_berita_acara_status" class="text-success ms-1">
                                @if($data->berita_acara)<i class="fas fa-check-circle" title="File tersimpan"></i>@endif
                            </span>
                        </span>
                    </div>

                    <div class="preview-item">
                        <span class="preview-label d-block">Status</span>
                        <span class="status-badge-preview mt-1">
                            <i class="fas fa-circle"></i>{{ $data->status_label }}
                        </span>
                    </div>

                    @if($data->pengeluaran->count() > 0)
                    <div class="preview-item border-top pt-2 mt-2">
                        <span class="preview-label d-block text-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>Riwayat Pengeluaran
                        </span>
                        <span class="text-xxs text-muted">{{ $data->pengeluaran->count() }} record terkait</span>
                    </div>
                    @endif
                </div>
                
                <!-- Validation Summary -->
                <div id="validation_summary" class="alert-soft alert-soft-warning mt-4 p-3 d-none">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span class="text-xs font-weight-bold">Periksa Kembali:</span>
                    <ul class="text-xxs mb-0 mt-1 ps-3" id="validation_list"></ul>
                </div>

                <!-- Info Box -->
                <div class="alert-soft alert-soft-info mt-4 p-3 d-flex align-items-start">
                    <i class="fas fa-shield-alt mt-1 me-2"></i>
                    <p class="text-xs mb-0">
                        <strong class="d-block">Perubahan Tersimpan</strong>
                        Data yang diubah akan langsung memperbarui record di database setelah disimpan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const inputs = {
        jenis: document.getElementById('jenis_limbah'),
        kode: document.getElementById('kode_limbah'),
        sumber: document.getElementById('sumber_limbah'),
        manifest: document.getElementById('nomor_manifest'),
        tglMasuk: document.getElementById('tanggal_masuk'),
        jumlah: document.getElementById('jumlah_ton'),
        batas: document.getElementById('maksimal_penyimpanan'),
        catatan: document.getElementById('catatan'),
        beritaAcara: document.getElementById('berita_acara')
    };

    const views = {
        jenis: document.getElementById('view_jenis'),
        kode: document.getElementById('view_kode'),
        sumber: document.getElementById('view_sumber'),
        tglMasuk: document.getElementById('view_tgl_masuk'),
        jumlah: document.getElementById('view_jumlah'),
        batas: document.getElementById('view_batas'),
        beritaAcaraWrapper: document.getElementById('preview_berita_acara_wrapper'),
        beritaAcaraName: document.getElementById('view_berita_acara_name'),
        beritaAcaraStatus: document.getElementById('view_berita_acara_status')
    };

    const submitBtn = document.getElementById('submitBtn');
    const jumlahGroup = document.getElementById('jumlah_group');
    const jumlahError = document.getElementById('jumlah-error');
    const batasGroup = document.getElementById('batas_group');
    const batasError = document.getElementById('batas-error');
    const validationSummary = document.getElementById('validation_summary');
    const validationList = document.getElementById('validation_list');

    // Original values for change detection
    const originalValues = {
        jenis: `{{ $data->jenis_limbah }}`,
        kode: `{{ $data->kode_limbah }}`,
        sumber: `{{ $data->sumber_limbah }}`,
        tglMasuk: `{{ $data->tanggal_masuk?->format('Y-m-d') }}`,
        jumlah: `{{ $data->jumlah_ton }}`,
        batas: `{{ $data->maksimal_penyimpanan?->format('Y-m-d') }}`,
        beritaAcara: `{{ $data->berita_acara ?? '' }}`
    };

    // Check if field is readonly (jumlah_ton with pengeluaran)
    const isJumlahReadonly = {{ $data->pengeluaran->count() > 0 ? 'true' : 'false' }};
    const hasExistingFile = {{ $data->berita_acara ? 'true' : 'false' }};

    // Helper: Format tanggal Indonesia
    const formatDate = (dateStr) => {
        if (!dateStr) return '--';
        const [y, m, d] = dateStr.split('-');
        return `${d}/${m}/${y}`;
    };

    // Helper: Format number
    const formatNumber = (num) => {
        if (!num) return '--';
        return parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 3 }) + ' Ton';
    };

    // Helper: Check if value changed from original
    const isChanged = (field, currentValue) => {
        if (!originalValues[field]) return currentValue ? true : false;
        return currentValue && currentValue !== originalValues[field];
    };

    // Real-time Preview & Validation
    const updateUI = () => {
        const errors = [];

        // Update Preview with change indicator
        views.jenis.textContent = inputs.jenis?.value || '--';
        views.jenis.className = `preview-value ${isChanged('jenis', inputs.jenis?.value) ? 'changed' : ''}`;
        
        views.kode.textContent = inputs.kode?.value || '--';
        views.kode.className = `preview-value text-primary ${isChanged('kode', inputs.kode?.value) ? 'changed' : ''}`;
        
        views.sumber.textContent = inputs.sumber?.value || '--';
        views.sumber.className = `preview-value ${isChanged('sumber', inputs.sumber?.value) ? 'changed' : ''}`;
        
        views.tglMasuk.textContent = formatDate(inputs.tglMasuk?.value);
        views.tglMasuk.className = `preview-value ${isChanged('tglMasuk', inputs.tglMasuk?.value) ? 'changed' : ''}`;
        
        views.jumlah.textContent = formatNumber(inputs.jumlah?.value);
        
        views.batas.textContent = formatDate(inputs.batas?.value);
        views.batas.className = `preview-value ${isChanged('batas', inputs.batas?.value) ? 'changed' : ''}`;

        // Validasi: Jumlah (hanya jika tidak readonly)
        if (inputs.jumlah?.value && !isJumlahReadonly) {
            const val = parseFloat(inputs.jumlah.value);
            if (val < 0.001) {
                jumlahGroup.classList.add('is-invalid-custom');
                jumlahError.style.display = 'block';
                errors.push('Jumlah minimal 0.001 ton');
            } else {
                jumlahGroup.classList.remove('is-invalid-custom');
                jumlahError.style.display = 'none';
            }
        }

        // Validasi: Batas penyimpanan
        if (inputs.tglMasuk?.value && inputs.batas?.value) {
            const tglMasuk = new Date(inputs.tglMasuk.value);
            const tglBatas = new Date(inputs.batas.value);
            if (tglBatas <= tglMasuk) {
                batasGroup.classList.add('is-invalid-custom');
                batasError.style.display = 'block';
                errors.push('Batas penyimpanan harus setelah tanggal masuk');
            } else {
                batasGroup.classList.remove('is-invalid-custom');
                batasError.style.display = 'none';
            }
        }

        // Validasi: Berita Acara (file)
        if (inputs.beritaAcara?.files?.[0]) {
            const file = inputs.beritaAcara.files[0];
            const maxSizeMB = 10;
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            
            if (!validTypes.includes(file.type)) {
                errors.push('Format berita acara harus PDF, JPG, atau PNG');
            }
            if (file.size > maxSizeMB * 1024 * 1024) {
                errors.push(`Ukuran file berita acara maksimal ${maxSizeMB}MB`);
            }
        }

        // Validasi: Field wajib (kecuali jumlah jika readonly)
        const requiredFields = [
            { field: 'jenis', label: 'Jenis Limbah' },
            { field: 'kode', label: 'Kode Limbah' },
            { field: 'sumber', label: 'Sumber Limbah' },
            { field: 'tglMasuk', label: 'Tanggal Masuk' },
            { field: 'batas', label: 'Batas Penyimpanan' }
        ];
        
        if (!isJumlahReadonly) {
            requiredFields.push({ field: 'jumlah', label: 'Jumlah Limbah' });
        }

        requiredFields.forEach(({ field, label }) => {
            if (!inputs[field]?.value) {
                errors.push(`${label} wajib diisi`);
            }
        });

        // Update validation summary
        if (errors.length > 0) {
            validationSummary.classList.remove('d-none');
            validationList.innerHTML = errors.map(e => `<li>${e}</li>`).join('');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        } else {
            validationSummary.classList.add('d-none');
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    };

    // Event listeners
    Object.values(inputs).forEach(input => {
        if (input && !input.readOnly) {
            input.addEventListener('input', updateUI);
            input.addEventListener('change', updateUI);
        }
    });

    // Preview filename untuk berita_acara
    inputs.beritaAcara?.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            
            // Update preview sidebar
            if (views.beritaAcaraWrapper && views.beritaAcaraName) {
                views.beritaAcaraName.textContent = `${fileName} (${fileSize} MB)`;
                views.beritaAcaraWrapper.style.display = 'block';
                views.beritaAcaraStatus.innerHTML = '<i class="fas fa-upload text-warning" title="Akan diupload"></i>';
            }

            // Hide existing file preview if user selects new file
            const existingPreview = document.getElementById('existing_file_preview');
            const keepInput = document.getElementById('keep_existing_file');
            if (existingPreview && keepInput) {
                existingPreview.style.display = 'none';
                keepInput.value = '0'; // Mark to not keep existing file
            }
        } else {
            // Reset if file input cleared
            if (views.beritaAcaraWrapper && hasExistingFile) {
                views.beritaAcaraName.textContent = originalValues.beritaAcara;
                views.beritaAcaraStatus.innerHTML = '<i class="fas fa-check-circle text-success" title="File tersimpan"></i>';
            } else if (views.beritaAcaraWrapper) {
                views.beritaAcaraWrapper.style.display = 'none';
            }

            // Show existing file preview again if no new file selected
            const existingPreview = document.getElementById('existing_file_preview');
            const keepInput = document.getElementById('keep_existing_file');
            if (existingPreview && keepInput && hasExistingFile) {
                existingPreview.style.display = 'block';
                keepInput.value = '1';
            }
        }
        updateUI();
    });

    // Handle remove existing file button
    const removeFileBtn = document.getElementById('remove_file_btn');
    const existingPreview = document.getElementById('existing_file_preview');
    const keepInput = document.getElementById('keep_existing_file');
    
    if (removeFileBtn && existingPreview && keepInput) {
        removeFileBtn.addEventListener('click', function() {
            // Hide preview
            existingPreview.style.display = 'none';
            keepInput.value = '0';
            
            // Update sidebar preview
            if (views.beritaAcaraWrapper) {
                views.beritaAcaraWrapper.style.display = 'none';
            }
            
            // Reset file input
            if (inputs.beritaAcara) {
                inputs.beritaAcara.value = '';
            }
        });
    }

    // Form submit validation - IMPROVED
    document.getElementById('wasteForm')?.addEventListener('submit', function(e) {
        console.log('🔄 Form submit triggered');
        
        // Run UI update for visual feedback
        updateUI();
        
        // Check if button is disabled due to JS validation
        if (submitBtn.disabled) {
            // Look for visible error indicators (not just class presence)
            const visibleErrors = document.querySelectorAll('.is-invalid-custom');
            const hasVisibleError = Array.from(visibleErrors).some(el => {
                const feedback = el.nextElementSibling;
                return feedback && 
                    feedback.classList.contains('invalid-feedback-custom') && 
                    feedback.style.display !== 'none';
            });
            
            if (hasVisibleError) {
                // Real validation error - block submit and scroll to error
                console.log('❌ Blocking submit: visible validation errors found');
                e.preventDefault();
                const firstError = document.querySelector('.is-invalid-custom');
                firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                // No visible errors but button disabled - likely JS false positive
                // Allow submit to proceed so Laravel can validate properly
                console.log('✅ Allowing submit: button disabled but no visible errors (letting server validate)');
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.style.opacity = '0.8';
                // Don't preventDefault - let form submit to server
            }
        } else {
            console.log('✅ Submit allowed: button enabled');
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.style.opacity = '0.8';
        }
    });

    // Initial run
    updateUI();
});
</script>
@endpush
@endsection