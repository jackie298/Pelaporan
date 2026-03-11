@extends('layouts.user_type.auth')

@section('content')
<style>
    .card { border-radius: 1rem !important; box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05) !important; }
    .form-label { font-weight: 600; font-size: 0.75rem; text-transform: uppercase; color: #8392ab; margin-left: 0.25rem; }
    .form-control, .form-select { border-radius: 0.75rem !important; padding: 0.6rem 1rem; border: 1px solid #d2d6da; transition: all 0.2s ease; }
    .form-control:focus, .form-select:focus { border-color: #cb0c9f; box-shadow: 0 0 0 2px rgba(203, 12, 159, 0.2); }
    .input-group-text { background-color: #f8f9fa; border-radius: 0.75rem 0 0 0.75rem !important; border-right: none; color: #8392ab; }
    .input-group > .form-control { border-left: none; }
    .file-preview-box { background: #f8f9fa; border-radius: 0.75rem; padding: 1.2rem; border: 1px dashed #d2d6da; }
    .section-title { position: relative; padding-left: 15px; font-weight: 700; color: #344767; }
    .section-title::before { content: ""; position: absolute; left: 0; top: 5px; height: 18px; width: 4px; background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%); border-radius: 10px; }
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
                    <h4 class="font-weight-bolder mb-0">Edit Dokumen Kontrak</h4>
                    <p class="text-sm mb-0 text-muted">ID Kontrak: <strong>#{{ $rekap_anggaran->id }}</strong> | Periode: {{ $rekap_anggaran->periode ? date('d/m/Y', strtotime($rekap_anggaran->periode)) : '-' }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.rekap-anggaran.update', $rekap_anggaran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- INFORMASI UTAMA --}}
                        <h6 class="section-title mb-3">Informasi Utama & Progres</h6>
                        <div class="row mb-4">
                            <div class="col-md-7 mb-3">
                                <label class="form-label">Nama Kontrak <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                    <input type="text" name="nama" value="{{ old('nama', $rekap_anggaran->nama) }}" 
                                           class="form-control @error('nama') is-invalid @enderror" placeholder="Nama kontrak...">
                                </div>
                                @error('nama') <div class="text-danger text-xxs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-5 mb-3">
                                <label class="form-label">Realisasi (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                    <input type="number" name="realisasi" value="{{ old('realisasi', $rekap_anggaran->realisasi) }}" 
                                           class="form-control @error('realisasi') is-invalid @enderror" 
                                           placeholder="0 - 100" min="0" max="100" step="0.01">
                                </div>
                                <div class="text-muted text-xxs mt-1">Hanya angka 0 sampai 100</div>
                                @error('realisasi') <div class="text-danger text-xxs mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- DETAIL ANGGARAN --}}
                        <h6 class="section-title mb-3">Detail Keuangan & Status</h6>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nilai Harga (Anggaran) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text font-weight-bold text-xs text-dark">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga', $rekap_anggaran->harga) }}" 
                                           class="form-control @error('harga') is-invalid @enderror" step="0.01">
                                </div>
                                @error('harga') <div class="text-danger text-xxs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status Kontrak <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="open" {{ old('status', $rekap_anggaran->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="close" {{ old('status', $rekap_anggaran->status) == 'close' ? 'selected' : '' }}>Close</option>
                                    <option value="pending" {{ old('status', $rekap_anggaran->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses finance" {{ old('status', $rekap_anggaran->status) == 'proses finance' ? 'selected' : '' }}>Proses Finance</option>
                                    <option value="hold" {{ old('status', $rekap_anggaran->status) == 'hold' ? 'selected' : '' }}>Hold</option>
                                </select>
                                @error('status') <div class="text-danger text-xxs mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Periode</label>
                                <input type="date" name="periode" value="{{ old('periode', $rekap_anggaran->periode ? date('Y-m-d', strtotime($rekap_anggaran->periode)) : '') }}" 
                                       class="form-control @error('periode') is-invalid @enderror">
                                @error('periode') <div class="text-danger text-xxs mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- DESKRIPSI TEKNIS --}}
                        <h6 class="section-title mb-3">Uraian & Deskripsi Pekerjaan</h6>
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">Keterangan Jasa Pekerjaan <span class="text-danger">*</span></label>
                                <textarea name="keterangan_jasa" rows="3" class="form-control @error('keterangan_jasa') is-invalid @enderror" placeholder="Detail pekerjaan...">{{ old('keterangan_jasa', $rekap_anggaran->keterangan_jasa) }}</textarea>
                                @error('keterangan_jasa') <div class="text-danger text-xxs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Uraian Matriks 21 RKAB</label>
                                <textarea name="uraian_rkab" rows="2" class="form-control" placeholder="Referensi RKAB...">{{ old('uraian_rkab', $rekap_anggaran->uraian_rkab) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Catatan Tambahan (Keterangan)</label>
                                <input type="text" name="keterangan" value="{{ old('keterangan', $rekap_anggaran->keterangan) }}" 
                                       class="form-control" placeholder="Opsional">
                            </div>
                        </div>

                        {{-- UPLOAD FILE --}}
                        <h6 class="section-title mb-3">Dokumen Lampiran</h6>
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="file-preview-box">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 border-end border-sm-0">
                                            <label class="form-label d-block">Perbarui File Kontrak</label>
                                            <input type="file" name="file_kontrak" class="form-control form-control-sm @error('file_kontrak') is-invalid @enderror">
                                            <small class="text-muted text-xxs mt-2 d-block">Biarkan kosong jika tidak ingin mengubah file. (Maks. 10MB)</small>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <div class="ps-md-4">
                                                <span class="d-block text-xs font-weight-bold text-uppercase text-muted mb-2">File Saat Ini:</span>
                                                @if ($rekap_anggaran->file_kontrak)
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon icon-shape icon-sm shadow-sm border-radius-md bg-gradient-info text-center me-3 d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-file-pdf text-white opacity-10"></i>
                                                        </div>
                                                        <div>
                                                            <a href="{{ asset('storage/' . $rekap_anggaran->file_kontrak) }}" target="_blank" class="text-info text-sm font-weight-bold">
                                                                <i class="fas fa-external-link-alt me-1"></i> Lihat Dokumen
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-secondary italic">Tidak ada file yang diunggah.</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('file_kontrak') <div class="text-danger text-xxs mt-2">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="d-flex justify-content-between align-items-center border-top pt-4">
                            <button type="button" class="btn btn-link text-secondary font-weight-bold mb-0" onclick="window.location='{{ route('admin.rekap-anggaran') }}'">Batalkan</button>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn bg-gradient-dark mb-0 px-5 shadow-sm">
                                    <i class="fas fa-sync-alt me-2 text-xs"></i> Update Data Kontrak
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
                <h4 class="font-weight-bold mb-2">Perhatian!</h4>
                <p class="text-muted text-sm mb-4">Beberapa data yang Anda masukkan tidak valid.</p>
                <div class="text-start bg-light p-3 border-radius-md mb-4">
                    <ul class="mb-0 text-xs font-weight-bold text-dark">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn bg-gradient-dark w-100 mb-0" data-bs-dismiss="modal">Perbaiki Data</button>
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