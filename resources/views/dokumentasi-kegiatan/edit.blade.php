@extends('layouts.user_type.auth')

@section('content')

<style>
    /* CSS Tambahan untuk Preview Multiple Foto */
    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }
    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #ddd;
    }
    .preview-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    .file-badge {
        font-size: 0.7rem;
        background: #0d4435;
        color: white;
        padding: 2px 5px;
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        opacity: 0.9;
    }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-3 mx-md-4" role="alert">
        <span class="text-white">
            <strong>Edit Dokumentasi Kegiatan</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-3 mx-md-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Dokumentasi Kegiatan</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('dokumentasi-kegiatan.update', $dokumentasi->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- JUDUL --}}
                            <div class="col-12">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" value="{{ old('judul', $dokumentasi->judul) }}"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       placeholder="Contoh: Inspeksi Harian Alat Berat">
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- TANGGAL --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', $dokumentasi->tanggal?->format('Y-m-d')) }}"
                                       class="form-control @error('tanggal') is-invalid @enderror">
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $dokumentasi->lokasi) }}"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       placeholder="Contoh: Area Tambang Selatan">
                                @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- JENIS KEGIATAN --}}
                            <div class="col-12">
                                <label class="form-label">Jenis Kegiatan</label>
                                <input type="text" name="jenis_kegiatan" value="{{ old('jenis_kegiatan', $dokumentasi->jenis_kegiatan) }}"
                                       class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                       placeholder="Contoh: Inspeksi, Maintenance, Operasional">
                                @error('jenis_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror"
                                          placeholder="Uraikan kegiatan secara lengkap">{{ old('deskripsi', $dokumentasi->deskripsi) }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- FILE DOKUMENTASI (MULTIPLE) --}}
                            <div class="col-12">
                                <label class="form-label">File Dokumentasi (Bisa pilih banyak foto)</label>
                                <input type="file"
                                       name="file_dokumentasi[]"
                                       class="form-control @error('file_dokumentasi') is-invalid @enderror @error('file_dokumentasi.*') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       multiple> {{-- Atribut multiple ditambahkan --}}

                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, PDF | Maks: 5 MB per file | Pilih banyak file sekaligus jika perlu.
                                </small>

                                {{-- Tampilkan daftar file lama --}}
                                @if($dokumentasi->file_dokumentasi && count($dokumentasi->file_dokumentasi) > 0)
                                    <div class="mt-4">
                                        <p class="mb-2 font-weight-bold" style="font-size: 0.85rem;">File saat ini ({{ count($dokumentasi->file_dokumentasi) }} item):</p>
                                        <div class="preview-container">
                                            @foreach($dokumentasi->file_dokumentasi as $path)
                                                @php $ext = pathinfo($path, PATHINFO_EXTENSION); @endphp
                                                <div class="preview-item">
                                                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                        <img src="{{ asset('storage/' . $path) }}" alt="Preview">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 100px;">
                                                            <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                                        </div>
                                                    @endif
                                                    <div class="file-badge text-truncate px-1">{{ basename($path) }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="alert alert-info mt-2 p-2" style="font-size: 0.75rem;">
                                            <i class="fas fa-info-circle me-1"></i> Catatan: Mengupload file baru akan menggantikan <strong>seluruh</strong> file lama di atas.
                                        </div>
                                    </div>
                                @endif

                                @error('file_dokumentasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('file_dokumentasi.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 mt-4">
                            <a href="{{ route('dokumentasi-kegiatan') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary">Update Dokumentasi</button>
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