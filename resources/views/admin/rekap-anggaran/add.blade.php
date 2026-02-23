@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Kontrak</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Document Contract</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.rekap-anggaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            {{-- JUDUL --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text"
                                       name="nama"
                                       value="{{ old('nama') }}"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       placeholder="Nama kontrak">

                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- REALISASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Realisasi</label>
                                <input type="text"
                                       name="realisasi"
                                       value="{{ old('realisasi') }}"
                                       class="form-control @error('realisasi') is-invalid @enderror"
                                       placeholder="Realisasi">

                                @error('realisasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- KETERANGAN JASA --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan Jasa Pekerjaan</label>
                                <textarea name="keterangan_jasa"
                                          rows="3"
                                          class="form-control @error('keterangan_jasa') is-invalid @enderror"
                                          placeholder="Deskripsi jasa pekerjaan">{{ old('keterangan_jasa') }}</textarea>

                                @error('keterangan_jasa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- HARGA --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number"
                                       name="harga"
                                       value="{{ old('harga') }}"
                                       class="form-control @error('harga') is-invalid @enderror"
                                       placeholder="Rp">

                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="close" {{ old('status') == 'close' ? 'selected' : '' }}>Close</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses finance" {{ old('status') == 'proses finance' ? 'selected' : '' }}>Proses Finance</option>
                                    <option value="hold" {{ old('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- KETERANGAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Keterangan</label>
                                <input type="text"
                                       name="keterangan"
                                       value="{{ old('keterangan') }}"
                                       class="form-control @error('keterangan') is-invalid @enderror"
                                       placeholder="Catatan tambahan">

                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- URAIAN RKAB --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Uraian di Matriks 21 RKAB</label>
                                <textarea name="uraian_rkab"
                                          rows="3"
                                          class="form-control @error('uraian_rkab') is-invalid @enderror"
                                          placeholder="Uraian RKAB">{{ old('uraian_rkab') }}</textarea>

                                @error('uraian_rkab')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- FILE KONTRAK --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">File Kontrak</label>
                                <input type="file"
                                       name="file_kontrak"
                                       class="form-control @error('file_kontrak') is-invalid @enderror">

                                @error('file_kontrak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.document-contract') }}"
                               class="btn btn-light me-2">
                                Batal
                            </a>

                            <button type="submit" class="btn bg-gradient-primary">
                                Simpan
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
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="errorModalLabel">
                    Terjadi Kesalahan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>Silakan periksa kembali form berikut:</p>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('errorModal'));
        modal.show();
    });
</script>
@endif


@endsection
