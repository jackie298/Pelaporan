@extends('layouts.user_type.auth')

@section('content')
<style>
    .main-content-wrapper { padding: 1.5rem; animation: fadeIn 0.5s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .custom-header {
        background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
        border-radius: 1.25rem;
        padding: 2.5rem 2rem 5rem 2rem;
        margin-bottom: -4rem;
    }

    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
    }

    .form-label-custom {
        font-size: 0.75rem;
        font-weight: 700;
        color: #344767;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        display: block;
    }

    .input-group-custom {
        border-radius: 0.75rem;
        transition: all 0.2s;
        border: 1px solid #d2d6da;
        background: #fff;
        overflow: hidden;
    }

    .input-group-custom:focus-within {
        border-color: #cb0c9f;
        box-shadow: 0 0 0 2px rgba(203, 12, 159, 0.2);
    }

    .input-group-custom .form-control, 
    .input-group-custom .form-select {
        border: none;
        box-shadow: none;
        padding: 0.75rem;
        font-size: 0.875rem;
        background: transparent;
    }

    .preview-card {
        background: #f8f9fa;
        border-radius: 1rem;
        border: 1px solid #ebeef1;
        position: sticky;
        top: 20px;
    }

    /* Stock Info Box */
    .stock-info-box {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border: 1px solid rgba(121, 40, 202, 0.2);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        display: none; /* Hidden by default, shown via JS */
    }
    .stock-info-box.visible { display: block; }
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

    /* File Upload Styling */
    .file-upload-wrapper {
        border: 2px dashed #dee2e6;
        background: #fafafa;
        transition: all 0.3s;
        cursor: pointer;
        border-radius: 0.75rem;
    }
    .file-upload-wrapper:hover {
        border-color: #cb0c9f;
        background: #fdf2fb;
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
    }
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
        max-width: 180px;
    }
    .file-preview-meta {
        font-size: 0.65rem;
        color: #67748e;
    }

    /* Validasi State */
    .is-invalid-custom { border-color: #fd5c70 !important; background-color: rgba(253, 92, 112, 0.05); }
    .invalid-feedback-custom { color: #fd5c70; font-size: 0.75rem; margin-top: 4px; display: none; font-weight: 600; }
    .is-invalid-custom + .invalid-feedback-custom { display: block; }
    
    .btn-round { border-radius: 0.75rem; }
</style>

<div class="main-content-wrapper">
    <div class="custom-header">
        <div class="d-flex align-items-center">
            <a href="{{ route('waste-b3-keluar') }}" class="btn btn-link text-white p-0 me-3">
                <i class="fas fa-chevron-left"></i>
            </a>
            <div>
                <h4 class="text-white font-weight-bolder mb-0">Input Pengeluaran Limbah B3</h4>
                <p class="text-white text-xs opacity-8 mb-0">Catat mutasi limbah keluar dari TPS ke pihak ketiga</p>
            </div>
        </div>
    </div>

    <div class="row px-3 mt-n4">
        <div class="col-lg-8 mb-4">
            <div class="card form-card p-4">
                <form action="{{ route('waste-b3-keluar.store') }}" method="POST" enctype="multipart/form-data" id="wasteForm">
                    @csrf
                    
                    {{-- Tampilkan Error Validasi Global --}}
                    @if ($errors->any())
                        <div class="alert-soft alert-soft-warning mb-4" style="background: rgba(245, 57, 57, 0.1); border-radius: 1rem; padding: 1rem;">
                            <i class="fas fa-exclamation-circle me-2" style="color: #f53939;"></i>
                            <strong class="d-block mb-1" style="color: #344767;">Terjadi kesalahan validasi:</strong>
                            <ul class="text-xxs mb-0 ps-3" style="color: #67748e;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="row">
                        {{-- ✅ Dropdown Limbah (Standard Entry) --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label-custom">Pilih Limbah dari TPS (Jenis & Kode)</label>
                            <div class="input-group-custom">
                                <select name="waste_b3_masuk_id" id="waste_id" class="form-select @error('waste_b3_masuk_id') is-invalid @enderror" required>
                                    <option value="" data-sisa="0">-- Pilih Jenis Limbah --</option>
                                    @foreach($limbahMasukOptions as $opt)
                                        <option value="{{ $opt->id }}" 
                                            data-sisa="{{ $opt->jumlah_tersisa_ton }}" 
                                            data-kode="{{ $opt->kode_limbah }}"
                                            data-nama="{{ $opt->jenis_limbah }}"
                                            {{ (old('waste_b3_masuk_id') == $opt->id || request('masuk_id') == $opt->id) ? 'selected' : '' }}>
                                            [{{ $opt->kode_limbah }}] {{ $opt->jenis_limbah }} - (Sisa: {{ number_format($opt->jumlah_tersisa_ton, 3, ',', '.') }} Ton)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('waste_b3_masuk_id') <small class="text-danger text-xs ms-1">{{ $message }}</small> @enderror
                            
                            {{-- Stock Info Box (Dynamic) --}}
                            <div id="stock_info_box" class="stock-info-box">
                                <div class="stock-item">
                                    <span class="stock-label">Sisa Stok Tersedia</span>
                                    <span class="stock-value warning" id="stock_value">0,000 Ton</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Keluar --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Tanggal Keluar</label>
                            <div class="input-group-custom">
                                <input type="date" name="tanggal_keluar" id="tgl_keluar" class="form-control" 
                                       value="{{ old('tanggal_keluar', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        {{-- Jumlah Keluar --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Jumlah Keluar (Ton)</label>
                            <div class="input-group-custom" id="berat_group">
                                <input type="number" step="0.001" min="0.001" name="jumlah_keluar_ton" id="berat_keluar" 
                                       class="form-control" placeholder="0.000" value="{{ old('jumlah_keluar_ton') }}" required>
                            </div>
                            <div id="berat-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Jumlah melebihi stok tersedia!
                            </div>
                            <div id="berat-min-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Minimal 0.001 ton
                            </div>
                        </div>

                        {{-- Perusahaan Tujuan --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Nama Perusahaan Tujuan</label>
                            <div class="input-group-custom">
                                <input type="text" name="tujuan_penyerahan" id="tujuan" class="form-control" 
                                       placeholder="PT. Pengolah Limbah Aman" value="{{ old('tujuan_penyerahan') }}" maxlength="200" required>
                            </div>
                        </div>

                        {{-- Nomor Dokumen --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Nomor Dokumen / Manifest</label>
                            <div class="input-group-custom">
                                <input type="text" name="nomor_dokumen_keluar" id="no_dok" class="form-control" 
                                       placeholder="Contoh: MNF-2024-001" value="{{ old('nomor_dokumen_keluar') }}" maxlength="100" required>
                            </div>
                        </div>

                        {{-- SECTION: Dokumen --}}
                        <div class="col-12 mb-2">
                            <div style="display: flex; align-items: center; margin: 1rem 0; color: #67748e; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                <span style="padding: 0 1rem; color: #7928ca;"><i class="fas fa-file-signature me-1"></i>Dokumen</span>
                            </div>
                        </div>

                        {{-- Unggah Berita Acara --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label-custom">Berita Acara</label>
                            <div class="file-upload-wrapper border-radius-lg p-4 text-center">
                                <i class="fas fa-file-signature text-success mb-2 fa-2x"></i>
                                <input type="file" name="berita_acara" id="berita_acara" class="form-control d-none" accept=".pdf,.jpg,.jpeg,.png">
                                <p class="text-sm mb-1 text-dark font-weight-bold" id="ba_name_display">Klik untuk memilih file</p>
                                <label for="berita_acara" class="btn btn-xs bg-gradient-success mb-0">Pilih File</label>
                                <div class="mt-2 text-xxs text-muted">Format: PDF/JPG/PNG (Maks 10MB)</div>
                            </div>
                            @error('berita_acara')
                                <div class="invalid-feedback-custom d-block mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Preview File yang Dipilih --}}
                        <div class="col-md-12 mb-4" id="file_preview_section" style="display: none;">
                            <div class="file-preview-box">
                                <div class="file-preview-item" id="preview_berita_acara" style="display: none;">
                                    <div class="file-preview-icon"><i class="fas fa-file-signature"></i></div>
                                    <div class="file-preview-info">
                                        <div class="file-preview-name" id="preview_ba_name">-</div>
                                        <div class="file-preview-meta"><i class="fas fa-upload text-warning me-1"></i>Akan diupload</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label-custom">Catatan Tambahan</label>
                            <div class="input-group-custom">
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Informasi tambahan pengiriman..." maxlength="500">{{ old('catatan') }}</textarea>
                            </div>
                            <small class="text-xxs text-muted ps-1 mt-1 d-block">Opsional. Maksimal 500 karakter.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center pt-3 border-top">
                        <button type="button" class="btn btn-link text-secondary mb-0 me-3" onclick="window.history.back()">Batal</button>
                        <button type="submit" id="submitBtn" class="btn bg-gradient-dark btn-round px-5 mb-0">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Preview Sidebar --}}
        <div class="col-lg-4">
            <div class="card form-card p-4 preview-card shadow-none">
                <h6 class="font-weight-bolder mb-3"><i class="fas fa-eye me-2 text-primary"></i> Live Preview</h6>
                <div class="p-3 bg-white border-radius-lg shadow-sm border border-soft">
                    <p class="text-xxs font-weight-bolder text-muted mb-1 text-uppercase ls-1">Ringkasan Pengeluaran</p>
                    
                    {{-- Info Limbah --}}
                    <h5 id="view_jenis" class="mb-1 text-dark">--</h5>
                    <p id="view_kode" class="text-xs text-primary font-weight-bold mb-2">--</p>
                    
                    <p id="view_tujuan" class="text-xs text-secondary mb-3 font-weight-bold">Tujuan belum diisi</p>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-xs text-secondary font-weight-bold">Tanggal:</span>
                        <span id="view_tgl" class="text-xs font-weight-bolder text-dark">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-top pt-2">
                        <span class="text-xs text-secondary font-weight-bold">Berat Keluar:</span>
                        <span id="view_berat" class="text-xs font-weight-bolder text-danger">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-xs text-secondary font-weight-bold">Manifest ID:</span>
                        <span id="view_dok" class="text-xs font-weight-bolder text-dark">-</span>
                    </div>
                    
                    {{-- Preview File --}}
                    <div id="preview_files_wrapper" style="display: none; margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px dashed #e9ecef;">
                        <span class="text-xxs text-muted font-weight-bold d-block mb-1">Dokumen:</span>
                        <div id="preview_files_list" class="text-xxs"></div>
                    </div>
                </div>
                
                <div class="alert alert-info border-radius-lg mt-4 p-3 shadow-none border-0" style="background: rgba(17, 205, 239, 0.1);">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-shield-alt mt-1 me-2 text-info"></i>
                        <p class="text-xs text-info mb-0 font-weight-bold">Sistem akan otomatis mengurangi sisa saldo limbah di TPS setelah data disimpan.</p>
                    </div>
                </div>
                
                {{-- Validation Summary --}}
                <div id="validation_summary" class="alert-soft alert-soft-warning mt-4 p-3 d-none" style="background: rgba(245, 57, 57, 0.1); border-radius: 1rem;">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #f53939;"></i>
                    <span class="text-xs font-weight-bold" style="color: #344767;">Periksa Kembali:</span>
                    <ul class="text-xxs mb-0 mt-1 ps-3" id="validation_list" style="color: #67748e;"></ul>
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
    const beratMinError = document.getElementById('berat-min-error');
    const beratGroup = document.getElementById('berat_group');
    const stockInfoBox = document.getElementById('stock_info_box');
    const stockValue = document.getElementById('stock_value');
    
    // File inputs
    const fileBAInput = document.getElementById('berita_acara');
    const filePreviewSection = document.getElementById('file_preview_section');
    
    // Preview elements
    const views = {
        jenis: document.getElementById('view_jenis'),
        kode: document.getElementById('view_kode'),
        tujuan: document.getElementById('view_tujuan'),
        tgl: document.getElementById('view_tgl'),
        berat: document.getElementById('view_berat'),
        dok: document.getElementById('view_dok'),
        filesWrapper: document.getElementById('preview_files_wrapper'),
        filesList: document.getElementById('preview_files_list')
    };

    const inputs = {
        tujuan: document.getElementById('tujuan'),
        tgl: document.getElementById('tgl_keluar'),
        no_dok: document.getElementById('no_dok')
    };

    // Helper: Format number with 3 decimals (Indonesian locale)
    const formatNumber = (num) => {
        if (!num && num !== 0) return '--';
        return parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 3, maximumFractionDigits: 3 });
    };

    // Helper: Format date to Indonesian format
    const formatDate = (dateStr) => {
        if (!dateStr) return '-';
        const [y, m, d] = dateStr.split('-');
        return `${d}/${m}/${y}`;
    };

    // File name display logic for Berita Acara
    const handleFileSelect = (input, displayName, previewId, previewNameId) => {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            
            // Update display name
            displayName.textContent = `${fileName} (${fileSize} MB)`;
            
            // Update preview box
            document.getElementById(previewId).style.display = 'flex';
            document.getElementById(previewNameId).textContent = `${fileName} (${fileSize} MB)`;
            filePreviewSection.style.display = 'block';
            
            // Update sidebar preview
            updateFilesPreview();
        }
    };

    fileBAInput.addEventListener('change', function() {
        handleFileSelect(this, document.getElementById('ba_name_display'), 'preview_berita_acara', 'preview_ba_name');
    });

    // Update files preview in sidebar
    const updateFilesPreview = () => {
        const files = [];
        
        if (fileBAInput.files[0]) {
            const f = fileBAInput.files[0];
            files.push(`<div><i class="fas fa-file-signature me-1 text-success"></i>Berita Acara: ${f.name}</div>`);
        }
        
        if (files.length > 0) {
            views.filesWrapper.style.display = 'block';
            views.filesList.innerHTML = files.join('');
        } else {
            views.filesWrapper.style.display = 'none';
            views.filesList.innerHTML = '';
        }
    };

    // Real-time Validation & Preview
    const updateUI = () => {
        const errors = [];
        const selected = wasteSelect.options[wasteSelect.selectedIndex];
        const sisaStok = parseFloat(selected.dataset.sisa) || 0;
        const inputBerat = parseFloat(beratInput.value) || 0;

        // Update Preview Text
        if (wasteSelect.selectedIndex > 0) {
            views.jenis.textContent = selected.dataset.nama;
            views.kode.textContent = `[${selected.dataset.kode}]`;
            // Show stock info box
            stockInfoBox.classList.add('visible');
            stockValue.textContent = `${formatNumber(sisaStok)} Ton`;
        } else {
            views.jenis.textContent = '--';
            views.kode.textContent = '--';
            stockInfoBox.classList.remove('visible');
        }
        
        views.tujuan.textContent = inputs.tujuan.value || 'Tujuan belum diisi';
        views.tgl.textContent = formatDate(inputs.tgl.value);
        views.berat.textContent = inputBerat > 0 ? `${formatNumber(inputBerat)} Ton` : '-';
        views.dok.textContent = inputs.no_dok.value || '-';

        // Validation: Jumlah Keluar
        if (beratInput.value) {
            if (inputBerat < 0.001) {
                beratGroup.classList.add('is-invalid-custom');
                beratMinError.style.display = 'block';
                beratError.style.display = 'none';
                errors.push('Jumlah minimal 0.001 ton');
            } else if (inputBerat > sisaStok && sisaStok > 0) {
                beratGroup.classList.add('is-invalid-custom');
                beratError.style.display = 'block';
                beratMinError.style.display = 'none';
                errors.push(`Jumlah (${formatNumber(inputBerat)} Ton) melebihi stok tersedia (${formatNumber(sisaStok)} Ton)`);
            } else {
                beratGroup.classList.remove('is-invalid-custom');
                beratError.style.display = 'none';
                beratMinError.style.display = 'none';
            }
        }

        // Validation: Required fields
        const requiredFields = [
            { el: wasteSelect, msg: 'Limbah harus dipilih' },
            { el: inputs.tgl, msg: 'Tanggal keluar wajib diisi' },
            { el: beratInput, msg: 'Jumlah keluar wajib diisi' },
            { el: inputs.tujuan, msg: 'Tujuan penyerahan wajib diisi' },
            { el: inputs.no_dok, msg: 'Nomor dokumen wajib diisi' }
        ];

        requiredFields.forEach(({ el, msg }) => {
            if (!el || !el.value) {
                errors.push(msg);
            }
        });

        // Validation: File types
        const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (fileBAInput.files[0] && !validTypes.includes(fileBAInput.files[0].type)) {
            errors.push('Format berita acara harus PDF, JPG, atau PNG');
        }

        // Update validation summary
        const validationSummary = document.getElementById('validation_summary');
        const validationList = document.getElementById('validation_list');
        
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
    [wasteSelect, beratInput, inputs.tujuan, inputs.tgl, inputs.no_dok].forEach(el => {
        if (el) {
            el.addEventListener('input', updateUI);
            el.addEventListener('change', updateUI);
        }
    });

    // Form submit validation
    document.getElementById('wasteForm')?.addEventListener('submit', function(e) {
        updateUI();
        if (submitBtn.disabled) {
            e.preventDefault();
            const firstError = document.querySelector('.is-invalid-custom');
            firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.disabled = true;
        }
    });

    // Initial run
    updateUI();
    
    // ✅ Auto-trigger if pre-selected via URL parameter
    @if(request('masuk_id'))
        wasteSelect.dispatchEvent(new Event('change'));
    @endif
});
</script>
@endpush
@endsection