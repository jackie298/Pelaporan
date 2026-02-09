@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Limbah B3 Management</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div>
                            <h5 class="mb-0">Daftar Logbook Limbah B3 Masuk</h5>
                        </div>
                        <a href="{{ route('waste-b3.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                            +&nbsp; Tambah Log Masuk
                        </a>
                    </div>
                </div>
                
                <!-- Filter Form -->
                <div class="card-body px-3 pt-3 pb-0">
                    <form method="GET" action="{{ route('waste-b3') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" 
                                       name="jenis" 
                                       class="form-control form-control-sm" 
                                       placeholder="Cari Jenis Limbah"
                                       value="{{ request('jenis') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" 
                                       name="sumber" 
                                       class="form-control form-control-sm" 
                                       placeholder="Cari Sumber Limbah"
                                       value="{{ request('sumber') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">Semua Status</option>
                                    @foreach($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" 
                                       name="tanggal_dari" 
                                       class="form-control form-control-sm" 
                                       value="{{ request('tanggal_dari') }}">
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-sm">
                                    <input type="date" 
                                           name="tanggal_sampai" 
                                           class="form-control" 
                                           value="{{ request('tanggal_sampai') }}">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('waste-b3') }}" class="btn btn-secondary">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jenis & Kode</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Masuk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Masuk (Ton)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sisa (Ton)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Maks. Simpan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wasteB3Masuk as $data)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0">{{ $wasteB3Masuk->firstItem() + $loop->index }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-xs font-weight-bold">{{ $data->jenis_limbah }}</h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <span class="badge badge-sm bg-gradient-dark">{{ $data->kode_limbah }}</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $data->tanggal_masuk_formatted }}
                                        </p>
                                        <p class="text-xxs text-secondary mb-0">
                                            <i class="fas fa-map-marker-alt"></i> {{ $data->sumber_limbah }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0 text-success">
                                            <i class="fas fa-plus"></i> {{ $data->jumlah_ton_formatted }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        @if($data->sisa_limbah > 0)
                                            <p class="text-xs font-weight-bold mb-0 text-warning">
                                                <i class="fas fa-box"></i> {{ $data->sisa_limbah_formatted }}
                                            </p>
                                        @else
                                            <span class="badge badge-sm bg-gradient-success">
                                                <i class="fas fa-check"></i> Habis
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $isOverdue = $data->is_kadaluarsa;
                                        @endphp
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="badge badge-sm {{ $isOverdue ? 'bg-gradient-danger' : 'bg-gradient-secondary' }}">
                                                <i class="fas {{ $isOverdue ? 'fa-exclamation-triangle' : 'fa-clock' }}"></i>
                                                {{ $data->maksimal_penyimpanan_formatted }}
                                            </span>
                                            @if($isOverdue)
                                                <small class="text-danger text-xxs mt-1">
                                                    <i class="fas fa-exclamation-circle"></i> Kadaluarsa
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-{{ $data->status_badge_color }}">
                                            {{ $data->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <!-- Detail Button -->
                                        <a href="{{ route('waste-b3.show', $data->id) }}" 
                                           class="mx-1" 
                                           title="Detail">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>
                                        
                                        <!-- Keluarkan Button (jika masih ada stok) -->
                                        @if($data->can_be_dikeluarkan)
                                            <a href="{{ route('waste-b3-keluar.create', ['masuk_id' => $data->id]) }}" 
                                               class="mx-1" 
                                               title="Keluarkan Limbah"
                                               style="color: #2dce89;">
                                                <i class="fas fa-truck"></i>
                                            </a>
                                        @endif
                                        
                                        <!-- Edit Button -->
                                        <a href="{{ route('waste-b3.edit', $data->id) }}" 
                                           class="mx-1" 
                                           title="Edit">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <button 
                                            type="button" 
                                            class="mx-1 delete-btn border-0 bg-transparent" 
                                            data-id="{{ $data->id }}"
                                            data-nama="{{ $data->jenis_limbah }} ({{ $data->kode_limbah }})"
                                            title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Belum ada data logbook limbah B3 masuk.</p>
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
                                Menampilkan {{ $wasteB3Masuk->firstItem() }} - {{ $wasteB3Masuk->lastItem() }} dari {{ $wasteB3Masuk->total() }} data
                            </p>
                        </div>
                        <div>
                            {{ $wasteB3Masuk->links() }}
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
                <p>Apakah Anda yakin ingin menghapus data limbah <strong id="wasteName"></strong>?</p>
                <p class="text-muted text-sm">Tindakan ini akan menghapus log secara permanen dari sistem.</p>
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
            document.getElementById('deleteForm').action = '/waste-b3/' + id;

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