@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Limbah B3 Management - Logbook Keluar</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div>
                            <h5 class="mb-0">Daftar Logbook Limbah B3 Keluar</h5>
                            <p class="text-sm text-muted mb-0">
                                <i class="fas fa-info-circle"></i> 
                                Riwayat pengeluaran limbah B3 dari Tempat Penyimpanan Sementara (TPS)
                            </p>
                        </div>                        
                    </div>
                </div>
                
                <!-- Filter Form -->
                <div class="card-body px-3 pt-3 pb-0">
                    <form method="GET" action="{{ route('waste-b3-keluar') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <select name="masuk_id" class="form-control form-control-sm">
                                    <option value="">-- Semua Limbah Masuk --</option>
                                    @foreach($limbahMasukOptions as $limbah)
                                        <option value="{{ $limbah->id }}" {{ request('masuk_id') == $limbah->id ? 'selected' : '' }}>
                                            {{ $limbah->jenis_limbah }} ({{ $limbah->kode_limbah }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" 
                                       name="tujuan" 
                                       class="form-control form-control-sm" 
                                       placeholder="Cari Tujuan Penyerahan"
                                       value="{{ request('tujuan') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" 
                                       name="tanggal_dari" 
                                       class="form-control form-control-sm" 
                                       value="{{ request('tanggal_dari') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" 
                                       name="tanggal_sampai" 
                                       class="form-control form-control-sm" 
                                       value="{{ request('tanggal_sampai') }}">
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-sm">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('waste-b3-keluar') }}" class="btn btn-secondary">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table Data -->
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Limbah Masuk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Keluar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah Keluar (Ton)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tujuan Penyerahan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dokumen</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wasteB3Keluar as $data)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0">{{ $wasteB3Keluar->firstItem() + $loop->index }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-xs font-weight-bold">
                                                {{ $data->limbahMasuk->jenis_limbah }}
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <span class="badge badge-sm bg-gradient-dark">
                                                    {{ $data->limbahMasuk->kode_limbah }}
                                                </span>
                                            </p>
                                            <small class="text-xxs text-muted">
                                                <i class="fas fa-calendar"></i> 
                                                {{ $data->limbahMasuk->tanggal_masuk_formatted }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            <i class="fas fa-truck text-success"></i> 
                                            {{ $data->tanggal_keluar_formatted }}
                                        </p>
                                        <p class="text-xxs text-secondary mb-0">
                                            <i class="fas fa-clock"></i> 
                                            {{ $data->created_at?->format('H:i') }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0 text-danger">
                                            <i class="fas fa-minus"></i> 
                                            {{ $data->jumlah_keluar_ton_formatted }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            <i class="fas fa-building"></i> 
                                            {{ $data->tujuan_penyerahan_formatted }}
                                        </p>
                                        <p class="text-xxs text-secondary mb-0">
                                            <i class="fas fa-file-alt"></i> 
                                            {{ $data->nomor_dokumen_keluar }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        @if($data->file_dokumen_exists)
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="badge badge-sm bg-gradient-success">
                                                    <i class="fas fa-check"></i> Tersedia
                                                </span>
                                                <div class="mt-1">
                                                    {{-- <a href="{{ route('waste-b3-keluar.preview', $data->id) }}" 
                                                       target="_blank" 
                                                       class="btn btn-info btn-sm btn-icon"
                                                       title="Preview Dokumen">
                                                        <i class="fas fa-eye"></i>
                                                    </a> --}}
                                                    {{-- <a href="{{ route('waste-b3-keluar.download', $data->id) }}" 
                                                       class="btn btn-primary btn-sm btn-icon"
                                                       title="Download Dokumen">
                                                        <i class="fas fa-download"></i>
                                                    </a> --}}
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge badge-sm bg-gradient-secondary">
                                                <i class="fas fa-times"></i> Belum Upload
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Detail Button -->
                                        <a href="{{ route('waste-b3-keluar.show', $data->id) }}" 
                                           class="mx-1" 
                                           title="Detail">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>
                                        
                                        <!-- Edit Button -->
                                        <a href="{{ route('waste-b3-keluar.edit', $data->id) }}" 
                                           class="mx-1" 
                                           title="Edit">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <button 
                                            type="button" 
                                            class="mx-1 delete-btn border-0 bg-transparent" 
                                            data-id="{{ $data->id }}"
                                            data-nama="{{ $data->limbahMasuk->jenis_limbah }} ({{ $data->limbahMasuk->kode_limbah }})"
                                            title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Belum ada data logbook limbah B3 keluar.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="card-footer px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm mb-0">
                                Menampilkan {{ $wasteB3Keluar->firstItem() }} - {{ $wasteB3Keluar->lastItem() }} dari {{ $wasteB3Keluar->total() }} data
                            </p>
                        </div>
                        <div>
                            {{ $wasteB3Keluar->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data pengeluaran limbah <strong id="wasteName"></strong>?</p>
                <p class="text-muted text-sm">
                    <i class="fas fa-exclamation-triangle text-warning"></i> 
                    Tindakan ini akan mengembalikan stok limbah masuk yang bersangkutan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
@if (session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">Berhasil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Error Modal -->
@if (session('error'))
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Gagal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tombol Hapus
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');

            document.getElementById('wasteName').textContent = nama;
            document.getElementById('deleteForm').action = '/waste-b3-keluar/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // Modal Sukses
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif

    // Modal Error
    @if(session('error'))
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    @endif
});
</script>
@endpush

@endsection