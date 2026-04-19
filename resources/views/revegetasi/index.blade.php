@extends('layouts.user_type.auth')

@section('content')

<style>
    /* ===== THEME VARIABLES (Consistent with Reference) ===== */
    :root {
        --primary-gradient: linear-gradient(135deg, #2dce89, #2dcecc);
        --info-gradient: linear-gradient(135deg, #1171ef, #0dcaf0);
        --danger-gradient: linear-gradient(135deg, #f5365c, #ec3368);
        --warning-gradient: linear-gradient(135deg, #fb6340, #fbb140);
        --secondary-gradient: linear-gradient(135deg, #67748e, #8392ab);
        --card-bg: #ffffff;
        --text-primary: #344767;
        --text-secondary: #67748e;
        --border-color: rgba(0, 0, 0, 0.1);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.12);
        --radius: 16px;
        --radius-sm: 12px;
    }

    /* ===== GLOBAL READABILITY ===== */
    .filter-card, .data-card, .table-custom, .card-body, .card-header, .card-footer {
        color: var(--text-primary) !important;
    }
    .filter-card *, .data-card *, .table-custom * { color: inherit; }

    /* ===== ALERT BAR ===== */
    .alert-bar {
        background: var(--info-gradient);
        border: none;
        border-radius: var(--radius);
        padding: 14px 20px;
        margin: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }
    .alert-bar::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        pointer-events: none;
    }
    .alert-bar .text-white {
        position: relative; z-index: 1; font-weight: 600; font-size: 0.95rem;
        display: flex; align-items: center; gap: 8px; color: #fff !important;
    }
    .alert-bar .btn {
        position: relative; z-index: 1; border: none; font-weight: 600;
        padding: 8px 16px; border-radius: 10px; transition: all 0.2s;
        background: rgba(255, 255, 255, 0.95); color: #344767 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .alert-bar .btn:hover {
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2); background: #fff;
    }

    /* ===== FILTER CARD ===== */
    .filter-card {
        background: var(--card-bg); border-radius: var(--radius);
        border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);
        margin: 0 16px 20px; transition: box-shadow 0.3s ease;
    }
    .filter-card:hover { box-shadow: var(--shadow-md); }
    .filter-card .card-body { padding: 20px; }
    .filter-card .form-label {
        color: #344767 !important; font-weight: 700; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 6px;
        display: flex; align-items: center; gap: 4px;
    }
    .filter-card .form-label i { color: #1171ef; font-size: 0.8rem; }
    .filter-card .form-select, .filter-card .form-control {
        background: #f8f9fa; border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 10px; padding: 10px 14px; font-size: 0.9rem;
        color: #344767 !important; font-weight: 500; transition: all 0.2s;
    }
    .filter-card .form-select:focus, .filter-card .form-control:focus {
        background: #fff; border-color: #1171ef;
        box-shadow: 0 0 0 4px rgba(17, 113, 239, 0.15); outline: none; color: #344767 !important;
    }
    .filter-card .btn {
        border-radius: 10px; font-weight: 600; padding: 10px 16px;
        font-size: 0.85rem; transition: all 0.2s; border: none; color: #fff !important;
    }
    .filter-card .btn.bg-gradient-info {
        background: var(--info-gradient); box-shadow: 0 4px 12px rgba(17, 113, 239, 0.3);
    }
    .filter-card .btn.bg-gradient-info:hover {
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(17, 113, 239, 0.45);
    }
    .filter-card .btn-outline-secondary {
        border: 2px solid var(--border-color); color: #67748e !important; background: transparent;
    }
    .filter-card .btn-outline-secondary:hover {
        background: #f8f9fa; border-color: #67748e; color: #344767 !important;
    }

    /* ===== DATA CARD ===== */
    .data-card {
        background: var(--card-bg); border-radius: var(--radius);
        border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);
        margin: 0 16px 20px; overflow: hidden; color: #344767 !important;
    }
    .data-card .card-header {
        background: transparent; border-bottom: 1px solid var(--border-color);
        padding: 20px 24px; display: flex; flex-wrap: wrap; gap: 12px;
        align-items: center; color: #344767 !important;
    }
    .data-card .card-header h5 {
        color: #344767 !important; font-weight: 700; font-size: 1.1rem;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .data-card .card-header h5 i { color: #1171ef; }
    .data-card .card-header .filter-badge {
        background: rgba(17, 113, 239, 0.1); color: #1171ef !important;
        padding: 4px 10px; border-radius: 20px; font-size: 0.7rem;
        font-weight: 600; margin-left: 8px;
    }
    .data-card .btn.bg-gradient-primary {
        background: var(--primary-gradient); border: none; border-radius: 10px;
        padding: 10px 20px; font-weight: 600; font-size: 0.85rem;
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3); transition: all 0.2s;
        display: flex; align-items: center; gap: 6px; color: #fff !important;
    }
    .data-card .btn.bg-gradient-primary:hover {
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(45, 206, 137, 0.45);
    }

    /* ===== TABLE STYLING ===== */
    .table-container { padding: 0 24px 24px; color: #344767 !important; }
    .table-custom {
        width: 100%; border-collapse: separate; border-spacing: 0; color: #344767 !important;
    }
    .table-custom thead th {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #67748e !important; font-weight: 700; font-size: 0.7rem;
        text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;
        border-bottom: 2px solid var(--border-color); white-space: nowrap;
    }
    .table-custom thead th:first-child { border-radius: 12px 0 0 0; padding-left: 20px; }
    .table-custom thead th:last-child { border-radius: 0 12px 0 0; padding-right: 20px; }
    .table-custom tbody tr {
        transition: all 0.2s ease; border-bottom: 1px solid rgba(0, 0, 0, 0.05); color: #344767 !important;
    }
    .table-custom tbody tr:hover {
        background: rgba(17, 113, 239, 0.04); transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    .table-custom tbody tr:last-child { border-bottom: none; }
    .table-custom td {
        padding: 14px 16px; vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); color: #344767 !important;
    }
    .table-custom td:first-child { padding-left: 20px; border-radius: 12px 0 0 12px; }
    .table-custom td:last-child { padding-right: 20px; border-radius: 0 12px 12px 0; }

    .table-custom .row-number {
        background: rgba(17, 113, 239, 0.1); color: #1171ef !important;
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.8rem;
    }
    .table-custom .location-info h6 {
        color: #344767 !important; font-weight: 600; font-size: 0.9rem; margin: 0 0 4px;
    }
    .table-custom .success-badge {
        padding: 6px 14px; border-radius: 20px; font-size: 0.75rem;
        font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .table-custom .success-badge.bg-success {
        background: rgba(45, 206, 137, 0.15) !important; color: #2dce89 !important;
    }
    .table-custom .success-badge.bg-warning {
        background: rgba(251, 99, 64, 0.15) !important; color: #fb6340 !important;
    }
    .table-custom .success-badge.bg-danger {
        background: rgba(245, 54, 92, 0.15) !important; color: #f5365c !important;
    }
    .table-custom .success-badge i { font-size: 0.7rem; }

    .table-custom .action-btns { display: flex; align-items: center; justify-content: center; gap: 8px; }
    .table-custom .action-btn {
        width: 34px; height: 34px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s; text-decoration: none; border: none;
        background: transparent; cursor: pointer;
    }
    .table-custom .action-btn.edit { color: #1171ef !important; background: rgba(17, 113, 239, 0.1); }
    .table-custom .action-btn.edit:hover { background: #1171ef; color: #fff !important; transform: scale(1.1); }
    .table-custom .action-btn.delete { color: #f5365c !important; background: rgba(245, 54, 92, 0.1); }
    .table-custom .action-btn.delete:hover { background: #f5365c; color: #fff !important; transform: scale(1.1); }
    .table-custom .action-btn i { font-size: 0.9rem; }

    /* ===== EMPTY STATE ===== */
    .empty-state { text-align: center; padding: 60px 20px; color: #67748e !important; }
    .empty-state i { font-size: 3rem; color: rgba(17, 113, 239, 0.3); margin-bottom: 16px; display: block; }
    .empty-state p { font-size: 1rem; font-weight: 500; margin: 0; color: #67748e !important; }

    /* ===== PAGINATION ===== */
    .card-footer {
        background: transparent; border-top: 1px solid var(--border-color);
        padding: 16px 24px; color: #67748e !important;
    }
    .card-footer .text-secondary { color: #67748e !important; font-weight: 600; font-size: 0.85rem; }
    .pagination-container .pagination { gap: 4px; margin: 0; }
    .pagination-container .page-item .page-link {
        background: #f8f9fa; border: 2px solid var(--border-color);
        color: #344767 !important; padding: 8px 14px; border-radius: 10px;
        font-weight: 600; font-size: 0.85rem; margin: 0; transition: all 0.2s;
    }
    .pagination-container .page-item.active .page-link {
        background: var(--primary-gradient); border-color: transparent;
        color: #fff !important; box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
    }
    .pagination-container .page-item:hover:not(.active):not(.disabled) .page-link {
        background: #1171ef; border-color: #1171ef; color: #fff !important; transform: translateY(-2px);
    }
    .pagination-container .page-item.disabled .page-link {
        opacity: 0.4; cursor: not-allowed; color: #67748e !important;
    }

    /* ===== MODAL STYLING ===== */
    .modal-content { border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); }
    .modal-header.bg-danger {
        background: var(--danger-gradient) !important; border-radius: 20px 20px 0 0; border: none; padding: 18px 24px;
    }
    .modal-header.bg-success {
        background: var(--primary-gradient) !important; border-radius: 20px 20px 0 0; border: none; padding: 18px 24px;
    }
    .modal-title { font-weight: 700; font-size: 1.1rem; color: #fff !important; }
    .modal-body { padding: 24px; text-align: center; color: #344767 !important; }
    .modal-body p { color: #344767 !important; font-size: 1rem; line-height: 1.6; }
    .modal-body .text-muted { color: #67748e !important; font-size: 0.9rem; }
    .modal-footer { border-top: 1px solid var(--border-color); padding: 16px 24px; gap: 10px; }
    .modal-footer .btn {
        padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 0.9rem;
        border: none; transition: all 0.2s; color: #fff !important;
    }
    .modal-footer .btn-secondary { background: #e9ecef; color: #344767 !important; }
    .modal-footer .btn-secondary:hover { background: #dee2e6; transform: translateY(-2px); }
    .modal-footer .btn-danger {
        background: var(--danger-gradient); box-shadow: 0 4px 12px rgba(245, 54, 92, 0.3);
    }
    .modal-footer .btn-danger:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245, 54, 92, 0.45); }
    .modal-footer .btn-success {
        background: var(--primary-gradient); box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
    }
    .modal-footer .btn-success:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(45, 206, 137, 0.45); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
        .alert-bar { flex-direction: column; gap: 12px; text-align: center; }
        .data-card .card-header { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 767px) {
        .alert-bar, .filter-card, .data-card { margin-left: 12px; margin-right: 12px; }
        .table-container { padding: 0 12px 12px; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table-custom { min-width: 800px; }
        .card-footer .d-md-flex { flex-direction: column; gap: 12px; text-align: center; }
    }
    @media (max-width: 575px) {
        .filter-card .col-md-3, .filter-card .col-md-2 { flex: 0 0 100%; max-width: 100%; }
        .filter-card .d-flex.gap-2 { flex-direction: column; }
        .filter-card .btn { width: 100%; }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .table-custom tbody tr { animation: fadeIn 0.3s ease forwards; }
    .table-custom tbody tr:nth-child(1) { animation-delay: 0.05s; }
    .table-custom tbody tr:nth-child(2) { animation-delay: 0.1s; }
    .table-custom tbody tr:nth-child(3) { animation-delay: 0.15s; }
    .table-custom tbody tr:nth-child(4) { animation-delay: 0.2s; }
    .table-custom tbody tr:nth-child(5) { animation-delay: 0.25s; }
</style>

<div>
    {{-- Alert Bar --}}
    <div class="alert-bar">
        <span class="text-white">
            <i class="fas fa-seedling"></i>
            <strong>Revegetasi</strong>
        </span>
        <div class="d-flex gap-2">
            <a class="btn" href="{{ route('api.export.revegetasi', request()->query()) }}">
                <i class="fas fa-file-excel me-1"></i> Export Data
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('revegetasi') }}" class="row g-3 align-items-end">
                <div class="col-md-4 col-6">
                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Lokasi</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari lokasi..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label"><i class="fas fa-chart-line"></i> Keberhasilan</label>
                    <select name="keberhasilan" class="form-select">
                        <option value="">Semua Tingkat</option>
                        <option value="tinggi" {{ request('keberhasilan') === 'tinggi' ? 'selected' : '' }}>✅ Tinggi</option>
                        <option value="sedang" {{ request('keberhasilan') === 'sedang' ? 'selected' : '' }}>⚠️ Sedang</option>
                        <option value="rendah" {{ request('keberhasilan') === 'rendah' ? 'selected' : '' }}>❌ Rendah</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label"><i class="fas fa-calendar"></i> Dari</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label"><i class="fas fa-calendar-check"></i> Sampai</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-1 col-12 d-flex gap-2">
                    <button type="submit" class="btn bg-gradient-info w-100" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('revegetasi') }}" class="btn btn-outline-secondary w-100" title="Reset">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Card --}}
    <div class="data-card">
        <div class="card-header">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h5>
                    <i class="fas fa-list"></i>
                    Daftar Data Revegetasi
                    @if(request()->anyFilled(['search', 'keberhasilan', 'tanggal_dari', 'tanggal_sampai']))
                        <span class="filter-badge"><i class="fas fa-filter me-1"></i>Filtered</span>
                    @endif
                </h5>
            </div>
            <a href="{{ route('revegetasi.create') }}" class="btn bg-gradient-primary ms-auto">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
        
        <div class="table-container">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Lokasi</th>
                        <th>Tanggal Monitoring</th>
                        <th class="text-center">Luas (ha)</th>
                        <th class="text-center d-none d-md-table-cell">Keberhasilan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($revegetasiData as $data)
                    <tr>
                        <td class="ps-3">
                            <span class="row-number">
                                {{ ($revegetasiData->currentPage() - 1) * $revegetasiData->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td>
                            <div class="location-info">
                                <h6>{{ $data->lokasi_revegetasi ?? '—' }}</h6>
                            </div>
                        </td>
                        <td>
                            <div class="date-info">
                                <p>{{ $data->tanggal_monitoring ? $data->tanggal_monitoring->format('d M Y') : '—' }}</p>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="data-value">{{ number_format($data->luas_area, 2, ',', '.') }}</span>
                        </td>
                        <td class="text-center d-none d-md-table-cell">
                            @if($data->tingkat_keberhasilan === 'tinggi')
                                <span class="success-badge bg-success">
                                    <i class="fas fa-arrow-up"></i> Tinggi
                                </span>
                            @elseif($data->tingkat_keberhasilan === 'sedang')
                                <span class="success-badge bg-warning">
                                    <i class="fas fa-minus"></i> Sedang
                                </span>
                            @else
                                <span class="success-badge bg-danger">
                                    <i class="fas fa-arrow-down"></i> Rendah
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-btns">
                                <a href="{{ route('revegetasi.edit', $data->id) }}" class="action-btn edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="action-btn delete delete-btn" 
                                        data-id="{{ $data->id }}" data-nama="{{ $data->lokasi_revegetasi }}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-search"></i>
                                <p>Data tidak ditemukan dengan kriteria pencarian tersebut.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="card-footer">
            <div class="d-md-flex justify-content-between align-items-center">
                <p class="text-secondary mb-3 mb-md-0">
                    Menampilkan <strong style="color: #1171ef;">{{ $revegetasiData->firstItem() ?? 0 }}</strong> - 
                    <strong style="color: #1171ef;">{{ $revegetasiData->lastItem() ?? 0 }}</strong> 
                    dari <strong style="color: #1171ef;">{{ $revegetasiData->total() }}</strong> data
                </p>
                <div class="pagination-container">
                    {{ $revegetasiData->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-trash-alt text-danger fa-3x mb-3"></i>
                <p>Apakah Anda yakin ingin menghapus data revegetasi dari lokasi:</p>
                <p class="fw-bold text-primary" id="equipmentName"></p>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-check me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal --}}
@if (session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">
                    <i class="fas fa-check-circle me-2"></i>Berhasil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                <p class="mb-0 fw-medium">{{ session('success') }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Delete confirmation handler
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');

            document.getElementById('equipmentName').textContent = nama || 'data ini';
            document.getElementById('deleteForm').action = '/revegetasi/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // Success modal auto-show
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif

    // Ripple effect for buttons
    document.querySelectorAll('.btn, .action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if(!this.classList.contains('delete-btn')) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute; width: ${size}px; height: ${size}px;
                    border-radius: 50%; background: rgba(255,255,255,0.4);
                    left: ${x}px; top: ${y}px; animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            }
        });
    });

    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `@keyframes ripple { to { transform: scale(2); opacity: 0; } }`;
    document.head.appendChild(style);
});
</script>
@endpush

@endsection