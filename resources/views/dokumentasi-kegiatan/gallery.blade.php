@extends('layouts.user_type.auth')

@section('content')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<style>
    /* 1. STYLE KARTU AWAL DENGAN HOVER OVERLAY */
    .gallery-container {
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        background: #202940;
        cursor: pointer;
    }

    .gallery-image-wrapper {
        position: relative;
        width: 100%;
        height: 300px; /* Sesuaikan tinggi awal Anda */
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: filter 0.3s ease;
    }

    /* Overlay View More yang muncul saat Hover */
    .hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: white;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .gallery-container:hover .hover-overlay {
        opacity: 1;
    }

    .gallery-container:hover .gallery-img {
        filter: blur(2px);
    }

    /* 2. STYLE MODAL GRID (Tanpa Slide) */
    .modal-gallery-content {
        background-color: #013220 !important; /* Hijau Tua */
        border-radius: 1rem !important;
    }

    .image-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        padding: 15px;
        max-height: 400px;
        overflow-y: auto;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }

    .grid-item-img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid transparent;
        transition: border 0.3s;
    }

    .grid-item-img:hover {
        border-color: #2dce89;
    }

    .label-green {
        color: #2dce89;
        font-weight: bold;
        text-decoration: underline;
    }
</style>

<div class="row mx-2">
    @forelse ($dokumentasiData as $data)
        @php
            $files = $data->file_dokumentasi ?? [];
            $firstFile = count($files) > 0 ? $files[0] : null;
            $formattedDate = $data->tanggal ? $data->tanggal->format('d/m/Y') : '-';
        @endphp
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="gallery-container shadow" 
                 onclick="openGridModal({{ json_encode($files) }}, '{{ addslashes($data->judul) }}', '{{ $data->jenis_kegiatan }}', '{{ $data->lokasi }}', '{{ $formattedDate }}')">
                
                <div class="gallery-image-wrapper">
                    @if($firstFile)
                        <img src="{{ asset('storage/' . $firstFile) }}" class="gallery-img">
                    @else
                        <div class="gallery-img bg-dark d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-3x text-secondary"></i>
                        </div>
                    @endif

                    <div class="hover-overlay">
                        <span>VIEW MORE</span>
                    </div>
                </div>

                <div class="p-3">
                    <h6 class="text-white mb-1">{{ Str::limit($data->judul, 25) }}</h6>
                    <small class="text-secondary">{{ $data->jenis_kegiatan }}</small>
                    <small class="text-secondary d-block">Lokasi: {{ Str::limit($data->lokasi, 30) }}</small>
                    <small class="text-secondary d-block">Tanggal: {{ $formattedDate }}</small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada dokumentasi.</p>
        </div>
    @endforelse
</div>

<div class="modal fade" id="gridGalleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-gallery-content shadow-lg border-0">
            <div class="modal-body p-0">
                
                <div class="image-grid-container" id="modalGridContent">
                    </div>

                <div class="p-4 text-white">
                    <h4 class="text-white text-uppercase font-weight-bolder mb-3" id="modalGridJudul"></h4>
                    
                    <div class="mb-1 text-sm">
                        <span class="label-green">Unit / Jenis:</span>
                        <span class="ms-2" id="modalGridJenis"></span>
                    </div>
                    
                    <div class="mb-3 text-sm">
                        <span class="label-green">Lokasi:</span>
                        <span class="ms-2" id="modalGridLokasi"></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-3 border-secondary">
                        <small class="opacity-7">
                            <i class="fas fa-calendar-alt me-1"></i> <span id="modalGridTanggal"></span>
                        </small>
                        <small class="font-weight-bold opacity-7">PT NUSA KARYA ARINDO</small>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-white btn-sm px-5" data-bs-dismiss="modal">TUTUP</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openGridModal(files, judul, jenis, lokasi, tanggal) {
    const gridContent = document.getElementById('modalGridContent');
    gridContent.innerHTML = ''; // Reset isi grid

    if (files && files.length > 0) {
        files.forEach((file) => {
            // Menambahkan setiap gambar ke dalam container grid
            gridContent.innerHTML += `
                <a href="/storage/${file}" target="_blank">
                    <img src="/storage/${file}" class="grid-item-img" title="Klik untuk memperbesar">
                </a>
            `;
        });
    } else {
        gridContent.innerHTML = '<div class="w-100 text-center p-4 text-white">Tidak ada foto tersedia</div>';
    }

    // Update Text Detail
    document.getElementById('modalGridJudul').innerText = judul;
    document.getElementById('modalGridJenis').innerText = jenis;
    document.getElementById('modalGridLokasi').innerText = lokasi;
    document.getElementById('modalGridTanggal').innerText = tanggal;

    // Tampilkan Modal
    var myModal = new bootstrap.Modal(document.getElementById('gridGalleryModal'));
    myModal.show();
}
</script>
@endpush

@endsection