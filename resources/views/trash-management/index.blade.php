@extends('layouts.user_type.auth')

@section('content')

<style>
    /* ===== THEME VARIABLES ===== */
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

    /* ===== GLOBAL TEXT READABILITY ===== */
    .filter-card,
    .data-card,
    .table-custom,
    .card-body,
    .card-header,
    .card-footer {
        color: var(--text-primary) !important;
    }

    .filter-card *,
    .data-card *,
    .table-custom * {
        color: inherit;
    }

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
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        pointer-events: none;
    }

    .alert-bar .text-white {
        position: relative; z-index: 1;
        font-weight: 600; font-size: 0.95rem;
        display: flex; align-items: center; gap: 8px;
        color: #fff !important;
    }

    .alert-bar .text-white i { font-size: 1.1rem; }

    .alert-bar .btn {
        position: relative; z-index: 1;
        border: none; font-weight: 600;
        padding: 8px 16px; border-radius: 10px;
        transition: all 0.2s;
        background: rgba(255, 255, 255, 0.95);
        color: #344767 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .alert-bar .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        background: #fff;
    }

    .alert-bar .btn i { font-size: 0.9rem; }

    /* ===== FILTER CARD ===== */
    .filter-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin: 0 16px 20px;
        transition: box-shadow 0.3s ease;
    }

    .filter-card:hover { box-shadow: var(--shadow-md); }

    .filter-card .card-body { padding: 20px; }

    .filter-card .form-label {
        color: #344767 !important;
        font-weight: 700; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 0.3px;
        margin-bottom: 6px;
        display: flex; align-items: center; gap: 4px;
    }

    .filter-card .form-label i {
        color: #1171ef; font-size: 0.8rem;
    }

    .filter-card .form-select,
    .filter-card .form-control {
        background: #f8f9fa;
        border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.9rem;
        color: #344767 !important;
        font-weight: 500;
        transition: all 0.2s;
    }

    .filter-card .form-select:focus,
    .filter-card .form-control:focus {
        background: #fff;
        border-color: #1171ef;
        box-shadow: 0 0 0 4px rgba(17, 113, 239, 0.15);
        outline: none;
        color: #344767 !important;
    }

    .filter-card .form-select option {
        padding: 10px;
        color: #344767 !important;
        background: #fff;
    }

    .filter-card .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 16px;
        font-size: 0.85rem;
        transition: all 0.2s;
        border: none;
        color: #fff !important;
    }

    .filter-card .btn.bg-gradient-info {
        background: var(--info-gradient);
        box-shadow: 0 4px 12px rgba(17, 113, 239, 0.3);
    }

    .filter-card .btn.bg-gradient-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(17, 113, 239, 0.45);
    }

    .filter-card .btn-outline-secondary {
        border: 2px solid var(--border-color);
        color: #67748e !important;
        background: transparent;
    }

    .filter-card .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #67748e;
        color: #344767 !important;
    }

    /* ===== DATA CARD ===== */
    .data-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin: 0 16px 20px;
        overflow: hidden;
        color: #344767 !important;
    }

    .data-card .card-header {
        background: transparent;
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        color: #344767 !important;
    }

    .data-card .card-header h5 {
        color: #344767 !important;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .data-card .card-header h5 i { color: #1171ef; }

    .data-card .card-header .filter-badge {
        background: rgba(17, 113, 239, 0.1);
        color: #1171ef !important;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 8px;
    }

    .data-card .btn.bg-gradient-primary {
        background: var(--primary-gradient);
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        color: #fff !important;
    }

    .data-card .btn.bg-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 206, 137, 0.45);
    }

    .data-card .btn.bg-gradient-primary i {
        font-size: 1rem; font-weight: 700;
    }

    /* ===== TABLE STYLING ===== */
    .table-container {
        padding: 0 24px 24px;
        color: #344767 !important;
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        color: #344767 !important;
    }

    .table-custom thead th {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #67748e !important;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    .table-custom thead th:first-child {
        border-radius: 12px 0 0 0;
        padding-left: 20px;
    }

    .table-custom thead th:last-child {
        border-radius: 0 12px 0 0;
        padding-right: 20px;
    }

    .table-custom tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: #344767 !important;
    }

    .table-custom tbody tr:hover {
        background: rgba(17, 113, 239, 0.04);
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .table-custom tbody tr:last-child { border-bottom: none; }

    .table-custom td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: #344767 !important;
    }

    .table-custom td:first-child {
        padding-left: 20px;
        border-radius: 12px 0 0 12px;
    }

    .table-custom td:last-child {
        padding-right: 20px;
        border-radius: 0 12px 12px 0;
    }

    .table-custom .row-number {
        background: rgba(17, 113, 239, 0.1);
        color: #1171ef !important;
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.8rem;
    }

    /* Source Badge */
    .table-custom .source-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.7rem; font-weight: 600;
        text-transform: uppercase;
    }
    .table-custom .source-badge.kantor {
        background: rgba(17, 113, 239, 0.15); color: #1171ef !important;
    }
    .table-custom .source-badge.site {
        background: rgba(251, 99, 64, 0.15); color: #fb6340 !important;
    }
    .table-custom .source-badge i {
        width: 6px; height: 6px; border-radius: 50%; display: inline-block;
    }
    .table-custom .source-badge.kantor i { background: #1171ef; }
    .table-custom .source-badge.site i { background: #fb6340; }

    /* Date Info */
    .table-custom .date-info p {
        margin: 0; font-weight: 600; font-size: 0.9rem;
        color: #344767 !important;
    }

    /* Data Values */
    .table-custom .data-value {
        text-align: center;
        font-weight: 700; font-size: 0.9rem;
        color: #344767 !important;
        padding: 6px 12px;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.03);
        min-width: 65px;
        display: inline-block;
    }
    .table-custom .data-value.total {
        color: #2dce89 !important;
        background: rgba(45, 206, 137, 0.12);
        font-weight: 800;
    }

    /* Action Buttons */
    .table-custom .action-btns {
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .table-custom .action-btn {
        width: 34px; height: 34px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s; text-decoration: none;
        border: none; background: transparent; cursor: pointer;
    }
    .table-custom .action-btn.edit {
        color: #1171ef !important; background: rgba(17, 113, 239, 0.1);
    }
    .table-custom .action-btn.edit:hover {
        background: #1171ef; color: #fff !important; transform: scale(1.1);
    }
    .table-custom .action-btn.delete {
        color: #f5365c !important; background: rgba(245, 54, 92, 0.1);
    }
    .table-custom .action-btn.delete:hover {
        background: #f5365c; color: #fff !important; transform: scale(1.1);
    }
    .table-custom .action-btn i { font-size: 0.9rem; }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center; padding: 60px 20px;
        color: #67748e !important;
    }
    .empty-state i {
        font-size: 3rem; color: rgba(17, 113, 239, 0.3);
        margin-bottom: 16px; display: block;
    }
    .empty-state p {
        font-size: 1rem; font-weight: 500; margin: 0;
        color: #67748e !important;
    }
    .empty-state .btn {
        margin-top: 12px; border-radius: 10px;
        padding: 8px 20px; font-weight: 600;
    }

    /* ===== PAGINATION ===== */
    .card-footer {
        background: transparent;
        border-top: 1px solid var(--border-color);
        padding: 16px 24px;
        color: #67748e !important;
    }
    .card-footer .text-secondary {
        color: #67748e !important;
        font-weight: 600; font-size: 0.85rem;
    }
    .pagination-container .pagination {
        gap: 4px; margin: 0;
    }
    .pagination-container .page-item .page-link {
        background: #f8f9fa;
        border: 2px solid var(--border-color);
        color: #344767 !important;
        padding: 8px 14px; border-radius: 10px;
        font-weight: 600; font-size: 0.85rem;
        margin: 0; transition: all 0.2s;
    }
    .pagination-container .page-item.active .page-link {
        background: var(--primary-gradient);
        border-color: transparent;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
    }
    .pagination-container .page-item:hover:not(.active):not(.disabled) .page-link {
        background: #1171ef; border-color: #1171ef;
        color: #fff !important; transform: translateY(-2px);
    }
    .pagination-container .page-item.disabled .page-link {
        opacity: 0.4; cursor: not-allowed; color: #67748e !important;
    }

    /* ===== MODAL STYLING ===== */
    .modal-content {
        border-radius: 20px; border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .modal-header.bg-danger {
        background: var(--danger-gradient) !important;
        border-radius: 20px 20px 0 0; border: none;
        padding: 18px 24px;
    }
    .modal-header.bg-success {
        background: var(--primary-gradient) !important;
        border-radius: 20px 20px 0 0; border: none;
        padding: 18px 24px;
    }
    .modal-title {
        font-weight: 700; font-size: 1.1rem; color: #fff !important;
    }
    .modal-body {
        padding: 24px; text-align: center; color: #344767 !important;
    }
    .modal-body p {
        color: #344767 !important; font-size: 1rem; line-height: 1.6;
    }
    .modal-body .text-muted {
        color: #67748e !important; font-size: 0.9rem;
    }
    .modal-body i.fa-check-circle { color: #2dce89; }
    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 16px 24px; gap: 10px;
    }
    .modal-footer .btn {
        padding: 10px 24px; border-radius: 10px;
        font-weight: 600; font-size: 0.9rem;
        border: none; transition: all 0.2s; color: #fff !important;
    }
    .modal-footer .btn-secondary {
        background: #e9ecef; color: #344767 !important;
    }
    .modal-footer .btn-secondary:hover {
        background: #dee2e6; transform: translateY(-2px);
    }
    .modal-footer .btn-danger {
        background: var(--danger-gradient);
        box-shadow: 0 4px 12px rgba(245, 54, 92, 0.3);
    }
    .modal-footer .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 54, 92, 0.45);
    }
    .modal-footer .btn-success {
        background: var(--primary-gradient);
        box-shadow: 0 4px 12px rgba(45, 206, 137, 0.3);
    }
    .modal-footer .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 206, 137, 0.45);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
        .alert-bar { flex-direction: column; gap: 12px; text-align: center; }
        .data-card .card-header { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 767px) {
        .alert-bar, .filter-card, .data-card { margin-left: 12px; margin-right: 12px; }
        .table-container { padding: 0 12px 12px; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table-custom { min-width: 750px; }
        .card-footer .d-md-flex { flex-direction: column; gap: 12px; text-align: center; }
    }
    @media (max-width: 575px) {
        .filter-card .col-md-3, .filter-card .col-md-2 { flex: 0 0 100%; max-width: 100%; }
        .filter-card .d-flex.gap-2 { flex-direction: column; }
        .filter-card .btn { width: 100%; }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .table-custom tbody tr { animation: fadeIn 0.3s ease forwards; }
    .table-custom tbody tr:nth-child(1) { animation-delay: 0.05s; }
    .table-custom tbody tr:nth-child(2) { animation-delay: 0.1s; }
    .table-custom tbody tr:nth-child(3) { animation-delay: 0.15s; }
    .table-custom tbody tr:nth-child(4) { animation-delay: 0.2s; }
    .table-custom tbody tr:nth-child(5) { animation-delay: 0.25s; }

    /* ===== TOOLTIPS ===== */
    [title] { position: relative; }
    [title]:hover::after {
        content: attr(title);
        position: absolute; bottom: 100%; left: 50%;
        transform: translateX(-50%) translateY(-8px);
        background: #344767; color: #fff !important;
        padding: 6px 12px; border-radius: 8px;
        font-size: 0.75rem; font-weight: 500;
        white-space: nowrap; z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        pointer-events: none; opacity: 0;
        animation: tooltipFade 0.2s ease forwards;
    }
    @keyframes tooltipFade {
        to { opacity: 1; transform: translateX(-50%) translateY(-12px); }
    }
</style>

<div>
    {{-- 🔔 Alert Bar --}}
    <div class="alert-bar">
        <span class="text-white">
            <i class="fas fa-recycle"></i>
            <strong>Manajemen Sampah</strong>
        </span>
        <div class="d-flex gap-2">
            <a class="btn" href="{{ route('api.trashmanagement.export') }}">
                <i class="fas fa-file-excel me-1"></i> Export Data
            </a>
        </div>
    </div>

    {{-- 🔍 Filter Card --}}
    <div class="filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('trash-management') }}" class="row g-3 align-items-end">
                <!-- Search Keyword -->
                <div class="col-md-3 col-6">
                    <label class="form-label">
                        <i class="fas fa-search"></i> Cari
                    </label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari sumber..." value="{{ request('search') }}">
                </div>

                <!-- Filter Tanggal -->
                <div class="col-md-2 col-6">
                    <label class="form-label">
                        <i class="fas fa-calendar"></i> Tanggal
                    </label>
                    <input type="date" name="tanggal" class="form-control" 
                           value="{{ request('tanggal') }}" max="{{ date('Y-m-d') }}">
                </div>

                <!-- Filter Sumber Sampah -->
                <div class="col-md-3 col-6">
                    <label class="form-label">
                        <i class="fas fa-layer-group"></i> Sumber
                    </label>
                    <select name="sumber_sampah" class="form-select">
                        <option value="">Semua Sumber</option>
                        @foreach(\App\Models\TrashManagement::SUMBER_SAMPAH_OPTIONS as $key => $label)
                            <option value="{{ $key }}" {{ request('sumber_sampah') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-4 col-12 d-flex gap-2">
                    <button type="submit" class="btn bg-gradient-info w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('trash-management') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                </div>
            </form>

            {{-- Active Filter Badges --}}
            @if(request()->anyFilled(['search', 'tanggal', 'sumber_sampah']))
            <div class="mt-3 d-flex flex-wrap gap-2">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Hasil: <strong>{{ $trashData->count() }}</strong> dari <strong>{{ $trashData->total() }}</strong>
                </small>
                @if(request('search'))
                    <span class="filter-badge" style="background:rgba(17,113,239,0.1);color:#1171ef!important">
                        🔎 "{{ request('search') }}" 
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" 
                           class="ms-1 text-decoration-none">×</a>
                    </span>
                @endif
                @if(request('tanggal'))
                    <span class="filter-badge" style="background:rgba(45,206,137,0.1);color:#2dce89!important">
                        📅 {{ request('tanggal') }}
                        <a href="{{ request()->fullUrlWithQuery(['tanggal' => null]) }}" 
                           class="ms-1 text-decoration-none">×</a>
                    </span>
                @endif
                @if(request('sumber_sampah'))
                    <span class="filter-badge" style="background:rgba(251,99,64,0.1);color:#fb6340!important">
                        🗂️ {{ \App\Models\TrashManagement::SUMBER_SAMPAH_OPTIONS[request('sumber_sampah')] ?? request('sumber_sampah') }}
                        <a href="{{ request()->fullUrlWithQuery(['sumber_sampah' => null]) }}" 
                           class="ms-1 text-decoration-none">×</a>
                    </span>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- 📊 Data Card --}}
    <div class="data-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-list"></i>
                Daftar Data Pengelolaan Sampah
                @if(request()->anyFilled(['search', 'tanggal', 'sumber_sampah']))
                    <span class="filter-badge">
                        <i class="fas fa-filter me-1"></i>Filtered
                    </span>
                @endif
            </h5>
            <a href="{{ route('trash-management.create') }}" class="btn bg-gradient-primary ms-auto">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
        
        <div class="table-container">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Tanggal & Sumber</th>
                        <th class="text-center">Organik (kg)</th>
                        <th class="text-center">Anorganik (kg)</th>
                        <th class="text-center d-none d-md-table-cell">Residu (kg)</th>
                        <th class="text-center fw-bold">Total (kg)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trashData as $data)
                    <tr>
                        <td class="ps-3">
                            <span class="row-number">
                                {{ ($trashData->currentPage() - 1) * $trashData->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td>
                            <div class="date-info">
                                <p>{{ $data->tanggal_formatted }}</p>
                                <span class="source-badge {{ str_contains($data->sumber_sampah, 'kantor') ? 'kantor' : 'site' }}">
                                    <i></i> {{ $data->sumber_sampah_label }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="data-value">
                                {{ number_format($data->sampah_organik_terpilah ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="data-value">
                                {{ number_format($data->sampah_anorganik_terpilah ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center d-none d-md-table-cell">
                            <span class="data-value">
                                {{ number_format($data->sampah_lainnya_dan_atau_residu ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="data-value total">
                                {{ number_format($data->total, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-btns">
                                <a href="{{ route('trash-management.edit', $data->id) }}" 
                                   class="action-btn edit" title="Edit Data">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="action-btn delete delete-btn" 
                                        data-id="{{ $data->id }}" 
                                        data-tanggal="{{ $data->tanggal_formatted }}"
                                        data-sumber="{{ $data->sumber_sampah_label }}"
                                        title="Hapus Data">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                @if(request()->anyFilled(['search', 'tanggal', 'sumber_sampah']))
                                    <p>Data tidak ditemukan dengan filter tersebut.</p>
                                    <a href="{{ route('trash-management') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-1"></i> Reset Filter
                                    </a>
                                @else
                                    <p>Belum ada data pengelolaan sampah.</p>
                                    <a href="{{ route('trash-management.create') }}" class="btn bg-gradient-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Data Pertama
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($trashData->hasPages())
        <div class="card-footer">
            <div class="d-md-flex justify-content-between align-items-center">
                <p class="text-secondary mb-3 mb-md-0">
                    Menampilkan <strong style="color: #1171ef;">{{ $trashData->firstItem() ?? 0 }}</strong> - 
                    <strong style="color: #1171ef;">{{ $trashData->lastItem() ?? 0 }}</strong> 
                    dari <strong style="color: #1171ef;">{{ $trashData->total() }}</strong> data
                </p>
                <div class="pagination-container">
                    {{ $trashData->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- 🗑️ Delete Confirmation Modal --}}
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
                <p>Apakah Anda yakin ingin menghapus data sampah pada:</p>
                <p class="fw-bold text-primary">
                    <span id="tanggalData"></span> • <span id="sumberData"></span>
                </p>
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

{{-- ✅ Success Modal --}}
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
        const btn = e.target.closest('.delete-btn');
        if (btn) {
            document.getElementById('tanggalData').textContent = btn.dataset.tanggal;
            document.getElementById('sumberData').textContent = btn.dataset.sumber;
            document.getElementById('deleteForm').action = '/trash-management/' + btn.dataset.id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });

    // Success modal auto-show
    @if(session('success'))
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
        document.getElementById('successModal').addEventListener('hidden.bs.modal', () => {
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url);
            }
        });
    @endif

    // Ripple effect for buttons
    document.querySelectorAll('.btn, .action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if(this.classList.contains('delete-btn')) return;
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size/2;
            const y = e.clientY - rect.top - size/2;
            ripple.style.cssText = `
                position:absolute;width:${size}px;height:${size}px;
                border-radius:50%;background:rgba(255,255,255,0.4);
                left:${x}px;top:${y}px;animation:ripple 0.6s ease-out;
                pointer-events:none;
            `;
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add ripple animation keyframes
    if(!document.getElementById('ripple-style')) {
        const style = document.createElement('style');
        style.id = 'ripple-style';
        style.textContent = `@keyframes ripple{to{transform:scale(2);opacity:0;}}`;
        document.head.appendChild(style);
    }
});
</script>
@endpush

@endsection