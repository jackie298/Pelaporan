@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Data Revegetasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Data Revegetasi</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('revegetasi.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- TANGGAL MONITORING --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Monitoring</label>
                                <input type="date"
                                       name="tanggal_monitoring"
                                       value="{{ old('tanggal_monitoring', $data->tanggal_monitoring?->format('Y-m-d')) }}"
                                       class="form-control @error('tanggal_monitoring') is-invalid @enderror">
                                @error('tanggal_monitoring')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI REVEGETASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Revegetasi</label>
                                <input type="text"
                                       name="lokasi_revegetasi"
                                       value="{{ old('lokasi_revegetasi', $data->lokasi_revegetasi) }}"
                                       class="form-control @error('lokasi_revegetasi') is-invalid @enderror">
                                @error('lokasi_revegetasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LUAS AREA --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Luas Area (ha)</label>
                                <input type="number"
                                       step="0.01"
                                       name="luas_area"
                                       value="{{ old('luas_area', $data->luas_area) }}"
                                       class="form-control @error('luas_area') is-invalid @enderror">
                                @error('luas_area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS VEGETASI == Jenis Kegiatan --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Kegiatan</label> 
                                <input type="text" 
                                       name="jenis_vegetasi" 
                                       list="vegetasiOptions"
                                       value="{{ old('jenis_vegetasi', $data->jenis_vegetasi) }}"
                                       class="form-control @error('jenis_vegetasi') is-invalid @enderror"
                                       placeholder="Jenis Kegiatan">
                                @error('jenis_vegetasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JUMLAH TANAMAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Tanaman</label>
                                <input type="number"
                                       name="jumlah_tanaman"
                                       value="{{ old('jumlah_tanaman', $data->jumlah_tanaman) }}"
                                       class="form-control @error('jumlah_tanaman') is-invalid @enderror">
                                @error('jumlah_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGKAT KEBERHASILAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tingkat Keberhasilan</label>
                                <select name="tingkat_keberhasilan"
                                        class="form-select @error('tingkat_keberhasilan') is-invalid @enderror">
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="rendah" {{ old('tingkat_keberhasilan', $data->tingkat_keberhasilan) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ old('tingkat_keberhasilan', $data->tingkat_keberhasilan) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ old('tingkat_keberhasilan', $data->tingkat_keberhasilan) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                </select>
                                @error('tingkat_keberhasilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- KONDISI TANAH --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kondisi Tanah</label>
                                <input type="text"
                                       name="kondisi_tanah"
                                       value="{{ old('kondisi_tanah', $data->kondisi_tanah) }}"
                                       class="form-control @error('kondisi_tanah') is-invalid @enderror">
                                @error('kondisi_tanah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- METODE PENANAMAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Metode Penanaman</label>
                                <input type="text"
                                       name="metode_penanaman"
                                       value="{{ old('metode_penanaman', $data->metode_penanaman) }}"
                                       class="form-control @error('metode_penanaman') is-invalid @enderror">
                                @error('metode_penanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS TANAMAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Tanaman</label>
                                <input type="text"
                                       name="jenis_tanaman"
                                       value="{{ old('jenis_tanaman', $data->jenis_tanaman) }}"
                                       class="form-control @error('jenis_tanaman') is-invalid @enderror">
                                @error('jenis_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $data->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('revegetasi') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary">Update</button>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
});
</script>
@endpush
@endif

@endsection