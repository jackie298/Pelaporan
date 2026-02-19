@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Data Limbah B3 Keluar</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Data Limbah B3 Keluar</h5>
                    <p class="text-sm text-muted mb-0">
                        <i class="fas fa-info-circle"></i> 
                        Data pengeluaran limbah B3 dari Tempat Penyimpanan Sementara (TPS)
                    </p>
                </div>
                <div class="card-body">
                    <form action="{{ route('waste-b3-keluar.store') }}" method="POST" id="wasteForm" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- INFORMASI PENTING --}}
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-info-circle me-2"></i>Petunjuk Pengisian:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Isi semua field yang bertanda <span class="text-danger">*</span> (wajib)</li>
                                <li>Pilih limbah B3 yang akan dikeluarkan dari TPS</li>
                                <li>Jumlah keluar tidak boleh melebihi sisa limbah yang tersedia</li>
                                <li>Upload dokumen manifest (PDF/JPG/PNG, max 5MB)</li>
                            </ul>
                        </div>

                        {{-- SECTION 1: DATA LIMBAH MASUK --}}
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                            <i class="fas fa-cube me-2"></i>Data Limbah B3 Masuk
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12 mb-3">
                                @if($limbahMasuk)
                                    {{-- MODE: LIMBAH SUDAH DIPILIH DARI TOMBOL "KELUARKAN" --}}
                                    <div class="alert alert-success">
                                        <h6 class="alert-heading mb-2">
                                            <i class="fas fa-check-circle"></i> Limbah B3 Terpilih
                                        </h6>
                                        <p class="mb-1"><strong>Jenis Limbah:</strong> {{ $limbahMasuk->jenis_limbah }}</p>
                                        <p class="mb-1"><strong>Kode Limbah:</strong> {{ $limbahMasuk->kode_limbah }}</p>
                                        <p class="mb-1"><strong>Sumber:</strong> {{ $limbahMasuk->sumber_limbah }}</p>
                                        <p class="mb-1"><strong>Tanggal Masuk:</strong> {{ $limbahMasuk->tanggal_masuk_formatted }}</p>
                                        <p class="mb-0">
                                            <strong>Sisa Limbah Tersedia:</strong> 
                                            <span class="badge badge-sm bg-gradient-warning">
                                                {{ $limbahMasuk->sisa_limbah_formatted }}
                                            </span>
                                        </p>
                                    </div>
                                    <input type="hidden" name="waste_b3_masuk_id" value="{{ $limbahMasuk->id }}">
                                @else
                                    {{-- MODE: PILIH LIMBAH DARI DROPDOWN --}}
                                    <label class="form-label">Pilih Limbah B3 Masuk <span class="text-danger">*</span></label>
                                    <select name="waste_b3_masuk_id" 
                                            id="waste_b3_masuk_id" 
                                            class="form-control @error('waste_b3_masuk_id') is-invalid @enderror"
                                            required>
                                        <option value="">-- Pilih Limbah B3 Masuk --</option>
                                        @foreach($limbahMasukOptions as $limbah)
                                            <option value="{{ $limbah->id }}" 
                                                    data-sisa="{{ $limbah->jumlah_tersisa_ton }}"
                                                    {{ old('waste_b3_masuk_id') == $limbah->id ? 'selected' : '' }}>
                                                {{ $limbah->jenis_limbah }} ({{ $limbah->kode_limbah }})
                                                - Sisa: {{ number_format($limbah->jumlah_tersisa_ton, 2, ',', '.') }} ton
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('waste_b3_masuk_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Pilih limbah B3 yang akan dikeluarkan dari TPS
                                    </small>
                                @endif
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        {{-- SECTION 2: DATA PENGELUARAN --}}
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-primary">
                            <i class="fas fa-truck me-2"></i>Data Pengeluaran
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="tanggal_keluar" 
                                       value="{{ old('tanggal_keluar', date('Y-m-d')) }}" 
                                       class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Tanggal limbah dikeluarkan dari TPS</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Keluar (Ton) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.01" 
                                       name="jumlah_keluar_ton" 
                                       id="jumlah_keluar_ton"
                                       value="{{ old('jumlah_keluar_ton') }}" 
                                       class="form-control @error('jumlah_keluar_ton') is-invalid @enderror"
                                       placeholder="0.00"
                                       min="0.01"
                                       required>
                                @error('jumlah_keluar_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted" id="maxInfo">
                                    @if($limbahMasuk)
                                        Maksimal: <span class="text-danger" id="maxValue">{{ $limbahMasuk->sisa_limbah }}</span> ton
                                    @else
                                        Pilih limbah terlebih dahulu untuk melihat maksimal
                                    @endif
                                </small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tujuan Penyerahan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="tujuan_penyerahan" 
                                       value="{{ old('tujuan_penyerahan') }}" 
                                       class="form-control @error('tujuan_penyerahan') is-invalid @enderror"
                                       placeholder="Contoh: PT. Pengolah B3, CV. Limbah Aman"
                                       maxlength="200"
                                       required>
                                @error('tujuan_penyerahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Perusahaan/instansi tujuan penyerahan</small>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        {{-- SECTION 3: DOKUMEN --}}
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-warning">
                            <i class="fas fa-file-alt me-2"></i>Dokumen Manifest
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Dokumen/Manifest <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="nomor_dokumen_keluar" 
                                       value="{{ old('nomor_dokumen_keluar') }}" 
                                       class="form-control @error('nomor_dokumen_keluar') is-invalid @enderror"
                                       placeholder="Contoh: MNF-B3-KELUAR-001"
                                       maxlength="100"
                                       required>
                                @error('nomor_dokumen_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Nomor dokumen manifest pengeluaran</small>
                            </div>
                            <div class="col-md-6 mb-3">                                
                                <input type="file" 
                                       name="file_dokumen" 
                                       class="form-control @error('file_dokumen') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       >
                                @error('file_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Format: PDF, JPG, JPEG, PNG | Max: 5MB
                                </small>
                                @if(old('file_dokumen'))
                                    <small class="form-text text-success">
                                        <i class="fas fa-check"></i> File terpilih: {{ old('file_dokumen') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        {{-- SECTION 4: CATATAN --}}
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-secondary">
                            <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                        </h6>
                        <div class="row g-3">
                            <div class="col-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan" 
                                          class="form-control @error('catatan') is-invalid @enderror" 
                                          rows="3"
                                          placeholder="Catatan tambahan atau keterangan lainnya...">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Informasi tambahan (opsional)</small>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-4">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Setelah disimpan, jumlah limbah tersisa di TPS akan berkurang otomatis</li>
                                <li>Status limbah masuk akan berubah sesuai sisa limbah</li>
                                <li>Dokumen manifest wajib diupload untuk kelengkapan administrasi</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('waste-b3-keluar') }}" class="btn btn-light me-2">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i>Simpan Data
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
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>Validasi Gagal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger p-3">
                    <p class="fw-bold mb-2">Mohon perbaiki kesalahan berikut:</p>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ✅ SET MAX VALUE UNTUK INPUT JUMLAH KELUAR (JIKA LIMBAH SUDAH DIPILIH)
    @if($limbahMasuk)
        const jumlahKeluarInput = document.getElementById('jumlah_keluar_ton');
        const maxValueSpan = document.getElementById('maxValue');
        
        if (jumlahKeluarInput && maxValueSpan) {
            const maxVal = parseFloat(maxValueSpan.textContent);
            jumlahKeluarInput.setAttribute('max', maxVal);
            
            // ✅ VALIDASI REAL-TIME
            jumlahKeluarInput.addEventListener('input', function() {
                const currentVal = parseFloat(this.value);
                if (currentVal > maxVal) {
                    this.value = maxVal;
                    alert('⚠️ Jumlah keluar tidak boleh melebihi sisa limbah (' + maxVal + ' ton)');
                }
            });
        }
    @endif

    // ✅ VALIDASI SAAT SUBMIT
    const wasteForm = document.getElementById('wasteForm');
    if (wasteForm) {
        wasteForm.addEventListener('submit', function(e) {
            @if($limbahMasuk)
                const jumlahKeluarInput = document.getElementById('jumlah_keluar_ton');
                const maxVal = parseFloat(document.getElementById('maxValue').textContent);
                const currentVal = parseFloat(jumlahKeluarInput.value);
                
                if (currentVal > maxVal) {
                    e.preventDefault();
                    alert('❌ Jumlah keluar tidak boleh melebihi sisa limbah (' + maxVal + ' ton)');
                    jumlahKeluarInput.focus();
                    return;
                }
                
                if (currentVal < 0.01) {
                    e.preventDefault();
                    alert('❌ Jumlah keluar minimal 0.01 ton');
                    jumlahKeluarInput.focus();
                    return;
                }
            @endif
            
            // ✅ VALIDASI FILE UPLOAD
            const fileInput = document.querySelector('input[name="file_dokumen"]');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (file.size > maxSize) {
                    e.preventDefault();
                    alert('❌ Ukuran file maksimal 5MB');
                    fileInput.focus();
                    return;
                }

                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    e.preventDefault();
                    alert('❌ Format file harus PDF, JPG, atau PNG');
                    fileInput.focus();
                    return;
                }
            }
        });
    }
});
</script>
@endpush

@push('css')
<style>
    .form-label {
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    
    .form-control[readonly] {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
        opacity: 1;
    }
    
    .text-danger {
        font-weight: bold;
    }
    
    .alert-info, .alert-warning, .alert-secondary {
        font-size: 0.875rem;
    }
    
    .badge.bg-gradient-info {
        background: linear-gradient(310deg, #2152ff, #21d4fd) !important;
    }
    
    .form-text.text-muted {
        font-size: 0.75rem;
    }
    
    .form-control:focus {
        border-color: #2152ff;
        box-shadow: 0 0 0 0.2rem rgba(33, 82, 255, 0.25);
    }
    
    .btn.bg-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(33, 82, 255, 0.3);
    }
    
    .alert-success {
        padding: 15px;
        border-radius: 8px;
    }
</style>
@endpush