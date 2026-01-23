@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Alat</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Data Alat</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.equipment-list.update', $equipment->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- NAMA --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text"
                                       name="nama"
                                       value="{{ old('nama', $equipment->nama) }}"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       placeholder="Nama alat">

                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- KODE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode</label>
                                <input type="text"
                                       name="kode"
                                       value="{{ old('kode', $equipment->kode) }}"
                                       class="form-control @error('kode') is-invalid @enderror"
                                       placeholder="Kode unik alat">

                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis</label>
                                <input type="text"
                                       name="jenis"
                                       value="{{ old('jenis', $equipment->jenis) }}"
                                       class="form-control @error('jenis') is-invalid @enderror"
                                       placeholder="Jenis alat (ex: Excavator, Dump Truck)">

                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- MERK --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Merk</label>
                                <input type="text"
                                       name="merk"
                                       value="{{ old('merk', $equipment->merk) }}"
                                       class="form-control @error('merk') is-invalid @enderror"
                                       placeholder="Merk alat">

                                @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TAHUN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number"
                                       name="tahun"
                                       value="{{ old('tahun', $equipment->tahun) }}"
                                       class="form-control @error('tahun') is-invalid @enderror"
                                       placeholder="Tahun pembuatan">

                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NO. POLISI --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">No. Polisi</label>
                                <input type="text"
                                    name="no_polisi"
                                    value="{{ old('no_polisi', $equipment->no_polisi ?? '') }}"
                                    class="form-control @error('no_polisi') is-invalid @enderror"
                                    placeholder="Nomor polisi kendaraan"
                                    style="text-transform: uppercase;"
                                    oninput="this.value = this.value.toUpperCase()">

                                @error('no_polisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NO. MESIN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">No. Mesin</label>
                                <input type="text"
                                       name="no_mesin"
                                       value="{{ old('no_mesin', $equipment->no_mesin) }}"
                                       class="form-control @error('no_mesin') is-invalid @enderror"
                                       placeholder="Nomor mesin">

                                @error('no_mesin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <input type="text"
                                       name="status"
                                       value="{{ old('status', $equipment->status) }}"
                                       class="form-control @error('status') is-invalid @enderror"
                                       placeholder="Status alat (ex: Aktif, Perbaikan)">

                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI SEKARANG --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Sekarang</label>
                                <input type="text"
                                       name="lokasi_sekarang"
                                       value="{{ old('lokasi_sekarang', $equipment->lokasi_sekarang) }}"
                                       class="form-control @error('lokasi_sekarang') is-invalid @enderror"
                                       placeholder="Lokasi terkini alat">

                                @error('lokasi_sekarang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan tambahan">{{ old('catatan', $equipment->catatan) }}</textarea>

                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.equipment-list') }}"
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