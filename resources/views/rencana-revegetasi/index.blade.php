@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Rencana & Target Revegetasi</strong>
        </span>
            <a class="btn bg-gradient-secondary btn-sm mb-0" href="{{ route('api.export.rencanarevegetasi') }}">
            <i class="fas fa-file-excel me-1"></i>Export Data
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div>
                            <h5 class="mb-0">Daftar Rencana Revegetasi</h5>
                            <p class="text-sm mb-0 text-muted">Target bulanan per tahun</p>
                        </div>
                        <a href="{{ route('rencana-revegetasi.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                            <i class="fas fa-plus me-1"></i>Tambah Rencana
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3" style="width: 50px;">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 100px;">Tahun</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target Bulanan (Pcs)</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 120px;">Total</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rencanaData as $data)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            <span class="badge bg-gradient-info">{{ $data->tahun }}</span>
                                        </p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($daftarBulan as $key => $bulan)
                                                @php
                                                    $target = $data->target_bulanan[$key] ?? 0;
                                                @endphp
                                                @if($target > 0)
                                                    <span class="badge bg-gradient-success" title="{{ $bulan }}: {{ number_format($target) }} pcs">
                                                        {{ substr($bulan, 0, 3) }}: {{ number_format($target) }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                        @if($data->total_target == 0)
                                            <span class="text-muted text-xs">Belum ada target</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-wrap" style="max-width: 250px;">
                                            {{ $data->lokasi ?? '—' }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0 text-success">
                                            <strong>{{ number_format($data->total_target) }}</strong>
                                        </p>
                                        <small class="text-muted">{{ number_format($data->rata_rata_bulanan) }}/bln</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('rencana-revegetasi.show', $data->id) }}" class="mx-1" title="Detail">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                        <a href="{{ route('rencana-revegetasi.edit', $data->id) }}" class="mx-1" title="Edit">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button 
                                            type="button" 
                                            class="mx-1 delete-btn" 
                                            data-id="{{ $data->id }}"
                                            data-tahun="{{ $data->tahun }}"
                                            title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Belum ada data rencana revegetasi.</p>
                                        <a href="{{ route('rencana-revegetasi.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i>Buat Rencana Baru
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($rencanaData->hasPages())
                    <div class="card-footer py-3">
                        <div class="d-flex justify-content-end">
                            {{ $rencanaData->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title text-white" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Peringatan!</strong> Data ini akan dihapus permanen dari sistem.
                </div>
                <p>Apakah Anda yakin ingin menghapus rencana revegetasi tahun <strong id="tahunInfo"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-gradient-danger">
                        <i class="fas fa-trash me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Success -->
@if (session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success">
                <h5 class="modal-title text-white">
                    <i class="fas fa-check-circle me-2"></i>Berhasil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                <h5 class="mb-3">{{ session('success') }}</h5>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn bg-gradient-success" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal Error -->
@if (session('error'))
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>Gagal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-times-circle text-danger fa-4x mb-3"></i>
                <h5 class="mb-3">{{ session('error') }}</h5>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
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
            const tahun = button.getAttribute('data-tahun');

            document.getElementById('tahunInfo').textContent = tahun;
            document.getElementById('deleteForm').action = '{{ url("rencana-revegetasi") }}/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // Tampilkan modal sukses jika ada flash message
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif

    // Tampilkan modal error jika ada flash message
    @if(session('error'))
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    @endif
});
</script>
@endpush

@endsection