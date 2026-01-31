@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Work Hours</strong>
        </span>
        <a class="btn bg-gradient-secondary btn-sm mb-0" href="{{ route('api.export.jamkerja') }}">Export Data</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div>
                            <h5 class="mb-0">Daftar Jam Kerja Alat</h5>
                        </div>
                        <a href="{{ route('admin.work-hours.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                            +&nbsp; Tambah Jam Kerja
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total Jam</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center d-none d-md-table-cell">Lokasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center d-none d-lg-table-cell">Aktivitas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($workHours as $index => $wh)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-wrap" style="min-width: 120px;">
                                            {{ $wh->alat ? $wh->alat->nama : '—' }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $wh->tanggal ? $wh->tanggal->format('d M Y') : '—' }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ number_format($wh->total_jam, 2) }}</p>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <p class="text-xs font-weight-bold mb-0 text-wrap" style="max-width: 150px;">{{ $wh->lokasi ?? '—' }}</p>
                                    </td>
                                    <td class="text-center d-none d-lg-table-cell">
                                        <p class="text-xs font-weight-bold mb-0 text-wrap" style="max-width: 180px;">{{ $wh->aktivitas ?? '—' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.work-hours.edit', $wh->id) }}" class="mx-1" title="Edit">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button 
                                            type="button" 
                                            class="mx-1 delete-btn" 
                                            data-id="{{ $wh->id }}"
                                            data-nama="{{ $wh->alat ? $wh->alat->nama : 'Jam Kerja #' . $wh->id }}"
                                            title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada data jam kerja.
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
                <p>Apakah Anda yakin ingin menghapus data jam kerja untuk alat <strong id="equipmentName"></strong>?</p>
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
            const nama = button.getAttribute('data-nama');

            document.getElementById('equipmentName').textContent = nama;
            document.getElementById('deleteForm').action = '/admin/work-hours/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // Tampilkan modal sukses
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();

        document.getElementById('successModal').addEventListener('hidden.bs.modal', function () {
            window.location.reload();
        });
    @endif
});
</script>
@endpush

@endsection