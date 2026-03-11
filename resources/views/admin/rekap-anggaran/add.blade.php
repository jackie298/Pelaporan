@extends('layouts.user_type.auth')

@section('content')
<style>
    /* Custom Styling for Modern Look */
    .card { border-radius: 1rem !important; box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05) !important; }
    .form-label { font-weight: 600; font-size: 0.75rem; text-transform: uppercase; color: #8392ab; margin-left: 0.25rem; }
    .form-control, .form-select { border-radius: 0.5rem !important; padding: 0.6rem 0.75rem; border: 1px solid #d2d6da; transition: all 0.2s ease; }
    .form-control:focus, .form-select:focus { border-color: #cb0c9f; box-shadow: 0 0 0 2px rgba(203, 12, 159, 0.2); }
    
    .input-group-text { background-color: #f8f9fa; border-radius: 0.5rem 0 0 0.5rem !important; border-right: none; color: #8392ab; }
    .input-group > .form-control { border-left: none; }
    
    .section-divider { position: relative; display: flex; align-items: center; margin: 2rem 0 1.5rem; }
    .section-divider span { background: #fff; padding-right: 15px; font-weight: 700; color: #344767; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; z-index: 1; }
    .section-divider::after { content: ""; position: absolute; left: 0; top: 50%; width: 100%; height: 1px; background: #e9ecef; }

    .upload-zone { border: 2px dashed #d2d6da; border-radius: 0.75rem; padding: 1.5rem; text-align: center; background: #f8f9fa; transition: all 0.3s ease; }
    .upload-zone:hover { border-color: #cb0c9f; background: #fff; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            {{-- HEADER NAVIGATION --}}
            <div class="d-flex align-items-center mb-4 ms-2">
                <a href="{{ route('admin.rekap-anggaran') }}" class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="font-weight-bolder mb-0">Tambah Kontrak Baru</h4>
                    <p class="text-sm mb-0">Input data anggaran dan dokumen kontrak ke dalam sistem.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.rekap-anggaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- SEKSI 1: IDENTITAS & PERIODE --}}
                        <div class="section-divider">
                            <span><i class="fas fa-id-card me-2"></i>Informasi Identitas & Periode</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kontrak <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-signature text-xs"></i></span>
                                    <input type="text" name="nama" value="{{ old('nama') }}" 
                                           class="form-control @error('nama') is-invalid @enderror" 
                                           placeholder="Contoh: Pengadaan Jasa IT Support">
                                </div>
                                @error('nama') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Realisasi (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-percentage text-xs"></i></span>
                                    <input type="number" name="realisasi" value="{{ old('realisasi') }}" 
                                        class="form-control @error('realisasi') is-invalid @enderror" 
                                        placeholder="0 - 100" min="0" max="100">
                                </div>
                                @error('realisasi') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Periode Kontrak</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar text-xs"></i></span>
                                    <input type="date" name="periode" value="{{ old('periode') }}" 
                                           class="form-control @error('periode') is-invalid @enderror">
                                </div>
                                <div class="text-muted text-xxs mt-1">Kosongkan jika ingin mengikuti tanggal sistem</div>
                                @error('periode') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- SEKSI 2: KEUANGAN & STATUS --}}
                        <div class="section-divider">
                            <span><i class="fas fa-coins me-2"></i>Anggaran & Status</span>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nilai Kontrak (Harga) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text font-weight-bold text-xs">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga') }}" 
                                           class="form-control @error('harga') is-invalid @enderror" 
                                           placeholder="0" step="0.01">
                                </div>
                                @error('harga') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status Pekerjaan <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="" selected disabled>-- Pilih Status --</option>
                                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="close" {{ old('status') == 'close' ? 'selected' : '' }}>Close</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses finance" {{ old('status') == 'proses finance' ? 'selected' : '' }}>Proses Finance</option>
                                    <option value="hold" {{ old('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                                </select>
                                @error('status') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Keterangan Singkat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sticky-note text-xs"></i></span>
                                    <input type="text" name="keterangan" value="{{ old('keterangan') }}" 
                                           class="form-control @error('keterangan') is-invalid @enderror" 
                                           placeholder="Catatan kecil (opsional)">
                                </div>
                                @error('keterangan') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- SEKSI 3: DETAIL PEKERJAAN --}}
                        <div class="section-divider">
                            <span><i class="fas fa-align-left me-2"></i>Deskripsi Pekerjaan</span>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan Jasa Pekerjaan <span class="text-danger">*</span></label>
                                <textarea name="keterangan_jasa" rows="3" 
                                          class="form-control @error('keterangan_jasa') is-invalid @enderror" 
                                          placeholder="Tuliskan detail jasa pekerjaan secara lengkap (Min. 10 karakter)...">{{ old('keterangan_jasa') }}</textarea>
                                @error('keterangan_jasa') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label">Uraian di Matriks 21 RKAB</label>
                                <textarea name="uraian_rkab" rows="2" 
                                          class="form-control @error('uraian_rkab') is-invalid @enderror" 
                                          placeholder="Tuliskan uraian sesuai matriks RKAB...">{{ old('uraian_rkab') }}</textarea>
                                @error('uraian_rkab') <div class="text-danger text-xxs mt-1 ps-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- SEKSI 4: LAMPIRAN --}}
                        <div class="section-divider">
                            <span><i class="fas fa-cloud-upload-alt me-2"></i>Dokumen Pendukung</span>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="upload-zone">
                                    <i class="fas fa-file-pdf text-gradient text-primary fa-2x mb-2"></i>
                                    <label class="d-block text-sm font-weight-bold mb-1">Upload File Kontrak</label>
                                    <p class="text-xs text-muted mb-3">Format: PDF, DOC, JPG, PNG (Maks. 10MB)</p>
                                    <input type="file" name="file_kontrak" class="form-control form-control-sm @error('file_kontrak') is-invalid @enderror">
                                    @error('file_kontrak') <div class="text-danger text-xxs mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- BUTTON ACTION --}}
                        <div class="d-flex justify-content-end align-items-center mt-5">
                            <button type="reset" class="btn btn-link text-secondary font-weight-bold mb-0 me-4">
                                Reset Form
                            </button>
                            <button type="submit" class="btn bg-gradient-dark px-5 mb-0">
                                <i class="fas fa-save me-2 text-xs"></i> Simpan Kontrak
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ERROR VALIDASI (Auto-trigger) --}}
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white border-radius-top-lg">
                <h6 class="modal-title text-white mb-0" id="errorModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Input Tidak Valid
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-sm font-weight-bold mb-3">Beberapa kolom memerlukan perbaikan:</p>
                <ul class="text-xs text-secondary ps-3">
                    @foreach ($errors->all() as $error)
                        <li class="mb-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn bg-gradient-secondary btn-sm mb-0" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('errorModal'));
        myModal.show();
    });
</script>
@endif

@endsection