@extends('layouts.user_type.auth')

@section('content')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Dokumentasi Kegiatan</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-body p-3">
                    <div class="row">
                        @forelse ($dokumentasiData as $data)
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card card-blog card-plain p-3 mb-4">
                                    <div class="position-relative">
                                        <a class="d-block shadow-xl border-radius-xl">
                                            @if($data->file_dokumentasi)
                                                @php
                                                    $ext = pathinfo($data->file_dokumentasi, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ asset('storage/' . $data->file_dokumentasi) }}"
                                                         alt="{{ $data->judul }}"
                                                         class="img-fluid shadow border-radius-xl"
                                                         style="height: 200px; object-fit: cover;">
                                                @else
                                                    <div class="bg-gradient-primary d-flex align-items-center justify-content-center"
                                                         style="height: 200px; border-radius: 0.75rem;">
                                                        <i class="fa-solid fa-file-pdf text-white fa-3x"></i>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="bg-gradient-secondary d-flex align-items-center justify-content-center"
                                                     style="height: 200px; border-radius: 0.75rem;">
                                                    <i class="fa-solid fa-image text-white fa-3x"></i>
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="card-body px-1 pb-0">
                                        <p class="text-gradient text-dark mb-2 text-sm">
                                            {{ $data->jenis_kegiatan }}
                                        </p>
                                        <a href="javascript:;"> test
                                            <h5>{{ Str::limit($data->judul, 30) }}</h5>
                                        </a>
                                        <p class="mb-4 text-sm">
                                            Lokasi: {{ $data->lokasi ?? '—' }}<br>
                                            Tanggal: {{ $data->tanggal ? $data->tanggal->format('d M Y') : '—' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada dokumentasi kegiatan.</p>
                                <a href="{{ route('admin.dokumentasi-kegiatan.create') }}"
                                   class="btn btn-primary mt-2">
                                    + Tambah Dokumentasi
                                </a>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $dokumentasiData->links() }}
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
                <p>Apakah Anda yakin ingin menghapus dokumentasi kegiatan <strong id="dokumenJudul"></strong>?</p>
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
            const judul = button.getAttribute('data-judul');

            document.getElementById('dokumenJudul').textContent = judul;
            document.getElementById('deleteForm').action = '/admin/dokumentasi-kegiatan/' + id;

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