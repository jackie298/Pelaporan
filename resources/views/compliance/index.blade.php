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
    .table-custom .reporter-info h6 {
        color: #344767 !important; font-weight: 600; font-size: 0.9rem; margin: 0 0 4px;
    }
    .table-custom .status-badge,
    .table-custom .severity-badge {
        padding: 6px 14px; border-radius: 20px; font-size: 0.75rem;
        font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .table-custom .status-badge.escalated { background: rgba(220, 53, 69, 0.15) !important; color: #dc3545 !important; }
    .table-custom .status-badge.pending { background: rgba(255, 193, 7, 0.15) !important; color: #856404 !important; }
    .table-custom .status-badge.resolved { background: rgba(25, 135, 84, 0.15) !important; color: #198754 !important; }
    .table-custom .status-badge.open { background: rgba(13, 202, 240, 0.15) !important; color: #0dcaf0 !important; }
    .table-custom .severity-badge.low { background: rgba(25, 135, 84, 0.15) !important; color: #198754 !important; }
    .table-custom .severity-badge.medium { background: rgba(255, 193, 7, 0.15) !important; color: #856404 !important; }
    .table-custom .severity-badge.high { background: rgba(220, 53, 69, 0.15) !important; color: #dc3545 !important; }
    .table-custom .severity-badge.critical { background: rgba(33, 37, 41, 0.15) !important; color: #212529 !important; }
    .table-custom .severity-badge i,
    .table-custom .status-badge i { font-size: 0.7rem; }

    .table-custom .doc-badge {
        background: rgba(17, 113, 239, 0.1); color: #1171ef !important;
        padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .table-custom .action-btns { display: flex; align-items: center; justify-content: center; gap: 4px; }
    .table-custom .action-btn {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s; text-decoration: none; border: none;
        background: transparent; cursor: pointer; font-size: 0.85rem;
    }
    .table-custom .action-btn.visual { color: #1171ef !important; background: rgba(17, 113, 239, 0.1); }
    .table-custom .action-btn.visual:hover { background: #1171ef; color: #fff !important; transform: scale(1.1); }
    .table-custom .action-btn.detail { color: #2dce89 !important; background: rgba(45, 206, 137, 0.1); }
    .table-custom .action-btn.detail:hover { background: #2dce89; color: #fff !important; transform: scale(1.1); }
    .table-custom .action-btn.edit { color: #fb6340 !important; background: rgba(251, 99, 64, 0.1); }
    .table-custom .action-btn.edit:hover { background: #fb6340; color: #fff !important; transform: scale(1.1); }
    .table-custom .action-btn.delete { color: #f5365c !important; background: rgba(245, 54, 92, 0.1); }
    .table-custom .action-btn.delete:hover { background: #f5365c; color: #fff !important; transform: scale(1.1); }

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
    .pagination-container .pagination { gap: 4px; margin: 0; justify-content: flex-end; }
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
    .modal-header.bg-gradient-danger {
        background: var(--danger-gradient) !important; border-radius: 20px 20px 0 0; border: none; padding: 18px 24px;
    }
    .modal-header.bg-gradient-success {
        background: var(--primary-gradient) !important; border-radius: 20px 20px 0 0; border: none; padding: 18px 24px;
    }
    .modal-title { font-weight: 700; font-size: 1.1rem; color: #fff !important; }
    .modal-body { padding: 24px; color: #344767 !important; }
    .modal-body p { color: #ffffff !important; font-size: 1rem; line-height: 1.6; }
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

    /* ===== NKA VISUAL CARD (Improved) ===== */
    .nka-card {
        background: #fff;
        border: 2px solid #0d4435;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        max-width: 900px;
        margin: 0 auto;
    }
    .nka-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 4px;
        background-color: #eee;
        padding: 4px;
    }
    .nka-grid-container.single-photo { grid-template-columns: 1fr; }
    .nka-grid-item {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #333;
        border-radius: 8px;
    }
    .nka-grid-item img.main-img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    .nka-grid-item:hover img.main-img { transform: scale(1.05); }
    .nka-logo-watermark {
        position: absolute;
        bottom: 8px; left: 8px;
        width: 45px;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5));
        z-index: 10;
    }
    .nka-header-box {
        background: linear-gradient(135deg, #0d4435, #1a5c4a);
        color: #ffffff;
        padding: 18px 20px;
        border-top: 4px solid #c05c2e;
    }
    .nka-header-box h6 {
        font-weight: 800; letter-spacing: 1px; margin-bottom: 12px;
        text-transform: uppercase; font-size: 0.95rem;
    }
    .nka-info-text {
        font-size: 0.85rem; margin-bottom: 6px; line-height: 1.5;
        display: flex; align-items: center; gap: 6px;
    }
    .nka-info-text .label {
        color: #2ecc71; font-weight: 700; text-decoration: underline;
        min-width: 110px;
    }
    .nka-footer-meta {
        display: flex; justify-content: space-between;
        margin-top: 16px; padding-top: 12px;
        border-top: 1px solid rgba(255,255,255,0.2);
        font-size: 0.75rem; opacity: 0.9;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
        .alert-bar { flex-direction: column; gap: 12px; text-align: center; }
        .data-card .card-header { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 767px) {
        .alert-bar, .filter-card, .data-card { margin-left: 12px; margin-right: 12px; }
        .table-container { padding: 0 12px 12px; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table-custom { min-width: 1100px; }
        .card-footer .d-md-flex { flex-direction: column; gap: 12px; text-align: center; }
        .pagination-container .pagination { justify-content: center; }
        .nka-grid-container { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
        .filter-card .col-md-3, .filter-card .col-md-2 { flex: 0 0 100%; max-width: 100%; }
        .filter-card .d-flex.gap-2 { flex-direction: column; }
        .filter-card .btn { width: 100%; }
        .nka-grid-container { grid-template-columns: 1fr; }
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
            <i class="fas fa-clipboard-check"></i>
            <strong>Dokumen Inspeksi</strong>
        </span>
        <div class="d-flex gap-2">
            <a class="btn" href="{{ route('api.export.compliance', request()->query()) }}">
                <i class="fas fa-file-excel me-1"></i> Export Data
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('compliance') }}" class="row g-3 align-items-end">
                <div class="col-md-3 col-6">
                    <label class="form-label"><i class="fas fa-search"></i> Cari Data</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Pelapor / Lokasi / Insiden..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label"><i class="fas fa-building"></i> Departemen</label>
                    <select name="departemen" class="form-select">
                        <option value="">Semua</option>
                        <option value="HSE" {{ request('departemen') === 'HSE' ? 'selected' : '' }}>HSE</option>
                        <option value="Produksi" {{ request('departemen') === 'Produksi' ? 'selected' : '' }}>Produksi</option>
                        <option value="HRD" {{ request('departemen') === 'HRD' ? 'selected' : '' }}>HRD</option>
                        <option value="Maintenance" {{ request('departemen') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Lainnya" {{ request('departemen') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label"><i class="fas fa-flag"></i> Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="Escalated" {{ request('status') === 'Escalated' ? 'selected' : '' }}>🔴 Escalated</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>🟡 Pending</option>
                        <option value="Resolved" {{ request('status') === 'Resolved' ? 'selected' : '' }}>🟢 Resolved</option>
                        <option value="Open" {{ request('status') === 'Open' ? 'selected' : '' }}>🔵 Open</option>
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
                    <a href="{{ route('compliance') }}" class="btn btn-outline-secondary w-100" title="Reset">
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
                    Daftar Dokumen Inspeksi
                    @if(request()->anyFilled(['search', 'departemen', 'status', 'tanggal_dari', 'tanggal_sampai']))
                        <span class="filter-badge"><i class="fas fa-filter me-1"></i>Filtered</span>
                    @endif
                </h5>
            </div>
            <a href="{{ route('compliance.create') }}" class="btn bg-gradient-primary ms-auto">
                <i class="fas fa-plus"></i> Tambah Dokumen
            </a>
        </div>
        
        <div class="table-container">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="ps-3" style="width: 50px;">No</th>
                        <th>Nama Pelapor</th>
                        <th>Departemen</th>
                        <th>Lokasi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Keparahan</th>
                        <th class="text-center">Dokumen</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compliances as $item)
                    <tr>
                        <td class="ps-3">
                            <span class="row-number">
                                {{ ($compliances->currentPage() - 1) * $compliances->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td>
                            <div class="reporter-info">
                                <h6>{{ $item->Nama_pelapor ?? '—' }}</h6>
                                <small class="text-muted">{{ $item->Tanggal_lapor ? \Carbon\Carbon::parse($item->Tanggal_lapor)->format('d M Y') : '—' }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="text-sm">{{ $item->Departemen ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="text-sm">{{ $item->Lokasi ?? '—' }}</span>
                        </td>
                        <td class="text-center">
                            @php
                                $statusClass = match($item->Status) {
                                    'Escalated' => 'escalated',
                                    'Pending' => 'pending',
                                    'Resolved' => 'resolved',
                                    'Open' => 'open',
                                    default => ''
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                @if($item->Status === 'Escalated') <i class="fas fa-arrow-up"></i>
                                @elseif($item->Status === 'Pending') <i class="fas fa-clock"></i>
                                @elseif($item->Status === 'Resolved') <i class="fas fa-check"></i>
                                @elseif($item->Status === 'Open') <i class="fas fa-circle"></i>
                                @endif
                                {{ $item->Status ?? '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                                $severityClass = match($item->Tingkat_keparahan) {
                                    'Low' => 'low',
                                    'Medium' => 'medium',
                                    'High' => 'high',
                                    'Critical' => 'critical',
                                    default => ''
                                };
                            @endphp
                            <span class="severity-badge {{ $severityClass }}">
                                @if($item->Tingkat_keparahan === 'Low') <i class="fas fa-check"></i>
                                @elseif($item->Tingkat_keparahan === 'Medium') <i class="fas fa-minus"></i>
                                @elseif($item->Tingkat_keparahan === 'High') <i class="fas fa-exclamation"></i>
                                @elseif($item->Tingkat_keparahan === 'Critical') <i class="fas fa-times"></i>
                                @endif
                                {{ $item->Tingkat_keparahan ?? '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($item->file_dokumentasi && is_array($item->file_dokumentasi) && count($item->file_dokumentasi) > 0)
                                <span class="doc-badge">
                                    <i class="fas fa-images"></i> {{ count($item->file_dokumentasi) }}
                                </span>
                            @else
                                <span class="text-muted text-xs">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-btns">
                                @if($item->file_dokumentasi && is_array($item->file_dokumentasi) && count($item->file_dokumentasi) > 0)
                                <button type="button" class="action-btn visual detail-visual-btn" 
                                        title="Lihat Visual"
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
                                    <i class="fas fa-images"></i>
                                </button>
                                @endif
                                <button type="button" class="action-btn detail detail-btn" 
                                        title="Detail Info"
                                        data-nama="{{ $item->Nama_pelapor }}"
                                        data-departemen="{{ $item->Departemen }}"
                                        data-lokasi="{{ $item->Lokasi }}"
                                        data-jenis-insiden="{{ $item->Jenis_insiden }}"
                                        data-jenis-inspeksi="{{ $item->Jenis_inspeksi }}"
                                        data-tanggal="{{ $item->Tanggal_lapor ? \Carbon\Carbon::parse($item->Tanggal_lapor)->format('d M Y') : '-' }}"
                                        data-status="{{ $item->Status }}"
                                        data-tingkat="{{ $item->Tingkat_keparahan }}"
                                        data-diselesaikan="{{ $item->Diselesaikan_oleh }}">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <a href="{{ route('compliance.edit', $item->id) }}" class="action-btn edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="action-btn delete delete-btn" 
                                        data-id="{{ $item->id }}" data-nama="{{ $item->Nama_pelapor }}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Data tidak ditemukan dengan kriteria pencarian tersebut.</p>
                                <a href="{{ route('compliance.create') }}" class="btn bg-gradient-primary btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i>Tambah Dokumen Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($compliances) && $compliances->hasPages())
        <div class="card-footer">
            <div class="d-md-flex justify-content-between align-items-center">
                <p class="text-secondary mb-3 mb-md-0">
                    Menampilkan <strong style="color: #1171ef;">{{ $compliances->firstItem() ?? 0 }}</strong> - 
                    <strong style="color: #1171ef;">{{ $compliances->lastItem() ?? 0 }}</strong> 
                    dari <strong style="color: #1171ef;">{{ $compliances->total() }}</strong> data
                </p>
                <div class="pagination-container">
                    {{ $compliances->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail Text -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h5 class="modal-title text-white">
                    <i class="fas fa-info-circle me-2"></i>Detail Informasi Compliance
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6"><strong>Nama Pelapor:</strong></div>
                    <div class="col-6" id="detail-nama"></div>
                    <div class="col-6"><strong>Departemen:</strong></div>
                    <div class="col-6" id="detail-departemen"></div>
                    <div class="col-6"><strong>Lokasi:</strong></div>
                    <div class="col-6" id="detail-lokasi"></div>
                    <div class="col-6"><strong>Jenis Insiden:</strong></div>
                    <div class="col-6" id="detail-jenis-insiden"></div>
                    <div class="col-6"><strong>Jenis Inspeksi:</strong></div>
                    <div class="col-6" id="detail-jenis-inspeksi"></div>
                    <div class="col-6"><strong>Tanggal Lapor:</strong></div>
                    <div class="col-6" id="detail-tanggal"></div>
                    <div class="col-6"><strong>Status:</strong></div>
                    <div class="col-6" id="detail-status"></div>
                    <div class="col-6"><strong>Tingkat Keparahan:</strong></div>
                    <div class="col-6" id="detail-tingkat"></div>
                    <div class="col-6"><strong>Diselesaikan Oleh:</strong></div>
                    <div class="col-6" id="detail-diselesaikan"></div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn bg-gradient-info px-4" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Visual Dokumen (NKA Card) -->
<div class="modal fade" id="detailKegiatanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <div class="nka-card" id="visual-content-area">
                    <div id="photo-grid" class="nka-grid-container">
                        <!-- Photos will be inserted here dynamically -->
                    </div>
                    
                    <div class="nka-header-box">
                        <h6 id="v-nama" class="text-white text-uppercase mb-2"></h6>
                        <p class="nka-info-text"><span class="label">Departemen:</span> <span id="v-departemen"></span></p>
                        <p class="nka-info-text"><span class="label">Lokasi:</span> <span id="v-lokasi"></span></p>
                        <p class="nka-info-text"><span class="label">Jenis Insiden:</span> <span id="v-jenis-insiden"></span></p>
                        <p class="nka-info-text"><span class="label">Jenis Inspeksi:</span> <span id="v-jenis-inspeksi"></span></p>
                        <div class="nka-footer-meta">
                            <span id="v-tanggal"></span>
                            <span>PT NUSA KARYA ARINDO</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn bg-gradient-secondary btn-sm px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash-alt text-danger fa-3x mb-3"></i>
                <p>Apakah Anda yakin ingin menghapus dokumen Inspeksi dari:</p>
                <p class="fw-bold text-primary" id="equipmentName"></p>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn bg-gradient-danger px-4">
                        <i class="fas fa-check me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success">
                <h5 class="modal-title text-white">
                    <i class="fas fa-check-circle me-2"></i>Berhasil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                <h5 class="mb-3">{{ session('success') }}</h5>
            </div>
            <div class="modal-footer justify-content-center border-0 pb-4">
                <button type="button" class="btn bg-gradient-success px-4" data-bs-dismiss="modal">
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
    // === 1. DETAIL TEXT MODAL ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-btn')) {
            const btn = e.target.closest('.detail-btn');
            document.getElementById('detail-nama').textContent = btn.getAttribute('data-nama') || '—';
            document.getElementById('detail-departemen').textContent = btn.getAttribute('data-departemen') || '—';
            document.getElementById('detail-lokasi').textContent = btn.getAttribute('data-lokasi') || '—';
            document.getElementById('detail-jenis-insiden').textContent = btn.getAttribute('data-jenis-insiden') || '—';
            document.getElementById('detail-jenis-inspeksi').textContent = btn.getAttribute('data-jenis-inspeksi') || '—';
            document.getElementById('detail-tanggal').textContent = btn.getAttribute('data-tanggal') || '—';
            document.getElementById('detail-status').textContent = btn.getAttribute('data-status') || '—';
            document.getElementById('detail-tingkat').textContent = btn.getAttribute('data-tingkat') || '—';
            document.getElementById('detail-diselesaikan').textContent = btn.getAttribute('data-diselesaikan') || '—';
            
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    });

    // === 2. VISUAL MODAL (GRID FOTO) ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-visual-btn')) {
            const btn = e.target.closest('.detail-visual-btn');
            const fotos = JSON.parse(btn.getAttribute('data-fotos') || '[]');
            
            // Set Text
            document.getElementById('v-nama').textContent = "Pelapor: " + (btn.getAttribute('data-nama') || '—');
            document.getElementById('v-departemen').textContent = btn.getAttribute('data-departemen') || '—';
            document.getElementById('v-lokasi').textContent = btn.getAttribute('data-lokasi') || '—';
            document.getElementById('v-jenis-insiden').textContent = btn.getAttribute('data-jenis-insiden') || '—';
            document.getElementById('v-jenis-inspeksi').textContent = btn.getAttribute('data-jenis-inspeksi') || '—';
            document.getElementById('v-tanggal').textContent = "📅 " + (btn.getAttribute('data-tanggal') || '—');

            // Render Grid Foto
            const grid = document.getElementById('photo-grid');
            grid.innerHTML = '';
            
            if(fotos.length === 1) {
                grid.classList.add('single-photo');
            } else {
                grid.classList.remove('single-photo');
            }

            if(fotos.length > 0) {
                fotos.forEach(path => {
                    const ext = path.split('.').pop().toLowerCase();
                    let content = '';
                    
                    if(['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                        content = `<img src="/storage/${path}" class="main-img" onerror="this.src='{{ asset('assets/img/default-image.png') }}'" alt="Dokumentasi">`;
                    } else if(ext === 'pdf') {
                        content = `<div class="d-flex align-items-center justify-content-center bg-white" style="height: 100%;">
                            <i class="fas fa-file-pdf fa-3x text-danger"></i>
                        </div>`;
                    } else {
                        content = `<div class="d-flex align-items-center justify-content-center bg-white" style="height: 100%;">
                            <i class="fas fa-file fa-3x text-muted"></i>
                        </div>`;
                    }
                    
                    grid.innerHTML += `
                        <div class="nka-grid-item">
                            ${content}
                            <img src="{{ asset('assets/img/logoperusahaan.png') }}" class="nka-logo-watermark" alt="Logo">
                        </div>
                    `;
                });
            } else {
                grid.innerHTML = '<div class="p-4 text-center w-100 text-muted">Tidak ada dokumen.</div>';
            }

            const modal = new bootstrap.Modal(document.getElementById('detailKegiatanModal'));
            modal.show();
        }
    });

    // === 3. DELETE CONFIRMATION ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            document.getElementById('equipmentName').textContent = btn.getAttribute('data-nama') || 'data ini';
            document.getElementById('deleteForm').action = '/compliance/' + btn.getAttribute('data-id');
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // === 4. SUCCESS MODAL ===
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif

    // === 5. RIPPLE EFFECT ===
    document.querySelectorAll('.btn, .action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if(this.classList.contains('delete-btn')) return;
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.cssText = `
                position: absolute; width: ${size}px; height: ${size}px;
                border-radius: 50%; background: rgba(255,255,255,0.4);
                left: ${x}px; top: ${y}px; animation: ripple 0.6s ease-out;
                pointer-events: none; z-index: 0;
            `;
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });
    if(!document.getElementById('ripple-style')) {
        const style = document.createElement('style');
        style.id = 'ripple-style';
        style.textContent = `@keyframes ripple { to { transform: scale(2); opacity: 0; } }`;
        document.head.appendChild(style);
    }
});
</script>
@endpush

@endsection