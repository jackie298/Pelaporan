@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Rencana Revegetasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Rencana</h5>
                    <p class="text-sm">Mengedit rencana untuk bulan <strong>{{ $data->nama_bulan }} {{ $data->tahun }}</strong></p>
                </div>

                <div class="card-body">
                    <form action="{{ route('rencana-revegetasi.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- TAHUN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" 
                                       name="tahun" 
                                       class="form-control @error('tahun') is-invalid @enderror" 
                                       value="{{ old('tahun', $data->tahun) }}">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- BULAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select @error('bulan') is-invalid @enderror">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ old('bulan', $data->bulan) == $m ? 'selected' : '' }}>
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
                                       value="{{ old('target_bibit', $data->target_bibit) }}">
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
                                       value="{{ old('lokasi', $data->lokasi) }}">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('rencana-revegetasi') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="btn bg-gradient-info">Perbarui Data</button>
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