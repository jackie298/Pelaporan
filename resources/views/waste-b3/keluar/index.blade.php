@extends('layouts.user_type.auth')

@section('content')
<style>
    /* ===== PREMIUM SOFT UI 2.0 ENHANCEMENTS ===== */
    :root {
        --primary-gradient: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
        --secondary-bg: #f8f9fa;
    }

    .main-content-wrapper { padding: 1.5rem; animation: fadeIn 0.5s ease; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Glassmorphism Header */
    .custom-header {
        background: var(--primary-gradient);
        border-radius: 1.25rem;
        padding: 3rem 2rem 6rem 2rem;
        margin-bottom: -4.5rem;
        position: relative;
        overflow: hidden;
    }

    .custom-header .bg-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 0;
    }

    /* Stats Card Enhancement */
    .stat-card {
        border: none;
        border-radius: 1rem;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.03);
    }
    .stat-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
    }

    /* Modern Filter Bar */
    .filter-wrapper {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border-radius: 1rem;
        padding: 1.25rem;
        margin: 0 1.5rem 1.5rem 1.5rem;
        border: 1px solid #fff;
        box-shadow: 0 8px 26px -4px rgba(20, 20, 20, 0.1);
    }

    .form-control-soft {
        border-radius: 0.75rem;
        border: 1px solid #d2d6da;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s;
    }
    .form-control-soft:focus {
        border-color: #cb0c9f;
        box-shadow: 0 0 0 2px rgba(203, 12, 159, 0.2);
    }

    /* Table & Action Buttons */
    .table-container {
        background: #fff;
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
    }

    .btn-action {
        width: 34px;
        height: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        background-color: #fff;
        border: 1px solid #f0f2f5;
        color: #67748e;
        transition: all 0.3s;
    }
    .btn-action:hover {
        background-color: #f8f9fa;
        color: #344767;
        transform: scale(1.1);
    }

    /* New Badge Style */
    .status-badge {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        padding: 0.45em 0.85em;
        border-radius: 0.5rem;
    }

    /* File Badge */
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
        text-decoration: none;
        transition: all 0.2s;
    }
    .file-badge:hover {
        background: rgba(33, 82, 255, 0.2);
        color: #2152ff;
        text-decoration: none;
    }
    .file-badge.no-file {
        background: #f0f2f5;
        color: #8392ab;
    }

    .text-gradient-primary {
        background-image: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Toast Notification */
    .toast-container {
        z-index: 9999;
    }
</style>

<div class="main-content-wrapper">
    <div class="custom-header">
        <div class="bg-shape" style="width: 300px; height: 300px; top: -150px; right: -50px;"></div>
        <div class="bg-shape" style="width: 200px; height: 200px; bottom: -100px; left: -50px;"></div>
        
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h3 class="text-white font-weight-bolder mb-1">Logbook Limbah B3 Keluar</h3>
                <p class="text-white opacity-8 mb-0">Monitor dan kelola pengeluaran limbah dari TPS secara real-time.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('waste-b3-keluar.create') }}" class="btn btn-white btn-round mb-0 shadow-lg px-4">
                    <i class="fas fa-plus-circle me-2 text-primary"></i> Catat Pengeluaran
                </a>
            </div>
        </div>
    </div>

    @if(isset($summaryStats))
    <div class="row px-3 mb-4">
        @foreach([
            ['label' => 'Total Keluar', 'val' => $summaryStats['total_keluar'] ?? 0, 'icon' => 'fa-truck-loading', 'color' => 'primary'],
            ['label' => 'Total Berat', 'val' => number_format($summaryStats['total_volume_keluar'] ?? 0, 3, ',', '.') . ' Ton', 'icon' => 'fa-balance-scale', 'color' => 'success'],
            ['label' => 'Dokumen OK', 'val' => $summaryStats['dokumen_lengkap'] ?? 0, 'icon' => 'fa-file-check', 'color' => 'info'],
            ['label' => 'Pending Doc', 'val' => $summaryStats['menunggu_dokumen'] ?? 0, 'icon' => 'fa-file-signature', 'color' => 'warning']
        ] as $stat)
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-xs font-weight-bold text-muted text-uppercase mb-0">{{ $stat['label'] }}</p>
                            <h5 class="font-weight-bolder mb-0 mt-1">{{ $stat['val'] }}</h5>
                        </div>
                        <div class="icon icon-shape bg-gradient-{{ $stat['color'] }} shadow-{{ $stat['color'] }} text-center border-radius-md" style="width: 45px; height: 45px;">
                            <i class="fas {{ $stat['icon'] }} text-white opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="filter-wrapper">
        <form action="{{ route('waste-b3-keluar') }}" method="GET" class="row gx-2 align-items-end">
            <div class="col-lg-4 col-md-6 mb-2 mb-lg-0">
                <label class="form-label text-xxs font-weight-bolder text-dark ms-1">CARI JENIS LIMBAH</label>
                <select name="masuk_id" class="form-select form-control-soft text-sm">
                    <option value="">Semua Limbah</option>
                    @foreach($limbahMasukOptions as $limbah)
                        <option value="{{ $limbah->id }}" {{ request('masuk_id') == $limbah->id ? 'selected' : '' }}>{{ $limbah->jenis_limbah }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 col-md-6 mb-2 mb-lg-0">
                <label class="form-label text-xxs font-weight-bolder text-dark ms-1">TUJUAN</label>
                <input type="text" name="tujuan" class="form-control form-control-soft text-sm" placeholder="Nama perusahaan..." value="{{ request('tujuan') }}">
            </div>
            <div class="col-lg-3 col-md-8 mb-2 mb-lg-0">
                <label class="form-label text-xxs font-weight-bolder text-dark ms-1">RENTANG TANGGAL</label>
                <div class="input-group">
                    <input type="date" name="tanggal_dari" class="form-control form-control-soft text-sm" value="{{ request('tanggal_dari') }}">
                    <input type="date" name="tanggal_sampai" class="form-control form-control-soft text-sm" value="{{ request('tanggal_sampai') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-4 d-flex gap-2">
                <button type="submit" class="btn bg-gradient-dark btn-round w-100 mb-0">Cari</button>
                <a href="{{ route('waste-b3-keluar') }}" class="btn btn-outline-secondary btn-round mb-0 px-3"><i class="fas fa-sync-alt"></i></a>
            </div>
        </form>
    </div>

    <div class="card table-container mx-3">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-4">Batch Limbah</th>
                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Waktu Keluar</th>
                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Volume</th>
                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Tujuan & Dokumen</th>
                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Berita Acara</th>
                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wasteB3Keluar as $data)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex flex-column">
                                <h6 class="mb-0 text-sm">{{ $data->limbahMasuk->jenis_limbah }}</h6>
                                <span class="text-xs text-gradient-primary font-weight-bold">{{ $data->limbahMasuk->kode_limbah }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-sm font-weight-bold text-dark">{{ $data->tanggal_keluar_formatted }}</span>
                                <span class="text-xxs text-muted"><i class="far fa-clock me-1"></i>{{ $data->created_at?->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="text-center">
                            {{-- ✅ 3 Decimal Places for Volume --}}
                            <span class="badge badge-sm bg-gradient-light text-danger font-weight-bolder">
                                - {{ number_format($data->jumlah_keluar_ton, 3, ',', '.') }} Ton
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-sm font-weight-bold">{{ Str::limit($data->tujuan_penyerahan, 20) }}</span>
                                <span class="text-xxs text-muted">Doc: {{ $data->nomor_dokumen_keluar ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            {{-- ✅ Check berita_acara instead of file_dokumen --}}
                            @if($data->berita_acara)
                                <a href="{{ Storage::url('waste-b3/berita-acara-keluar/' . $data->berita_acara) }}" 
                                   target="_blank" 
                                   class="file-badge" 
                                   title="Download: {{ $data->berita_acara }}">
                                    <i class="fas fa-file-{{ pathinfo($data->berita_acara, PATHINFO_EXTENSION) == 'pdf' ? 'pdf' : 'image' }}"></i>
                                    <span class="d-none d-md-inline">{{ Str::limit(pathinfo($data->berita_acara, PATHINFO_FILENAME), 8) }}</span>
                                </a>
                            @else
                                <span class="file-badge no-file">
                                    <i class="fas fa-minus"></i>
                                    <span class="d-none d-md-inline">-</span>
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('waste-b3-keluar.show', $data->id) }}" class="btn-action" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('waste-b3-keluar.edit', $data->id) }}" class="btn-action" title="Edit"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn-action text-danger delete-btn" data-id="{{ $data->id }}" data-nama="{{ $data->limbahMasuk->jenis_limbah }}"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <img src="https://illustrations.popsy.co/gray/box-empty.svg" style="width: 150px; opacity: 0.5;">
                            <p class="text-muted mt-3">Belum ada riwayat pengeluaran limbah.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($wasteB3Keluar->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center border-0">
            <span class="text-xs text-muted">Menampilkan {{ $wasteB3Keluar->count() }} data</span>
            {{ $wasteB3Keluar->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
            <div class="modal-body text-center p-4">
                <div class="text-danger mb-3">
                    <i class="fas fa-exclamation-circle fa-3x"></i>
                </div>
                <h5 class="font-weight-bolder">Hapus Data?</h5>
                <p class="text-sm text-muted">Data <b id="wasteName"></b> akan dihapus dan stok akan dikembalikan.</p>
                <p class="text-xxs text-muted mt-2">
                    <i class="fas fa-info-circle me-1"></i>File berita acara juga akan dihapus permanen.
                </p>
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-light btn-round w-100 mb-0" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="w-100">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn bg-gradient-danger btn-round w-100 mb-0">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
@if(session('success') || session('error'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
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
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('wasteName').textContent = this.dataset.nama;
                document.getElementById('deleteForm').action = `/waste-b3-keluar/${this.dataset.id}`;
                deleteModal.show();
            });
        });

        // Auto-hide toasts after 5 seconds
        const toastElList = document.querySelectorAll('.toast');
        [...toastElList].map(toast => {
            setTimeout(() => {
                const bsToast = bootstrap.Toast.getInstance(toast) || new bootstrap.Toast(toast);
                bsToast.hide();
            }, 5000);
        });
    });
</script>
@endpush
@endsection