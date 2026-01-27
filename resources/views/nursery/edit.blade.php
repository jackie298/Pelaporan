@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Data Pembibitan</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Data Pembibitan</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('nursery.update', $data->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- JENIS TANAMAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Tanaman</label>
                                <input type="text"
                                       name="jenis_tanaman"
                                       value="{{ old('jenis_tanaman', $data->jenis_tanaman) }}"
                                       class="form-control @error('jenis_tanaman') is-invalid @enderror"
                                       placeholder="Contoh: Sengon, Jati, Mahoni">

                                @error('jenis_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JUMLAH BIBIT --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Bibit</label>
                                <input type="number"
                                       name="jumlah_bibit"
                                       value="{{ old('jumlah_bibit', $data->jumlah_bibit) }}"
                                       class="form-control @error('jumlah_bibit') is-invalid @enderror"
                                       placeholder="Contoh: 5000"
                                       min="1">

                                @error('jumlah_bibit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TANGGAL PENYEMAIAAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Penyemaian</label>
                                <input type="date"
                                       name="tanggal_penyemaian"
                                       value="{{ old('tanggal_penyemaian', $data->tanggal_penyemaian?->format('Y-m-d')) }}"
                                       class="form-control @error('tanggal_penyemaian') is-invalid @enderror">

                                @error('tanggal_penyemaian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI PEMBIBITAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Pembibitan</label>
                                <input type="text"
                                       name="lokasi_pembibitan"
                                       value="{{ old('lokasi_pembibitan', $data->lokasi_pembibitan) }}"
                                       class="form-control @error('lokasi_pembibitan') is-invalid @enderror"
                                       placeholder="Contoh: Nursery Utara, Blok A">

                                @error('lokasi_pembibitan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS PERTUMBUHAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Pertumbuhan</label>
                                <select name="status_pertumbuhan"
                                        class="form-select @error('status_pertumbuhan') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="bagus" {{ old('status_pertumbuhan', $data->status_pertumbuhan) == 'bagus' ? 'selected' : '' }}>
                                        Bagus
                                    </option>
                                    <option value="sedang" {{ old('status_pertumbuhan', $data->status_pertumbuhan) == 'sedang' ? 'selected' : '' }}>
                                        Sedang
                                    </option>
                                    <option value="buruk" {{ old('status_pertumbuhan', $data->status_pertumbuhan) == 'buruk' ? 'selected' : '' }}>
                                        Buruk
                                    </option>
                                </select>

                                @error('status_pertumbuhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PERSENTASE KEBERHASILAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Persentase Keberhasilan (%)</label>
                                <input type="number"
                                       step="0.01"
                                       name="persentase_keberhasilan"
                                       value="{{ old('persentase_keberhasilan', $data->persentase_keberhasilan) }}"
                                       class="form-control @error('persentase_keberhasilan') is-invalid @enderror"
                                       placeholder="Contoh: 85.50"
                                       min="0" max="100">

                                @error('persentase_keberhasilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ESTIMASI SIAP TANAM --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estimasi Siap Tanam</label>
                                <input type="date"
                                       name="estimasi_siap_tanam"
                                       value="{{ old('estimasi_siap_tanam', $data->estimasi_siap_tanam?->format('Y-m-d')) }}"
                                       class="form-control @error('estimasi_siap_tanam') is-invalid @enderror">

                                @error('estimasi_siap_tanam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan tambahan tentang kondisi bibit atau perawatan">{{ old('catatan', $data->catatan) }}</textarea>

                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('nursery') }}"
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