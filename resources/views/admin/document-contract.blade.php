@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Daftar Kontrak</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Documents</h5>
                        </div>
                        <a href="{{ route('admin.document-contract.create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Document</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Realisasi
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Keterangan Jasa Pekerjaan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Harga
                                    </th>
                                    <th class="c">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kontrak file
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $contracts as $index => $item )
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama }}</p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->realisasi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->keterangan_jasa }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $status = strtolower($item->status);
                                            $badgeClass = match($status) {
                                                'aktif' => 'bg-gradient-info',
                                                'selesai' => 'bg-gradient-success',
                                                'batal' => 'bg-gradient-danger',
                                                default => 'bg-gradient-secondary',
                                            };
                                        @endphp
                                        <span class="badge badge-sm {{ $badgeClass }}">{{ ucfirst($item->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><a href="{{ asset('storage/' . $item->file_kontrak) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            Lihat
                                        </a></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.document-contract.edit', $item->id) }}" class="mx-2" title="Edit">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button 
                                            type="button" 
                                            class="mx-2 delete-btn" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->nama }}"
                                            title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        Data kontrak belum tersedia
                                    </td>
                                </tr>
                                @endforelse
                                @if($contracts->count())
                                <tr class="bg-light">
                                    <td colspan="4" class="text-center text-xs font-weight-bold border-top border-bottom">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="text-center text-xs font-weight-bold border-top border-bottom">
                                        <strong>Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}</strong>
                                    </td>
                                    <td colspan="5" class="border-top border-bottom"></td>
                                </tr>
                                @endif
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
                <p>Apakah Anda yakin ingin menghapus kontrak <strong id="contractName"></strong>?</p>
                <p class="text-muted">Ini akan Menghapus Data Secara permanen.</p>
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

<!-- ✅ TAMBAHKAN INI: Modal Sukses -->
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
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === HAPUS DATA ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');

            document.getElementById('contractName').textContent = nama;
            document.getElementById('deleteForm').action = '/admin/document-contract/' + id;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    });

    // === TAMPILKAN MODAL SUKSES & REFRESH SETELAH DITUTUP ===
    @if(session('success'))
        const successModalEl = document.getElementById('successModal');
        if (successModalEl) {
            const successModal = new bootstrap.Modal(successModalEl);
            successModal.show();

            // Refresh halaman setelah modal ditutup
            successModalEl.addEventListener('hidden.bs.modal', function () {
                window.location.reload();
            });
        }
    @endif
});
</script>
@endpush

@endsection