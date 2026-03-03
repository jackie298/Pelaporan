@extends('layouts.user_type.auth')

@section('content')

<style>
    /* CSS UNTUK LAYOUT GRID MULTIPLE FOTO */
    .nka-card {
        background: #fff;
        border: 2px solid #0d4435;
        border-radius: 12px;
        overflow: hidden;
        margin: auto;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .nka-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 4px;
        background-color: #eee;
        padding: 4px;
    }
    .nka-grid-container.single-photo { grid-template-columns: 1fr; }
    .nka-grid-item { position: relative; aspect-ratio: 4/3; overflow: hidden; background: #333; }
    .nka-grid-item img.main-img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .nka-logo-watermark { position: absolute; bottom: 8px; left: 8px; width: 50px; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5)); z-index: 10; }
    .nka-header-box { background-color: #0d4435; color: #ffffff; padding: 15px; border-top: 4px solid #c05c2e; }
    .nka-footer-label { color: #2ecc71; font-weight: bold; text-decoration: underline; font-size: 0.9rem; }
    .nka-info-text { font-size: 0.85rem; margin-bottom: 4px; line-height: 1.4; }

    /* CSS FILTER BAR */
    .filter-container {
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .custom-header {
        background: linear-gradient(310deg, #0d4435 0%, #1a6d56 100%);
        border-radius: 1rem;
        padding: 2rem 2rem 4rem 2rem;
        margin-bottom: -3.5rem;
        position: relative;
    }
    .btn-round { border-radius: 0.5rem; }

    /* PAGINATION STYLING */
    .pagination { margin-bottom: 0; gap: 5px; }
    .pagination .page-item .page-link {
        border-radius: 50% !important;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        border: none;
        color: #67748e;
    }
    .pagination .page-item.active .page-link {
        background-image: linear-gradient(310deg, #0d4435 0%, #1a6d56 100%);
        color: #fff;
        box-shadow: 0 3px 5px -1px rgba(0, 0, 0, .09), 0 2px 3px -1px rgba(0, 0, 0, .07);
    }
</style>

<div class="container-fluid py-4">
    <div class="custom-header mx-3">
        <div class="d-md-flex align-items-center justify-content-between">
            <div>
                <h4 class="text-white font-weight-bolder mb-0">Dokumentasi Kegiatan</h4>
                <p class="text-white opacity-8 text-sm">Manajemen arsip visual dan laporan kegiatan.</p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0">
                <a href="{{ route('api.export.dokumentasi-kegiatan') }}" class="btn btn-outline-white btn-sm btn-round mb-0">
                    <i class="fas fa-file-export me-2"></i> Export Data
                </a>
                <a href="{{ route('dokumentasi-kegiatan.create') }}" class="btn btn-white btn-sm btn-round mb-0 shadow-sm">
                    <i class="fas fa-plus text-primary me-2"></i> Tambah Kegiatan
                </a>
            </div>
        </div>
    </div>

    <div class="filter-container mx-3 mt-4">
        <form action="{{ route('dokumentasi-kegiatan') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-xs font-weight-bold">Cari Judul / Lokasi</label>
                <div class="input-group shadow-none border-radius-sm">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 bg-light text-sm" placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-5">
                <label class="form-label text-xs font-weight-bold">Rentang Tanggal</label>
                <div class="d-flex align-items-center">
                    <input type="date" name="tanggal_dari" class="form-control border-0 bg-light text-sm" value="{{ request('tanggal_dari') }}">
                    <span class="mx-2 text-muted text-xs">s/d</span>
                    <input type="date" name="tanggal_sampai" class="form-control border-0 bg-light text-sm" value="{{ request('tanggal_sampai') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-round w-100 mb-0">Filter</button>
                <a href="{{ route('dokumentasi-kegiatan') }}" class="btn btn-light btn-round mb-0">
                    <i class="fas fa-redo-alt"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="card mb-4 mx-3 shadow-sm border-0" style="border-radius: 1rem;">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kegiatan & Lokasi</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumentasi as $item)
                        <tr>
                            <td class="ps-4 text-xs font-weight-bold">
                                {{ ($dokumentasi->currentPage() - 1) * $dokumentasi->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0 text-sm">{{ $item->judul }}</h6>
                                    <p class="text-xs text-secondary mb-0"><i class="fas fa-map-marker-alt me-1"></i>{{ $item->lokasi }}</p>
                                </div>
                            </td>
                            <td class="text-center text-xs font-weight-bold">
                                {{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}
                            </td>
                            <td class="text-center">
                                <span class="badge badge-sm bg-gradient-info">
                                    {{ is_array($item->file_dokumentasi) ? count($item->file_dokumentasi) : 0 }} Item
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link text-primary btn-sm mb-0 detail-visual-btn"
                                    data-judul="{{ $item->judul }}"
                                    data-tanggal="{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}"
                                    data-lokasi="{{ $item->lokasi }}"
                                    data-jenis="{{ $item->jenis_kegiatan }}"
                                    data-fotos='@json($item->file_dokumentasi ?? [])'>
                                    <i class="fas fa-images me-1"></i> Visual
                                </button>
                                <button type="button" class="btn btn-link text-info btn-sm mb-0 detail-btn"
                                    data-judul="{{ $item->judul }}"
                                    data-tanggal="{{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}"
                                    data-lokasi="{{ $item->lokasi }}"
                                    data-jenis="{{ $item->jenis_kegiatan }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    data-pembuat="{{ $item->creator->name ?? 'Admin' }}">
                                    <i class="fas fa-info-circle"></i> Detail
                                </button>
                                <a href="{{ route('dokumentasi-kegiatan.edit', $item->id) }}" class="mx-2"><i class="fas fa-edit text-dark"></i></a>
                                <button type="button" class="border-0 bg-transparent delete-btn" data-id="{{ $item->id }}" data-nama="{{ $item->judul }}">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-3 border-0 bg-transparent">
            <div class="d-md-flex justify-content-between align-items-center">
                <p class="text-xs text-secondary font-weight-bold mb-3 mb-md-0">
                    Menampilkan {{ $dokumentasi->firstItem() ?? 0 }} sampai {{ $dokumentasi->lastItem() ?? 0 }} dari {{ $dokumentasi->total() }} data
                </p>
                <div class="pagination-container">
                    {{ $dokumentasi->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5>Detail Informasi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <p><strong>Judul:</strong> <span id="detail-judul"></span></p>
                <p><strong>Tanggal:</strong> <span id="detail-tanggal"></span></p>
                <p><strong>Lokasi:</strong> <span id="detail-lokasi"></span></p>
                <p><strong>Jenis:</strong> <span id="detail-jenis"></span></p>
                <p><strong>Deskripsi:</strong> <span id="detail-deskripsi"></span></p>
                <p><strong>Pembuat:</strong> <span id="detail-pembuat"></span></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailKegiatanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div class="nka-card" id="visual-content-area">
                    <div id="photo-grid" class="nka-grid-container"></div>
                    <div class="nka-header-box">
                        <h6 id="v-judul" class="text-white text-uppercase mb-2" style="font-weight: 800; letter-spacing: 1px;"></h6>
                        <p class="nka-info-text"><span class="nka-footer-label">Unit / Jenis:</span> <span id="v-jenis" class="ms-1"></span></p>
                        <p class="nka-info-text"><span class="nka-footer-label">Lokasi:</span> <span id="v-lokasi" class="ms-1"></span></p>
                        <div class="d-flex justify-content-between mt-3 opacity-8" style="font-size: 0.7rem;">
                            <span id="v-tanggal"></span>
                            <span>PT NUSA KARYA ARINDO</span>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3"><button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Tutup</button></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body text-center">
                    <h5 class="mt-3">Hapus Data?</h5>
                    <p>Anda akan menghapus: <strong id="equipmentName"></strong></p>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5>Berhasil!</h5>
                <p>{{ session('success') }}</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === 1. DETAIL TEXT ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-btn')) {
            const btn = e.target.closest('.detail-btn');
            document.getElementById('detail-judul').textContent = btn.getAttribute('data-judul');
            document.getElementById('detail-tanggal').textContent = btn.getAttribute('data-tanggal');
            document.getElementById('detail-lokasi').textContent = btn.getAttribute('data-lokasi');
            document.getElementById('detail-jenis').textContent = btn.getAttribute('data-jenis');
            document.getElementById('detail-deskripsi').textContent = btn.getAttribute('data-deskripsi');
            document.getElementById('detail-pembuat').textContent = btn.getAttribute('data-pembuat');
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    });

    // === 2. DETAIL VISUAL ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-visual-btn')) {
            const btn = e.target.closest('.detail-visual-btn');
            const fotos = JSON.parse(btn.getAttribute('data-fotos'));
            document.getElementById('v-judul').textContent = btn.getAttribute('data-judul');
            document.getElementById('v-jenis').textContent = btn.getAttribute('data-jenis');
            document.getElementById('v-lokasi').textContent = btn.getAttribute('data-lokasi');
            document.getElementById('v-tanggal').textContent = "📅 " + btn.getAttribute('data-tanggal');
            const grid = document.getElementById('photo-grid');
            grid.innerHTML = ''; 
            
            if(fotos.length === 1) grid.classList.add('single-photo'); else grid.classList.remove('single-photo');
            
            if(fotos.length > 0) {
                fotos.forEach(path => {
                    grid.innerHTML += `<div class="nka-grid-item">
                        <img src="/storage/${path}" class="main-img">
                        <img src="{{ asset('assets/img/logoperusahaan.png') }}" class="nka-logo-watermark">
                    </div>`;
                });
            } else { 
                grid.innerHTML = '<div class="p-4 text-center w-100">Tidak ada foto dokumentasi.</div>'; 
            }
            new bootstrap.Modal(document.getElementById('detailKegiatanModal')).show();
        }
    });

    // === 3. DELETE ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            document.getElementById('equipmentName').textContent = btn.getAttribute('data-nama');
            document.getElementById('deleteForm').action = '/dokumentasi-kegiatan/' + btn.getAttribute('data-id');
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });

    // === 4. SUCCESS MODAL ===
    @if(session('success'))
        new bootstrap.Modal(document.getElementById('successModal')).show();
    @endif
});
</script>
@endpush

@endsection