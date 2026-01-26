@extends('layouts.user_type.auth')

@section('content')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<style>
    /* Indikator jumlah foto tambahan seperti tampilan WA (+2) */
    .image-overlay-count {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        border-radius: 0.75rem;
    }
</style>

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white font-weight-bold">
            <i class="fas fa-images me-2"></i> Gallery Dokumentasi Kegiatan
        </span>
        <a href="{{ route('admin.dokumentasi-kegiatan.create') }}" class="btn btn-sm btn-white mb-0">
            + Tambah Data
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4 shadow-none bg-transparent">
                <div class="card-body p-0">
                    <div class="row">
                        @forelse ($dokumentasiData as $data)
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100 border-radius-xl shadow-sm border-0">
                                    <div class="position-relative p-2">
                                        <a href="{{ route('admin.dokumentasi-kegiatan.edit', $data->id) }}" class="d-block border-radius-xl overflow-hidden">
                                            @if($data->file_dokumentasi && count($data->file_dokumentasi) > 0)
                                                {{-- AMBIL FOTO PERTAMA SEBAGAI THUMBNAIL --}}
                                                @php
                                                    $firstFile = $data->file_dokumentasi[0];
                                                    $count = count($data->file_dokumentasi);
                                                    $ext = pathinfo($firstFile, PATHINFO_EXTENSION);
                                                @endphp

                                                <div class="position-relative">
                                                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                        <img src="{{ asset('storage/' . $firstFile) }}"
                                                             alt="{{ $data->judul }}"
                                                             class="img-fluid border-radius-xl w-100"
                                                             style="height: 200px; object-fit: cover;">
                                                        
                                                        {{-- INDIKATOR JIKA ADA LEBIH DARI 1 FOTO --}}
                                                        @if($count > 1)
                                                            <div class="image-overlay-count">
                                                                +{{ $count - 1 }}
                                                            </div>
                                                        @endif
                                                    @else
                                                        {{-- JIKA FILE PERTAMA ADALAH PDF --}}
                                                        <div class="bg-gradient-primary d-flex flex-column align-items-center justify-content-center"
                                                             style="height: 200px; border-radius: 0.75rem;">
                                                            <i class="fa-solid fa-file-pdf text-white fa-3x mb-2"></i>
                                                            <span class="text-white text-xs">{{ $count }} File (Termasuk PDF)</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="bg-gradient-secondary d-flex align-items-center justify-content-center"
                                                     style="height: 200px; border-radius: 0.75rem;">
                                                    <i class="fa-solid fa-image text-white fa-3x"></i>
                                                </div>
                                            @endif
                                        </a>
                                    </div>

                                    <div class="card-body px-3 pt-2 pb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge badge-sm bg-gradient-info">{{ $data->jenis_kegiatan }}</span>
                                            <div class="dropdown">
                                                <a href="javascript:;" class="text-secondary" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v text-xs"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="{{ route('admin.dokumentasi-kegiatan.edit', $data->id) }}">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger delete-btn" href="javascript:;" data-id="{{ $data->id }}" data-judul="{{ $data->judul }}">Hapus</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <h6 class="mb-1 text-dark">{{ Str::limit($data->judul, 40) }}</h6>
                                        
                                        <div class="d-flex align-items-center text-sm text-muted mb-1">
                                            <i class="fas fa-map-marker-alt me-2 text-xs"></i>
                                            {{ $data->lokasi ?? '—' }}
                                        </div>
                                        <div class="d-flex align-items-center text-sm text-muted">
                                            <i class="fas fa-calendar-alt me-2 text-xs"></i>
                                            {{ $data->tanggal ? $data->tanggal->format('d M Y') : '—' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada dokumentasi kegiatan.</p>
                                <a href="{{ route('admin.dokumentasi-kegiatan.create') }}" class="btn btn-primary mt-2">+ Tambah Dokumentasi</a>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $dokumentasiData->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus dokumentasi: <br>
                <strong id="dokumenJudul" class="text-danger"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            document.getElementById('dokumenJudul').textContent = btn.getAttribute('data-judul');
            document.getElementById('deleteForm').action = '/admin/dokumentasi-kegiatan/' + btn.getAttribute('data-id');
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });
});
</script>
@endpush

@endsection