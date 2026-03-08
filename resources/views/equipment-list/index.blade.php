@extends('layouts.user_type.auth')

@section('content')
<style>
    /* ===== MODERN SOFT UI ENHANCEMENTS ===== */
    :root {
        --primary-gradient: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
        --surface-color: #f8f9fa;
    }

    .main-content-wrapper { padding: 1.5rem; }

    .custom-header {
        background: var(--primary-gradient);
        border-radius: 1rem;
        padding: 2.5rem 2rem 5rem 2rem;
        margin-bottom: -4rem;
        position: relative;
        box-shadow: 0 4px 20px 0 rgba(0,0,0,0.1);
    }

    .stat-card {
        border: none;
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        transition: transform 0.2s ease;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.07);
    }
    .stat-card:hover { transform: translateY(-5px); }
    
    .icon-box {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        color: #fff;
    }

    .filter-container {
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .custom-table-card {
        border-radius: 1rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        background: white;
    }

    .table thead th {
        background: #fbfbfb;
        padding: 1rem;
        font-size: 0.65rem;
        letter-spacing: 0.05rem;
        color: #8392ab;
        border-bottom: 1px solid #f0f2f5;
    }

    .btn-round { border-radius: 0.5rem; padding: 0.5rem 1.2rem; }
    
    .action-link {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        background: #f8f9fa;
        color: #67748e;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
    }
    .action-link:hover { 
        background: #e9ecef; 
        color: #344767;
        transform: scale(1.05);
    }

    /* Status badge variants */
    .badge-equipment {
        border-radius: 20px;
        padding: 0.35rem 0.75rem;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03rem;
    }
</style>

<div class="main-content-wrapper">
    <!-- Header Section -->
    <div class="custom-header">
        <div class="d-md-flex align-items-center justify-content-between">
            <div>
                <h4 class="text-white font-weight-bolder mb-0">Equipment Management</h4>
                <p class="text-white opacity-8 text-sm">Kelola inventaris peralatan dan alat berat secara terpusat.</p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0">
                <a href="{{ route('api.export.alat') }}" class="btn btn-white btn-round mb-0 shadow-sm">
                    <i class="fas fa-download text-primary me-2 text-xs"></i> Export
                </a>
                <a href="{{ route('admin.equipment-list.create') }}" class="btn btn-white btn-round mb-0 shadow-sm">
                    <i class="fas fa-plus text-primary me-2 text-xs"></i> New Equipment
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row px-3 mb-4">
        @php
            // ✅ Gunakan $summaryStats dari Controller (query terpisah, tanpa filter pagination)
            $stats = [
                [
                    'label' => 'Total Equipment', 
                    'val' => $summaryStats['total'] ?? 0, 
                    'icon' => 'fa-tools', 
                    'bg' => 'bg-gradient-dark'
                ],
                [
                    'label' => 'Tersedia', 
                    'val' => $summaryStats['tersedia'] ?? 0, 
                    'icon' => 'fa-check-circle', 
                    'bg' => 'bg-gradient-success'
                ],
                [
                    'label' => 'Sedang Dipakai', 
                    'val' => $summaryStats['dipakai'] ?? 0, 
                    'icon' => 'fa-user', 
                    'bg' => 'bg-gradient-info'
                ],
                [
                    'label' => 'Perawatan/Rusak', 
                    'val' => $summaryStats['maintenance'] ?? 0, 
                    'icon' => 'fa-wrench', 
                    'bg' => 'bg-gradient-warning'
                ]
            ];
        @endphp
        @foreach($stats as $s)
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box {{ $s['bg'] }} shadow text-center">
                            <i class="fas {{ $s['icon'] }} opacity-10"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-xs mb-0 text-uppercase font-weight-bold text-muted">{{ $s['label'] }}</p>
                            <h5 class="font-weight-bolder mb-0">{{ $s['val'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filter Section -->
    <div class="filter-container mx-3">
        <form action="{{ route('admin.equipment-list') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-xs font-weight-bold">Cari Equipment</label>
                <div class="input-group shadow-none border-radius-sm">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 bg-light text-sm" 
                           placeholder="Nama atau kode..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-xs font-weight-bold">Jenis Alat</label>
                <select name="jenis" class="form-select border-0 bg-light text-sm">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisList as $jenis)
                        <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-xs font-weight-bold">Status</label>
                <select name="status" class="form-select border-0 bg-light text-sm">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipakai" {{ request('status') == 'dipakai' ? 'selected' : '' }}>Dipakai</option>
                    <option value="perawatan" {{ request('status') == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                    <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-round w-100 mb-0">Filter</button>
                <a href="{{ route('admin.equipment-list') }}" class="btn btn-light btn-round mb-0" title="Reset">
                    <i class="fas fa-redo-alt"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="card custom-table-card mx-3">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase font-weight-bolder ps-4">Equipment</th>
                        <th class="text-uppercase font-weight-bolder">Kode & Jenis</th>
                        <th class="text-uppercase font-weight-bolder">Merk & Tahun</th>
                        <th class="text-center text-uppercase font-weight-bolder">Lokasi</th>
                        <th class="text-center text-uppercase font-weight-bolder">Status</th>
                        <th class="text-center text-uppercase font-weight-bolder">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($equipment as $item)
                    <tr>
                        <!-- Equipment Info -->
                        <td class="ps-4">
                            <div class="d-flex flex-column">
                                <span class="text-sm font-weight-bold text-dark">{{ $item->nama ?? '-' }}</span>
                                @if($item->catatan)
                                <span class="text-xxs text-muted">{{ Str::limit($item->catatan, 30) }}</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Code & Type -->
                        <td>
                            <div class="d-flex flex-column text-xs">
                                <span class="font-weight-bold text-primary">{{ $item->kode ?? '-' }}</span>
                                <span class="text-muted mt-1">
                                    <i class="fas fa-tag me-1"></i>{{ $item->jenis ?? '-' }}
                                </span>
                            </div>
                        </td>
                        
                        <!-- Brand & Year -->
                        <td>
                            <div class="d-flex flex-column text-xs">
                                <span><i class="fas fa-industry me-1 text-muted"></i>{{ $item->merk ?? '-' }}</span>
                                @if($item->tahun)
                                <span class="text-muted mt-1"><i class="far fa-calendar me-1"></i>{{ $item->tahun }}</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Location -->
                        <td class="text-center text-xs">
                            <span class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ Str::limit($item->lokasi_sekarang ?? '-', 15) }}
                            </span>
                        </td>
                        
                        <!-- Status Badge -->
                        <td class="text-center">
                            @php
                                $statusConfig = [
                                    'tersedia' => ['color' => 'success', 'label' => 'Tersedia'],
                                    'dipakai' => ['color' => 'info', 'label' => 'Dipakai'],
                                    'perawatan' => ['color' => 'warning', 'label' => 'Perawatan'],
                                    'rusak' => ['color' => 'danger', 'label' => 'Rusak'],
                                    'tidak_aktif' => ['color' => 'secondary', 'label' => 'Non-Aktif'],
                                ];
                                $config = $statusConfig[$item->status] ?? ['color' => 'secondary', 'label' => 'Unknown'];
                            @endphp
                            <span class="badge badge-equipment bg-gradient-{{ $config['color'] }} text-white">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        
                        <!-- Actions -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <!-- Detail Button -->
                                <button type="button" class="action-link text-primary detail-btn" 
                                        data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama }}"
                                        data-kode="{{ $item->kode }}"
                                        data-jenis="{{ $item->jenis }}"
                                        data-merk="{{ $item->merk ?? '-' }}"
                                        data-tahun="{{ $item->tahun ?? '-' }}"
                                        data-no_polisi="{{ $item->no_polisi ?? '-' }}"
                                        data-no_mesin="{{ $item->no_mesin ?? '-' }}"
                                        data-status="{{ ucfirst(str_replace('_', ' ', $item->status)) }}"
                                        data-lokasi="{{ $item->lokasi_sekarang ?? '-' }}"
                                        data-catatan="{{ $item->catatan ?? '-' }}"
                                        title="Lihat Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('admin.equipment-list.edit', $item->id) }}" 
                                   class="action-link text-info" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <button type="button" class="action-link text-danger delete-btn" 
                                        data-id="{{ $item->id }}" 
                                        data-nama="{{ $item->nama }}"
                                        title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar avatar-lg bg-light rounded-circle mb-3">
                                    <i class="fas fa-box-open text-muted fa-lg"></i>
                                </div>
                                <h6 class="text-muted mb-1">Tidak ada data equipment</h6>
                                <p class="text-xs text-muted mb-3">
                                    @if(request()->anyFilled(['search', 'jenis', 'status']))
                                        Coba reset filter untuk melihat semua data
                                    @else
                                        Mulai tambahkan equipment baru untuk mengelola inventaris
                                    @endif
                                </p>
                                @if(request()->anyFilled(['search', 'jenis', 'status']))
                                <a href="{{ route('admin.equipment-list') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-filter-slash me-1"></i> Reset Filter
                                </a>
                                @else
                                <a href="{{ route('admin.equipment-list.create') }}" class="btn btn-sm bg-gradient-primary">
                                    <i class="fas fa-plus me-1"></i> Tambah Equipment
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($equipment, 'hasPages') && $equipment->hasPages())
        <div class="card-footer py-3 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-xs text-secondary mb-0">
                    Showing {{ $equipment->firstItem() }} to {{ $equipment->lastItem() }} of {{ $equipment->total() }} entries
                </p>
                <div>
                    {{ $equipment->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- 🔍 Modal Detail Equipment -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title font-weight-bold">Detail Equipment</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Nama</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-nama"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Kode</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-kode"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Jenis</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-jenis"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Merk</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-merk"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Tahun</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-tahun"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">No. Polisi</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-no-polisi"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">No. Mesin</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-no-mesin"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Status</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-status"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Lokasi</small>
                            <p class="text-sm font-weight-bold mb-0 mt-1" id="detail-lokasi"></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted text-xs text-uppercase font-weight-bold">Catatan</small>
                            <p class="text-sm mb-0 mt-1" id="detail-catatan"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- 🗑️ Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title font-weight-bold">Konfirmasi Hapus</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <p class="text-sm mb-0">
                    Anda yakin ingin menghapus equipment <strong class="text-danger" id="equipmentName"></strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Toast Notification -->
@if(session('success') || session('error'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div class="toast align-items-center text-white {{ session('success') ? 'bg-success' : 'bg-danger' }} border-0 show" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas {{ session('success') ? 'fa-check-circle' : 'fa-exclamation-circle' }} me-2"></i>
                {{ session('success') ?? session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // === DETAIL MODAL ===
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.detail-btn');
        if (btn) {
            const fields = ['nama', 'kode', 'jenis', 'merk', 'tahun', 'no-polisi', 'no-mesin', 'status', 'lokasi', 'catatan'];
            fields.forEach(field => {
                const dataAttr = 'data-' + field.replace('-', '_');
                const value = btn.getAttribute(dataAttr) || '-';
                document.getElementById('detail-' + field).textContent = value;
            });
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    });

    // === DELETE MODAL ===
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (btn) {
            document.getElementById('equipmentName').textContent = btn.dataset.nama;
            document.getElementById('deleteForm').action = `/admin/equipment-list/${btn.dataset.id}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });

    // === AUTO-HIDE TOAST ===
    const toastElList = document.querySelectorAll('.toast');
    [...toastElList].map(toast => {
        const bsToast = bootstrap.Toast.getOrCreateInstance(toast, { delay: 5000 });
        bsToast.show();
    });
});
</script>
@endpush
@endsection