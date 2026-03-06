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
    .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h3 class="font-weight-bolder mb-0">Daftar Kontrak</h3>
            <p class="text-muted mb-0">Overview status kontrak dan manajemen dokumen anggaran.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('api.export.rekapanggaran') }}" class="btn btn-outline-dark btn-sm mb-0 px-3">
                <i class="fas fa-file-excel me-2 text-success"></i>Export Excel
            </a>
            <a href="{{ route('admin.rekap-anggaran.create') }}" class="btn bg-gradient-dark btn-sm mb-0 px-3">
                <i class="fas fa-plus me-2"></i>Tambah Dokumen
            </a>
        </div>
    </div>

    <div class="card bg-white p-3 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari di halaman ini..." id="searchInput">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select border-0 bg-light" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="open">Open</option>
                    <option value="close">Close</option>
                    <option value="pending">Pending</option>
                    <option value="proses finance">Proses Finance</option>
                    <option value="hold">Hold</option>
                </select>
            </div>
            <div class="col-md-5 text-md-end text-center">
                <span class="text-xs font-weight-bold text-dark p-2 bg-light rounded-3">
                    Total: <span class="text-primary">{{ $rekap_anggaran->total() }}</span> Data Keseluruhan
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0" id="contractsTable">
                <thead>
                    <tr>
                        <th class="text-xxs font-weight-bolder opacity-9">No</th>
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
                    <tr data-nama="{{ strtolower($item->nama) }}" data-status="{{ strtolower($item->status) }}">
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0 text-secondary">
                                {{ $rekap_anggaran->firstItem() + $index }}
                            </p>
                        </td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm font-weight-bold">{{ $item->nama }}</h6>
                                    <p class="text-xs text-muted mb-0">
                                        <i class="fas fa-tag me-1 opacity-5"></i> {{ Str::limit($item->keterangan_jasa, 40) }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="text-xs font-weight-bold">{{ $item->realisasi ?? '-' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-weight-bolder text-dark">
                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                                $status = strtolower($item->status);
                                $badgeStyle = [
                                    'open' => 'bg-info',
                                    'close' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'proses finance' => 'bg-primary',
                                    'hold' => 'bg-danger',
                                ][$status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge badge-pill-md {{ $badgeStyle }} text-white">
                                <span class="status-dot bg-white"></span>{{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($item->file_kontrak)
                                <a href="{{ asset('storage/' . $item->file_kontrak) }}" target="_blank" class="btn-action text-info" title="Lihat Berkas">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @else
                                <span class="text-xxs text-muted opacity-5">No File</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.rekap-anggaran.edit', $item->id) }}" class="btn-action text-dark" title="Edit">
                                    <i class="fas fa-pen-nib text-xs"></i>
                                </a>
                                <button type="button" class="btn-action text-danger delete-btn" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <p class="text-muted">Data tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($rekap_anggaran->count() > 0)
                <tfoot>
                    <tr class="total-summary-row">
                        <td colspan="3" class="text-end py-3">
                            <span class="text-xxs font-weight-bolder text-uppercase text-secondary">Total Seluruh Anggaran:</span>
                        </td>
                        <td class="text-center">
                            <span class="text-md font-weight-bolder text-primary">
                                Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}
                            </span>
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
                    Menampilkan {{ $rekap_anggaran->firstItem() }} sampai {{ $rekap_anggaran->lastItem() }} dari {{ $rekap_anggaran->total() }} data
                </p>
                <div>
                    {{ $rekap_anggaran->links('pagination::bootstrap-5') }}
                </div>
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
                <p class="text-sm">Apakah Anda yakin ingin menghapus <strong><span id="contractName"></span></strong>?</p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-gradient-danger">Hapus Permanen</button>
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
            <p class="text-sm text-muted px-4">{{ session('success') }}</p>
            <div class="px-4">
                <button type="button" class="btn bg-gradient-success w-100" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Success Modal Auto-show
        @if(session('success'))
            new bootstrap.Modal(document.getElementById('successModal')).show();
        @endif

        // Delete Logic
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('contractName').textContent = this.dataset.nama;
                document.getElementById('deleteForm').action = `/admin/rekap-anggaran/${this.dataset.id}`;
                deleteModal.show();
            });
        });

        // Client-side Filter (for current page)
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('#contractsTable tbody tr[data-nama]');

        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const status = statusFilter.value.toLowerCase();

            rows.forEach(row => {
                const matchSearch = row.dataset.nama.includes(search);
                const matchStatus = !status || row.dataset.status === status;
                row.style.display = (matchSearch && matchStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>
@endpush
@endsection