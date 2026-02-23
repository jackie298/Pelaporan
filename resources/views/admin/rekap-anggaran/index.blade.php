@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Daftar Kontrak</strong>
        </span>
        <a class="btn bg-gradient-secondary btn-sm mb-0" href="{{ route('api.export.rekapanggaran') }}">Export Data</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Documents</h5>
                        </div>
                        <a href="{{ route('admin.rekap-anggaran.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; New Document</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Realisasi</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan Jasa</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $rekap_anggaran as $index => $item )
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-wrap" style="max-width: 200px;">{{ $item->nama }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs mb-0">{{ $item->realisasi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs mb-0 text-wrap">{{ $item->keterangan_jasa }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $status = strtolower($item->status);
                                            // PERBAIKAN: Sesuaikan dengan value yang ada di form input
                                            $badgeClass = match($status) {
                                                'open' => 'bg-gradient-info',
                                                'close' => 'bg-gradient-success',
                                                'pending' => 'bg-gradient-warning',
                                                'proses finance' => 'bg-gradient-primary',
                                                'hold' => 'bg-gradient-danger',
                                                default => 'bg-gradient-secondary',
                                            };
                                        @endphp
                                        <span class="badge badge-sm {{ $badgeClass }}">{{ ucfirst($item->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->file_kontrak)
                                            <a href="{{ asset('storage/' . $item->file_kontrak) }}" target="_blank" class="btn btn-link text-primary text-gradient px-3 mb-0">
                                                <i class="fas fa-file-pdf"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-xs text-muted">No File</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.rekap-anggaran.edit', $item->id) }}" class="mx-3" title="Edit">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <button type="button" class="cursor-pointer border-0 bg-transparent delete-btn" 
                                                data-id="{{ $item->id }}" 
                                                data-nama="{{ $item->nama }}">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Data kontrak belum tersedia</td>
                                </tr>
                                @endforelse

                                @if($rekap_anggaran->count())
                                <tr class="bg-gray-100">
                                    <td colspan="4" class="text-end text-xs font-weight-bolder">TOTAL NILAI KONTRAK:</td>
                                    <td class="text-center text-xs font-weight-bolder">Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}</td>
                                    <td colspan="3"></td>
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

{{-- MODAL HAPUS --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p>Apakah Anda yakin ingin menghapus kontrak <strong id="contractName"></strong>?</p>
               <p>Ini akan menghapus data secara permanen.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
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
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                <h5>Berhasil!</h5>
                <p>{{ session('success') }}</p>
                <button type="button" class="btn bg-gradient-success mb-0" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tombol Hapus
    const deleteBtns = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');
    const contractName = document.getElementById('contractName');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            
            contractName.textContent = nama;
            // SESUAIKAN URL DIBAWAH INI DENGAN ROUTE KAMU
            deleteForm.action = `/admin/rekap-anggaran/${id}`; 
            
            deleteModal.show();
        });
    });

    // Modal Sukses
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif
});
</script>
@endpush

@endsection