@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Dokumentasi Kegiatan</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Daftar Dokumentasi</h5>
                        </div>
                        <a href="{{ route('admin.dokumentasi-kegiatan.create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">
                            +&nbsp; Tambah Dokumentasi
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                        No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Judul
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Lokasi
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jenis Kegiatan
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        File
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dokumentasi as $index => $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->judul ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->lokasi ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->jenis_kegiatan ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        @if($item->file_dokumentasi)
                                            <a href="{{ asset('storage/' . $item->file_dokumentasi) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="Lihat File">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Lihat Detail -->
                                        <button 
                                            type="button" 
                                            class="mx-2 detail-btn" 
                                            data-id="{{ $item->id }}"
                                            data-judul="{{ $item->judul }}"
                                            data-tanggal="{{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}"
                                            data-lokasi="{{ $item->lokasi ?? '-' }}"
                                            data-jenis="{{ $item->jenis_kegiatan ?? '-' }}"
                                            data-deskripsi="{{ $item->deskripsi ?? '-' }}"
                                            data-file="{{ $item->file_dokumentasi ? 'Tersedia' : 'Tidak ada' }}"
                                            data-pembuat="{{ $item->creator ? $item->creator->name : 'Sistem' }}"
                                            title="Lihat Detail"
                                        >
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>

                                        <a href="{{ route('admin.dokumentasi-kegiatan.edit', $item->id) }}" 
                                           class="mx-2" 
                                           title="Edit">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>

                                        <button 
                                            type="button" 
                                            class="mx-2 delete-btn" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->judul }}"
                                            title="Hapus"
                                        >
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">
                                        Belum ada dokumentasi kegiatan.
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

<!-- Modal Detail Dokumentasi -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="detailModalLabel">Detail Dokumentasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr><th width="30%">Judul</th><td id="detail-judul"></td></tr>
                    <tr><th>Tanggal</th><td id="detail-tanggal"></td></tr>
                    <tr><th>Lokasi</th><td id="detail-lokasi"></td></tr>
                    <tr><th>Jenis Kegiatan</th><td id="detail-jenis"></td></tr>
                    <tr><th>Deskripsi</th><td id="detail-deskripsi"></td></tr>
                    <tr><th>File Dokumentasi</th><td id="detail-file"></td></tr>
                    <tr><th>Dibuat Oleh</th><td id="detail-pembuat"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                <p>Apakah Anda yakin ingin menghapus dokumentasi <strong id="equipmentName"></strong>?</p>
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

    // === LIHAT DETAIL ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-btn')) {
            const btn = e.target.closest('.detail-btn');
            document.getElementById('detail-judul').textContent = btn.getAttribute('data-judul');
            document.getElementById('detail-tanggal').textContent = btn.getAttribute('data-tanggal');
            document.getElementById('detail-lokasi').textContent = btn.getAttribute('data-lokasi');
            document.getElementById('detail-jenis').textContent = btn.getAttribute('data-jenis');
            document.getElementById('detail-deskripsi').textContent = btn.getAttribute('data-deskripsi');
            document.getElementById('detail-file').textContent = btn.getAttribute('data-file');
            document.getElementById('detail-pembuat').textContent = btn.getAttribute('data-pembuat');

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    });

    // === HAPUS DATA ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');

            document.getElementById('equipmentName').textContent = nama;
            document.getElementById('deleteForm').action = '/admin/dokumentasi-kegiatan/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // === TAMPILKAN MODAL SUKSES ===
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