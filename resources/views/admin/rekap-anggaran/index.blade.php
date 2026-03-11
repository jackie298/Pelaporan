@extends('layouts.user_type.auth')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);
    }
    
    .card { border-radius: 1rem !important; border: none !important; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05) !important; }
    .table thead th { background-color: #f8f9fa; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #ebedf2 !important; color: #8392ab !important; padding: 12px 24px !important; }
    .badge-pill-md { padding: 0.55em 1em !important; border-radius: 50rem !important; font-weight: 600 !important; }
    .btn-action { width: 36px; height: 36px; border-radius: 10px !important; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; border: 1px solid #e9ecef; background: white; }
    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .total-summary-row { background: #f8f9fa; border-top: 2px solid #fff; }
    .filter-card { background: #ffffff; border-radius: 1rem; border: 1px solid #f1f1f1; }
    .select-custom { border-radius: 0.5rem !important; border: 1px solid #e9ecef !important; padding: 0.5rem; font-size: 0.875rem; }
</style>

<div class="container-fluid py-4">
    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h3 class="font-weight-bolder mb-0">Rekap Anggaran</h3>
            <p class="text-muted mb-0">Manajemen dokumen dan pemantauan status kontrak anggaran.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('api.export.rekapanggaran', request()->query()) }}" class="btn btn-outline-dark btn-sm mb-0 px-3">
                <i class="fas fa-file-excel me-2 text-success"></i>Ekspor Excel
            </a>
            <a href="{{ route('admin.rekap-anggaran.create') }}" class="btn bg-gradient-dark btn-sm mb-0 px-3">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </a>
        </div>
    </div>

    {{-- PANEL FILTER --}}
    <div class="card filter-card p-3 mb-4 shadow-sm">
        <form action="{{ route('admin.rekap-anggaran') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label text-xs font-weight-bold text-uppercase">Cari Kontrak</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="cari" class="form-control select-custom border-start-0 ps-0" 
                           placeholder="Nama kontrak..." value="{{ request('cari') }}">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label text-xs font-weight-bold text-uppercase">Bulan</label>
                <select name="bulan" class="form-select select-custom" onchange="this.form.submit()">
                    <option value="">Semua Bulan</option>
                    @for ($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label text-xs font-weight-bold text-uppercase text-muted">Filter Tahun</label>
                <div class="input-group">
                    <select name="tahun" class="form-select select-custom border-start-0 ps-0" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        
                        @php
                            $currentYear = date('Y');
                            $selectedYear = request('tahun');
                        @endphp
                        
                        @for ($y = $currentYear + 2; $y >= $currentYear - 10; $y--)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label text-xs font-weight-bold text-uppercase">Status</label>
                <select name="status" class="form-select select-custom">
                    <option value="">Semua Status</option>
                    @php $raw_statuses = ['open', 'close', 'pending', 'proses finance', 'hold']; @endphp
                    @foreach($raw_statuses as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ strtoupper($st) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0 w-100">Filter</button>
                <a href="{{ route('admin.rekap-anggaran') }}" class="btn btn-outline-secondary btn-sm mb-0 w-100">Reset</a>
            </div>
        </form>
    </div>

    {{-- TABEL DATA --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-xxs font-weight-bolder opacity-9 ps-4">No</th>
                        <th class="text-xxs font-weight-bolder opacity-9">Periode</th>
                        <th class="text-xxs font-weight-bolder opacity-9">Detail Kontrak</th>
                        <th class="text-xxs font-weight-bolder opacity-9 text-center">Realisasi</th>
                        <th class="text-xxs font-weight-bolder opacity-9 text-center">Harga</th>
                        <th class="text-xxs font-weight-bolder opacity-9 text-center">Status</th>
                        <th class="text-xxs font-weight-bolder opacity-9 text-center">Berkas</th>
                        <th class="text-xxs font-weight-bolder opacity-9 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ( $rekap_anggaran as $index => $item )
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0 text-secondary">{{ $rekap_anggaran->firstItem() + $index }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0 text-dark">
                                <i class="far fa-calendar-alt me-1 text-primary"></i>
                                {{ $item->periode ? $item->periode->format('F Y') : '-' }}
                            </p>
                        </td>
                        <td>
                            <div class="py-1">
                                <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $item->nama }}</h6>
                                <p class="text-xs text-muted mb-0">{{ Str::limit($item->keterangan_jasa, 45) }}</p>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="text-xs font-weight-bold">{{ $item->realisasi ?? '-' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-weight-bolder text-dark">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="text-center">
                            @php
                                $colorMap = [
                                    'open' => 'bg-info',
                                    'close' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'proses finance' => 'bg-primary',
                                    'hold' => 'bg-danger',
                                ];
                                $badgeColor = $colorMap[strtolower($item->status)] ?? 'bg-secondary';
                            @endphp
                            <span class="badge badge-pill-md {{ $badgeColor }} text-white text-uppercase">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($item->file_kontrak)
                                <a href="{{ asset('storage/' . $item->file_kontrak) }}" target="_blank" class="btn-action text-info" title="Lihat Berkas">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @else
                                <span class="text-xxs text-muted opacity-6">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.rekap-anggaran.edit', $item->id) }}" class="btn-action text-dark"><i class="fas fa-pen-nib text-xs"></i></a>
                                <button type="button" class="btn-action text-danger delete-btn" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"><i class="fas fa-trash-alt text-xs"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <p class="text-muted mb-0">Data tidak ditemukan untuk filter ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($rekap_anggaran->count() > 0)
                <tfoot>
                    <tr class="total-summary-row">
                        <td colspan="4" class="text-end py-3">
                            <span class="text-xxs font-weight-bolder text-uppercase text-secondary">Total Anggaran (Terfilter):</span>
                        </td>
                        <td class="text-center">
                            <span class="text-md font-weight-bolder text-primary">Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}</span>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        
        <div class="card-footer py-3 border-0 bg-transparent">
            <div class="d-md-flex justify-content-between align-items-center">
                <p class="text-xs text-secondary font-weight-bold mb-3 mb-md-0">
                    Menampilkan {{ $rekap_anggaran->firstItem() ?? 0 }} - {{ $rekap_anggaran->lastItem() ?? 0 }} dari {{ $rekap_anggaran->total() }} data
                </p>
                <div>{{ $rekap_anggaran->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-weight-bold">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-sm">Hapus data kontrak <strong><span id="contractName"></span></strong>? Data tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn bg-gradient-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SUKSES --}}
@if (session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg text-center py-4">
            <div class="avatar avatar-lg bg-gradient-success text-white rounded-circle mx-auto mb-3">
                <i class="fas fa-check text-lg"></i>
            </div>
            <h5 class="font-weight-bold">Berhasil!</h5>
            <p class="text-sm text-muted px-4 mb-3">{{ session('success') }}</p>
            <button type="button" class="btn bg-gradient-success mx-4" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-show success modal
        @if(session('success'))
            new bootstrap.Modal(document.getElementById('successModal')).show();
        @endif

        // Delete confirmation logic
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('contractName').textContent = this.dataset.nama;
                document.getElementById('deleteForm').action = `/admin/rekap-anggaran/${this.dataset.id}`;
                deleteModal.show();
            });
        });
    });
</script>
@endpush
@endsection