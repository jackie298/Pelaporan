@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Kontrak</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Document Contract</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.rekap-anggaran.update', $rekap_anggaran->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- NAMA --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text"
                                       name="nama"
                                       value="{{ old('nama', $rekap_anggaran->nama) }}"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       placeholder="Nama kontrak">

                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- REALISASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Realisasi</label>
                                <input type="text"
                                       name="realisasi"
                                       value="{{ old('realisasi', $rekap_anggaran->realisasi) }}"
                                       class="form-control @error('realisasi') is-invalid @enderror"
                                       placeholder="Realisasi">

                                @error('realisasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- KETERANGAN JASA --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan Jasa Pekerjaan</label>
                                <textarea name="keterangan_jasa"
                                          rows="3"
                                          class="form-control @error('keterangan_jasa') is-invalid @enderror"
                                          placeholder="Deskripsi jasa pekerjaan">{{ old('keterangan_jasa', $rekap_anggaran->keterangan_jasa) }}</textarea>

                                @error('keterangan_jasa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- HARGA --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number"
                                       name="harga"
                                       value="{{ old('harga', $rekap_anggaran->harga) }}"
                                       class="form-control @error('harga') is-invalid @enderror"
                                       placeholder="Rp">

                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="open" {{ old('status', $rekap_anggaran->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="close" {{ old('status', $rekap_anggaran->status) == 'close' ? 'selected' : '' }}>Close</option>
                                    <option value="pending" {{ old('status', $rekap_anggaran->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses finance" {{ old('status', $rekap_anggaran->status) == 'proses finance' ? 'selected' : '' }}>Proses Finance</option>
                                    <option value="hold" {{ old('status', $rekap_anggaran->status) == 'hold' ? 'selected' : '' }}>Hold</option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- KETERANGAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Keterangan</label>
                                <input type="text"
                                       name="keterangan"
                                       value="{{ old('keterangan', $rekap_anggaran->keterangan) }}"
                                       class="form-control @error('keterangan') is-invalid @enderror"
                                       placeholder="Catatan tambahan">

                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- URAIAN RKAB --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Uraian di Matriks 21 RKAB</label>
                                <textarea name="uraian_rkab"
                                          rows="3"
                                          class="form-control @error('uraian_rkab') is-invalid @enderror"
                                          placeholder="Uraian RKAB">{{ old('uraian_rkab', $rekap_anggaran->uraian_rkab) }}</textarea>

                                @error('uraian_rkab')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FILE KONTRAK --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">File Kontrak</label>
                                <input type="file"
                                       name="file_kontrak"
                                       class="form-control @error('file_kontrak') is-invalid @enderror">

                                @if ($rekap_anggaran->file_kontrak)
                                    <small class="text-muted">
                                        File saat ini:
                                        <a href="{{ asset('storage/' . $rekap_anggaran->file_kontrak) }}"
                                           target="_blank">
                                            Lihat file
                                        </a>
                                    </small>
                                @endif

                                @error('file_kontrak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.rekap-anggaran') }}"
                               class="btn btn-light me-2">
                                Batal
                            </a>

                            <button type="submit" class="btn bg-gradient-primary">
                                Update
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
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Terjadi Kesalahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('errorModal')).show();
});
</script>
@endif

@endsection
