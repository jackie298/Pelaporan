@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Tambah Rencana Revegetasi</strong>
        </span>
        <a href="{{ route('rencana-revegetasi') }}" class="btn bg-gradient-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Rencana</h5>
                    <p class="text-sm">Buat rencana target revegetasi untuk satu tahun penuh</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('rencana-revegetasi.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- TAHUN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="tahun" 
                                       class="form-control @error('tahun') is-invalid @enderror" 
                                       value="{{ old('tahun', date('Y')) }}"
                                       min="2020" max="2099" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" 
                                       name="lokasi" 
                                       class="form-control @error('lokasi') is-invalid @enderror" 
                                       value="{{ old('lokasi') }}"
                                       placeholder="Contoh: Area Disposal Selatan">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TARGET BULANAN --}}
                        <h6 class="mb-3">
                            <i class="fas fa-calendar-alt me-2"></i>Target Bulanan (Pcs)
                        </h6>

                        <div class="row g-3">
                            @php
                                $bulanList = [
                                    'januari', 'februari', 'maret', 'april', 'mei', 'juni',
                                    'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
                                ];
                            @endphp

                            @foreach($bulanList as $index => $bulan)
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-capitalize">
                                    {{ $bulan }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-seedling"></i>
                                    </span>
                                    <input type="number" 
                                           name="{{ $bulan }}" 
                                           class="form-control @error($bulan) is-invalid @enderror" 
                                           value="{{ old($bulan, 0) }}"
                                           min="0" required>
                                </div>
                                @error($bulan)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('rencana-revegetasi') }}" class="btn bg-gradient-secondary me-2">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i> Simpan Rencana
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Error --}}
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="mb-0 text-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
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