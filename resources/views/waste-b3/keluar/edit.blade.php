@extends('layouts.user_type.auth')

@section('content')
<style>
    /* ===== MODERN SOFT UI - EDIT FORM (Consistent with Create) ===== */
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
    .input-group-custom .form-select,
    .input-group-custom textarea {
        border: none;
        box-shadow: none;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        background: transparent;
    }
    .input-group-custom textarea { resize: vertical; min-height: 80px; }
    .input-group-custom .form-control:read-only {
        background: #f8f9fa;
        color: #67748e;
        cursor: not-allowed;
    }

    /* Info Box untuk Limbah Terpilih */
    .info-box {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border: 1px solid rgba(121, 40, 202, 0.2);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
    }
    .info-box .badge {
        font-weight: 600;
        padding: 0.4em 0.8em;
        border-radius: 50px;
    }

    /* File Upload Styling */
    .file-upload-wrapper {
        border: 2px dashed #dee2e6;
        background: #fafafa;
        border-radius: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        padding: 1.5rem;
    }
    .file-upload-wrapper:hover,
    .file-upload-wrapper.dragover {
        border-color: #7928ca;
        background: linear-gradient(145deg, #fdf2fb, #fff);
    }
    .file-upload-wrapper i { transition: transform 0.2s ease; }
    .file-upload-wrapper:hover i { transform: scale(1.1); }
    .file-upload-wrapper .current-file {
        background: rgba(23, 173, 55, 0.1);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        margin-top: 0.75rem;
    }

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
    .preview-value { font-weight: 600; color: #344767; }
    
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
    .alert-soft-info i, .alert-soft-warning i { color: inherit; }

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
    .cursor-pointer { cursor: pointer; }
</style>

<div class="main-content-wrapper">
    <!-- Page Header -->
    <div class="custom-header">
        <div class="d-flex align-items-center">
            <a href="{{ route('waste-b3-keluar') }}" class="btn btn-link text-white p-0 me-3 shadow-none" title="Kembali">
                <i class="fas fa-chevron-left fa-lg"></i>
            </a>
            <div>
                <h4 class="text-white font-weight-bolder mb-0">
                    <i class="fas fa-pen-to-square me-2"></i>Edit Pengeluaran Limbah B3
                </h4>
                <p class="text-white text-xs opacity-8 mb-0">
                    Perbarui data mutasi limbah keluar #{{ $data->id }} dari TPS.
                </p>
            </div>
        </div>
    </div>

    <div class="row px-3 mt-n4">
        <!-- Form Section -->
        <div class="col-lg-8 mb-4">
            <div class="card form-card p-4">
                <form action="{{ route('waste-b3-keluar.update', $data->id) }}" method="POST" enctype="multipart/form-data" id="wasteForm">
                    @csrf
                    @method('PUT')
                    
                    {{-- Tampilkan Error Validasi Global --}}
                    @if ($errors->any())
                        <div class="alert-soft alert-soft-warning mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong class="d-block mb-1">Terjadi kesalahan validasi:</strong>
                            <ul class="text-xxs mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="row">
                        {{-- SECTION: Info Limbah Masuk (Read Only) --}}
                        <div class="col-12 mb-4">
                            <label class="form-label-custom">
                                <i class="fas fa-cube me-1"></i>Informasi Limbah Sumber
                            </label>
                            <div class="info-box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <h6 class="mb-0 text-dark font-weight-bold">{{ $data->limbahMasuk->jenis_limbah }}</h6>
                                        <span class="text-xxs text-primary font-weight-bold">{{ $data->limbahMasuk->kode_limbah }}</span>
                                        <div class="mt-2 text-xxs text-secondary">
                                            <i class="far fa-calendar-alt me-1"></i>{{ $data->limbahMasuk->tanggal_masuk_formatted }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-map-pin me-1"></i>{{ $data->limbahMasuk->sumber_limbah }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-xxs text-secondary d-block mb-1">Stok Saat Ini</span>
                                        <span class="badge bg-gradient-warning" id="currentStock">
                                            {{ number_format($data->limbahMasuk->sisa_limbah + $data->jumlah_keluar_ton, 3, ',', '.') }}
                                        </span> <small class="text-xxs">Ton</small>
                                        <div class="text-xxs text-muted mt-1">
                                            <small>(Termasuk {{ number_format($data->jumlah_keluar_ton, 3, ',', '.') }} ton dari record ini)</small>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="waste_b3_masuk_id" value="{{ $data->waste_b3_masuk_id }}">
                            </div>
                            
                            <!-- Warning Alert -->
                            <div class="alert-soft alert-soft-warning mt-3 d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                <p class="text-xs mb-0">
                                    <strong>Perhatian:</strong> Mengubah jumlah keluar akan mempengaruhi perhitungan stok limbah di TPS. 
                                    Pastikan data yang diinput sudah sesuai dengan dokumen fisik.
                                </p>
                            </div>
                        </div>

                        {{-- SECTION: Detail Transaksi --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="far fa-calendar me-1"></i>Tanggal Keluar</label>
                            <div class="input-group-custom">
                                <input type="date" name="tanggal_keluar" id="tgl_keluar" class="form-control" 
                                       value="{{ old('tanggal_keluar', $data->tanggal_keluar?->format('Y-m-d')) }}" 
                                       max="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-weight-hanging me-1"></i>Jumlah Keluar (Ton)</label>
                            <div class="input-group-custom" id="berat_group">
                                <input type="number" step="0.001" min="0.001" name="jumlah_keluar_ton" id="berat_keluar" 
                                       class="form-control" placeholder="0.000" 
                                       value="{{ old('jumlah_keluar_ton', $data->jumlah_keluar_ton) }}" required>
                            </div>
                            <div id="berat-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Jumlah melebihi batas maksimal!
                            </div>
                            <div id="berat-min-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Minimal 0.001 ton
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-building me-1"></i>Perusahaan Tujuan</label>
                            <div class="input-group-custom">
                                <input type="text" name="tujuan_penyerahan" id="tujuan" class="form-control" 
                                       placeholder="PT. Pengolah Limbah Aman" 
                                       value="{{ old('tujuan_penyerahan', $data->tujuan_penyerahan) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-file-contract me-1"></i>Nomor Manifest</label>
                            <div class="input-group-custom">
                                <input type="text" name="nomor_dokumen_keluar" id="no_dok" class="form-control" 
                                       placeholder="MNF-2024-XXX" 
                                       value="{{ old('nomor_dokumen_keluar', $data->nomor_dokumen_keluar) }}" required>
                            </div>
                        </div>

                        {{-- SECTION: Upload Berita Acara --}}
                        <div class="col-12 mb-4">
                            <label class="form-label-custom"><i class="fas fa-file-signature me-1"></i>Berita Acara</label>
                            <div class="file-upload-wrapper text-center" id="drop_zone">
                                <input type="file" name="berita_acara" id="berita_acara" class="d-none" accept=".pdf,.jpg,.jpeg,.png">
                                
                                @if($data->berita_acara)
                                    <!-- Show current file -->
                                    <div class="current-file text-start">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <i class="fas fa-file-{{ pathinfo($data->berita_acara, PATHINFO_EXTENSION) == 'pdf' ? 'pdf' : 'image' }} text-success me-2"></i>
                                                <span class="text-sm font-weight-bold text-dark">File Saat Ini:</span>
                                                <span class="text-xxs text-muted d-block">{{ $data->berita_acara }}</span>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <a href="{{ Storage::url('waste-b3/berita-acara-keluar/' . $data->berita_acara) }}" target="_blank" 
                                                   class="btn btn-xs bg-gradient-info text-white" title="Lihat File">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" id="remove_file_btn" 
                                                   class="btn btn-xs bg-gradient-danger text-white" title="Hapus File">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-xxs text-muted mt-3">Klik area ini atau tombol di bawah untuk <strong>mengganti</strong> file</p>
                                    <input type="hidden" name="keep_existing_file" id="keep_existing_file" value="1">
                                @else
                                    <i class="fas fa-file-upload text-primary mb-2 fa-2x"></i>
                                    <p class="text-sm mb-1 text-dark font-weight-bold" id="file_name_display">Klik atau drag file ke sini</p>
                                    <span class="text-xxs text-muted d-block mb-2">PDF/JPG/PNG • Maksimal 10MB</span>
                                @endif
                                
                                <label for="berita_acara" class="btn btn-sm btn-gradient-primary mb-0 cursor-pointer mt-2">
                                    <i class="fas fa-folder-open me-1"></i>{{ $data->berita_acara ? 'Ganti File' : 'Pilih File' }}
                                </label>
                                <div id="file_error" class="text-danger text-xxs mt-2" style="display:none;">
                                    <i class="fas fa-exclamation-circle me-1"></i><span id="file_error_msg"></span>
                                </div>
                            </div>
                            @error('berita_acara')
                                <div class="invalid-feedback-custom d-block mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- SECTION: Catatan --}}
                        <div class="col-12 mb-4">
                            <label class="form-label-custom"><i class="fas fa-sticky-note me-1"></i>Catatan Tambahan</label>
                            <div class="input-group-custom">
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Informasi tambahan mengenai pengiriman...">{{ old('catatan', $data->catatan) }}</textarea>
                            </div>
                            <small class="text-xxs text-muted ps-1 mt-1 d-block">Opsional. Maksimal 500 karakter.</small>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('waste-b3-keluar') }}" class="btn btn-outline-soft mb-0">
                            <i class="fas fa-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" id="submitBtn" class="btn btn-gradient-primary btn-round mb-0">
                            <i class="fas fa-save me-2"></i>Update Data
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
                        <span id="view_jenis" class="preview-value d-block">{{ $data->limbahMasuk->jenis_limbah }}</span>
                        <span id="view_kode" class="text-xxs text-primary d-block">[{{ $data->limbahMasuk->kode_limbah }}]</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label d-block">Tujuan Penyerahan</span>
                        <span id="view_tujuan" class="preview-value d-block">{{ $data->tujuan_penyerahan }}</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Tanggal Keluar</span>
                        <span id="view_tgl" class="preview-value">{{ \Carbon\Carbon::parse(old('tanggal_keluar', $data->tanggal_keluar))->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Volume Keluar</span>
                        <span id="view_berat" class="preview-value text-danger">{{ number_format(old('jumlah_keluar_ton', $data->jumlah_keluar_ton), 3, ',', '.') }} Ton</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">No. Manifest</span>
                        <span id="view_dok" class="preview-value">{{ $data->nomor_dokumen_keluar }}</span>
                    </div>
                    
                    {{-- Preview Berita Acara --}}
                    <div class="preview-item">
                        <span class="preview-label d-block">Berita Acara</span>
                        <span id="view_file" class="text-xxs {{ $data->berita_acara ? 'text-success' : 'text-muted' }} font-weight-bold">
                            <i class="fas {{ $data->berita_acara ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                            {{ $data->berita_acara ? 'Tersedia' : 'Belum diupload' }}
                        </span>
                    </div>
                </div>
                
                <!-- Stock Impact Warning -->
                <div id="stock_impact" class="alert-soft alert-soft-warning mt-4 p-3 d-none">
                    <i class="fas fa-scale-balanced me-2"></i>
                    <span class="text-xs font-weight-bold">Dampak pada Stok:</span>
                    <p class="text-xxs mb-0 mt-1">
                        Sisa stok setelah update: <strong id="new_stock_value" class="text-danger"></strong>
                        <br>
                        <small class="text-muted">Perubahan: <span id="stock_diff"></span></small>
                    </p>
                </div>

                <!-- Info Box -->
                <div class="alert-soft alert-soft-info mt-4 p-3 d-flex align-items-start">
                    <i class="fas fa-shield-alt mt-1 me-2"></i>
                    <p class="text-xs mb-0">
                        <strong class="d-block">Auto Inventory Sync</strong>
                        Perubahan data akan otomatis memperbarui stok limbah di TPS setelah disimpan.
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
    const beratInput = document.getElementById('berat_keluar');
    const submitBtn = document.getElementById('submitBtn');
    const beratError = document.getElementById('berat-error');
    const beratMinError = document.getElementById('berat-min-error');
    const beratGroup = document.getElementById('berat_group');
    const fileInput = document.getElementById('berita_acara');
    const fileDisplay = document.getElementById('file_name_display');
    const fileError = document.getElementById('file_error');
    const fileErrorMsg = document.getElementById('file_error_msg');
    const dropZone = document.getElementById('drop_zone');
    const stockImpact = document.getElementById('stock_impact');
    const newStockValue = document.getElementById('new_stock_value');
    const stockDiff = document.getElementById('stock_diff');
    const removeFileBtn = document.getElementById('remove_file_btn');
    const keepExistingInput = document.getElementById('keep_existing_file');

    // Preview elements
    const views = {
        tujuan: document.getElementById('view_tujuan'),
        tgl: document.getElementById('view_tgl'),
        berat: document.getElementById('view_berat'),
        dok: document.getElementById('view_dok'),
        file: document.getElementById('view_file')
    };

    const inputs = {
        tujuan: document.getElementById('tujuan'),
        tgl: document.getElementById('tgl_keluar'),
        no_dok: document.getElementById('no_dok')
    };

    // Constants from blade (3 decimals)
    const currentStock = parseFloat('{{ number_format($data->limbahMasuk->sisa_limbah + $data->jumlah_keluar_ton, 3, '.', '') }}') || 0;
    const originalWeight = parseFloat('{{ $data->jumlah_keluar_ton }}') || 0;
    const hasExistingFile = {{ $data->berita_acara ? 'true' : 'false' }};

    // Helper: Format tanggal Indonesia
    const formatDate = (dateStr) => {
        if (!dateStr) return '-';
        const [y, m, d] = dateStr.split('-');
        return `${d}/${m}/${y}`;
    };

    // Helper: Format number with 3 decimals (Indonesian locale)
    const formatNumber = (num) => {
        if (num === null || num === undefined || num === '') return '--';
        return parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 3, maximumFractionDigits: 3 });
    };

    // File Upload: Display filename & validation
    fileInput?.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB for berita_acara
            
            // Validasi ukuran
            if (file.size > maxSize) {
                fileError.style.display = 'block';
                fileErrorMsg.textContent = `Ukuran file "${file.name}" melebihi 10MB!`;
                fileInput.value = '';
                if (fileDisplay) fileDisplay.textContent = 'Klik atau drag file ke sini';
                views.file.innerHTML = '<i class="fas fa-times-circle me-1"></i>Belum dipilih';
                return;
            }
            
            // Validasi tipe
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                fileError.style.display = 'block';
                fileErrorMsg.textContent = 'Format file tidak didukung! Gunakan PDF/JPG/PNG.';
                fileInput.value = '';
                if (fileDisplay) fileDisplay.textContent = 'Klik atau drag file ke sini';
                views.file.innerHTML = '<i class="fas fa-times-circle me-1"></i>Belum dipilih';
                return;
            }
            
            // Success
            fileError.style.display = 'none';
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            if (fileDisplay) fileDisplay.textContent = `${file.name} (${fileSize} MB)`;
            views.file.innerHTML = `<i class="fas fa-check-circle me-1 text-success"></i>${file.name.substring(0, 20)}${file.name.length > 20 ? '...' : ''}`;
            
            // Hide existing file preview if user selects new file
            const existingPreview = document.querySelector('.current-file');
            if (existingPreview && keepExistingInput) {
                existingPreview.style.display = 'none';
                keepExistingInput.value = '0'; // Mark to not keep existing file
            }
        } else {
            // Reset if file input cleared
            if (fileDisplay && hasExistingFile) {
                fileDisplay.textContent = 'Klik atau drag file ke sini';
            }
            if (hasExistingFile) {
                views.file.innerHTML = '<i class="fas fa-check-circle me-1 text-success"></i>Tersedia';
            } else {
                views.file.innerHTML = '<i class="fas fa-times-circle me-1"></i>Belum diupload';
            }
            
            // Show existing file preview again if no new file selected
            const existingPreview = document.querySelector('.current-file');
            if (existingPreview && keepExistingInput && hasExistingFile) {
                existingPreview.style.display = 'block';
                keepExistingInput.value = '1';
            }
        }
        updateUI();
    });

    // Handle remove existing file button
    if (removeFileBtn && keepExistingInput) {
        removeFileBtn.addEventListener('click', function() {
            // Hide preview
            const existingPreview = document.querySelector('.current-file');
            if (existingPreview) {
                existingPreview.style.display = 'none';
            }
            keepExistingInput.value = '0';
            
            // Update sidebar preview
            views.file.innerHTML = '<i class="fas fa-times-circle me-1"></i>File akan dihapus';
            
            // Reset file input
            if (fileInput) {
                fileInput.value = '';
            }
            if (fileDisplay) {
                fileDisplay.textContent = 'Klik atau drag file ke sini';
            }
            
            updateUI();
        });
    }

    // Drag & Drop
    if (dropZone && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => { e.preventDefault(); e.stopPropagation(); });
        });
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'));
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'));
        });
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length) { fileInput.files = files; fileInput.dispatchEvent(new Event('change')); }
        });
        dropZone.addEventListener('click', () => fileInput.click());
    }

    // Real-time Validation & Preview Update
    const updateUI = () => {
        const inputBerat = parseFloat(beratInput?.value) || 0;
        const newStock = currentStock - inputBerat;
        const diff = inputBerat - originalWeight;

        // ===== UPDATE PREVIEW =====
        views.tujuan.textContent = inputs.tujuan?.value || '-';
        views.tgl.textContent = formatDate(inputs.tgl?.value);
        views.berat.textContent = inputBerat > 0 ? `${formatNumber(inputBerat)} Ton` : '-';
        views.dok.textContent = inputs.no_dok?.value || '-';

        // Stock impact calculation (3 decimals)
        if (inputBerat > 0) {
            stockImpact.classList.remove('d-none');
            newStockValue.textContent = `${formatNumber(Math.max(0, newStock))} Ton`;
            
            if (diff > 0.0001) {
                stockDiff.textContent = `+${formatNumber(diff)} ton dari sebelumnya`;
                stockDiff.className = 'text-danger';
            } else if (diff < -0.0001) {
                stockDiff.textContent = `-${formatNumber(Math.abs(diff))} ton dari sebelumnya`;
                stockDiff.className = 'text-success';
            } else {
                stockDiff.textContent = 'Tidak ada perubahan';
                stockDiff.className = 'text-muted';
            }
        } else {
            stockImpact.classList.add('d-none');
        }

        // ===== VALIDASI BERAT =====
        if (beratInput?.value) {
            if (inputBerat < 0.001) {
                beratGroup.classList.add('is-invalid-custom');
                beratMinError.style.display = 'block';
                beratError.style.display = 'none';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
            } else if (inputBerat > currentStock && currentStock > 0) {
                beratGroup.classList.add('is-invalid-custom');
                beratError.style.display = 'block';
                beratMinError.style.display = 'none';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
            } else {
                beratGroup.classList.remove('is-invalid-custom');
                beratError.style.display = 'none';
                beratMinError.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            }
        }
    };

    // Event listeners
    const trackedInputs = [beratInput, inputs.tujuan, inputs.tgl, inputs.no_dok].filter(el => el);
    trackedInputs.forEach(el => {
        el?.addEventListener('input', updateUI);
        el?.addEventListener('change', updateUI);
    });
    
    // Initial run
    updateUI();

    // Form submit validation
    document.getElementById('wasteForm')?.addEventListener('submit', function(e) {
        updateUI();
        if (submitBtn.disabled) {
            e.preventDefault();
            const firstError = document.querySelector('.is-invalid-custom');
            firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError?.querySelector('input')?.focus();
        } else {
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.disabled = true;
        }
    });
});
</script>
@endpush
@endsection