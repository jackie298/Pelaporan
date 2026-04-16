@extends('layouts.user_type.auth')

@section('content')
<style>
    /* ===== MODERN SOFT UI - CREATE FORM MASUK ===== */
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
    .alert-soft-success { background: rgba(23, 173, 55, 0.1); color: #344767; }

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
                    <i class="fas fa-plus-circle me-2"></i>Tambah Limbah B3 Masuk
                </h4>
                <p class="text-white text-xs opacity-8 mb-0">
                    Catat data limbah B3 yang masuk ke Tempat Penyimpanan Sementara (TPS).
                </p>
            </div>
        </div>
    </div>

    <div class="row px-3 mt-n4">
        <!-- Form Section -->
        <div class="col-lg-8 mb-4">
            <div class="card form-card p-4">
                <form action="{{ route('waste-b3.store') }}" method="POST" id="wasteForm" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        {{-- SECTION: Identitas Limbah --}}
                        <div class="col-12 mb-2">
                            <div class="section-divider"><span><i class="fas fa-cube me-1"></i>Identitas Limbah</span></div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-tag me-1"></i>Jenis Limbah B3</label>
                            <div class="input-group-custom">
                                <input type="text" name="jenis_limbah" id="jenis_limbah" class="form-control" 
                                       placeholder="Contoh: Oli Bekas, Baterai, Cat..." 
                                       value="{{ old('jenis_limbah') }}" maxlength="100" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-barcode me-1"></i>Kode Limbah</label>
                            <div class="input-group-custom">
                                <input type="text" name="kode_limbah" id="kode_limbah" class="form-control" 
                                       placeholder="Contoh: B3-OLI-001" 
                                       value="{{ old('kode_limbah') }}" maxlength="50" required>
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
                                       value="{{ old('sumber_limbah') }}" maxlength="100" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-file-alt me-1"></i>Nomor Manifest</label>
                            <div class="input-group-custom">
                                <input type="text" name="nomor_manifest" id="nomor_manifest" class="form-control" 
                                       placeholder="Contoh: MNF-B3-2024-001" 
                                       value="{{ old('nomor_manifest') }}" maxlength="100">
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
                                       value="{{ old('tanggal_masuk', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom"><i class="fas fa-weight-hanging me-1"></i>Jumlah (Ton)</label>
                            <div class="input-group-custom" id="jumlah_group">
                                <input type="number" step="any" name="jumlah_ton" id="jumlah_ton" class="form-control" 
                                       placeholder="0.000" value="{{ old('jumlah_ton') }}" required>
                            </div>
                            <div id="jumlah-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Minimal 0.001 ton
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label-custom"><i class="fas fa-hourglass-end me-1"></i>Batas Penyimpanan</label>
                            <div class="input-group-custom" id="batas_group">
                                <input type="date" name="maksimal_penyimpanan" id="maksimal_penyimpanan" class="form-control" 
                                       min="{{ date('Y-m-d') }}" value="{{ old('maksimal_penyimpanan') }}" required>
                            </div>
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
                        </div>

                        {{-- SECTION: Catatan --}}
                        <div class="col-12 mb-2">
                            <div class="section-divider"><span><i class="fas fa-sticky-note me-1"></i>Catatan</span></div>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label-custom"><i class="fas fa-comment-alt me-1"></i>Catatan Tambahan</label>
                            <div class="input-group-custom">
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Informasi tambahan...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Info Status -->
                    <div class="alert-soft alert-soft-info mb-4 d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <p class="text-xs mb-0">
                            <strong>Status Awal:</strong> Data baru akan otomatis berstatus 
                            <span class="status-badge-preview"><i class="fas fa-circle"></i>Belum Dikeluarkan</span>.
                            Status akan berubah otomatis saat ada pengeluaran limbah.
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('waste-b3') }}" class="btn btn-outline-soft mb-0">
                            <i class="fas fa-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" id="submitBtn" class="btn btn-gradient-primary btn-round mb-0">
                            <i class="fas fa-save me-2"></i>Simpan Data
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
                    <p class="text-xxs font-weight-bolder text-muted mb-3 text-uppercase ls-1">Ringkasan Data</p>
                    
                    <div class="preview-item">
                        <span class="preview-label d-block">Jenis Limbah</span>
                        <span id="view_jenis" class="preview-value d-block">--</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label d-block">Kode Limbah</span>
                        <span id="view_kode" class="preview-value text-primary d-block">--</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="preview-label d-block">Sumber</span>
                        <span id="view_sumber" class="preview-value d-block">--</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Tanggal Masuk</span>
                        <span id="view_tgl_masuk" class="preview-value">--</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Volume</span>
                        <span id="view_jumlah" class="preview-value text-danger">--</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="preview-label">Batas Simpan</span>
                        <span id="view_batas" class="preview-value">--</span>
                    </div>

                    <div class="preview-item">
                        <span class="preview-label d-block">Status</span>
                        <span class="status-badge-preview mt-1"><i class="fas fa-circle"></i>Belum Dikeluarkan</span>
                    </div>

                    {{-- Preview Berita Acara --}}
                    <div class="preview-item" id="preview_berita_acara_wrapper" style="display: none;">
                        <span class="preview-label d-block">Berita Acara</span>
                        <span id="view_berita_acara" class="preview-value d-block text-truncate" style="max-width: 100%;">
                            <i class="fas fa-paperclip me-1"></i><span id="view_berita_acara_name"></span>
                        </span>
                    </div>
                </div>
                
                <!-- Validation Summary -->
                <div id="validation_summary" class="alert-soft alert-soft-warning mt-4 p-3 d-none">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span class="text-xs font-weight-bold">Periksa Kembali:</span>
                    <ul class="text-xxs mb-0 mt-1 ps-3" id="validation_list"></ul>
                </div>

                <!-- Info Box -->
                <div class="alert-soft alert-soft-success mt-4 p-3 d-flex align-items-start">
                    <i class="fas fa-shield-alt mt-1 me-2"></i>
                    <p class="text-xs mb-0">
                        <strong class="d-block">Data Valid</strong>
                        Semua field wajib telah diisi dengan benar. Data siap disimpan.
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
        catatan: document.querySelector('textarea[name="catatan"]'),
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
        beritaAcaraName: document.getElementById('view_berita_acara_name')
    };

    const submitBtn = document.getElementById('submitBtn');
    const jumlahGroup = document.getElementById('jumlah_group');
    const jumlahError = document.getElementById('jumlah-error');
    const batasGroup = document.getElementById('batas_group');
    const validationSummary = document.getElementById('validation_summary');
    const validationList = document.getElementById('validation_list');
    const successAlert = document.querySelector('.alert-soft-success');

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

    // Auto-set batas penyimpanan = tanggal masuk + 6 bulan
    if (inputs.tglMasuk && inputs.batas && !inputs.batas.value) {
        const tgl = new Date(inputs.tglMasuk.value);
        tgl.setMonth(tgl.getMonth() + 6);
        inputs.batas.value = tgl.toISOString().split('T')[0];
    }

    // Real-time Preview & Validation
    const updateUI = () => {
        const errors = [];

        // Update Preview
        views.jenis.textContent = inputs.jenis?.value || '--';
        views.kode.textContent = inputs.kode?.value || '--';
        views.sumber.textContent = inputs.sumber?.value || '--';
        views.tglMasuk.textContent = formatDate(inputs.tglMasuk?.value);
        views.jumlah.textContent = formatNumber(inputs.jumlah?.value);
        views.batas.textContent = formatDate(inputs.batas?.value);

        // Validasi: Jumlah
        if (inputs.jumlah?.value) {
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
                errors.push('Batas penyimpanan harus setelah tanggal masuk');
            } else {
                batasGroup.classList.remove('is-invalid-custom');
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

        // Validasi: Field wajib
        ['jenis', 'kode', 'sumber', 'tglMasuk', 'jumlah', 'batas'].forEach(field => {
            if (!inputs[field]?.value) {
                errors.push(`${inputs[field]?.previousElementSibling?.textContent?.trim() || field} wajib diisi`);
            }
        });

        // Update validation summary
        if (errors.length > 0) {
            validationSummary.classList.remove('d-none');
            successAlert?.classList.add('d-none');
            validationList.innerHTML = errors.map(e => `<li>${e}</li>`).join('');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        } else {
            validationSummary.classList.add('d-none');
            successAlert?.classList.remove('d-none');
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    };

    // Event listeners
    Object.values(inputs).forEach(input => {
        input?.addEventListener('input', updateUI);
        input?.addEventListener('change', updateUI);
    });

    // Preview filename untuk berita_acara
    inputs.beritaAcara?.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
            
            // Update preview
            if (views.beritaAcaraWrapper && views.beritaAcaraName) {
                views.beritaAcaraName.textContent = `${fileName} (${fileSize} MB)`;
                views.beritaAcaraWrapper.style.display = 'block';
            }
        } else {
            // Reset jika file dihapus
            if (views.beritaAcaraWrapper) {
                views.beritaAcaraWrapper.style.display = 'none';
            }
        }
        updateUI(); // Trigger validation update
    });

    // Auto-update batas when tanggal_masuk changes
    inputs.tglMasuk?.addEventListener('change', function() {
        if (this.value && !inputs.batas?.value) {
            const tgl = new Date(this.value);
            tgl.setMonth(tgl.getMonth() + 6);
            inputs.batas.value = tgl.toISOString().split('T')[0];
            updateUI();
        }
    });

    // Form submit validation
    document.getElementById('wasteForm')?.addEventListener('submit', function(e) {
        updateUI();
        if (submitBtn.disabled) {
            e.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.is-invalid-custom');
            firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Initial run
    updateUI();
});
</script>
@endpush
@endsection