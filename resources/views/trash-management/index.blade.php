@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Manajemen Sampah</strong>
        </span>
        <a class="btn bg-gradient-secondary btn-sm mb-0" href="{{ route('api.trashmanagement.export') }}">Export Data</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div>
                            <h5 class="mb-0">Daftar Data Pengelolaan Sampah</h5>
                        </div>
                        <a href="{{ route('trash-management.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                            +&nbsp; Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sumber Sampah</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Organik (kg)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Anorganik (kg)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center d-none d-md-table-cell">Residu (kg)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total (kg)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trashData as $index => $data)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $data->tanggal_formatted }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            <span class="badge badge-sm bg-gradient-{{ $data->sumber_sampah === 'area kantor' ? 'info' : 'primary' }}">
                                                {{ $data->sumber_sampah_label }}
                                            </span>
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ number_format($data->sampah_organik_terpilah ?? 0, 0) }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ number_format($data->sampah_anorganik_terpilah ?? 0, 0) }}
                                        </p>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ number_format($data->sampah_lainnya_dan_atau_residu ?? 0, 0) }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            <strong>{{ number_format($data->total, 0) }}</strong>
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('trash-management.edit', $data->id) }}" class="mx-1" title="Edit">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button 
                                            type="button" 
                                            class="mx-1 delete-btn" 
                                            data-id="{{ $data->id }}"
                                            data-tanggal="{{ $data->tanggal_formatted }}"
                                            data-sumber="{{ $data->sumber_sampah_label }}"
                                            title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada data pengelolaan sampah.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data pengelolaan sampah tanggal <strong id="tanggalData"></strong> dari sumber <strong id="sumberData"></strong>?</p>
                <p class="text-muted">Ini akan menghapus data secara permanen.</p>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Event delegation untuk tombol hapus
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const id = button.getAttribute('data-id');
            const tanggal = button.getAttribute('data-tanggal');
            const sumber = button.getAttribute('data-sumber');

            document.getElementById('tanggalData').textContent = tanggal;
            document.getElementById('sumberData').textContent = sumber;
            document.getElementById('deleteForm').action = '/trash-management/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // Tampilkan modal sukses
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();

        // Reload halaman setelah modal ditutup
        document.getElementById('successModal').addEventListener('hidden.bs.modal', function () {
            window.location.reload();
        });
    @endif
});
</script>
@endpush

@endsection