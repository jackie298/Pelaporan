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

    /* ===== MODAL VISUAL DOKUMEN ===== */
    .nka-card {
        background: #fff;
        border: 2px solid #0d4435;
        border-radius: 12px;
        overflow: hidden;
        margin: auto;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        max-width: 100%;
    }

    .nka-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 4px;
        background-color: #eee;
        padding: 4px;
    }

    .nka-grid-container.single-photo {
        grid-template-columns: 1fr;
    }

    .nka-grid-item {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #333;
        cursor: pointer;
        transition: var(--transition);
    }

    .nka-grid-item:hover {
        transform: scale(1.02);
        z-index: 5;
    }

    .nka-grid-item img.main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .nka-logo-watermark {
        position: absolute;
        bottom: 8px;
        left: 8px;
        width: 40px;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5));
        z-index: 10;
        opacity: 0.9;
    }

    .nka-header-box {
        background-color: #0d4435;
        color: #ffffff;
        padding: 15px 20px;
        border-top: 4px solid #c05c2e;
    }

    .nka-footer-label {
        color: #2ecc71;
        font-weight: bold;
        text-decoration: underline;
        font-size: 0.85rem;
    }

    .nka-info-text {
        font-size: 0.8rem;
        margin-bottom: 3px;
        line-height: 1.4;
        color: rgba(255,255,255,0.9);
    }

    /* Lightbox overlay untuk zoom foto */
    .nka-lightbox {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .nka-lightbox.active {
        display: flex;
    }

    .nka-lightbox img {
        max-width: 90vw;
        max-height: 90vh;
        border-radius: 8px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .nka-lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 2rem;
        cursor: pointer;
        background: rgba(255,255,255,0.1);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .nka-lightbox-close:hover {
        background: rgba(255,255,255,0.2);
        transform: rotate(90deg);
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

    /* ===== URGENCY BORDER INDICATORS ===== */
    tr.urgency-critical td:first-child {
        border-left: 4px solid #f5365c !important;
        animation: pulse-critical 2.5s infinite;
    }
    tr.urgency-high td:first-child {
        border-left: 4px solid #fb6340 !important;
    }
    tr.urgency-medium td:first-child {
        border-left: 4px solid #1171ef !important;
    }

    @keyframes pulse-critical {
        0%, 100% { box-shadow: 0 0 0 0 rgba(245, 54, 92, 0.15); }
        50% { box-shadow: 0 0 0 8px rgba(245, 54, 92, 0); }
    }

    /* ===== TOOLTIP CUSTOM ===== */
    .time-detail-tooltip {
        position: relative;
        cursor: help;
    }
    .time-detail-tooltip:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #344767;
        color: #fff;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        white-space: nowrap;
        z-index: 100;
        margin-bottom: 4px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .time-detail-tooltip:hover::before {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) rotate(45deg);
        width: 8px;
        height: 8px;
        background: #344767;
        margin-bottom: -4px;
        z-index: 99;
    }

    /* ===== PAGINATION STYLING ===== */
    .pagination-container .pagination {
        gap: 4px;
        margin: 0;
        flex-wrap: wrap;
    }
    .pagination-container .page-item .page-link {
        border: none;
        border-radius: 8px !important;
        color: var(--text-secondary, #67748e);
        font-size: 0.75rem;
        padding: 6px 12px;
        margin: 0 2px;
        transition: all 0.2s ease;
        background: var(--light, #f8f9fa);
    }
    .pagination-container .page-item.active .page-link {
        background: var(--info, #1171ef) !important;
        color: #fff !important;
        font-weight: 600;
    }
    .pagination-container .page-item:not(.active) .page-link:hover {
        background: var(--info, #1171ef);
        color: #fff !important;
        transform: translateY(-1px);
    }
    .pagination-container .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="fas fa-file-contract"></i> Rekap Anggaran</h6>
                <span class="badge bg-gradient-info text-white text-xs">
                    Periode: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                </span>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Kegiatan/Dokumen</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekap_anggaran as $index => $item)
                                <tr>
                                    <td class="ps-3 text-sm">
                                        {{ ($rekap_anggaran->currentPage() - 1) * $rekap_anggaran->perPage() + $index + 1 }}
                                    </td>
                                    <td>
                                        <p class="text-wrap fw-medium mb-0 text-sm">{{ $item->nama }}</p>
                                        <span class="text-xxs text-muted">Input: {{ $item->created_at->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($item->file_kontrak)
                                            <a href="{{ asset('storage/' . $item->file_kontrak) }}" target="_blank" class="btn btn-link text-info p-0 mb-0">
                                                <i class="fa fa-file-pdf text-lg"></i>
                                            </a>
                                        @else
                                            <span class="text-xs text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <p class="text-sm mb-0">Belum ada data anggaran untuk periode <strong>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                        @if($rekap_anggaran->count() > 0)
                        <tfoot class="bg-gray-100">
                            <tr>
                                <td colspan="2" class="ps-3 py-2 text-end">
                                    <span class="text-xs font-weight-bold">Total Anggaran {{ \Carbon\Carbon::now()->translatedFormat('F') }}:</span>
                                </td>
                                <td class="text-center py-2">
                                    <span class="text-info text-sm font-weight-bolder">
                                        Rp{{ number_format($totalAnggaranBulanIni, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($rekap_anggaran->hasPages())
                <div class="card-footer px-3 py-3 border-0 bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-xxs text-secondary mb-0">
                            Hal {{ $rekap_anggaran->currentPage() }} dari {{ $rekap_anggaran->lastPage() }}
                        </p>
                        <div class="pagination-container text-xxs">
                            {{ $rekap_anggaran->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0">
                <h6><i class="fas fa-chart-pie"></i> Grafik Status Dokumen</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart-container" style="position: relative; height:200px;">
                    <canvas id="chart-status-dokumen"></canvas>
                </div>
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach(['open' => 'bg-info', 'close' => 'bg-success', 'pending' => 'bg-warning', 'proses finance' => 'bg-primary', 'hold' => 'bg-danger'] as $key => $color)
                        <span class="badge badge-dot me-3">
                            <i class="{{ $color }}"></i>
                            <span class="text-dark text-xxs text-capitalize">
                                {{ $key }}: <strong>{{ $statuscount[$key] ?? 0 }}</strong>
                            </span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- LOGBOOK LIMBAH B3 SECTION --}}
<div class="section-divider">
    <i class="fas fa-drumstick-bite"></i>
    <span>Logbook Limbah B3</span>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="fas fa-clipboard-list"></i> Monitoring Limbah Berbahaya</h6>
                <a href="{{ route('waste-b3') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body p-3">
                
                {{-- Stats Cards dengan Urgency Breakdown --}}
                <div class="row px-1 mb-3">
                    @php
                        $stats = [
                            [
                                'label' => 'Total Log', 
                                'val' => $summaryStats['total'] ?? 0, 
                                'icon' => 'fa-database', 
                                'color' => '#344767',
                                'sub' => 'semua data'
                            ],
                            [
                                'label' => 'Aktif', 
                                'val' => $summaryStats['belum_dikeluarkan'] ?? 0, 
                                'icon' => 'fa-warehouse', 
                                'color' => '#1171ef',
                                'sub' => 'perlu tindakan'
                            ],
                            [
                                'label' => '🔥 Mendesak', 
                                'val' => $summaryStats['urgensi_tinggi'] ?? 0, 
                                'icon' => 'fa-fire', 
                                'color' => '#fb6340',
                                'sub' => '≤ 3 hari',
                                'highlight' => ($summaryStats['urgensi_tinggi'] ?? 0) > 0
                            ],
                            [
                                'label' => '⚠️ Kadaluarsa', 
                                'val' => $summaryStats['kadaluarsa'] ?? 0, 
                                'icon' => 'fa-exclamation-triangle', 
                                'color' => '#f5365c',
                                'sub' => 'sudah lewat'
                            ],
                        ];
                    @endphp
                    @foreach($stats as $s)
                    <div class="col-xl-3 col-sm-6 mb-2">
                        <div class="card h-100 {{ $s['highlight'] ?? false ? 'border-warning border-2' : '' }}">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box shadow text-center" 
                                         style="width:40px;height:40px;border-radius:10px;background:{{ $s['color'] }};display:flex;align-items:center;justify-content:center;color:#fff;">
                                        <i class="fas {{ $s['icon'] }} opacity-10" style="font-size:1rem;"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-xxs mb-0 text-uppercase font-weight-bold text-muted">{{ $s['label'] }}</p>
                                        <h6 class="font-weight-bolder mb-0 {{ $s['highlight'] ?? false ? 'text-warning' : '' }}">
                                            {{ is_numeric($s['val']) ? number_format($s['val']) : $s['val'] }}
                                        </h6>
                                        @if(isset($s['sub']))
                                            <span class="text-xxs text-muted">{{ $s['sub'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Table Preview --}}
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Jenis Limbah</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Asal & Tanggal</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sisa / Total</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Batas Simpan</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($wasteB3Preview as $data)
                            @php
                                $sisa = $data->sisa_waktu;
                                $urgencyClass = $sisa['is_expired'] ? 'urgency-critical' : 
                                               ($sisa['total_hari'] !== null && $sisa['total_hari'] <= 3 ? 'urgency-high' : 
                                               ($sisa['total_hari'] !== null && $sisa['total_hari'] <= 7 ? 'urgency-medium' : ''));
                            @endphp
                            <tr class="{{ $urgencyClass }}">
                                <td class="ps-3">
                                    <div class="d-flex flex-column">
                                        <span class="text-sm font-weight-bold">{{ $data->jenis_limbah }}</span>
                                        <span class="text-xxs text-info">{{ $data->kode_limbah }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column text-xs">
                                        <span><i class="far fa-calendar-alt me-1 text-muted"></i> {{ $data->tanggal_masuk_formatted }}</span>
                                        <span class="text-muted mt-1"><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($data->sumber_limbah, 25) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-xxs font-weight-bold">{{ $data->sisa_limbah_formatted }} / {{ $data->jumlah_ton_formatted }}</span>
                                        @php 
                                            $p = ($data->jumlah_ton > 0) ? min(100, ($data->sisa_limbah / $data->jumlah_ton) * 100) : 0;
                                            $barColor = $p > 50 ? '#2dce89' : ($p > 15 ? '#fb6340' : '#f5365c');
                                        @endphp
                                        <div class="progress" style="height:4px;border-radius:10px;background:#f0f2f5;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width:{{ $p }}%;background:{{ $barColor }};border-radius:10px;"></div>
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Kolom Batas Simpan dengan Detail Waktu --}}
                                <td class="text-center" style="min-width: 140px;">
                                    <div class="d-flex flex-column align-items-center">
                                        {{-- Tanggal batas --}}
                                        <span class="text-xxs text-muted mb-1">
                                            <i class="far fa-calendar me-1"></i>{{ $sisa['raw_date'] }}
                                        </span>
                                        
                                        {{-- Badge sisa waktu --}}
                                        <span class="badge badge-sm bg-gradient-{{ $sisa['badge_color'] }} text-xxs px-2 py-1 mb-1" 
                                            style="border-radius: 12px; min-width: 110px;">
                                            <i class="fas {{ $sisa['icon'] }} me-1"></i>
                                            {{ $sisa['label'] }}
                                        </span>

                                        {{-- Tampilkan detail breakdown di bawahnya --}}
                                        @if(!$sisa['is_expired'])
                                            <span class="text-xxs text-secondary">
                                                @if($sisa['tahun'] > 0)
                                                    <strong>{{ $sisa['tahun'] }} tahun</strong>
                                                @endif
                                                @if($sisa['bulan'] > 0)
                                                    {{ $sisa['tahun'] > 0 ? '• ' : '' }}<strong>{{ $sisa['bulan'] }} bulan</strong>
                                                @endif
                                                @if($sisa['hari'] > 0)
                                                    {{ ($sisa['tahun'] > 0 || $sisa['bulan'] > 0) ? '• ' : '' }}<strong>{{ $sisa['hari'] }} hari</strong>
                                                @endif
                                            </span>
                                        @endif
                                        
                                        {{-- Progress bar mini --}}
                                        @if($sisa['total_hari'] !== null && $sisa['total_hari'] >= 0)
                                            @php
                                                $maxDays = 365;
                                                $progress = min(100, max(0, ($sisa['total_hari'] / $maxDays) * 100));
                                                $progressColor = $sisa['total_hari'] <= 3 ? '#f5365c' : 
                                                                ($sisa['total_hari'] <= 7 ? '#fb6340' : 
                                                                ($sisa['total_hari'] <= 30 ? '#1171ef' : '#2dce89'));
                                            @endphp
                                            <div class="progress mt-1" style="height: 3px; width: 100px; background: #f0f2f5; border-radius: 10px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $progress }}%; background: {{ $progressColor }}; border-radius: 10px;"></div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    @php
                                        // Status colors sesuai STATUS_OPTIONS di model
                                        $statusColors = [
                                            'belum_dikeluarkan' => 'info',
                                            'sebagian_dikeluarkan' => 'warning',
                                            'sudah_dikeluarkan' => 'success',
                                            'kadaluarsa' => 'danger',
                                        ];
                                        $badgeColor = $statusColors[$data->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $badgeColor }} text-xxs px-3 py-2" style="border-radius:20px;">
                                        {{ $data->status_label }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if($data->can_be_dikeluarkan && !$sisa['is_expired'])
                                        <a href="{{ route('waste-b3-keluar.create1', ['masuk_id' => $data->id]) }}" 
                                           class="btn btn-link text-success p-0 mb-0" title="Proses Keluar">
                                            <i class="fas fa-sign-out-alt text-xs"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('waste-b3.edit', $data->id) }}" 
                                           class="btn btn-link text-info p-0 mb-0" title="Edit">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="table-empty">
                                        <i class="fas fa-drumstick-bite text-secondary mb-2" style="font-size:1.8rem;"></i>
                                        <p class="text-xs text-secondary mb-0">Belum ada data limbah B3.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Links --}}
                @if($wasteB3Preview->hasPages())
                <div class="card-footer py-3 border-0 bg-transparent">
                    <div class="d-md-flex justify-content-between align-items-center">
                        <p class="text-xs text-secondary font-weight-bold mb-3 mb-md-0">
                            Menampilkan {{ $wasteB3Preview->firstItem() ?? 0 }} sampai {{ $wasteB3Preview->lastItem() ?? 0 }} 
                            dari {{ $wasteB3Preview->total() }} data
                        </p>
                        <div class="pagination-container">
                            {{ $wasteB3Preview->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Footer Link --}}
                <div class="text-center mt-2">
                    <a href="{{ route('waste-b3') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-list me-1"></i> Buka Halaman Lengkap
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>

{{-- Pengelolaan Sampah --}}
<div class="section-divider">
    <i class="fa-solid fa-recycle"></i>
    <span>Pengelolaan Sampah</span>
</div>

<div class="row mb-3">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card card-stats">
            <div class="card-body text-center py-3">
                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-lg mb-2">
                    <i class="fa-solid fa-building text-white"></i>
                </div>
                <h5 class="mb-0">{{ number_format($wasteStats['total_bulan_ini'] ?? 0, 0, ',', '.') }} kg</h5>
                <small class="text-muted">Area Kantor (Bulan Ini)</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card card-stats">
            <div class="card-body text-center py-3">
                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-lg mb-2">
                    <i class="fa-solid fa-industry text-white"></i>
                </div>
                <h5 class="mb-0">{{ number_format(($wasteStats['total_bulan_ini'] ?? 0) * 0.6, 0, ',', '.') }} kg</h5>
                <small class="text-muted">Area Site (Bulan Ini)*</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stats">
            <div class="card-body text-center py-3">
                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-lg mb-2">
                    <i class="fa-solid fa-scale-balanced text-white"></i>
                </div>
                <h5 class="mb-0">{{ number_format(($wasteStats['total_bulan_ini'] ?? 0) * 1.6, 0, ',', '.') }} kg</h5>
                <small class="text-muted">Total Gabungan</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0"><i class="fas fa-chart-line text-primary me-2"></i>Grafik Pengelolaan Sampah {{ date('Y') }}</h6>
                        <p class="mb-0 text-sm text-muted">
                            <i class="fa fa-arrow-up text-success me-1"></i>
                            <span class="fw-bold">Total Sampah Terkelola</span> Area Kantor & Site
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="chart position-relative">
                    <canvas id="chart-pengelolaan-sampah" class="chart-canvas" height="300"></canvas>
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
                                        data-nama="{{ $item->Nama_pelapor }}"
                                        data-departemen="{{ $item->Departemen }}"
                                        data-lokasi="{{ $item->Lokasi }}"
                                        data-jenis-insiden="{{ $item->Jenis_insiden ?? '-' }}"
                                        data-jenis-inspeksi="{{ $item->Jenis_inspeksi ?? '-' }}"
                                        data-tanggal="{{ $item->Tanggal_lapor ? \Carbon\Carbon::parse($item->Tanggal_lapor)->format('d/m/Y') : '-' }}"
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
    <span>Rencana Dan Realisasi</span>
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

<!-- ======================================== -->
<!-- MODAL VISUAL DOKUMEN COMPLIANCE          -->
<!-- ======================================== -->
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
                    <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox untuk Zoom Foto -->
<div class="nka-lightbox" id="nkaLightbox">
    <span class="nka-lightbox-close" id="nkaLightboxClose">&times;</span>
    <img src="" id="nkaLightboxImg" alt="Zoomed">
</div>

@endsection

@push('dashboard')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === Initialize all existing charts ===
    @include('chart.status-dokumen')
    @include('chart.compliace')
    @include('chart.bukaanlahan-reklamasi')
    @include('chart.revegetasi')
    @include('chart.performa-vegetasi')
    @include('chart.rencana-realisasi')
    @include('chart.nursery')
    @include('chart.work-hours')
    @include('chart.waste-water')
    @include('chart.pengelolaan-sampah')
    
    // === 🗑️ WASTE MANAGEMENT CHARTS (FIXED) ===
    if (document.getElementById('chart-waste-type')) {
        new Chart(document.getElementById('chart-waste-type').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: @json($wasteTypeLabels),
                datasets: [{
                    data: @json($wasteTypeValues),
                    backgroundColor: @json($wasteTypeColors),
                    borderWidth: 0,
                    hoverOffset: 12,
                    spacing: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.parsed.toLocaleString('id-ID')} kg (${ctx.dataset.data.reduce((a,b)=>a+b,0)>0 ? Math.round((ctx.parsed/ctx.dataset.data.reduce((a,b)=>a+b,0))*100) : 0}%)`
                        }
                    }
                }
            }
        });
    }

    if (document.getElementById('chart-waste-trend')) {
        const ctxTrend = document.getElementById('chart-waste-trend').getContext('2d');
        const grad = ctxTrend.createLinearGradient(0,0,0,280);
        grad.addColorStop(0, 'rgba(45,206,137,0.35)');
        grad.addColorStop(1, 'rgba(45,206,137,0.02)');

        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: @json($wasteTrendLabels),
                datasets: [{
                    label: 'Total Sampah (kg)',
                    data: @json($wasteTrendValues),
                    borderColor: '#2dce89',
                    backgroundColor: grad,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 2,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2dce89'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: { label: ctx => `Total: ${ctx.parsed.y.toLocaleString('id-ID')} kg` }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.75)', maxRotation: 0, autoSkip: true, maxTicksLimit: 10 } },
                    y: { grid: { color: 'rgba(255,255,255,0.12)' }, ticks: { color: 'rgba(255,255,255,0.75)', callback: v => v>=1000?(v/1000).toFixed(1)+'K':v }, beginAtZero: true }
                }
            }
        });
    }

    if (document.getElementById('chart-waste-source')) {
        new Chart(document.getElementById('chart-waste-source').getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($wasteSourceLabels),
                datasets: [{
                    label: 'Total Sampah (kg)',
                    data: @json($wasteSourceValues),
                    backgroundColor: @json($wasteSourceColors),
                    borderRadius: 10,
                    borderSkipped: false,
                    barThickness: 70
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => `Total: ${ctx.parsed.toLocaleString('id-ID')} kg` } }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.95)' } },
                    y: { grid: { color: 'rgba(255,255,255,0.12)' }, ticks: { color: 'rgba(255,255,255,0.75)', callback: v => v>=1000?(v/1000).toFixed(1)+'K':v }, beginAtZero: true }
                }
            }
        });
    }

    // === Table row hover effect ===
    document.querySelectorAll('.table tbody tr').forEach(row => { row.addEventListener('mouseenter', function() { this.style.zIndex = '1'; }); });
    
    // === Badge hover effect ===
    document.querySelectorAll('.badge-dot').forEach(badge => { badge.addEventListener('mouseenter', function() { this.style.transform = 'translateY(-2px)'; }); badge.addEventListener('mouseleave', function() { this.style.transform = 'translateY(0)'; }); });

    // === MODAL VISUAL HANDLER ===
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.detail-visual-btn');
        if (!btn) return;
        e.preventDefault();
        const fotos = JSON.parse(btn.getAttribute('data-fotos') || '[]');
        document.getElementById('v-nama').textContent = "Pelapor: " + (btn.getAttribute('data-nama') || '-');
        document.getElementById('v-departemen').textContent = btn.getAttribute('data-departemen') || '-';
        document.getElementById('v-lokasi').textContent = btn.getAttribute('data-lokasi') || '-';
        document.getElementById('v-jenis-insiden').textContent = btn.getAttribute('data-jenis-insiden') || '-';
        document.getElementById('v-jenis-inspeksi').textContent = btn.getAttribute('data-jenis-inspeksi') || '-';
        document.getElementById('v-tanggal').textContent = "📅 " + (btn.getAttribute('data-tanggal') || '-');
        const grid = document.getElementById('photo-grid');
        grid.innerHTML = '';
        grid.classList.toggle('single-photo', fotos.length === 1);
        if (fotos.length > 0) {
            fotos.forEach((path, idx) => {
                const ext = (path.split('.').pop() || '').toLowerCase();
                let content = '';
                const storagePath = `/storage/${path}`;
                const fallbackImg = `{{ asset('assets/img/default-image.png') }}`;
                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    content = `<img src="${storagePath}" class="main-img nka-zoomable" data-full="${storagePath}" onerror="this.src='${fallbackImg}'" alt="Dokumentasi ${idx + 1}">`;
                } else if (ext === 'pdf') {
                    content = `<a href="${storagePath}" target="_blank" class="text-decoration-none"><div class="d-flex align-items-center justify-content-center bg-light" style="height: 100%;"><i class="fas fa-file-pdf fa-4x text-danger"></i><div class="mt-2 text-xs text-muted">Klik untuk buka PDF</div></div></a>`;
                } else {
                    content = `<a href="${storagePath}" target="_blank" class="text-decoration-none"><div class="d-flex align-items-center justify-content-center bg-light" style="height: 100%;"><i class="fas fa-file fa-4x text-muted"></i><div class="mt-2 text-xs text-muted">${ext.toUpperCase()}</div></div></a>`;
                }
                grid.innerHTML += `<div class="nka-grid-item">${content}<img src="{{ asset('assets/img/logoperusahaan.png') }}" class="nka-logo-watermark" alt="Logo"></div>`;
            });
        } else {
            grid.innerHTML = '<div class="p-4 text-center w-100 text-muted">Tidak ada dokumen visual.</div>';
        }
        const modalEl = document.getElementById('detailKegiatanModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

    // === LIGHTBOX HANDLER ===
    const lightbox = document.getElementById('nkaLightbox');
    const lightboxImg = document.getElementById('nkaLightboxImg');
    const lightboxClose = document.getElementById('nkaLightboxClose');
    document.getElementById('photo-grid')?.addEventListener('click', function(e) {
        const zoomable = e.target.closest('.nka-zoomable');
        if (zoomable) {
            e.preventDefault();
            lightboxImg.src = zoomable.getAttribute('data-full') || zoomable.src;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    });
    function closeLightbox() { lightbox.classList.remove('active'); lightboxImg.src = ''; document.body.style.overflow = ''; }
    lightboxClose?.addEventListener('click', closeLightbox);
    lightbox?.addEventListener('click', function(e) { if (e.target === lightbox) closeLightbox(); });
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && lightbox.classList.contains('active')) closeLightbox(); });
    document.getElementById('detailKegiatanModal')?.addEventListener('hidden.bs.modal', function () { document.getElementById('photo-grid').innerHTML = ''; });
});
</script>
@endpush