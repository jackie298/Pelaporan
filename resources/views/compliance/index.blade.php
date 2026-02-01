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
    
    /* Container Grid ala Gallery */
    .nka-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 4px;
        background-color: #eee;
        padding: 4px;
    }

    /* Jika foto cuma 1, buat ukurannya besar */
    .nka-grid-container.single-photo {
        grid-template-columns: 1fr;
    }

    .nka-grid-item {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #333;
    }

    .nka-grid-item img.main-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Agar foto rapi di dalam grid */
        display: block;
    }

    .nka-logo-watermark {
        position: absolute;
        bottom: 8px;
        left: 8px;
        width: 50px;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5));
        z-index: 10;
    }

    .nka-header-box {
        background-color: #0d4435;
        color: #ffffff;
        padding: 15px;
        border-top: 4px solid #c05c2e;
    }

    .nka-footer-label {
        color: #2ecc71;
        font-weight: bold;
        text-decoration: underline;
        font-size: 0.9rem;
    }

    .nka-info-text {
        font-size: 0.85rem;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    /* Badge Status Colors */
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-escalated { background: #dc3545; color: white; }
    .status-pending { background: #ffc107; color: #212529; }
    .status-resolved { background: #198754; color: white; }
    .status-open { background: #0dcaf0; color: white; }

    /* Badge Severity Colors */
    .severity-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .severity-low { background: #198754; color: white; }
    .severity-medium { background: #ffc107; color: #212529; }
    .severity-high { background: #dc3545; color: white; }
    .severity-critical { background: #212529; color: white; }
</style>

<div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
    <span class="text-white">
        <strong>Dokumen Compliance</strong>
    </span>
    <a class="btn bg-gradient-secondary btn-sm mb-0" href="{{ route('api.export.compliance') }}">Export Data</a>
</div>

<div class="container-fluid py-4">
    <div class="card mb-4">
        <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div><h5 class="mb-0">Dokumen Compliance</h5></div>
                <a href="{{ route('compliance.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah</a>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pelapor</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Departemen</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tingkat Keparahan</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dokumen</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compliances as $item)
                        <tr>
                            <td class="ps-4 text-xs font-weight-bold">{{ $loop->iteration }}</td>
                            <td class="text-xs font-weight-bold">{{ $item->Nama_pelapor }}</td>
                            <td class="text-xs font-weight-bold">{{ $item->Departemen }}</td>
                            <td class="text-xs font-weight-bold">{{ $item->Lokasi }}</td>
                            <td class="text-center">
                                <span class="status-badge 
                                    @if($item->Status === 'Escalated') status-escalated
                                    @elseif($item->Status === 'Pending') status-pending
                                    @elseif($item->Status === 'Resolved') status-resolved
                                    @elseif($item->Status === 'Open') status-open
                                    @else bg-secondary text-white @endif">
                                    {{ $item->Status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="severity-badge 
                                    @if($item->Tingkat_keparahan === 'Low') severity-low
                                    @elseif($item->Tingkat_keparahan === 'Medium') severity-medium
                                    @elseif($item->Tingkat_keparahan === 'High') severity-high
                                    @elseif($item->Tingkat_keparahan === 'Critical') severity-critical
                                    @else bg-secondary text-white @endif">
                                    {{ $item->Tingkat_keparahan }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->file_dokumentasi && is_array($item->file_dokumentasi) && count($item->file_dokumentasi) > 0)
                                    <span class="badge badge-sm bg-gradient-info">
                                        <i class="fas fa-images"></i> {{ count($item->file_dokumentasi) }} File
                                    </span>
                                @else
                                    <span class="badge badge-sm bg-gradient-secondary">
                                        <i class="fas fa-times"></i> Tidak Ada
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->file_dokumentasi && is_array($item->file_dokumentasi) && count($item->file_dokumentasi) > 0)
                                <button type="button" class="btn btn-link text-primary btn-sm mb-0 detail-visual-btn"
                                    data-nama="{{ $item->Nama_pelapor }}"
                                    data-departemen="{{ $item->Departemen }}"
                                    data-lokasi="{{ $item->Lokasi }}"
                                    data-jenis-insiden="{{ $item->Jenis_insiden }}"
                                    data-jenis-inspeksi="{{ $item->Jenis_inspeksi }}"
                                    data-tanggal="{{ $item->Tanggal_lapor ? \Carbon\Carbon::parse($item->Tanggal_lapor)->format('d/m/Y') : '-' }}"
                                    data-status="{{ $item->Status }}"
                                    data-tingkat="{{ $item->Tingkat_keparahan }}"
                                    data-diselesaikan="{{ $item->Diselesaikan_oleh }}"
                                    data-fotos='@json($item->file_dokumentasi)'>
                                    <i class="fas fa-images me-1"></i> Visual
                                </button>
                                @endif

                                <button type="button" class="btn btn-link text-info btn-sm mb-0 detail-btn"
                                    data-nama="{{ $item->Nama_pelapor }}"
                                    data-departemen="{{ $item->Departemen }}"
                                    data-lokasi="{{ $item->Lokasi }}"
                                    data-jenis-insiden="{{ $item->Jenis_insiden }}"
                                    data-jenis-inspeksi="{{ $item->Jenis_inspeksi }}"
                                    data-tanggal="{{ $item->Tanggal_lapor ? \Carbon\Carbon::parse($item->Tanggal_lapor)->format('d M Y') : '-' }}"
                                    data-status="{{ $item->Status }}"
                                    data-tingkat="{{ $item->Tingkat_keparahan }}"
                                    data-diselesaikan="{{ $item->Diselesaikan_oleh }}">
                                    <i class="fas fa-info-circle"></i> Detail
                                </button>

                                <a href="{{ route('compliance.edit', $item->id) }}" class="mx-2" title="Edit">
                                    <i class="fas fa-edit text-dark"></i>
                                </a>

                                <button type="button" class="border-0 bg-transparent delete-btn" 
                                    data-id="{{ $item->id }}" 
                                    data-nama="{{ $item->Nama_pelapor }}"
                                    title="Hapus">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Text -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Informasi Compliance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Pelapor:</strong> <span id="detail-nama"></span></p>
                <p><strong>Departemen:</strong> <span id="detail-departemen"></span></p>
                <p><strong>Lokasi:</strong> <span id="detail-lokasi"></span></p>
                <p><strong>Jenis Insiden:</strong> <span id="detail-jenis-insiden"></span></p>
                <p><strong>Jenis Inspeksi:</strong> <span id="detail-jenis-inspeksi"></span></p>
                <p><strong>Tanggal Lapor:</strong> <span id="detail-tanggal"></span></p>
                <p><strong>Status:</strong> <span id="detail-status"></span></p>
                <p><strong>Tingkat Keparahan:</strong> <span id="detail-tingkat"></span></p>
                <p><strong>Diselesaikan Oleh:</strong> <span id="detail-diselesaikan"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Visual Dokumen -->
<div class="modal fade" id="detailKegiatanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div class="nka-card" id="visual-content-area">
                    <div id="photo-grid" class="nka-grid-container">
                        <!-- Photos will be inserted here dynamically -->
                    </div>
                    
                    <div class="nka-header-box">
                        <h6 id="v-nama" class="text-white text-uppercase mb-2" style="font-weight: 800; letter-spacing: 1px;"></h6>
                        <p class="nka-info-text"><span class="nka-footer-label">Departemen:</span> <span id="v-departemen" class="ms-1"></span></p>
                        <p class="nka-info-text"><span class="nka-footer-label">Lokasi:</span> <span id="v-lokasi" class="ms-1"></span></p>
                        <p class="nka-info-text"><span class="nka-footer-label">Jenis Insiden:</span> <span id="v-jenis-insiden" class="ms-1"></span></p>
                        <p class="nka-info-text"><span class="nka-footer-label">Jenis Inspeksi:</span> <span id="v-jenis-inspeksi" class="ms-1"></span></p>
                        <div class="d-flex justify-content-between mt-3 opacity-8" style="font-size: 0.7rem;">
                            <span id="v-tanggal"></span>
                            <span>PT NUSA KARYA ARINDO</span>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body text-center">
                    <h5 class="mt-3">Hapus Data?</h5>
                    <p>Anda akan menghapus dokumen compliance dari: <strong id="equipmentName"></strong></p>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="mt-3">Berhasil!</h5>
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
            document.getElementById('detail-nama').textContent = btn.getAttribute('data-nama');
            document.getElementById('detail-departemen').textContent = btn.getAttribute('data-departemen');
            document.getElementById('detail-lokasi').textContent = btn.getAttribute('data-lokasi');
            document.getElementById('detail-jenis-insiden').textContent = btn.getAttribute('data-jenis-insiden');
            document.getElementById('detail-jenis-inspeksi').textContent = btn.getAttribute('data-jenis-inspeksi');
            document.getElementById('detail-tanggal').textContent = btn.getAttribute('data-tanggal');
            document.getElementById('detail-status').textContent = btn.getAttribute('data-status');
            document.getElementById('detail-tingkat').textContent = btn.getAttribute('data-tingkat');
            document.getElementById('detail-diselesaikan').textContent = btn.getAttribute('data-diselesaikan');
            
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    });

    // === 2. DETAIL VISUAL (MULTIPLE FOTO GRID) ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-visual-btn')) {
            const btn = e.target.closest('.detail-visual-btn');
            const fotos = JSON.parse(btn.getAttribute('data-fotos')); // Parse JSON array
            
            // Set Text
            document.getElementById('v-nama').textContent = "Pelapor: " + btn.getAttribute('data-nama');
            document.getElementById('v-departemen').textContent = btn.getAttribute('data-departemen');
            document.getElementById('v-lokasi').textContent = btn.getAttribute('data-lokasi');
            document.getElementById('v-jenis-insiden').textContent = btn.getAttribute('data-jenis-insiden');
            document.getElementById('v-jenis-inspeksi').textContent = btn.getAttribute('data-jenis-inspeksi');
            document.getElementById('v-tanggal').textContent = "📅 " + btn.getAttribute('data-tanggal');

            // Render Grid Foto
            const grid = document.getElementById('photo-grid');
            grid.innerHTML = ''; // Reset grid
            
            // Atur class jika foto cuma 1 agar lebar penuh
            if(fotos.length === 1) {
                grid.classList.add('single-photo');
            } else {
                grid.classList.remove('single-photo');
            }

            if(fotos.length > 0) {
                fotos.forEach(path => {
                    const ext = path.split('.').pop().toLowerCase();
                    if(['jpg', 'jpeg', 'png'].includes(ext)) {
                        // Gambar
                        grid.innerHTML += `
                            <div class="nka-grid-item">
                                <img src="/storage/${path}" class="main-img" onerror="this.src='{{ asset('assets/img/default-image.png') }}'">
                                <img src="{{ asset('assets/img/logoperusahaan.png') }}" class="nka-logo-watermark">
                            </div>
                        `;
                    } else if(ext === 'pdf') {
                        // PDF
                        grid.innerHTML += `
                            <div class="nka-grid-item">
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 100%;">
                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                </div>
                                <img src="{{ asset('assets/img/logoperusahaan.png') }}" class="nka-logo-watermark">
                            </div>
                        `;
                    } else {
                        // File lainnya
                        grid.innerHTML += `
                            <div class="nka-grid-item">
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 100%;">
                                    <i class="fas fa-file fa-4x text-muted"></i>
                                </div>
                                <img src="{{ asset('assets/img/logoperusahaan.png') }}" class="nka-logo-watermark">
                            </div>
                        `;
                    }
                });
            } else {
                grid.innerHTML = '<div class="p-4 text-center w-100">Tidak ada dokumen.</div>';
            }

            new bootstrap.Modal(document.getElementById('detailKegiatanModal')).show();
        }
    });

    // === 3. DELETE ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            document.getElementById('equipmentName').textContent = btn.getAttribute('data-nama');
            document.getElementById('deleteForm').action = '/compliance/' + btn.getAttribute('data-id');
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });

    // === 4. SUCCESS MODAL ===
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif
});
</script>
@endpush

@endsection