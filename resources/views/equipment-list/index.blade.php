@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Equipment List</strong>
        </span>
        <a class="btn bg-gradient-secondary btn-sm mb-0" href="{{ route('api.export.alat') }}">Export Data</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">All Equipment</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm w-auto">
                        <span class="input-group-text bg-gradient-primary text-white border-0">
                            <i class="fas fa-filter"></i>
                        </span>
                        
                        <select 
                            class="form-select form-select-sm" 
                            id="searchJenisAlat"
                            style="min-width: 220px; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                        >
                            <option value="">-- Semua Jenis Alat --</option>
                            @foreach($jenisList as $jenis)
                                <option value="{{ $jenis }}" {{ $searchJenis == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>

                        <button 
                            class="btn btn-outline-secondary btn-sm mb-0" 
                            type="button" 
                            id="clearSearch" 
                            title="Reset filter"
                            style="border-left: none; text-transform: uppercase; font-weight: bold;"
                        >
                            X
                        </button>
                    </div>
                            <a href="{{ route('admin.equipment-list.create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Equipment</a>
                        </div>
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
                                        Nama
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jenis
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Merk
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>  
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($equipment as $index => $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->nama ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->kode ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-info text-white">
                                            {{ $item->jenis ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->merk ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm 
                                            @if($item->status === 'tersedia') bg-success
                                            @elseif($item->status === 'dipakai') bg-info
                                            @elseif($item->status === 'perawatan') bg-warning
                                            @elseif($item->status === 'rusak') bg-danger
                                            @elseif($item->status === 'tidak_aktif') bg-secondary
                                            @else bg-secondary @endif">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <!-- Lihat Detail -->
                                        <button 
                                            type="button" 
                                            class="mx-2 detail-btn" 
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}"
                                            data-kode="{{ $item->kode }}"
                                            data-jenis="{{ $item->jenis }}"
                                            data-merk="{{ $item->merk ?? '-' }}"
                                            data-tahun="{{ $item->tahun ?? '-' }}"
                                            data-no_polisi="{{ $item->no_polisi ?? '-' }}"
                                            data-no_mesin="{{ $item->no_mesin ?? '-' }}"
                                            data-status="{{ ucfirst(str_replace('_', ' ', $item->status)) }}"
                                            data-lokasi="{{ $item->lokasi_sekarang ?? '-' }}"
                                            data-catatan="{{ $item->catatan ?? '-' }}"
                                            title="Lihat Detail"
                                        >
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>
                                        <a href="{{ route('admin.equipment-list.edit', $item->id) }}" class="mx-2" title="Edit">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <button 
                                            type="button" 
                                            class="mx-2 delete-btn" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->nama }}"
                                            title="Hapus"
                                        >
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-box-open fa-3x text-muted mb-2"></i>
                                            <p class="mb-0">Tidak ada data equipment ditemukan</p>
                                            @if($searchJenis)
                                                <small class="text-muted mt-1">Coba hapus filter jenis alat untuk melihat semua data</small>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($equipment->count() > 0)
                    <div class="card-footer px-4 py-3 bg-light border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Menampilkan {{ $filteredCount }} dari total {{ $totalEquipment }} equipment
                            </small>
                            @if($searchJenis)
                                <small class="text-primary">
                                    <i class="fas fa-filter"></i> Filter: {{ $searchJenis }}
                                </small>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Equipment -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="detailModalLabel">Detail Alat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Nama</th>
                        <td id="detail-nama"></td>
                    </tr>
                    <tr>
                        <th>Kode</th>
                        <td id="detail-kode"></td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td id="detail-jenis"></td>
                    </tr>
                    <tr>
                        <th>Merk</th>
                        <td id="detail-merk"></td>
                    </tr>
                    <tr>
                        <th>Tahun</th>
                        <td id="detail-tahun"></td>
                    </tr>
                    <tr>
                        <th>No. Polisi</th>
                        <td id="detail-no-polisi"></td>
                    </tr>
                    <tr>
                        <th>No. Mesin</th>
                        <td id="detail-no-mesin"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="detail-status"></td>
                    </tr>
                    <tr>
                        <th>Lokasi Sekarang</th>
                        <td id="detail-lokasi"></td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td id="detail-catatan"></td>
                    </tr>
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
                <p>Apakah Anda yakin ingin menghapus alat <strong id="equipmentName"></strong>?</p>
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
    const searchSelect = document.getElementById('searchJenisAlat');
    const clearBtn = document.getElementById('clearSearch');
    
    // Filter saat pilihan berubah
    searchSelect.addEventListener('change', function () {
        const jenis = this.value.trim();
        let url = new URL(window.location.href);
        
        if (jenis) {
            url.searchParams.set('jenis', jenis);
        } else {
            url.searchParams.delete('jenis');
        }
        
        window.location.href = url.toString();
    });
    
    // Clear filter
    clearBtn.addEventListener('click', function () {
        searchSelect.value = '';
        let url = new URL(window.location.href);
        url.searchParams.delete('jenis');
        window.location.href = url.toString();
    });

    // === LIHAT DETAIL ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-btn')) {
            const btn = e.target.closest('.detail-btn');
            document.getElementById('detail-nama').textContent = btn.getAttribute('data-nama');
            document.getElementById('detail-kode').textContent = btn.getAttribute('data-kode');
            document.getElementById('detail-jenis').textContent = btn.getAttribute('data-jenis');
            document.getElementById('detail-merk').textContent = btn.getAttribute('data-merk');
            document.getElementById('detail-tahun').textContent = btn.getAttribute('data-tahun');
            document.getElementById('detail-no-polisi').textContent = btn.getAttribute('data-no_polisi');
            document.getElementById('detail-no-mesin').textContent = btn.getAttribute('data-no_mesin');
            document.getElementById('detail-status').textContent = btn.getAttribute('data-status');
            document.getElementById('detail-lokasi').textContent = btn.getAttribute('data-lokasi');
            document.getElementById('detail-catatan').textContent = btn.getAttribute('data-catatan');

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    });

    // === DELETE BUTTON ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.getAttribute('data-id');
            const nama = btn.getAttribute('data-nama');

            document.getElementById('equipmentName').textContent = nama;
            document.getElementById('deleteForm').action = '/admin/equipment-list/' + id;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });

    // Tampilkan modal sukses jika ada
    @if (session('success'))
        new bootstrap.Modal(document.getElementById('successModal')).show();
    @endif
});
</script>
@endpush

@endsection