@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Data Limbah B3 Keluar</strong> (ID: #{{ $data->id }})
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Data Limbah B3 Keluar</h5>
                    <p class="text-sm text-muted mb-0">
                        <i class="fas fa-info-circle"></i> 
                        Edit data pengeluaran limbah B3 dari Tempat Penyimpanan Sementara (TPS)
                    </p>
                </div>
                <div class="card-body">
                    <form action="{{ route('waste-b3-keluar.update', $data->id) }}" method="POST" id="wasteForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- INFORMASI PENTING --}}
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-info-circle me-2"></i>Petunjuk Pengisian:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Isi semua field yang bertanda <span class="text-danger">*</span> (wajib)</li>
                                <li>Upload file baru untuk mengganti dokumen lama</li>
                                <li>File lama akan dihapus otomatis jika upload file baru</li>
                            </ul>
                        </div>

                        {{-- SECTION 1: DATA LIMBAH MASUK --}}
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                            <i class="fas fa-cube me-2"></i>Data Limbah B3 Masuk
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12 mb-3">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading mb-2">
                                        <i class="fas fa-info-circle"></i> Informasi Limbah Masuk
                                    </h6>
                                    <p class="mb-1"><strong>Jenis Limbah:</strong> {{ $data->limbahMasuk->jenis_limbah }}</p>
                                    <p class="mb-1"><strong>Kode Limbah:</strong> {{ $data->limbahMasuk->kode_limbah }}</p>
                                    <p class="mb-1"><strong>Sumber:</strong> {{ $data->limbahMasuk->sumber_limbah }}</p>
                                    <p class="mb-1"><strong>Tanggal Masuk:</strong> {{ $data->limbahMasuk->tanggal_masuk_formatted }}</p>
                                    <p class="mb-0">
                                        <strong>Sisa Limbah Saat Ini:</strong> 
                                        <span class="badge badge-sm bg-gradient-warning">
                                            {{ number_format($data->limbahMasuk->sisa_limbah + $data->jumlah_keluar_ton, 2, ',', '.') }} ton
                                        </span>
                                        <br>
                                        <small class="text-muted">(Sisa setelah pengeluaran ini dihapus: {{ $data->limbahMasuk->sisa_limbah_formatted }})</small>
                                    </p>
                                </div>
                                <input type="hidden" name="waste_b3_masuk_id" value="{{ $data->waste_b3_masuk_id }}">
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
                                       value="{{ old('tanggal_keluar', $data->tanggal_keluar?->format('Y-m-d')) }}" 
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
                                       value="{{ old('jumlah_keluar_ton', $data->jumlah_keluar_ton) }}" 
                                       class="form-control @error('jumlah_keluar_ton') is-invalid @enderror"
                                       placeholder="0.00"
                                       min="0.01"
                                       required>
                                @error('jumlah_keluar_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted" id="maxInfo">
                                    Maksimal: <span class="text-danger" id="maxValue">{{ $data->limbahMasuk->sisa_limbah + $data->jumlah_keluar_ton }}</span> ton
                                    <br>
                                    <small class="text-muted">(Sisa saat ini: {{ $data->limbahMasuk->sisa_limbah }} ton)</small>
                                </small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tujuan Penyerahan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="tujuan_penyerahan" 
                                       value="{{ old('tujuan_penyerahan', $data->tujuan_penyerahan) }}" 
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
                                       value="{{ old('nomor_dokumen_keluar', $data->nomor_dokumen_keluar) }}" 
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
                                <label class="form-label">Upload Dokumen Manifest </label>
                                <input type="file" 
                                       name="file_dokumen" 
                                       class="form-control @error('file_dokumen') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                @error('file_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Format: PDF, JPG, JPEG, PNG | Max: 5MB
                                    <br>
                                    <small class="text-muted">(Kosongkan untuk tidak mengganti file)</small>
                                </small>
                                
                                {{-- Tampilkan file yang sudah ada --}}
                                @if($data->file_dokumen_exists)
                                    <div class="mt-2">
                                        <div class="alert alert-success p-2">
                                            <i class="fas fa-check-circle"></i> 
                                            <strong>File saat ini:</strong> 
                                            <a href="{{ route('waste-b3-keluar.preview', $data->id) }}" 
                                               target="_blank" 
                                               class="text-white">
                                                {{ basename($data->file_dokumen) }}
                                            </a>
                                            <br>
                                            <small>
                                                <a href="{{ route('waste-b3-keluar.download', $data->id) }}" 
                                                   class="text-white">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                |
                                                <a href="{{ route('waste-b3-keluar.preview', $data->id) }}" 
                                                   target="_blank" 
                                                   class="text-white">
                                                    <i class="fas fa-eye"></i> Preview
                                                </a>
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-2 alert alert-warning p-2">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        Belum ada file yang diupload
                                    </div>
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
                                          placeholder="Catatan tambahan atau keterangan lainnya...">{{ old('catatan', $data->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Informasi tambahan (opsional)</small>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-4">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Mengubah jumlah keluar akan mempengaruhi stok limbah di TPS</li>
                                <li>Upload file baru akan mengganti file lama secara otomatis</li>
                                <li>Data yang diubah akan langsung tersimpan ke database</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('waste-b3-keluar') }}" class="btn btn-light me-2">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i>Update Data
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
    // ✅ SET MAX VALUE UNTUK INPUT JUMLAH KELUAR
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

    // ✅ VALIDASI SAAT SUBMIT
    const wasteForm = document.getElementById('wasteForm');
    if (wasteForm) {
        wasteForm.addEventListener('submit', function(e) {
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
            
            // ✅ VALIDASI FILE UPLOAD (jika ada file baru)
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
    
    .alert-success, .alert-info {
        padding: 15px;
        border-radius: 8px;
    }
    
    .alert-success a, .alert-info a {
        color: white;
        text-decoration: underline;
    }
    
    .alert-success a:hover, .alert-info a:hover {
        color: #fff;
        text-decoration: none;
    }
</style>
@endpush