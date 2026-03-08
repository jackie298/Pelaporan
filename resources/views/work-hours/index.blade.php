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

    /* Hours badge */
    .badge-hours {
        border-radius: 20px;
        padding: 0.35rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 600;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Status dot indicator */
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.35rem;
    }
    .status-dot.active { background: #10b981; }
    .status-dot.warning { background: #f59e0b; }
    .status-dot.danger { background: #ef4444; }
</style>

<div class="main-content-wrapper">
    <!-- Header Section -->
    <div class="custom-header">
        <div class="d-md-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar bg-white rounded-circle p-2 shadow">
                    <i class="fas fa-clock text-primary fa-lg"></i>
                </div>
                <div>
                    <h4 class="text-white font-weight-bolder mb-0">Work Hours Management</h4>
                    <p class="text-white opacity-8 text-sm">Pantau dan kelola jam operasional peralatan</p>
                </div>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0">
                <a href="{{ route('api.export.jamkerja') }}" class="btn btn-white btn-round mb-0 shadow-sm">
                    <i class="fas fa-download text-primary me-2 text-xs"></i> Export
                </a>
                <a href="{{ route('admin.work-hours.create') }}" class="btn btn-white btn-round mb-0 shadow-sm">
                    <i class="fas fa-plus text-primary me-2 text-xs"></i> Tambah Jam Kerja
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row px-3 mb-4">
        @php
            $stats = [
                [
                    'label' => 'Total Records', 
                    'val' => $summaryStats['total'] ?? ($workHours->total() ?? 0), 
                    'icon' => 'fa-list', 
                    'bg' => 'bg-gradient-dark'
                ],
                [
                    'label' => 'Total Jam Operasional', 
                    'val' => number_format($summaryStats['total_hours'] ?? 0, 2) . ' Jam', 
                    'icon' => 'fa-stopwatch', 
                    'bg' => 'bg-gradient-primary'
                ],
                [
                    'label' => 'Rata-rata / Hari', 
                    'val' => number_format($summaryStats['avg_hours'] ?? 0, 1) . ' Jam', 
                    'icon' => 'fa-chart-line', 
                    'bg' => 'bg-gradient-info'
                ],
                [
                    'label' => 'Equipment Aktif', 
                    'val' => $summaryStats['active_equipment'] ?? 0, 
                    'icon' => 'fa-tools', 
                    'bg' => 'bg-gradient-success'
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
        <form action="{{ route('admin.work-hours') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-xs font-weight-bold">Cari Equipment</label>
                <div class="input-group shadow-none border-radius-sm">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 bg-light text-sm" 
                           placeholder="Nama atau kode alat..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-xs font-weight-bold">Tanggal Dari</label>
                <input type="date" name="tanggal_dari" class="form-control border-0 bg-light text-sm" 
                       value="{{ request('tanggal_dari') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-xs font-weight-bold">Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" class="form-control border-0 bg-light text-sm" 
                       value="{{ request('tanggal_sampai') }}">
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-round w-100 mb-0">Filter</button>
                <a href="{{ route('admin.work-hours') }}" class="btn btn-light btn-round mb-0" title="Reset">
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
                        <th class="text-uppercase font-weight-bolder">Tanggal</th>
                        <th class="text-center text-uppercase font-weight-bolder">Total Jam</th>
                        <th class="text-center text-uppercase font-weight-bolder d-none d-md-table-cell">Lokasi</th>
                        <th class="text-center text-uppercase font-weight-bolder d-none d-lg-table-cell">Aktivitas</th>
                        <th class="text-center text-uppercase font-weight-bolder">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($workHours as $wh)
                    <tr>
                        <!-- Equipment Info -->
                        <td class="ps-4">
                            <div class="d-flex flex-column">
                                <span class="text-sm font-weight-bold text-dark">
                                    {{ $wh->alat ? $wh->alat->nama : '—' }}
                                </span>
                                @if($wh->alat && $wh->alat->kode)
                                <span class="text-xxs text-primary">{{ $wh->alat->kode }}</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Date -->
                        <td>
                            <div class="d-flex flex-column text-xs">
                                <span class="font-weight-bold">
                                    <i class="far fa-calendar me-1 text-muted"></i>
                                    {{ $wh->tanggal ? $wh->tanggal->format('d M Y') : '—' }}
                                </span>
                                <span class="text-muted mt-1">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $wh->tanggal ? $wh->tanggal->format('H:i') : '' }}
                                </span>
                            </div>
                        </td>
                        
                        <!-- Total Hours -->
                        <td class="text-center">
                            <span class="badge badge-hours">
                                <i class="fas fa-stopwatch me-1 fa-xs"></i>
                                {{ number_format($wh->total_jam, 2) }}
                            </span>
                        </td>
                        
                        <!-- Location (Desktop) -->
                        <td class="text-center text-xs d-none d-md-table-cell">
                            <span class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ Str::limit($wh->lokasi ?? '-', 20) }}
                            </span>
                        </td>
                        
                        <!-- Activity (Desktop) -->
                        <td class="text-center text-xs d-none d-lg-table-cell">
                            <span class="text-muted">
                                {{ Str::limit($wh->aktivitas ?? '-', 25) }}
                            </span>
                        </td>
                        
                        <!-- Actions -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.work-hours.edit', $wh->id) }}" 
                                   class="action-link text-info" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <button type="button" class="action-link text-danger delete-btn" 
                                        data-id="{{ $wh->id }}" 
                                        data-nama="{{ $wh->alat ? $wh->alat->nama : 'Jam Kerja #' . $wh->id }}"
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
                                    <i class="fas fa-hourglass-half text-muted fa-lg"></i>
                                </div>
                                <h6 class="text-muted mb-1">Belum ada data jam kerja</h6>
                                <p class="text-xs text-muted mb-3">
                                    @if(request()->anyFilled(['search', 'tanggal_dari', 'tanggal_sampai']))
                                        Coba reset filter untuk melihat semua data
                                    @else
                                        Mulai catat jam kerja equipment untuk memantau operasional
                                    @endif
                                </p>
                                @if(request()->anyFilled(['search', 'tanggal_dari', 'tanggal_sampai']))
                                <a href="{{ route('admin.work-hours') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-filter-slash me-1"></i> Reset Filter
                                </a>
                                @else
                                <a href="{{ route('admin.work-hours.create') }}" class="btn btn-sm bg-gradient-primary">
                                    <i class="fas fa-plus me-1"></i> Tambah Jam Kerja
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
        @if(method_exists($workHours, 'hasPages') && $workHours->hasPages())
        <div class="card-footer py-3 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-xs text-secondary mb-0">
                    Showing {{ $workHours->firstItem() }} to {{ $workHours->lastItem() }} of {{ $workHours->total() }} entries
                </p>
                <div>
                    {{ $workHours->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- 🗑️ Modal Konfirmasi Hapus - Enhanced -->
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
                    Anda yakin ingin menghapus data jam kerja untuk <strong class="text-danger" id="equipmentName"></strong>? 
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
    
    // === DELETE MODAL ===
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (btn) {
            document.getElementById('equipmentName').textContent = btn.dataset.nama;
            document.getElementById('deleteForm').action = `/admin/work-hours/${btn.dataset.id}`;
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