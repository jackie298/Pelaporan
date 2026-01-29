@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Rencana & Target Revegetasi</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div>
                            <h5 class="mb-0">Daftar Target Bulanan</h5>
                        </div>
                        <a href="{{ route('rencana-revegetasi.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                            +&nbsp; Tambah Rencana
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bulan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Target Bibit (Pcs)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rencanaData as $data)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->tahun }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{-- Menggunakan Accessor dari Model --}}
                                            {{ $data->nama_bulan }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ number_format($data->target_bibit) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-wrap">
                                            {{ $data->lokasi ?? '—' }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('rencana-revegetasi.edit', $data->id) }}" class="mx-1" title="Edit">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button 
                                            type="button" 
                                            class="mx-1 delete-btn" 
                                            data-id="{{ $data->id }}"
                                            data-nama="{{ $data->nama_bulan }} {{ $data->tahun }}"
                                            title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data rencana revegetasi.
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

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus rencana bulan <strong id="rencanaInfo"></strong>?</p>
                <p class="text-muted">Data ini akan dihapus permanen dari sistem.</p>
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

            document.getElementById('rencanaInfo').textContent = nama;
            // Pastikan URL action sesuai dengan route destroy Anda
            document.getElementById('deleteForm').action = '/rencana-revegetasi/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // Tampilkan modal sukses jika ada flash message
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif
});
</script>
@endpush

@endsection