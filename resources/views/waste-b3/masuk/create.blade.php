@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Data Limbah B3 Masuk</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Data Limbah B3 Masuk</h5>
                    <p class="text-sm text-muted mb-0">
                        <i class="fas fa-info-circle"></i> 
                        Data limbah B3 yang masuk ke Tempat Penyimpanan Sementara (TPS)
                    </p>
                </div>
                <div class="card-body">
                    <form action="{{ route('waste-b3.store') }}" method="POST" id="wasteForm">
                        @csrf
                        
                        {{-- INFORMASI PENTING --}}
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-info-circle me-2"></i>Petunjuk Pengisian:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Isi semua field yang bertanda <span class="text-danger">*</span> (wajib)</li>
                                <li>Tanggal maksimal penyimpanan harus setelah tanggal masuk</li>
                                <li>Jumlah limbah minimal 0.01 ton</li>
                                <li>Kombinasi Kode Limbah + Tanggal Masuk tidak boleh duplikat</li>
                            </ul>
                        </div>

                        {{-- SECTION 1: DATA LIMBAH --}}
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                            <i class="fas fa-cube me-2"></i>Data Limbah B3
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Limbah B3 <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="jenis_limbah" 
                                       value="{{ old('jenis_limbah') }}" 
                                       class="form-control @error('jenis_limbah') is-invalid @enderror"
                                       placeholder="Contoh: Oli Bekas, Baterai Bekas, Cat/Kaleng Bekas, dll"
                                       maxlength="100"
                                       autofocus
                                       required>
                                @error('jenis_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Masukkan jenis limbah secara bebas</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Limbah <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="kode_limbah" 
                                       value="{{ old('kode_limbah') }}" 
                                       class="form-control @error('kode_limbah') is-invalid @enderror"
                                       placeholder="Contoh: B3-OLI-001, B3-BAT-002"
                                       maxlength="50"
                                       required>
                                @error('kode_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kode unik untuk identifikasi limbah</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sumber Limbah <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="sumber_limbah" 
                                       value="{{ old('sumber_limbah') }}" 
                                       class="form-control @error('sumber_limbah') is-invalid @enderror"
                                       placeholder="Contoh: Workshop, Area Kantor, Site Produksi, Laboratorium"
                                       maxlength="100"
                                       required>
                                @error('sumber_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Asal limbah dihasilkan</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Manifest</label>
                                <input type="text" 
                                       name="nomor_manifest" 
                                       value="{{ old('nomor_manifest') }}" 
                                       class="form-control @error('nomor_manifest') is-invalid @enderror"
                                       placeholder="Contoh: MNF-B3-2026-001"
                                       maxlength="100">
                                @error('nomor_manifest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Nomor dokumen manifest limbah (opsional)</small>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        {{-- SECTION 2: DATA WAKTU & JUMLAH --}}
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-primary">
                            <i class="fas fa-calendar-alt me-2"></i>Data Waktu & Jumlah
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="tanggal_masuk" 
                                       value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                                       class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Tanggal limbah masuk ke TPS</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Limbah (Ton) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.01" 
                                       name="jumlah_ton" 
                                       value="{{ old('jumlah_ton') }}" 
                                       class="form-control @error('jumlah_ton') is-invalid @enderror"
                                       placeholder="0.00"
                                       min="0.01"
                                       max="999999.99"
                                       required>
                                @error('jumlah_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Minimal 0.01 ton</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Maks. Penyimpanan <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="maksimal_penyimpanan" 
                                       value="{{ old('maksimal_penyimpanan') }}" 
                                       class="form-control @error('maksimal_penyimpanan') is-invalid @enderror"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('maksimal_penyimpanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Tanggal maksimal penyimpanan limbah di TPS
                                </small>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        {{-- SECTION 3: CATATAN --}}
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

                        {{-- STATUS DEFAULT INFO --}}
                        <div class="alert alert-secondary mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong><i class="fas fa-info-circle me-2"></i>Informasi Status:</strong>
                                    <p class="mb-0 mt-2">
                                        Status awal akan otomatis diset sebagai 
                                        <span class="badge badge-sm bg-gradient-info">Belum Dikeluarkan</span>.
                                        Status akan berubah otomatis saat ada pengeluaran limbah.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('waste-b3') }}" class="btn btn-light me-2">
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
    // Tampilkan modal error jika ada validasi gagal
    @if ($errors->any())
    setTimeout(function() {
        const modalEl = document.getElementById('errorModal');
        if (modalEl && typeof bootstrap !== 'undefined') {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }, 300);
    @endif

    // Validasi tanggal maksimal penyimpanan harus setelah tanggal masuk
    const tanggalMasukInput = document.querySelector('input[name="tanggal_masuk"]');
    const maksimalPenyimpananInput = document.querySelector('input[name="maksimal_penyimpanan"]');

    if (tanggalMasukInput && maksimalPenyimpananInput) {
        // Set default maksimal_penyimpanan = tanggal_masuk + 6 bulan
        if (!maksimalPenyimpananInput.value && tanggalMasukInput.value) {
            const tanggalMasuk = new Date(tanggalMasukInput.value);
            tanggalMasuk.setMonth(tanggalMasuk.getMonth() + 6);
            maksimalPenyimpananInput.value = tanggalMasuk.toISOString().split('T')[0];
        }

        tanggalMasukInput.addEventListener('change', function() {
            if (this.value) {
                // Auto-set maksimal_penyimpanan = tanggal_masuk + 6 bulan
                const tanggalMasuk = new Date(this.value);
                tanggalMasuk.setMonth(tanggalMasuk.getMonth() + 6);
                maksimalPenyimpananInput.value = tanggalMasuk.toISOString().split('T')[0];
            }
        });

        // Validasi saat blur
        maksimalPenyimpananInput.addEventListener('blur', function() {
            if (this.value && tanggalMasukInput.value) {
                const tanggalMasuk = new Date(tanggalMasukInput.value);
                const maksimalPenyimpanan = new Date(this.value);
                
                if (maksimalPenyimpanan <= tanggalMasuk) {
                    alert('⚠️ Tanggal maksimal penyimpanan harus setelah tanggal masuk!');
                    this.value = '';
                }
            }
        });

        // Validasi saat submit form
        const wasteForm = document.getElementById('wasteForm');
        if (wasteForm) {
            wasteForm.addEventListener('submit', function(e) {
                if (tanggalMasukInput.value && maksimalPenyimpananInput.value) {
                    const tanggalMasuk = new Date(tanggalMasukInput.value);
                    const maksimalPenyimpanan = new Date(maksimalPenyimpananInput.value);
                    
                    if (maksimalPenyimpanan <= tanggalMasuk) {
                        e.preventDefault();
                        alert('❌ Tanggal maksimal penyimpanan harus setelah tanggal masuk!');
                        maksimalPenyimpananInput.focus();
                    }
                }

                // Validasi jumlah ton
                const jumlahTonInput = document.querySelector('input[name="jumlah_ton"]');
                if (jumlahTonInput && jumlahTonInput.value) {
                    const jumlahTon = parseFloat(jumlahTonInput.value);
                    if (jumlahTon < 0.01) {
                        e.preventDefault();
                        alert('❌ Jumlah limbah minimal 0.01 ton!');
                        jumlahTonInput.focus();
                    }
                }
            });
        }
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
    
    .alert-info, .alert-secondary {
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
</style>
@endpush