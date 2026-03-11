@extends('layouts.user_type.auth')

@section('content')

<style>
    /* ===== THEME VARIABLES ===== */
    :root {
        --primary: #2dce89;
        --primary-dark: #24a46d;
        --info: #1171ef;
        --info-light: #0dcaf0;
        --warning: #f5365c;
        --warning-light: #fb6340;
        --success: #2dce89;
        --danger: #f5365c;
        --secondary: #67748e;
        --dark: #344767;
        --light: #f8f9fa;
        
        --card-bg: #ffffff;
        --card-bg-alt: #fafbfc;
        --text-primary: #344767;
        --text-secondary: #67748e;
        --text-muted: #adb5bd;
        --border-color: rgba(0, 0, 0, 0.08);
        --border-light: rgba(0, 0, 0, 0.04);
        
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.12);
        --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.15);
        
        --radius: 16px;
        --radius-sm: 12px;
        --radius-lg: 20px;
        
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== GLOBAL RESETS ===== */
    .card {
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        background: var(--card-bg);
    }

    .card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .card.z-index-2 {
        z-index: 2;
    }

    .card-header {
        background: linear-gradient(135deg, #fff, var(--card-bg-alt));
        border-bottom: 1px solid var(--border-color);
        padding: 18px 24px;
        position: relative;
    }

    .card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 24px;
        right: 24px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    }

    .card-header h6 {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h6 i {
        color: var(--info);
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    .card-header p {
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin: 6px 0 0;
        line-height: 1.5;
    }

    .card-body {
        padding: 20px 24px;
    }

    /* ===== SECTION HEADERS ===== */
    .section-header {
        margin: 24px 16px 16px;
        padding: 0 8px;
    }

    .section-header h5 {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-header h5::before {
        content: '';
        width: 4px;
        height: 20px;
        background: var(--primary-gradient);
        border-radius: 2px;
        display: inline-block;
    }

    .section-header h6 {
        color: var(--info);
        font-weight: 600;
        font-size: 0.95rem;
        margin: 12px 0 8px;
        padding-left: 28px;
        position: relative;
    }

    .section-header h6::before {
        content: '▸';
        position: absolute;
        left: 12px;
        color: var(--info);
        font-weight: bold;
    }

    .section-divider {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 24px 0;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0 16px;
    }

    .section-divider::before,
    .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    }

    .section-divider i {
        color: var(--info);
        font-size: 0.9rem;
    }

    /* ===== TABLE STYLING ===== */
    .table-responsive {
        border-radius: var(--radius-sm);
        overflow: hidden;
    }

    .table.align-items-center {
        margin: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: var(--text-secondary);
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table thead th:first-child {
        border-radius: 12px 0 0 0;
        padding-left: 24px;
    }

    .table thead th:last-child {
        border-radius: 0 12px 0 0;
        padding-right: 24px;
    }

    .table tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid var(--border-light);
    }

    .table tbody tr:hover {
        background: rgba(17, 113, 239, 0.04);
        transform: scale(1.001);
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .table td {
        padding: 14px 16px;
        vertical-align: middle;
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .table td:first-child {
        padding-left: 24px;
    }

    .table td:last-child {
        padding-right: 24px;
    }

    .table p {
        margin: 0;
        color: var(--text-primary);
        font-weight: 500;
    }

    .table .text-secondary {
        color: var(--text-secondary) !important;
    }

    /* Table Row Number */
    .table .row-number {
        background: rgba(17, 113, 239, 0.1);
        color: var(--info);
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
    }

    /* Table Badges */
    .table .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .table .badge.bg-gradient-info,
    .table .badge.border-info {
        background: rgba(17, 113, 239, 0.12) !important;
        color: var(--info) !important;
        border-color: rgba(17, 113, 239, 0.3) !important;
    }

    .table .badge.bg-gradient-success,
    .table .badge.border-success {
        background: rgba(45, 206, 137, 0.12) !important;
        color: var(--success) !important;
        border-color: rgba(45, 206, 137, 0.3) !important;
    }

    .table .badge.bg-gradient-warning,
    .table .badge.border-warning {
        background: rgba(251, 99, 64, 0.12) !important;
        color: var(--warning-light) !important;
        border-color: rgba(251, 99, 64, 0.3) !important;
    }

    .table .badge.bg-gradient-danger,
    .table .badge.border-danger {
        background: rgba(245, 54, 92, 0.12) !important;
        color: var(--danger) !important;
        border-color: rgba(245, 54, 92, 0.3) !important;
    }

    .table .badge.bg-gradient-primary,
    .table .badge.border-primary {
        background: rgba(17, 113, 239, 0.12) !important;
        color: var(--info) !important;
        border-color: rgba(17, 113, 239, 0.3) !important;
    }

    /* Table Action Buttons */
    .table .btn-link {
        padding: 6px 12px;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .table .btn-link.text-info {
        color: var(--info) !important;
        background: rgba(17, 113, 239, 0.08);
    }

    .table .btn-link.text-info:hover {
        background: var(--info);
        color: #fff !important;
        transform: scale(1.05);
    }

    .table .btn-link i {
        font-size: 1rem;
        transition: var(--transition);
    }

    .table .btn-link:hover i {
        transform: scale(1.1);
    }

    /* Empty State */
    .table-empty {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-secondary);
    }

    .table-empty i {
        font-size: 2.5rem;
        color: rgba(17, 113, 239, 0.2);
        margin-bottom: 12px;
        display: block;
    }

    .table-empty p {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* ===== CHART CONTAINERS ===== */
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
        padding: 16px 8px 8px;
    }

    .chart-container canvas {
        border-radius: var(--radius-sm);
    }

    .bg-gradient-dark {
        background: linear-gradient(135deg, #1a1f33, #242e4a) !important;
        border-radius: var(--radius);
        padding: 16px;
        position: relative;
        overflow: hidden;
    }

    .bg-gradient-dark::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 80%, rgba(45, 206, 137, 0.1), transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(17, 113, 239, 0.1), transparent 50%);
        pointer-events: none;
    }

    .bg-gradient-dark .chart {
        position: relative;
        z-index: 1;
    }

    /* ===== LEGEND BADGES ===== */
    .badge-dot {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(0, 0, 0, 0.03);
        border-radius: 20px;
        margin: 4px;
        transition: var(--transition);
    }

    .badge-dot:hover {
        background: rgba(0, 0, 0, 0.06);
        transform: translateY(-1px);
    }

    .badge-dot i {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
        border: 2px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .badge-dot .text-dark {
        color: var(--text-primary) !important;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .badge-dot .text-capitalize {
        text-transform: capitalize;
    }

    /* ===== BUTTONS ===== */
    .btn {
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 18px;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        position: relative;
        overflow: hidden;
    }

    .btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::after {
        left: 100%;
    }

    .btn-sm {
        padding: 6px 14px;
        font-size: 0.8rem;
    }

    .btn-outline-primary {
        border: 2px solid var(--info);
        color: var(--info);
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: var(--info);
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        border: 2px solid var(--border-color);
        color: var(--text-secondary);
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: var(--light);
        color: var(--text-primary);
        border-color: var(--text-secondary);
    }

    .btn-link {
        padding: 0;
        font-weight: 500;
        text-decoration: none;
    }

    .btn-link:hover {
        text-decoration: none;
    }

    /* ===== LOCATION/SAMPLER HEADERS ===== */
    .location-header {
        margin: 28px 16px 12px;
        padding: 12px 20px;
        background: linear-gradient(135deg, rgba(17, 113, 239, 0.08), rgba(45, 206, 137, 0.08));
        border-radius: var(--radius);
        border-left: 4px solid var(--info);
    }

    .location-header h5 {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.05rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .location-header h5::before {
        content: '📍';
        font-size: 1.1rem;
    }

    .sampler-header {
        margin: 16px 24px 8px;
        padding: 8px 16px;
        background: rgba(17, 113, 239, 0.06);
        border-radius: var(--radius-sm);
        border-left: 3px solid var(--info);
    }

    .sampler-header h6 {
        color: var(--info);
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .sampler-header h6::before {
        content: '🔹';
        font-size: 0.8rem;
    }

    /* ===== BAKU MUTU ATAS PH BADGE ===== */
    .baku-mutu-atas-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: rgba(64, 251, 54, 0.1);
        border: 1px solid rgba(54, 245, 63, 0.3);
        border-radius: 20px;
        color: var(--danger);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .baku-mutu-atas-badge i {
        font-size: 0.7rem;
    }

    /* ===== BAKU MUTU TSS BADGE ===== */
    .baku-mutu-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: rgba(245, 54, 92, 0.1);
        border: 1px solid rgba(245, 54, 92, 0.3);
        border-radius: 20px;
        color: var(--danger);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .baku-mutu-badge i {
        font-size: 0.7rem;
    }


    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.4s ease forwards;
    }

    .card:nth-child(1) { animation-delay: 0.05s; }
    .card:nth-child(2) { animation-delay: 0.1s; }
    .card:nth-child(3) { animation-delay: 0.15s; }
    .card:nth-child(4) { animation-delay: 0.2s; }
    .card:nth-child(5) { animation-delay: 0.25s; }
    .card:nth-child(6) { animation-delay: 0.3s; }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .loading {
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
        .card-header h6 {
            font-size: 0.95rem;
        }
        
        .table thead th,
        .table td {
            padding: 12px 14px;
            font-size: 0.85rem;
        }
        
        .chart-container {
            height: 240px;
        }
    }

    @media (max-width: 767px) {
        .card {
            margin: 8px !important;
        }
        
        .card-header,
        .card-body {
            padding: 16px;
        }
        
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table {
            min-width: 600px;
        }
        
        .chart-container {
            height: 200px;
        }
        
        .badge-dot {
            padding: 4px 10px;
            margin: 2px;
        }
        
        .badge-dot .text-dark {
            font-size: 0.75rem;
        }
        
        .section-header h5 {
            font-size: 1rem;
        }
        
        .location-header,
        .sampler-header {
            margin-left: 8px;
            margin-right: 8px;
        }
    }

    @media (max-width: 575px) {
        .card-header h6 {
            flex-wrap: wrap;
            gap: 6px;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .d-flex.flex-wrap {
            justify-content: center !important;
        }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(17, 113, 239, 0.3);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(17, 113, 239, 0.5);
    }

    /* ===== UTILITIES ===== */
    .text-wrap {
        word-break: break-word;
        max-width: 200px;
    }

    .opacity-7 {
        opacity: 0.7 !important;
    }

    .font-weight-bolder {
        font-weight: 700 !important;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .text-xxs {
        font-size: 0.65rem !important;
    }

    .text-xs {
        font-size: 0.75rem !important;
    }

    .text-sm {
        font-size: 0.875rem !important;
    }

    .mb-0 { margin-bottom: 0 !important; }
    .ps-2 { padding-left: 0.5rem !important; }
    .ps-3 { padding-left: 1rem !important; }
    .px-3 { padding-left: 1rem !important; padding-right: 1rem !important; }
    .py-3 { padding-top: 1rem !important; padding-bottom: 1rem !important; }
    .py-4 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
    .mt-2 { margin-top: 0.5rem !important; }
    .mt-3 { margin-top: 1rem !important; }
    .mt-4 { margin-top: 1.5rem !important; }
    .mb-3 { margin-bottom: 1rem !important; }
    .mb-4 { margin-bottom: 1.5rem !important; }
    .me-1 { margin-right: 0.25rem !important; }
    .me-2 { margin-right: 0.5rem !important; }
    .me-3 { margin-right: 1rem !important; }
    .ms-1 { margin-left: 0.25rem !important; }
    .ms-2 { margin-left: 0.5rem !important; }
    .ms-3 { margin-left: 1rem !important; }
    .ms-4 { margin-left: 1.5rem !important; }
</style>

{{-- SECTION 1: DOKUMEN KONTRAK & STATUS --}}
<div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
    <div class="card-header">
        <h6><i class="fas fa-file-contract"></i>Rekap Anggaran (Terbaru)</h6>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama</th>
                        <th class="text-center">Kontrak File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekap_anggaran as $index => $item)
                        <tr>
                            <td class="ps-3">
                                {{-- ✅ Rumus pagination agar nomor urut tetap berkesinambungan --}}
                                <span class="row-number">
                                    {{ ($rekap_anggaran->currentPage() - 1) * $rekap_anggaran->perPage() + $index + 1 }}
                                </span>
                            </td>
                            <td>
                                <p class="text-wrap fw-medium mb-0">{{ $item->nama }}</p>
                            </td>
                            <td class="align-middle text-center">
                                @if($item->file_kontrak)
                                    <a href="{{ asset('storage/' . $item->file_kontrak) }}" 
                                       target="_blank" 
                                       class="btn btn-link text-info"
                                       title="Lihat Dokumen">
                                        <i class="fa fa-file-pdf"></i>
                                    </a>
                                @else
                                    <span class="text-xs text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="table-empty py-4">
                                    <i class="fas fa-folder-open"></i>
                                    <p class="mb-0">Data belum tersedia</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination Section untuk Rekap Anggaran --}}
        @if ($rekap_anggaran->hasPages())
        <div class="card-footer px-3 py-3 border-0 bg-transparent">
            <div class="d-md-flex justify-content-between align-items-center">
                {{-- Info Text --}}
                <p class="text-xs text-secondary font-weight-bold mb-3 mb-md-0">
                    Menampilkan 
                    <span class="text-info fw-bold">{{ $rekap_anggaran->firstItem() ?? 0 }}</span> - 
                    <span class="text-info fw-bold">{{ $rekap_anggaran->lastItem() ?? 0 }}</span> 
                    dari <span class="text-info fw-bold">{{ $rekap_anggaran->total() }}</span> data
                </p>
                
                {{-- Pagination Links --}}
                <div class="pagination-container">
                    {{ $rekap_anggaran->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
    </div>

    <div class="col-lg-5">
        <div class="card z-index-2 h-100">
            <div class="card-header">
                <h6><i class="fas fa-chart-pie"></i>Grafik Status Dokumen</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart-container">
                    <canvas id="chart-status-dokumen"></canvas>
                </div>
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach(['open' => 'bg-info', 'close' => 'bg-success', 'pending' => 'bg-warning', 'proses finance' => 'bg-primary', 'hold' => 'bg-danger'] as $key => $color)
                        <span class="badge badge-dot">
                            <i class="{{ $color }}"></i>
                            <span class="text-dark text-capitalize">
                                {{ $key }}: <strong>{{ $statuscount[$key] ?? 0 }}</strong>
                            </span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SECTION 2: COMPLIANCE --}}
<div class="section-header">
    <h5><i class="fas fa-shield-alt"></i>Compliance Overview</h5>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="fas fa-clipboard-check"></i>Daftar Kepatuhan</h6>
                <a href="{{ route('compliance') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body p-3">
                <div class="card mb-4">
    <div class="card-header pb-0">
        <h6>Tabel Compliance</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pelapor / Dept</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lokasi</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Severity</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Visual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compliances as $index => $item)
                    <tr>
                        <td>
                            {{-- Agar nomor berlanjut di halaman berikutnya (Contoh: 11, 12, dst) --}}
                            <span class="ps-3 text-xs font-weight-bold">
                                {{ ($compliances->currentPage() - 1) * $compliances->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-sm fw-medium">{{ $item->Nama_pelapor }}</span>
                                <small class="text-xs text-secondary">{{ $item->Departemen }}</small>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0 text-wrap" style="max-width: 180px;">{{ $item->Lokasi }}</p>
                        </td>
                        <td class="align-middle text-center">
                            @php
                                $statusColors = [
                                    'open' => 'info',
                                    'pending' => 'warning',
                                    'resolved' => 'success',
                                    'escalated' => 'danger'
                                ];
                                $currentStatus = strtolower($item->Status);
                                $color = $statusColors[$currentStatus] ?? 'secondary';
                            @endphp
                            <span class="badge badge-sm border border-{{ $color }} text-{{ $color }}">
                                {{ $item->Status }}
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            @php
                                $severityColors = [
                                    'critical' => 'danger',
                                    'high' => 'warning',
                                    'medium' => 'info',
                                    'low' => 'secondary'
                                ];
                                $currentSeverity = strtolower($item->Tingkat_keparahan);
                                $sevColor = $severityColors[$currentSeverity] ?? 'secondary';
                            @endphp
                            <span class="badge badge-sm bg-gradient-{{ $sevColor }}">
                                {{ $item->Tingkat_keparahan }}
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            @if($item->file_dokumentasi && count((array)$item->file_dokumentasi) > 0)
                                <button class="btn btn-link text-info p-0 detail-visual-btn" 
                                        data-fotos='@json($item->file_dokumentasi)'
                                        title="Lihat Foto">
                                    <i class="fas fa-camera"></i>
                                </button>
                            @else
                                <span class="text-xs text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="table-empty">
                                <i class="fas fa-folder-open text-secondary mb-3" style="font-size: 2rem;"></i>
                                <p class="text-secondary">Belum ada data kepatuhan yang tercatat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Footer Pagination Sesuai Request --}}
    <div class="card-footer py-3 border-0 bg-transparent">
        <div class="d-md-flex justify-content-between align-items-center">
            <p class="text-xs text-secondary font-weight-bold mb-3 mb-md-0">
                Menampilkan {{ $compliances->firstItem() ?? 0 }} sampai {{ $compliances->lastItem() ?? 0 }} dari {{ $compliances->total() }} data
            </p>
            <div class="pagination-container">
                {{ $compliances->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
    
    {{-- Grafik Compliance --}}
    <div class="col-lg-6 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header">
                <h6><i class="fas fa-tasks"></i>Status Compliance</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart-container">
                    <canvas id="chart-status-compliance"></canvas>
                </div>
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach(['open' => '#11cdef', 'pending' => '#ffd400', 'resolved' => '#2dce89', 'escalated' => '#f5365c'] as $key => $hex)
                        <span class="badge badge-dot">
                            <i style="background-color: {{ $hex }};"></i>
                            <span class="text-dark text-capitalize">
                                {{ $key }}: <strong>{{ $complianceCounts[$key] ?? 0 }}</strong>
                            </span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header">
                <h6><i class="fas fa-exclamation-triangle"></i>Tingkat Keparahan</h6>
            </div>
            <div class="card-body p-3 text-center">
                <div class="chart-container">
                    <canvas id="chart-severity-compliance"></canvas>
                </div>
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach(['critical' => '#f5365c', 'high' => '#fb6340', 'medium' => '#11cdef', 'low' => '#adb5bd'] as $key => $hex)
                        <span class="badge badge-dot">
                            <i style="background-color: {{ $hex }};"></i>
                            <span class="text-dark text-capitalize">
                                {{ $key }}: <strong>{{ $severityStats[$key] ?? 0 }}</strong>
                            </span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BUKAAN LAHAN DAN REKLAMASI --}}
<div class="section-header">
    <h5><i class="fas fa-tree"></i>Bukaan Lahan & Reklamasi</h5>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-chart-area"></i>Monitoring Area</h6>
                <p class="mb-0">
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-info"></i>
                        <span class="ms-1">Bukaan Lahan (ha)</span>
                    </span>
                    <span>
                        <i class="fa-solid fa-circle text-success"></i>
                        <span class="ms-1">Reklamasi (ha)</span>
                    </span>
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-bukaanlahan-reklamasi" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Revegetasi --}}
<div class="section-header">
    <h5><i class="fas fa-seedling"></i>Monitoring Revegetasi</h5>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-chart-bar"></i>Total Pohon per Lokasi</h6>
                <p class="mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="fw-bold">Jumlah Pohon</span> yang ditanam
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-revegetasi" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pertumbuhan Rata-rata --}}
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-chart-line"></i>Pertumbuhan Rata² Tanaman</h6>
                <p class="mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="fw-bold">Nilai dalam cm</span> - Tahun {{ $currentYear }}
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-monitoring-rata2" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik Nursery --}}
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-leaf"></i>Status Pembibitan (Nursery)</h6>
                <p class="mb-0">
                    <i class="fa fa-leaf text-success"></i>
                    <span class="fw-bold">Total Bibit</span> Berdasarkan Jenis Tanaman
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-nursery" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RENCANA DAN REALISASI --}}
<div class="section-divider">
    <i class="fas fa-bullseye"></i>
    <span>Rencana vs Realisasi</span>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-tasks"></i>Penanaman Bibit Tahun {{ date('Y') }}</h6>
                <p class="mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="fw-bold">Perbandingan</span> Rencana dan Realisasi
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-revegetasi-rencana" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RITASE DAN JAM KERJA ALAT --}}
<div class="section-divider">
    <i class="fas fa-truck-monster"></i>
    <span>Ritase & Jam Kerja Alat</span>
</div>

@php
    $palette = [
        "#00d2ff", "#33ff00", "#ff9d00", "#f06292", 
        "#00e5ff", "#ffff00", "#a389f4", "#ffffff"
    ];
@endphp

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-chart-bar"></i>EXCAVATOR (Main Equipment)</h6>
                <p class="mb-0">
                    @foreach ($grupExca as $item)
                        <span class="me-3">
                            <i class="fa-solid fa-circle" style="color: {{ $palette[$loop->index % count($palette)] }}"></i>
                            <span class="ms-1">{{ $item->kode }}</span>
                        </span>
                    @endforeach
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-exca-murni" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-chart-bar"></i>EXCA LA, BREAKER & BULDOZER</h6>
                <p class="mb-0">
                    @foreach ($grupPendukung as $item)
                        <span class="me-3">
                            <i class="fa-solid fa-circle" style="color: {{ $palette[$loop->index % count($palette)] }}"></i>
                            <span class="ms-1">{{ $item->kode }}</span>
                        </span>
                    @endforeach
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-pendukung" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header">
                <h6><i class="fas fa-chart-bar"></i>DUMP TRUCK</h6>
                <p class="mb-0">
                    @foreach ($grupDT as $item)
                        <span class="me-3">
                            <i class="fa-solid fa-circle" style="color: {{ $palette[$loop->index % count($palette)] }}"></i>
                            <span class="ms-1">{{ $item->kode }}</span>
                        </span>
                    @endforeach
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-dt" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- WASTE WATER MANAGEMENT --}}
<div class="section-divider">
    <i class="fas fa-tint"></i>
    <span>Waste Water Management</span>
</div>

@foreach($wasteWaterGroups as $lokasi => $samplers)
    <div class="location-header">
        <h5>{{ $lokasi }}</h5>
    </div>

    @foreach($samplers as $sampler => $data)
        <div class="sampler-header">
            <h6>{{ $sampler }}</h6>
        </div>

        <div class="row">
            {{-- Card pH Air --}}
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header">
                        <h6><i class="fas fa-tint"></i>pH Air</h6>
                        {{-- <p class="mb-3 text-xs text-muted">Monitoring air limbah</p> --}}
                            <span class="baku-mutu-atas-badge">
                                <i class="fa fa-arrow-up"></i>
                                Baku Atas: {{ $bmAtas }} mg/L
                            </span>
                            <span class="baku-mutu-badge">
                                <i class="fa fa-arrow-down"></i>
                                Baku Bawah: {{ $bmBawah }} mg/L
                            </span>
                    </div>
                    <div class="card-body p-3">
                        <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                            <div class="chart">
                                <canvas id="chart-ph-{{ Str::slug($lokasi . '-' . $sampler) }}" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card TSS Air --}}
            <div class="col-lg-6">
                <div class="card z-index-2 h-100">
                    <div class="card-header">
                        <h6><i class="fas fa-weight-hanging"></i>Monitoring TSS Air</h6>
                        <p class="mb-0">
                            <span class="baku-mutu-badge">
                                <i class="fa fa-arrow-up"></i>
                                Baku Mutu: {{ $bmTss }} mg/L
                            </span>
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                            <div class="chart">
                                <canvas id="chart-tss-{{ Str::slug($lokasi . '-' . $sampler) }}" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-4"></div>
    @endforeach
    
    <hr class="horizontal dark my-5">
@endforeach

@endsection

@push('dashboard')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize all charts
    @include('chart.status-dokumen')
    @include('chart.compliace')
    @include('chart.bukaanlahan-reklamasi')
    @include('chart.revegetasi')
    @include('chart.performa-vegetasi')
    @include('chart.rencana-realisasi')
    @include('chart.nursery')
    @include('chart.work-hours')
    @include('chart.waste-water')
    
    // Add hover effect to table rows
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.zIndex = '1';
        });
    });
    
    // Add tooltip to badges
    document.querySelectorAll('.badge-dot').forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush