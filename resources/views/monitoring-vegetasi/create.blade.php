@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Data Monitoring Vegetasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Data Monitoring Vegetasi</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('monitoring-vegetasi.store') }}"
                          method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- LOKASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text"
                                       name="lokasi"
                                       value="{{ old('lokasi') }}"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       placeholder="Contoh: Pit Utara, Area Reklamasi">

                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TITIK PANTAU --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Titik Pantau</label>
                                <input type="text"
                                       name="titik_pantau"
                                       value="{{ old('titik_pantau') }}"
                                       class="form-control @error('titik_pantau') is-invalid @enderror"
                                       placeholder="Contoh: TP-001, Koordinat GPS">

                                @error('titik_pantau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS TANAMAN --}}
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Jenis Tanaman</label>
                                <input type="text"
                                       name="jenis_tanaman"
                                       value="{{ old('jenis_tanaman') }}"
                                       class="form-control @error('jenis_tanaman') is-invalid @enderror"
                                       placeholder="Contoh: Sengon, Jati, Mahoni">

                                @error('jenis_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TAHUN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun Pengukuran</label>
                                <input type="number"
                                       name="tahun"
                                       value="{{ old('tahun', date('Y')) }}"
                                       class="form-control @error('tahun') is-invalid @enderror"
                                       placeholder="Contoh: 2026"
                                       min="2020"
                                       max="2099">

                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGGI TRIWULAN 1 --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tinggi Triwulan I (cm)</label>
                                <input type="number"
                                       step="0.01"
                                       name="tinggi_triwulan1"
                                       value="{{ old('tinggi_triwulan1') }}"
                                       class="form-control @error('tinggi_triwulan1') is-invalid @enderror"
                                       placeholder="Contoh: 15.50">

                                @error('tinggi_triwulan1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGGI TRIWULAN 2 --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tinggi Triwulan II (cm)</label>
                                <input type="number"
                                       step="0.01"
                                       name="tinggi_triwulan2"
                                       value="{{ old('tinggi_triwulan2') }}"
                                       class="form-control @error('tinggi_triwulan2') is-invalid @enderror"
                                       placeholder="Contoh: 18.25">

                                @error('tinggi_triwulan2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGGI TRIWULAN 3 --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tinggi Triwulan III (cm)</label>
                                <input type="number"
                                       step="0.01"
                                       name="tinggi_triwulan3"
                                       value="{{ old('tinggi_triwulan3') }}"
                                       class="form-control @error('tinggi_triwulan3') is-invalid @enderror"
                                       placeholder="Contoh: 22.75">

                                @error('tinggi_triwulan3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGGI TRIWULAN 4 --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tinggi Triwulan IV (cm)</label>
                                <input type="number"
                                       step="0.01"
                                       name="tinggi_triwulan"
                                       value="{{ old('tinggi_triwulan') }}"
                                       class="form-control @error('tinggi_triwulan') is-invalid @enderror"
                                       placeholder="Contoh: 28.50">

                                @error('tinggi_triwulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan tambahan tentang kondisi tanaman atau pengamatan lapangan">{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('monitoring-vegetasi') }}"
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