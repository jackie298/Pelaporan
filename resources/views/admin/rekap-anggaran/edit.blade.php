@extends('layouts.user_type.auth')

@section('content')
<style>
    .card {
        border-radius: 1rem !important;
        box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05) !important;
    }
    .form-label {
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #8392ab;
        margin-left: 0.25rem;
    }
    .form-control, .form-select {
        border-radius: 0.75rem !important;
        padding: 0.6rem 1rem;
        border: 1px solid #d2d6da;
    }
    .form-control:focus, .form-select:focus {
        border-color: #cb0c9f;
        box-shadow: 0 0 0 2px rgba(203, 12, 159, 0.2);
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-radius: 0.75rem 0 0 0.75rem !important;
        border-right: none;
        color: #8392ab;
    }
    .input-group > .form-control {
        border-left: none;
    }
    .file-preview-box {
        background: #f8f9fa;
        border-radius: 0.75rem;
        padding: 1rem;
        border: 1px dashed #d2d6da;
    }
    .section-title {
        position: relative;
        padding-left: 15px;
        font-weight: 700;
        color: #344767;
    }
    .section-title::before {
        content: "";
        position: absolute;
        left: 0;
        top: 5px;
        height: 18px;
        width: 4px;
        background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);
        border-radius: 10px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            {{-- HEADER NAVIGATION --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.rekap-anggaran') }}" class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="font-weight-bolder mb-0">Edit Dokumen</h4>
                    <p class="text-sm mb-0 text-muted">Perbarui informasi kontrak: <strong>{{ $rekap_anggaran->nama }}</strong></p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body p-4">
                    <form action="{{ route('admin.rekap-anggaran.update', $rekap_anggaran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- INFORMASI UTAMA --}}
                        <h6 class="section-title mb-3">Informasi Utama</h6>
                        <div class="row mb-4">
                            <div class="col-md-7">
                                <label class="form-label">Nama Kontrak</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                    <input type="text" name="nama" value="{{ old('nama', $rekap_anggaran->nama) }}" 
                                           class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Pengadaan Jasa IT">
                                </div>
                                @error('nama') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Nomor Realisasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                    <input type="text" name="realisasi" value="{{ old('realisasi', $rekap_anggaran->realisasi) }}" 
                                           class="form-control @error('realisasi') is-invalid @enderror" placeholder="Kode Realisasi">
                                </div>
                                @error('realisasi') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- DETAIL ANGGARAN --}}
                        <h6 class="section-title mb-3">Detail Anggaran & Status</h6>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Nilai Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text font-weight-bold text-xs text-dark">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga', $rekap_anggaran->harga) }}" 
                                           class="form-control @error('harga') is-invalid @enderror">
                                </div>
                                @error('harga') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Saat Ini</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="open" {{ old('status', $rekap_anggaran->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="close" {{ old('status', $rekap_anggaran->status) == 'close' ? 'selected' : '' }}>Close</option>
                                    <option value="pending" {{ old('status', $rekap_anggaran->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses finance" {{ old('status', $rekap_anggaran->status) == 'proses finance' ? 'selected' : '' }}>Proses Finance</option>
                                    <option value="hold" {{ old('status', $rekap_anggaran->status) == 'hold' ? 'selected' : '' }}>Hold</option>
                                </select>
                                @error('status') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Catatan Singkat</label>
                                <input type="text" name="keterangan" value="{{ old('keterangan', $rekap_anggaran->keterangan) }}" 
                                       class="form-control" placeholder="Optional">
                            </div>
                        </div>

                        {{-- DESKRIPSI TEKNIS --}}
                        <h6 class="section-title mb-3">Uraian & Deskripsi</h6>
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">Keterangan Jasa Pekerjaan</label>
                                <textarea name="keterangan_jasa" rows="3" class="form-control @error('keterangan_jasa') is-invalid @enderror">{{ old('keterangan_jasa', $rekap_anggaran->keterangan_jasa) }}</textarea>
                                @error('keterangan_jasa') <div class="text-danger text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Uraian Matriks 21 RKAB</label>
                                <textarea name="uraian_rkab" rows="3" class="form-control">{{ old('uraian_rkab', $rekap_anggaran->uraian_rkab) }}</textarea>
                            </div>
                        </div>

                        {{-- UPLOAD FILE --}}
                        <h6 class="section-title mb-3">Dokumen Lampiran</h6>
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="file-preview-box">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 border-end border-sm-0">
                                            <label class="form-label d-block">Ganti File Kontrak (PDF/DOC)</label>
                                            <input type="file" name="file_kontrak" class="form-control form-control-sm">
                                            <small class="text-muted text-xxs mt-2 d-block">*Maksimal file 2MB</small>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            @if ($rekap_anggaran->file_kontrak)
                                                <div class="d-flex align-items-center ps-md-4">
                                                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-gradient-info text-center me-3 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-file-pdf text-white opacity-10"></i>
                                                    </div>
                                                    <div>
                                                        <span class="d-block text-dark font-weight-bold text-sm">File Terlampir</span>
                                                        <a href="{{ asset('storage/' . $rekap_anggaran->file_kontrak) }}" target="_blank" class="text-info text-xs font-weight-bold">
                                                            <i class="fas fa-external-link-alt me-1"></i> Lihat Dokumen Saat Ini
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="ps-md-4 text-center">
                                                    <span class="text-xs text-muted">Belum ada file terlampir</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @error('file_kontrak') <div class="text-danger text-xs mt-2">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="d-flex justify-content-between align-items-center border-top pt-4">
                            <button type="button" class="btn btn-link text-secondary font-weight-bold mb-0" onclick="history.back()">Kembali</button>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-danger mb-0 px-4">Reset Form</button>
                                <button type="submit" class="btn bg-gradient-dark mb-0 px-5 shadow-sm">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ERROR VALIDASI (Auto Show) --}}
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-body text-center p-4">
                <div class="icon icon-shape icon-xl bg-gradient-danger shadow-danger text-center border-radius-xl mb-3 mx-auto d-flex align-items-center justify-content-center">
                    <i class="fas fa-exclamation-circle text-white text-lg opacity-10"></i>
                </div>
                <h4 class="font-weight-bold mb-2">Validasi Gagal!</h4>
                <p class="text-muted text-sm mb-4">Silakan periksa kembali beberapa kolom yang wajib diisi.</p>
                <div class="text-start bg-light p-3 border-radius-md mb-4">
                    <ul class="mb-0 text-xs font-weight-bold text-dark">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn bg-gradient-dark w-100 mb-0" data-bs-dismiss="modal">Saya Mengerti</button>
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