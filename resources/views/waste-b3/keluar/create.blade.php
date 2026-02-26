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

    /* File Upload Styling */
    .file-upload-wrapper {
        border: 2px dashed #dee2e6;
        background: #fafafa;
        transition: all 0.3s;
        cursor: pointer;
    }
    .file-upload-wrapper:hover {
        border-color: #cb0c9f;
        background: #fdf2fb;
    }

    /* Validasi State */
    .is-invalid-custom { border-color: #fd5c70 !important; }
    .invalid-feedback-custom { color: #fd5c70; font-size: 0.75rem; margin-top: 4px; display: none; font-weight: 600; }
    
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
                    
                    <div class="row">
                        {{-- Dropdown Limbah --}}
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
                                                {{ old('waste_b3_masuk_id') == $opt->id ? 'selected' : '' }}>
                                            [{{ $opt->kode_limbah }}] {{ $opt->jenis_limbah }} - (Sisa: {{ number_format($opt->jumlah_tersisa_ton, 2) }} Ton)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('waste_b3_masuk_id') <small class="text-danger text-xs ms-1">{{ $message }}</small> @enderror
                        </div>

                        {{-- Tanggal Keluar --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Tanggal Keluar</label>
                            <div class="input-group-custom">
                                <input type="date" name="tanggal_keluar" id="tgl_keluar" class="form-control" value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        {{-- Jumlah Keluar --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Jumlah Keluar (Ton)</label>
                            <div class="input-group-custom" id="berat_group">
                                <input type="number" step="0.01" name="jumlah_keluar_ton" id="berat_keluar" class="form-control" placeholder="0.00" value="{{ old('jumlah_keluar_ton') }}" required>
                            </div>
                            <div id="berat-error" class="invalid-feedback-custom ps-1">
                                <i class="fas fa-exclamation-circle me-1"></i> Jumlah melebihi stok tersedia!
                            </div>
                        </div>

                        {{-- Perusahaan Tujuan --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Nama Perusahaan Tujuan</label>
                            <div class="input-group-custom">
                                <input type="text" name="tujuan_penyerahan" id="tujuan" class="form-control" placeholder="PT. Pengolah Limbah Aman" value="{{ old('tujuan_penyerahan') }}" required>
                            </div>
                        </div>

                        {{-- Nomor Dokumen --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Nomor Dokumen / Manifest</label>
                            <div class="input-group-custom">
                                <input type="text" name="nomor_dokumen_keluar" id="no_dok" class="form-control" placeholder="Contoh: MNF-2024-001" value="{{ old('nomor_dokumen_keluar') }}" required>
                            </div>
                        </div>

                        {{-- Unggah File --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label-custom">Unggah File Manifest</label>
                            <div class="file-upload-wrapper border-radius-lg p-4 text-center">
                                <i class="fas fa-cloud-upload-alt text-primary mb-2 fa-2x"></i>
                                <input type="file" name="file_dokumen" id="file_dokumen" class="form-control d-none">
                                <p class="text-sm mb-1 text-dark font-weight-bold" id="file_name_display">Klik untuk memilih file</p>
                                <label for="file_dokumen" class="btn btn-xs bg-gradient-primary mb-0">Pilih File</label>
                                <div class="mt-2 text-xxs text-muted">Format: PDF/JPG/PNG (Maks 5MB)</div>
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="col-md-12 mb-4">
                            <label class="form-label-custom">Catatan Tambahan</label>
                            <div class="input-group-custom">
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Informasi tambahan pengiriman...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center">
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
                    <h5 id="view_jenis" class="mb-1 text-dark">--</h5>
                    <p id="view_tujuan" class="text-xs text-secondary mb-3 font-weight-bold">Tujuan belum diisi</p>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-xs text-secondary font-weight-bold">Tanggal:</span>
                        <span id="view_tgl" class="text-xs font-weight-bolder text-dark">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-top pt-2">
                        <span class="text-xs text-secondary font-weight-bold">Berat Keluar:</span>
                        <span id="view_berat" class="text-xs font-weight-bolder text-danger">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-xs text-secondary font-weight-bold">Manifest ID:</span>
                        <span id="view_dok" class="text-xs font-weight-bolder text-dark">-</span>
                    </div>
                </div>
                
                <div class="alert alert-info border-radius-lg mt-4 p-3 shadow-none border-0" style="background: rgba(17, 205, 239, 0.1);">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-shield-alt mt-1 me-2 text-info"></i>
                        <p class="text-xs text-info mb-0 font-weight-bold">Sistem akan otomatis mengurangi sisa saldo limbah di TPS setelah data disimpan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wasteSelect = document.getElementById('waste_id');
        const beratInput = document.getElementById('berat_keluar');
        const submitBtn = document.getElementById('submitBtn');
        const beratError = document.getElementById('berat-error');
        const beratGroup = document.getElementById('berat_group');
        const fileInput = document.getElementById('file_dokumen');
        const fileDisplay = document.getElementById('file_name_display');

        // Preview elements
        const views = {
            jenis: document.getElementById('view_jenis'),
            tujuan: document.getElementById('view_tujuan'),
            tgl: document.getElementById('view_tgl'),
            berat: document.getElementById('view_berat'),
            dok: document.getElementById('view_dok')
        };

        const inputs = {
            tujuan: document.getElementById('tujuan'),
            tgl: document.getElementById('tgl_keluar'),
            no_dok: document.getElementById('no_dok')
        };

        // File name display logic
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileDisplay.textContent = this.files[0].name;
            }
        });

        // Real-time Validation & Preview
        const updateUI = () => {
            const selected = wasteSelect.options[wasteSelect.selectedIndex];
            const sisaStok = parseFloat(selected.dataset.sisa) || 0;
            const inputBerat = parseFloat(beratInput.value) || 0;

            // Update Preview Text
            views.jenis.textContent = wasteSelect.selectedIndex > 0 ? selected.dataset.nama : '--';
            views.tujuan.textContent = inputs.tujuan.value || 'Tujuan belum diisi';
            views.tgl.textContent = inputs.tgl.value || '-';
            views.berat.textContent = inputBerat > 0 ? `${inputBerat} Ton` : '-';
            views.dok.textContent = inputs.no_dok.value || '-';

            // Validation logic
            if (inputBerat > sisaStok && sisaStok > 0) {
                beratGroup.classList.add('is-invalid-custom');
                beratError.style.display = 'block';
                submitBtn.disabled = true;
            } else {
                beratGroup.classList.remove('is-invalid-custom');
                beratError.style.display = 'none';
                submitBtn.disabled = false;
            }
        };

        // Event listeners
        [wasteSelect, beratInput, inputs.tujuan, inputs.tgl, inputs.no_dok].forEach(el => {
            el.addEventListener('input', updateUI);
        });
        
        // Initial run to clear preview
        updateUI();
    });
</script>
@endsection