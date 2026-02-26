@extends('layouts.user_type.auth')

@section('content')
<style>
    /* ===== MODERN SOFT UI - CREATE FORM ===== */
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

    /* Info Box untuk Limbah Terpilih (Mode Auto-Select) */
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
    .file-upload-wrapper i {
        transition: transform 0.2s ease;
    }
    .file-upload-wrapper:hover i {
        transform: scale(1.1);
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
            <a href="{{ route('waste-b3-keluar') }}" class="btn btn-link text-white p-0 me-3 shadow-none" title="Kembali">
                <i class="fas fa-chevron-left fa-lg"></i>
            </a>
            <div>
                <h4 class="text-white font-weight-bolder mb-0">
                    <i class="fas fa-truck-loading me-2"></i>Input Pengeluaran Limbah B3
                </h4>
                <p class="text-white text-xs opacity-8 mb-0">
                    Catat mutasi limbah keluar dari TPS ke pihak ketiga pengolah.
                </p>
            </div>
        </div>
    </div>

    <div class="row px-3 mt-n4">
        <!-- Form Section -->
        <div class="col-lg-8 mb-4">
            <div class="card form-card p-4">
                <form action="{{ route('waste-b3-keluar.store') }}" method="POST" enctype="multipart/form-data" id="wasteForm">
                    @csrf
                    
                    <div class="row">
                        {{-- SECTION: Pilih Limbah --}}
                        <div class="col-12 mb-4">
                            <label class="form-label-custom">
                                <i class="fas fa-database me-1"></i>Pilih Limbah dari TPS
                            </label>
                            
                            @if(isset($limbahMasuk) && $limbahMasuk)
                                <!-- Mode: Auto-select dari halaman index -->
                                <div class="info-box">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div>
                                            <h6 class="mb-0 text-dark font-weight-bold">{{ $limbahMasuk->jenis_limbah }}</h6>
                                            <span class="text-xxs text-primary font-weight-bold">{{ $limbahMasuk->kode_limbah }}</span>
                                            <div class="mt-2 text-xxs text-secondary">
                                                <i class="far fa-calendar-alt me-1"></i>{{ $limbahMasuk->tanggal_masuk_formatted }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-map-pin me-1"></i>{{ $limbahMasuk->sumber_limbah }}
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-xxs text-secondary d-block mb-1">Stok Tersedia</span>
                                            <span class="badge bg-gradient-success" id="maxValue">
                                                {{ number_format($limbahMasuk->jumlah_tersisa_ton, 2) }}
                                            </span> <small class="text-xxs">Ton</small>
                                        </div>
                                    </div>
                                    <input type="hidden" name="waste_b3_masuk_id" value="{{ $limbahMasuk->id }}">
                                </div>
                            @else
                                <!-- Mode: Dropdown manual -->
                                <div class="input-group-custom">
                                    <select name="waste_b3_masuk_id" id="waste_id" class="form-select @error('waste_b3_masuk_id') is-invalid @enderror" required>
                                        <option value="" data-sisa="0" data-kode="" data-nama="">-- Pilih Jenis Limbah --</option>
                                        @foreach($limbahMasukOptions as $opt)
                                            @if($opt->jumlah_tersisa_ton > 0)
                                                <option value="{{ $opt->id }}" 
                                                        data-sisa="{{ $opt->jumlah_tersisa_ton }}" 
                                                        data-kode="{{ $opt->kode_limbah }}"
                                                        data-nama="{{ $opt->jenis_limbah }}"
                                                        {{ old('waste_b3_masuk_id') == $opt->id ? 'selected' : '' }}>
                                                    [{{ $opt->kode_limbah }}] {{ $opt->jenis_limbah }} • Sisa: {{ number_format($opt->jumlah_tersisa_ton, 2) }} Ton
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @error('waste_b3_masuk_id') 
                                    <small class="text-danger text-xs ms-1 mt-1 d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </small> 
                                @enderror
                            @endif
                        </div>

                        {{-- SECTION: Detail Transaksi --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="far fa-calendar me-1"></i>Tanggal Keluar</label>
                            <div class="input-group-custom">
                                <input type="date" name="tanggal_keluar" id="tgl_keluar" class="form-control" value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-weight-hanging me-1"></i>Jumlah Keluar (Ton)</label>
                            <div class="input-group-custom" id="berat_group">
                                <input type="number" step="0.01" min="0.01" name="jumlah_keluar_ton" id="berat_keluar" class="form-control" placeholder="0.00" value="{{ old('jumlah_keluar_ton') }}" required>
                            </div>
                            <div id="berat-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Jumlah melebihi stok tersedia!
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-building me-1"></i>Perusahaan Tujuan</label>
                            <div class="input-group-custom">
                                <input type="text" name="tujuan_penyerahan" id="tujuan" class="form-control" placeholder="PT. Pengolah Limbah Aman" value="{{ old('tujuan_penyerahan') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom"><i class="fas fa-file-contract me-1"></i>Nomor Manifest</label>
                            <div class="input-group-custom">
                                <input type="text" name="nomor_dokumen_keluar" id="no_dok" class="form-control" placeholder="MNF-2024-XXX" value="{{ old('nomor_dokumen_keluar') }}" required>
                            </div>
                        </div>

                        {{-- SECTION: Upload Dokumen --}}
                        <div class="col-12 mb-4">
                            <label class="form-label-custom"><i class="fas fa-cloud-upload-alt me-1"></i>Unggah File Manifest</label>
                            <div class="file-upload-wrapper text-center" id="drop_zone">
                                <input type="file" name="file_dokumen" id="file_dokumen" class="d-none" accept=".pdf,.jpg,.jpeg,.png">
                                <i class="fas fa-file-pdf text-primary mb-2 fa-2x"></i>
                                <p class="text-sm mb-1 text-dark font-weight-bold" id="file_name_display">Klik atau drag file ke sini</p>
                                <span class="text-xxs text-muted d-block mb-2">PDF/JPG/PNG • Maksimal 5MB</span>
                                <label for="file_dokumen" class="btn btn-sm btn-gradient-primary mb-0 cursor-pointer">
                                    <i class="fas fa-folder-open me-1"></i>Pilih File
                                </label>
                                <div id="file_error" class="text-danger text-xxs mt-2" style="display:none;">
                                    <i class="fas fa-exclamation-circle me-1"></i><span id="file_error_msg"></span>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: Catatan --}}
                        <div class="col-12 mb-4">
                            <label class="form-label-custom"><i class="fas fa-sticky-note me-1"></i>Catatan Tambahan</label>
                            <div class="input-group-custom">
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Informasi tambahan mengenai pengiriman...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button type="button" class="btn btn-link text-secondary mb-0 ps-0" onclick="window.history.back()">
                            <i class="fas fa-arrow-left me-1"></i>Batal
                        </button>
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
                    <p class="text-xxs font-weight-bolder text-muted mb-3 text-uppercase ls-1">Ringkasan Pengeluaran</p>
                    
                    <div class="preview-item">
                        <span class="text-xxs text-secondary d-block">Jenis Limbah</span>
                        <span id="view_jenis" class="text-sm font-weight-bold text-dark">-- Pilih limbah --</span>
                        <span id="view_kode" class="text-xxs text-primary d-block"></span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="text-xxs text-secondary d-block">Tujuan Penyerahan</span>
                        <span id="view_tujuan" class="text-sm font-weight-bold text-dark">-</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="text-xxs text-secondary">Tanggal Keluar</span>
                        <span id="view_tgl" class="text-sm font-weight-bold text-dark">-</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="text-xxs text-secondary">Volume Keluar</span>
                        <span id="view_berat" class="text-sm font-weight-bold text-danger">-</span>
                    </div>
                    
                    <div class="preview-item d-flex justify-content-between">
                        <span class="text-xxs text-secondary">No. Manifest</span>
                        <span id="view_dok" class="text-sm font-weight-bold text-dark">-</span>
                    </div>
                    
                    <div class="preview-item">
                        <span class="text-xxs text-secondary d-block">File Dokumen</span>
                        <span id="view_file" class="text-xxs text-success font-weight-bold">
                            <i class="fas fa-times-circle me-1"></i>Belum dipilih
                        </span>
                    </div>
                </div>
                
                <!-- Info Box -->
                <div class="alert alert-info border-radius-lg mt-4 p-3 shadow-none border-0 d-flex align-items-start" style="background: rgba(33, 82, 255, 0.1);">
                    <i class="fas fa-shield-alt mt-1 me-2 text-info"></i>
                    <p class="text-xs text-dark mb-0">
                        <strong class="d-block text-info">Auto Inventory Update</strong>
                        Sistem akan otomatis mengurangi stok limbah di TPS setelah data ini disimpan dan divalidasi.
                    </p>
                </div>

                <!-- Stok Warning -->
                <div id="stok_warning" class="alert alert-warning border-radius-lg mt-3 p-3 shadow-none border-0 d-none" style="background: rgba(245, 57, 57, 0.1);">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                    <span class="text-xs text-dark font-weight-bold">Stok Menipis!</span>
                    <p class="text-xxs text-dark mb-0 mt-1">Sisa stok setelah transaksi ini: <strong id="sisa_setelah" class="text-danger"></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const wasteSelect = document.getElementById('waste_id');
    const beratInput = document.getElementById('berat_keluar');
    const submitBtn = document.getElementById('submitBtn');
    const beratError = document.getElementById('berat-error');
    const beratGroup = document.getElementById('berat_group');
    const fileInput = document.getElementById('file_dokumen');
    const fileDisplay = document.getElementById('file_name_display');
    const fileError = document.getElementById('file_error');
    const fileErrorMsg = document.getElementById('file_error_msg');
    const dropZone = document.getElementById('drop_zone');
    const stokWarning = document.getElementById('stok_warning');
    const sisaSetelah = document.getElementById('sisa_setelah');

    // Preview elements
    const views = {
        jenis: document.getElementById('view_jenis'),
        kode: document.getElementById('view_kode'),
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

    // Helper: Format tanggal Indonesia
    const formatDate = (dateStr) => {
        if (!dateStr) return '-';
        const [y, m, d] = dateStr.split('-');
        return `${d}/${m}/${y}`;
    };

    // Helper: Format number dengan koma
    const formatNumber = (num) => {
        return parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    // File Upload: Display filename
    fileInput?.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            const file = this.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            // Validasi ukuran file
            if (file.size > maxSize) {
                fileError.style.display = 'block';
                fileErrorMsg.textContent = `Ukuran file "${file.name}" melebihi 5MB!`;
                fileInput.value = '';
                fileDisplay.textContent = 'Klik atau drag file ke sini';
                views.file.innerHTML = '<i class="fas fa-times-circle me-1"></i>Belum dipilih';
                return;
            }
            
            // Validasi tipe file
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                fileError.style.display = 'block';
                fileErrorMsg.textContent = 'Format file tidak didukung! Gunakan PDF/JPG/PNG.';
                fileInput.value = '';
                fileDisplay.textContent = 'Klik atau drag file ke sini';
                views.file.innerHTML = '<i class="fas fa-times-circle me-1"></i>Belum dipilih';
                return;
            }
            
            // Success
            fileError.style.display = 'none';
            fileDisplay.textContent = file.name;
            views.file.innerHTML = `<i class="fas fa-check-circle me-1"></i>${file.name.substring(0, 20)}${file.name.length > 20 ? '...' : ''}`;
        }
    });

    // Drag & Drop for file upload
    if (dropZone && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'));
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'));
        });
        
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
        
        dropZone.addEventListener('click', () => fileInput.click());
    }

    // Real-time Validation & Preview Update
    const updateUI = () => {
        let selected = { dataset: { sisa: 0, kode: '', nama: '' } };
        
        // Cek mode: auto-select atau dropdown
        const maxValueSpan = document.getElementById('maxValue');
        if (maxValueSpan) {
            // Mode auto-select: ambil dari info box
            selected.dataset.sisa = maxValueSpan.textContent.trim();
            selected.dataset.nama = document.querySelector('.info-box h6')?.textContent || '';
            selected.dataset.kode = document.querySelector('.info-box .text-primary')?.textContent || '';
        } else if (wasteSelect) {
            // Mode dropdown
            selected = wasteSelect.options[wasteSelect.selectedIndex] || { dataset: { sisa: 0, kode: '', nama: '' } };
        }

        const sisaStok = parseFloat(selected.dataset.sisa) || 0;
        const inputBerat = parseFloat(beratInput.value) || 0;
        const sisaBaru = sisaStok - inputBerat;

        // ===== UPDATE PREVIEW =====
        views.jenis.textContent = selected.dataset.nama || '-- Pilih limbah --';
        views.kode.textContent = selected.dataset.kode ? `[${selected.dataset.kode}]` : '';
        views.tujuan.textContent = inputs.tujuan?.value || '-';
        views.tgl.textContent = formatDate(inputs.tgl?.value);
        views.berat.textContent = inputBerat > 0 ? `${formatNumber(inputBerat)} Ton` : '-';
        views.dok.textContent = inputs.no_dok?.value || '-';

        // Update warning stok
        if (inputBerat > 0 && sisaStok > 0) {
            if (sisaBaru > 0) {
                stokWarning.classList.remove('d-none');
                sisaSetelah.textContent = `${formatNumber(sisaBaru)} Ton`;
                sisaSetelah.className = 'text-warning';
            } else if (sisaBaru === 0) {
                stokWarning.classList.remove('d-none');
                sisaSetelah.textContent = 'HABIS (0 Ton)';
                sisaSetelah.className = 'text-danger';
            }
        } else {
            stokWarning.classList.add('d-none');
        }

        // ===== VALIDASI BERAT =====
        if (inputBerat > sisaStok && sisaStok > 0) {
            beratGroup.classList.add('is-invalid-custom');
            beratError.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled');
            submitBtn.style.opacity = '0.6';
        } else if (inputBerat <= 0 && beratInput.value !== '') {
            beratGroup.classList.add('is-invalid-custom');
            submitBtn.disabled = true;
        } else {
            beratGroup.classList.remove('is-invalid-custom');
            beratError.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            submitBtn.style.opacity = '1';
        }
    };

    // Event listeners untuk real-time update
    const trackedInputs = [wasteSelect, beratInput, inputs.tujuan, inputs.tgl, inputs.no_dok].filter(el => el);
    trackedInputs.forEach(el => {
        el?.addEventListener('input', updateUI);
        el?.addEventListener('change', updateUI);
    });
    
    // Initial run
    updateUI();

    // Form submit: prevent if invalid
    document.getElementById('wasteForm')?.addEventListener('submit', function(e) {
        if (submitBtn.disabled) {
            e.preventDefault();
            // Scroll to error
            beratInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            beratInput?.focus();
        }
    });

    // Optional: Show success toast if redirected back with session
    @if(session('success'))
        // Bisa tambahkan toast notification di sini jika diperlukan
    @endif
});
</script>
@endpush
@endsection