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

    .progress-slim { height: 5px !important; margin-top: 5px; border-radius: 10px; }
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
    }
    .action-link:hover { background: #e9ecef; color: #344767; }
    
    /* File indicator badge */
    .file-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.2rem 0.5rem;
        background: rgba(33, 82, 255, 0.1);
        color: #2152ff;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    .file-badge:hover {
        background: rgba(33, 82, 255, 0.2);
        text-decoration: none;
        color: #2152ff;
    }
    .file-badge.no-file {
        background: #f0f2f5;
        color: #8392ab;
    }
</style>

<div class="main-content-wrapper">
    <div class="custom-header">
        <div class="d-md-flex align-items-center justify-content-between">
            <div>
                <h4 class="text-white font-weight-bolder mb-0">Logbook Limbah B3</h4>
                <p class="text-white opacity-8 text-sm">Monitoring limbah berbahaya secara real-time.</p>
            </div>
            <a href="{{ route('waste-b3.create') }}" class="btn btn-white btn-round mb-0 mt-3 mt-md-0 shadow-sm">
                <i class="fas fa-plus text-primary me-2 text-xs"></i> Tambah Data
            </a>
        </div>
    </div>

    <div class="row px-3 mb-4">
        @php
            $stats = [
                ['label' => 'Total Log', 'val' => $summaryStats['total'] ?? 0, 'icon' => 'fa-database', 'bg' => 'bg-gradient-dark'],
                ['label' => 'Penyimpanan', 'val' => $summaryStats['belum_dikeluarkan'] ?? 0, 'icon' => 'fa-warehouse', 'bg' => 'bg-gradient-primary'],
                ['label' => 'Kadaluarsa', 'val' => $summaryStats['kadaluarsa'] ?? 0, 'icon' => 'fa-exclamation-triangle', 'bg' => 'bg-gradient-danger'],
                ['label' => 'Volume (Ton)', 'val' => number_format($summaryStats['total_ton'] ?? 0, 2), 'icon' => 'fa-weight', 'bg' => 'bg-gradient-success']
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

    <div class="filter-container mx-3">
        <form action="{{ route('waste-b3') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-xs font-weight-bold">Jenis Limbah</label>
                <div class="input-group shadow-none border-radius-sm">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="jenis" class="form-control border-0 bg-light text-sm" placeholder="Cari limbah..." value="{{ request('jenis') }}">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label text-xs font-weight-bold">Status</label>
                <select name="status" class="form-select border-0 bg-light text-sm">
                    <option value="">Semua Status</option>
                    @foreach($statusOptions as $v => $l)
                        <option value="{{ $v }}" {{ request('status') == $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-xs font-weight-bold">Rentang Tanggal</label>
                <div class="d-flex align-items-center">
                    <input type="date" name="tanggal_dari" class="form-control border-0 bg-light text-sm" value="{{ request('tanggal_dari') }}">
                    <span class="mx-2 text-muted text-xs">s/d</span>
                    <input type="date" name="tanggal_sampai" class="form-control border-0 bg-light text-sm" value="{{ request('tanggal_sampai') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-round w-100 mb-0">Filter</button>
                <a href="{{ route('waste-b3') }}" class="btn btn-light btn-round mb-0"><i class="fas fa-redo-alt"></i></a>
            </div>
        </form>
    </div>

    <div class="card custom-table-card mx-3">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase font-weight-bolder">Informasi Limbah</th>
                        <th class="text-uppercase font-weight-bolder">Asal & Tanggal</th>
                        <th class="text-uppercase font-weight-bolder">Kapasitas Sisa</th>
                        <th class="text-center text-uppercase font-weight-bolder">Batas Simpan</th>
                        <th class="text-center text-uppercase font-weight-bolder">Berita Acara</th>
                        <th class="text-center text-uppercase font-weight-bolder">Status</th>
                        <th class="text-center text-uppercase font-weight-bolder">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wasteB3Masuk as $data)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex flex-column">
                                <span class="text-sm font-weight-bold text-dark">{{ $data->jenis_limbah }}</span>
                                <span class="text-xxs text-primary font-weight-bold">{{ $data->kode_limbah }}</span>
                                @if($data->nomor_manifest)
                                    <span class="text-xxs text-muted mt-1"><i class="fas fa-file-alt me-1"></i>{{ Str::limit($data->nomor_manifest, 15) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column text-xs">
                                <span><i class="far fa-calendar-alt me-1 text-muted"></i> {{ $data->tanggal_masuk_formatted }}</span>
                                <span class="text-muted mt-1"><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($data->sumber_limbah, 20) }}</span>
                            </div>
                        </td>
                        <td style="min-width: 150px;">
                            <div class="d-flex flex-column">
                                {{-- ✅ PERUBAHAN DI SINI: Format 3 angka desimal --}}
                                <span class="text-xxs font-weight-bold">
                                    {{ number_format($data->sisa_limbah, 3, ',', '.') }} Ton / {{ $data->jumlah_ton_formatted }}
                                </span>
                                @php 
                                    // Pastikan perhitungan progress bar menggunakan nilai float, bukan string formatted
                                    $sisa = is_numeric($data->sisa_limbah) ? $data->sisa_limbah : floatval(str_replace(',', '.', $data->sisa_limbah_formatted));
                                    $total = $data->jumlah_ton;
                                    $p = ($total > 0) ? min(100, ($sisa / $total) * 100) : 0;
                                    $c = $p > 50 ? 'bg-gradient-success' : ($p > 15 ? 'bg-gradient-warning' : 'bg-gradient-danger');
                                @endphp
                                <div class="progress progress-slim">
                                    <div class="progress-bar {{ $c }}" role="progressbar" style="width: {{ $p }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center text-xs font-weight-bold">
                            <span class="{{ $data->is_kadaluarsa ? 'text-danger' : 'text-muted' }}">
                                <i class="far fa-clock me-1"></i>{{ $data->maksimal_penyimpanan_formatted }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($data->berita_acara)
                                <a href="{{ Storage::url('waste-b3/berita-acara/' . $data->berita_acara) }}" 
                                   target="_blank" 
                                   class="file-badge" 
                                   title="Download: {{ $data->berita_acara }}">
                                    <i class="fas fa-file-{{ pathinfo($data->berita_acara, PATHINFO_EXTENSION) == 'pdf' ? 'pdf' : 'image' }}"></i>
                                    <span class="d-none d-md-inline">{{ Str::limit(pathinfo($data->berita_acara, PATHINFO_FILENAME), 10) }}</span>
                                </a>
                            @else
                                <span class="file-badge no-file">
                                    <i class="fas fa-minus"></i>
                                    <span class="d-none d-md-inline">-</span>
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-sm bg-gradient-{{ $data->status_badge_color }} text-xxs px-3 py-2" style="border-radius: 20px;">
                                {{ $data->status_label }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                @if($data->can_be_dikeluarkan)
                                <a href="{{ route('waste-b3-keluar.create1', ['masuk_id' => $data->id]) }}" class="action-link text-success" title="Keluar">
                                    <i class="fas fa-sign-out-alt text-xs"></i>
                                </a>
                                @endif
                                <a href="{{ route('waste-b3.edit', $data->id) }}" class="action-link text-info" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                {{-- <a href="{{ route('waste-b3.show', $data->id) }}" class="action-link text-secondary" title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a> --}}
                                <button type="button" class="action-link text-danger delete-btn" data-id="{{ $data->id }}" data-nama="{{ $data->jenis_limbah }}">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($wasteB3Masuk->hasPages())
        <div class="card-footer py-3 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-xs text-secondary mb-0">
                    Showing {{ $wasteB3Masuk->firstItem() }} to {{ $wasteB3Masuk->lastItem() }} of {{ $wasteB3Masuk->total() }} entries
                </p>
                <div>
                    {{ $wasteB3Masuk->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
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
                    Anda yakin ingin menghapus data limbah <strong class="text-danger" id="wasteName"></strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                <p class="text-xs text-muted mt-2 mb-0">
                    <i class="fas fa-info-circle me-1"></i>File berita acara juga akan dihapus permanen.
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

<!-- Toast Notification -->
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
        // Delete Modal Handler
        document.body.addEventListener('click', function (e) {
            const btn = e.target.closest('.delete-btn');
            if (btn) {
                document.getElementById('wasteName').textContent = btn.dataset.nama;
                document.getElementById('deleteForm').action = `/waste-b3/${btn.dataset.id}`;
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            }
        });

        // Auto-hide toasts
        const toastElList = document.querySelectorAll('.toast');
        [...toastElList].map(toast => {
            setTimeout(() => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            }, 5000);
        });
    });
</script>
@endpush
@endsection