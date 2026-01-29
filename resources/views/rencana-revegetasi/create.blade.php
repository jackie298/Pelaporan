@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Rencana Revegetasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Rencana Bulanan</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('rencana-revegetasi.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- TAHUN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" 
                                       name="tahun" 
                                       class="form-control @error('tahun') is-invalid @enderror" 
                                       value="{{ old('tahun', date('Y')) }}" 
                                       placeholder="Contoh: 2026">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- BULAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select @error('bulan') is-invalid @enderror">
                                    <option value="">-- Pilih Bulan --</option>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ old('bulan') == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TARGET BIBIT --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Target Bibit (Batang)</label>
                                <input type="number" 
                                       name="target_bibit" 
                                       class="form-control @error('target_bibit') is-invalid @enderror" 
                                       value="{{ old('target_bibit') }}" 
                                       placeholder="Contoh: 1000">
                                @error('target_bibit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Lokasi Target</label>
                                <input type="text" 
                                       name="lokasi" 
                                       class="form-control @error('lokasi') is-invalid @enderror" 
                                       value="{{ old('lokasi') }}" 
                                       placeholder="Contoh: Pit Barat Blok A">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('rencana-revegetasi') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary">Simpan Rencana</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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