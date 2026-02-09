@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Data Limbah B3 Masuk</strong> (ID: #{{ $data->id }})
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Data Limbah B3 Masuk</h5>
                    <p class="text-sm text-muted mb-0">
                        <i class="fas fa-info-circle"></i> 
                        Data limbah B3 yang masuk ke Tempat Penyimpanan Sementara (TPS)
                    </p>
                </div>
                <div class="card-body">
                    <form action="{{ route('waste-b3-masuk.update', $data->id) }}" method="POST" id="wasteForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Informasi Status Pengeluaran --}}
                        @if($data->pengeluaran->count() > 0)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Data ini sudah memiliki <strong>{{ $data->pengeluaran->count() }}</strong> riwayat pengeluaran limbah</li>
                                <li><strong>Jumlah ton tidak dapat diubah</strong> karena sudah ada pengeluaran</li>
                                <li>Hanya field lain yang dapat diedit</li>
                            </ul>
                        </div>
                        @endif

                        {{-- Informasi Sisa Limbah --}}
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Jumlah Masuk:</strong> {{ $data->jumlah_ton_formatted }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Sudah Dikeluarkan:</strong> {{ number_format($data->jumlah_dikeluarkan, 2, ',', '.') }} ton
                                </div>
                                <div class="col-md-4">
                                    <strong>Sisa Limbah:</strong> 
                                    <span class="badge badge-sm bg-gradient-{{ $data->sisa_limbah > 0 ? 'warning' : 'success' }}">
                                        {{ $data->sisa_limbah_formatted }}
                                    </span>
                                </div>
                            </div>
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
                                       value="{{ old('jenis_limbah', $data->jenis_limbah) }}" 
                                       class="form-control @error('jenis_limbah') is-invalid @enderror"
                                       placeholder="Contoh: Oli Bekas, Baterai Bekas, dll"
                                       maxlength="100"
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
                                       value="{{ old('kode_limbah', $data->kode_limbah) }}" 
                                       class="form-control @error('kode_limbah') is-invalid @enderror"
                                       placeholder="Contoh: B3-OLI-001"
                                       maxlength="50"
                                       required>
                                @error('kode_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sumber Limbah <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="sumber_limbah" 
                                       value="{{ old('sumber_limbah', $data->sumber_limbah) }}" 
                                       class="form-control @error('sumber_limbah') is-invalid @enderror"
                                       placeholder="Contoh: Workshop, Area Kantor, Site Produksi"
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
                                       value="{{ old('nomor_manifest', $data->nomor_manifest) }}" 
                                       class="form-control @error('nomor_manifest') is-invalid @enderror"
                                       placeholder="Contoh: MNF-B3-2026-001"
                                       maxlength="100">
                                @error('nomor_manifest')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('tanggal_masuk', $data->tanggal_masuk?->format('Y-m-d')) }}" 
                                       class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                       required>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Limbah (Ton) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.01" 
                                       name="jumlah_ton" 
                                       value="{{ old('jumlah_ton', $data->jumlah_ton) }}" 
                                       class="form-control @error('jumlah_ton') is-invalid @enderror"
                                       placeholder="0.00"
                                       {{ $data->pengeluaran->count() > 0 ? 'readonly' : '' }}
                                       required>
                                @error('jumlah_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($data->pengeluaran->count() > 0)
                                    <small class="form-text text-warning">
                                        <i class="fas fa-lock"></i> Tidak dapat diubah karena sudah ada pengeluaran
                                    </small>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Maks. Penyimpanan <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="maksimal_penyimpanan" 
                                       value="{{ old('maksimal_penyimpanan', $data->maksimal_penyimpanan?->format('Y-m-d')) }}" 
                                       class="form-control @error('maksimal_penyimpanan') is-invalid @enderror"
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
                                          placeholder="Catatan tambahan atau keterangan lainnya...">{{ old('catatan', $data->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- STATUS INFO (Readonly) --}}
                        <div class="alert alert-secondary mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Status:</strong> 
                                    <span class="badge badge-sm bg-gradient-{{ $data->status_badge_color }}">
                                        {{ $data->status_label }}
                                    </span>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> 
                                        Terakhir diupdate: {{ $data->updated_at?->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('waste-b3-masuk.index') }}" class="btn btn-light me-2">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i>Simpan Perubahan
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
        tanggalMasukInput.addEventListener('change', function() {
            if (this.value && maksimalPenyimpananInput.value) {
                const tanggalMasuk = new Date(this.value);
                const maksimalPenyimpanan = new Date(maksimalPenyimpananInput.value);
                
                if (maksimalPenyimpanan <= tanggalMasuk) {
                    alert('⚠️ Tanggal maksimal penyimpanan harus setelah tanggal masuk!');
                    maksimalPenyimpananInput.value = '';
                }
            }
        });

        maksimalPenyimpananInput.addEventListener('change', function() {
            if (this.value && tanggalMasukInput.value) {
                const tanggalMasuk = new Date(tanggalMasukInput.value);
                const maksimalPenyimpanan = new Date(this.value);
                
                if (maksimalPenyimpanan <= tanggalMasuk) {
                    alert('⚠️ Tanggal maksimal penyimpanan harus setelah tanggal masuk!');
                    this.value = '';
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
    
    .badge.bg-gradient-warning {
        background: linear-gradient(310deg, #f53939, #fbcf33) !important;
    }
    
    .badge.bg-gradient-success {
        background: linear-gradient(310deg, #17ad37, #98ec2d) !important;
    }
    
    .badge.bg-gradient-info {
        background: linear-gradient(310deg, #2152ff, #21d4fd) !important;
    }
    
    .badge.bg-gradient-danger {
        background: linear-gradient(310deg, #ea0606, #ff667c) !important;
    }
    
    .form-text.text-warning {
        color: #f53939 !important;
        font-weight: 500;
    }
</style>
@endpush