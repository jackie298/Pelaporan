@extends('layouts.user_type.auth')

@section('content')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<style>
    /* ===== PERBAIKAN VISIBILITAS TEKS ===== */
    .gallery-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: linear-gradient(145deg, #1a1f33, #15192b);
        border: 2px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    .gallery-container:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
        border-color: rgba(45, 206, 137, 0.6);
    }

    /* Image Wrapper dengan Overlay Lebih Gelap */
    .gallery-image-wrapper {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: #0d1117;
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    /* Overlay gelap untuk kontras teks lebih baik */
    .gallery-image-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
        pointer-events: none;
    }

    .gallery-container:hover .gallery-img {
        transform: scale(1.08);
    }

    /* Photo Count Badge - Lebih Terlihat */
    .photo-count {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(0, 0, 0, 0.85);
        color: #fff !important;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }

    .photo-count i {
        color: #2dce89;
    }

    /* Hover Overlay Button */
    .hover-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .gallery-container:hover .hover-overlay {
        opacity: 1;
    }

    .btn-view {
        background: linear-gradient(135deg, #2dce89, #2dcecc);
        color: #082032 !important;
        padding: 12px 28px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(45, 206, 137, 0.5);
        transition: transform 0.2s;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-view:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(45, 206, 137, 0.7);
    }

    /* Content Area - Perbaikan Kontras */
    .gallery-content {
        padding: 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: linear-gradient(145deg, #1a1f33, #15192b);
    }

    /* Badge - Lebih Terlihat */
    .activity-badge {
        background: linear-gradient(135deg, #2dce89, #2dcecc);
        color: #082032 !important;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        align-self: flex-start;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(45, 206, 137, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Judul - Lebih Besar dan Bold */
    .gallery-title {
        color: #fff !important;
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.4;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Meta Information - Kontras Tinggi */
    .gallery-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #e0e0e0 !important;
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: auto;
        flex-wrap: wrap;
    }

    .gallery-meta i {
        color: #2dce89;
        font-size: 0.9rem;
    }

    .gallery-meta span {
        color: #f0f0f0 !important;
        font-weight: 500;
    }

    .meta-divider {
        color: rgba(255, 255, 255, 0.4);
        margin: 0 4px;
    }

    /* ===== FILTER CARD - Input Lebih Jelas ===== */
    .filter-card {
        background: rgba(26, 31, 51, 0.95);
        backdrop-filter: blur(12px);
        border-radius: 16px;
        border: 2px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .form-label {
        color: #fff !important;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .form-control {
        background: rgba(255, 255, 255, 0.15) !important;
        border: 2px solid rgba(255, 255, 255, 0.25) !important;
        color: #fff !important;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.2) !important;
        border-color: #2dce89 !important;
        box-shadow: 0 0 0 4px rgba(45, 206, 137, 0.2) !important;
        color: #fff !important;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);
        font-weight: 400;
    }

    .input-group-text {
        background: rgba(45, 206, 137, 0.2) !important;
        border: 2px solid rgba(255, 255, 255, 0.25) !important;
        border-right: none !important;
        color: #2dce89 !important;
        font-weight: 600;
    }

    /* Button Filter - Lebih Menonjol */
    .btn.bg-gradient-success {
        background: linear-gradient(135deg, #2dce89, #2dcecc) !important;
        border: none;
        color: #082032 !important;
        font-weight: 800;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.4);
        transition: all 0.2s;
    }

    .btn.bg-gradient-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 206, 137, 0.6);
    }

    .btn-outline-light {
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
        color: #fff;
    }

    /* ===== EMPTY STATE - Lebih Jelas ===== */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: rgba(26, 31, 51, 0.8);
        border-radius: 20px;
        border: 3px dashed rgba(255, 255, 255, 0.3);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: rgba(45, 206, 137, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: #2dce89;
        font-size: 2.5rem;
        border: 3px solid rgba(45, 206, 137, 0.3);
    }

    .empty-state h5 {
        color: #fff !important;
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 12px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .empty-state p {
        color: #d0d0d0 !important;
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 24px;
    }

    /* ===== MODAL - Perbaikan ===== */
    .modal-gallery-content {
        background: linear-gradient(145deg, #0a0e17, #111625) !important;
        border: 2px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 20px !important;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.7) !important;
    }

    .modal-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.15);
        padding: 20px 24px;
    }

    .modal-title {
        color: #fff !important;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .modal-split {
        display: grid;
        grid-template-columns: 1fr;
        max-height: 75vh;
    }

    @media (min-width: 768px) {
        .modal-split {
            grid-template-columns: 1.2fr 0.8fr;
        }
    }

    .modal-images-section {
        padding: 20px;
        border-right: 2px solid rgba(255, 255, 255, 0.1);
        overflow-y: auto;
        max-height: 75vh;
    }

    .modal-info-section {
        padding: 28px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: linear-gradient(145deg, rgba(45, 206, 137, 0.08), transparent);
    }

    .image-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 14px;
    }

    @media (min-width: 576px) {
        .image-grid-container {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }

    .grid-item {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        aspect-ratio: 1;
        cursor: zoom-in;
        border: 3px solid transparent;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.08);
    }

    .grid-item:hover {
        border-color: #2dce89;
        transform: scale(1.03);
        box-shadow: 0 8px 25px rgba(45, 206, 137, 0.4);
    }

    .grid-item-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .grid-item:hover .grid-item-img {
        transform: scale(1.1);
    }

    /* Info Cards - Kontras Tinggi */
    .info-card {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 14px;
        transition: all 0.2s;
    }

    .info-card:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(45, 206, 137, 0.5);
        transform: translateX(4px);
    }

    .label-green {
        color: #2dce89 !important;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 8px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .info-value {
        color: #fff !important;
        font-weight: 600;
        font-size: 1rem;
        line-height: 1.5;
    }

    .modal-footer-brand {
        border-top: 2px solid rgba(255, 255, 255, 0.15);
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }

    .brand-badge {
        color: #2dce89 !important;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* ===== PAGINATION - SANGAT KENTARA ===== */
.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 20px;
}

.pagination-container .pagination {
    display: flex;
    gap: 6px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.pagination-container .page-item {
    margin: 0;
}

/* Page Numbers - SANGAT TERLIHAT */
.pagination-container .page-item .page-link {
    background: linear-gradient(145deg, #2d3436, #1e272e) !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    color: #ffffff !important;
    padding: 10px 16px !important;
    margin: 0 !important;
    border-radius: 12px !important;
    font-weight: 700 !important;
    font-size: 0.95rem !important;
    text-align: center;
    min-width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
    text-decoration: none !important;
}

/* Hover State - Sangat Jelas */
.pagination-container .page-item:not(.disabled):not(.active):hover .page-link {
    background: linear-gradient(145deg, #2dce89, #2dcecc) !important;
    border-color: #2dce89 !important;
    color: #082032 !important;
    transform: translateY(-3px) scale(1.05) !important;
    box-shadow: 0 8px 20px rgba(45, 206, 137, 0.5) !important;
}

/* Active State - Paling Menonjol */
.pagination-container .page-item.active .page-link {
    background: linear-gradient(135deg, #2dce89, #2dcecc) !important;
    border: 3px solid rgba(255, 255, 255, 0.5) !important;
    color: #082032 !important;
    font-weight: 800 !important;
    font-size: 1.05rem !important;
    box-shadow: 0 6px 20px rgba(45, 206, 137, 0.6), 
                0 0 0 4px rgba(45, 206, 137, 0.3) !important;
    transform: scale(1.1);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 6px 20px rgba(45, 206, 137, 0.6), 0 0 0 0 rgba(45, 206, 137, 0.4); }
    50% { box-shadow: 0 6px 20px rgba(45, 206, 137, 0.6), 0 0 0 10px rgba(45, 206, 137, 0); }
}

/* Disabled State */
.pagination-container .page-item.disabled .page-link {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 2px solid rgba(255, 255, 255, 0.1) !important;
    color: rgba(255, 255, 255, 0.3) !important;
    cursor: not-allowed;
    box-shadow: none !important;
}

/* Previous/Next Buttons */
.pagination-container .page-item:first-child .page-link,
.pagination-container .page-item:last-child .page-link {
    background: linear-gradient(145deg, #3d4446, #2d3436) !important;
    font-weight: 700 !important;
}

.pagination-container .page-item:first-child .page-link:hover,
.pagination-container .page-item:last-child .page-link:hover {
    background: linear-gradient(145deg, #2dce89, #2dcecc) !important;
    color: #082032 !important;
}

/* Info Text - Lebih Jelas */
.card-footer .text-secondary {
    color: #e0e0e0 !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
}

.card-footer span[style*="color: #2dce89"] {
    color: #2dce89 !important;
    font-weight: 800 !important;
    text-shadow: 0 2px 4px rgba(45, 206, 137, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .pagination-container .page-item .page-link {
        padding: 8px 12px !important;
        min-width: 38px;
        height: 38px;
        font-size: 0.85rem !important;
    }
    
    .pagination-container {
        flex-wrap: wrap;
        gap: 6px;
    }
}

/* Dots/Ellipsis */
.pagination-container .page-item.disabled span {
    color: rgba(255, 255, 255, 0.5) !important;
    font-weight: 700;
    padding: 10px 8px;
}

    .card-footer {
        background: rgba(255, 255, 255, 0.05);
        border-top: 2px solid rgba(255, 255, 255, 0.1) !important;
    }

    .text-secondary {
        color: #d0d0d0 !important;
        font-weight: 500;
    }

    /* Scrollbar Styling */
    .scrollbar-thin::-webkit-scrollbar {
        width: 8px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgba(45, 206, 137, 0.5);
        border-radius: 10px;
        border: 2px solid transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(45, 206, 137, 0.8);
    }

    /* Text truncation yang lebih baik */
    .text-truncate-1 {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }
</style>

<div class="container-fluid py-4">
    {{-- Filter Card --}}
    <div class="card filter-card mb-4 shadow-sm border-0" style="background: #1a2035; border-radius: 16px;">
        <div class="card-body p-4">
            <form action="{{ route('dokumentasi-kegiatan.gallery') }}" method="GET" class="row g-3 align-items-end">
                
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <label class="form-label text-white-50 text-xs fw-bold mb-2">
                        <i class="fas fa-search me-1"></i> PENCARIAN
                    </label>
                    <div class="input-group shadow-none">
                        <span class="input-group-text bg-white border-0 ps-3">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                            name="search" 
                            class="form-control border-0 ps-2" 
                            placeholder="Cari judul atau kegiatan..." 
                            value="{{ request('search') }}"
                            style="height: 45px;">
                    </div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-12">
                    <label class="form-label text-white-50 text-xs fw-bold mb-2">
                        <i class="fas fa-calendar-alt me-1"></i> RENTANG TANGGAL
                    </label>
                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1">
                            <input type="date" 
                                name="tanggal_dari" 
                                class="form-control border-0 text-sm" 
                                value="{{ request('tanggal_dari') }}"
                                style="height: 45px;">
                        </div>
                        <span class="text-white-50 fw-bold">/</span>
                        <div class="flex-grow-1">
                            <input type="date" 
                                name="tanggal_sampai" 
                                class="form-control border-0 text-sm" 
                                value="{{ request('tanggal_sampai') }}"
                                style="height: 45px;">
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn bg-gradient-success w-100 mb-0 d-flex align-items-center justify-content-center fw-bold" style="height: 45px; border-radius: 10px;">
                        <i class="fas fa-filter me-2"></i> FILTER
                    </button>
                    <a href="{{ route('dokumentasi-kegiatan.gallery') }}" 
                    class="btn btn-outline-light mb-0 d-flex align-items-center justify-content-center px-3"
                    style="height: 45px; border-radius: 10px; border-color: rgba(255,255,255,0.2);"
                    data-bs-toggle="tooltip"
                    title="Reset Filter">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Gallery Grid --}}
    <div class="row g-4">
        @forelse ($dokumentasiData as $data)
            @php
                $files = $data->file_dokumentasi ?? [];
                $firstFile = $files[0] ?? null;
                $formattedDate = $data->tanggal?->format('d M Y') ?? '-';
                $photoCount = count($files);
            @endphp
            
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="gallery-container shadow-sm" 
                     onclick="openGridModal({{ json_encode($files) }}, '{{ addslashes($data->judul) }}', '{{ $data->jenis_kegiatan }}', '{{ $data->lokasi }}', '{{ $formattedDate }}')"
                     role="button"
                     tabindex="0"
                     onkeydown="if(event.key==='Enter'||event.key===' ')openGridModal({{ json_encode($files) }}, '{{ addslashes($data->judul) }}', '{{ $data->jenis_kegiatan }}', '{{ $data->lokasi }}', '{{ $formattedDate }}')"
                     aria-label="Lihat detail: {{ $data->judul }}">
                    
                    <div class="gallery-image-wrapper">
                        @if($firstFile)
                            <img src="{{ asset('storage/' . $firstFile) }}" 
                                 class="gallery-img" 
                                 alt="{{ $data->judul }} - Foto utama"
                                 loading="lazy">
                        @else
                            <div class="gallery-img d-flex align-items-center justify-content-center bg-dark">
                                <i class="fas fa-images fa-3x text-white opacity-50"></i>
                            </div>
                        @endif

                        <div class="hover-overlay">
                            <span class="btn-view">
                                <i class="fas fa-eye me-2"></i>LIHAT {{ $photoCount }} FOTO
                            </span>
                        </div>

                        @if($photoCount > 1)
                            <span class="photo-count">
                                <i class="fas fa-camera"></i>{{ $photoCount }}
                            </span>
                        @endif
                    </div>

                    <div class="gallery-content">
                        <span class="activity-badge">{{ $data->jenis_kegiatan }}</span>
                        <h6 class="gallery-title">{{ $data->judul }}</h6>
                        <div class="gallery-meta">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="text-truncate-1">{{ $data->lokasi }}</span>
                            <span class="meta-divider">•</span>
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $formattedDate }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h5 class="text-white mb-2">Tidak Ada Dokumentasi</h5>
                    <p class="text-secondary mb-4">Belum ada data dokumentasi yang sesuai dengan filter Anda.</p>
                    <a href="{{ route('dokumentasi-kegiatan.gallery') }}" class="btn bg-gradient-success">
                        <i class="fas fa-sync-alt me-2"></i>Reset Filter
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    {{-- Pagination --}}
<div class="card-footer py-4 border-0 mt-4" style="background: rgba(26, 31, 51, 0.8); border-top: 2px solid rgba(255, 255, 255, 0.15) !important; border-radius: 16px;">
    <div class="d-md-flex justify-content-between align-items-center">
        <p class="mb-3 mb-md-0" style="color: #e0e0e0 !important; font-weight: 600; font-size: 0.95rem;">
            Menampilkan 
            <span style="color: #2dce89 !important; font-weight: 800; font-size: 1.1rem; text-shadow: 0 2px 4px rgba(45, 206, 137, 0.4);">
                {{ $dokumentasiData->firstItem() ?? 0 }}
            </span>
            <span style="color: rgba(255,255,255,0.6);">-</span>
            <span style="color: #2dce89 !important; font-weight: 800; font-size: 1.1rem; text-shadow: 0 2px 4px rgba(45, 206, 137, 0.4);">
                {{ $dokumentasiData->lastItem() ?? 0 }}
            </span>
            <span style="color: rgba(255,255,255,0.6);">dari</span>
            <span style="color: #2dce89 !important; font-weight: 800; font-size: 1.1rem; text-shadow: 0 2px 4px rgba(45, 206, 137, 0.4);">
                {{ $dokumentasiData->total() }}
            </span>
            <span style="color: rgba(255,255,255,0.8);">data</span>
        </p>
        <div class="pagination-container">
            {{ $dokumentasiData->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</div>

{{-- Detail Modal --}}
<div class="modal fade" id="gridGalleryModal" tabindex="-1" aria-labelledby="modalGridLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-gallery-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="modalGridLabel">
                    <i class="fas fa-images me-2"></i>Detail Dokumentasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup modal"></button>
            </div>
            
            <div class="modal-split">
                {{-- Images Section --}}
                <div class="modal-images-section scrollbar-thin">
                    <div class="image-grid-container" id="modalGridContent">
                        {{-- Dynamic content via JS --}}
                    </div>
                </div>
                
                {{-- Info Section --}}
                <div class="modal-info-section">
                    <h3 class="text-white font-weight-bolder mb-4" id="modalGridJudul" style="font-size: 1.4rem;"></h3>
                    
                    <div class="info-card">
                        <span class="label-green">
                            <i class="fas fa-tag me-1"></i>Jenis Kegiatan
                        </span>
                        <span id="modalGridJenis" class="info-value"></span>
                    </div>
                    
                    <div class="info-card">
                        <span class="label-green">
                            <i class="fas fa-map-marker-alt me-1"></i>Lokasi
                        </span>
                        <span id="modalGridLokasi" class="info-value"></span>
                    </div>
                    
                    <div class="info-card">
                        <span class="label-green">
                            <i class="fas fa-calendar me-1"></i>Tanggal
                        </span>
                        <span id="modalGridTanggal" class="info-value"></span>
                    </div>

                    <div class="mt-auto pt-3">
                        <small class="text-secondary d-block mb-2" style="color: #d0d0d0 !important; font-weight: 600;">Total Foto</small>
                        <span class="badge bg-gradient-success py-2 px-3" id="modalGridCount" style="font-size: 0.95rem; font-weight: 700;">
                            <i class="fas fa-images me-2"></i><span id="modalGridCountValue">0</span> Foto
                        </span>
                    </div>
                </div>
            </div>

            <div class="modal-footer-brand">
                <small class="text-secondary" style="color: #d0d0d0 !important;">
                    <i class="fas fa-info-circle me-2"></i>Klik foto untuk memperbesar
                </small>
                <span class="brand-badge">PT NUSA KARYA ARINDO</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openGridModal(files, judul, jenis, lokasi, tanggal) {
    const gridContent = document.getElementById('modalGridContent');
    gridContent.innerHTML = '';
    
    const fragment = document.createDocumentFragment();
    
    if (files && files.length > 0) {
        files.forEach((file, index) => {
            const link = document.createElement('a');
            link.href = `/storage/${file}`;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            link.className = 'grid-item';
            link.setAttribute('aria-label', `Lihat foto ${index + 1}`);
            
            const img = document.createElement('img');
            img.src = `/storage/${file}`;
            img.className = 'grid-item-img';
            img.alt = `${judul} - Foto ${index + 1}`;
            img.loading = 'lazy';
            
            link.appendChild(img);
            fragment.appendChild(link);
        });
    } else {
        const emptyMsg = document.createElement('div');
        emptyMsg.className = 'w-100 text-center py-5';
        emptyMsg.innerHTML = `
            <div class="empty-icon mb-3" style="width: 80px; height: 80px; margin: 0 auto 20px;">
                <i class="fas fa-camera-slash"></i>
            </div>
            <p class="text-white mb-0" style="color: #fff !important; font-weight: 500;">Tidak ada foto tersedia</p>
        `;
        fragment.appendChild(emptyMsg);
    }
    
    gridContent.appendChild(fragment);

    document.getElementById('modalGridJudul').textContent = judul || '-';
    document.getElementById('modalGridJenis').textContent = jenis || '-';
    document.getElementById('modalGridLokasi').textContent = lokasi || '-';
    document.getElementById('modalGridTanggal').textContent = tanggal || '-';
    document.getElementById('modalGridCountValue').textContent = files?.length || 0;

    const modalEl = document.getElementById('gridGalleryModal');
    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush

@endsection