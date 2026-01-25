@extends('layouts.user_type.auth')

@section('content')

<style>
    /* CSS UNTUK LAYOUT VISUAL (SESUAI GAMBAR LAMPIRAN) */
    .nka-card {
        background: #fff;
        border: 2px solid #0d4435;
        border-radius: 12px;
        overflow: hidden;
        margin: auto;
    }
    .nka-image-container {
        position: relative;
        width: 100%;
        background-color: #eee;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 200px;
    }
    .nka-image-container img {
        width: 100%;
        height: auto;
        display: block;
    }
    .nka-logo-watermark {
        position: absolute;
        bottom: 10px;
        left: 10px;
        width: 60px;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5));
    }
    .nka-header-box {
        background-color: #0d4435; /* Hijau Tua */
        color: #ffffff;
        padding: 12px;
        border-top: 4px solid #c05c2e; /* Garis Orange */
    }
    .nka-footer-label {
        color: #2ecc71; /* Hijau Terang */
        font-weight: bold;
        text-decoration: underline;
    }
</style>

<div class="container-fluid py-4">
    <div class="card mb-4">
        <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div><h5 class="mb-0">Dokumentasi Kegiatan</h5></div>
                <a href="{{ route('admin.dokumentasi-kegiatan.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah</a>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kegiatan</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dokumentasi as $item)
                        <tr>
                            <td class="ps-4 text-xs font-weight-bold">{{ $loop->iteration }}</td>
                            <td class="text-xs font-weight-bold">{{ $item->judul }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link text-primary btn-sm mb-0 detail-visual-btn"
                                    data-judul="{{ $item->judul }}"
                                    data-tanggal="{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}"
                                    data-lokasi="{{ $item->lokasi }}"
                                    data-jenis="{{ $item->jenis_kegiatan }}"
                                    data-file="{{ $item->file_dokumentasi ? asset('storage/' . $item->file_dokumentasi) : 'Tidak ada' }}">
                                    <i class="fas fa-image"></i> Visual
                                </button>

                                <button type="button" class="btn btn-link text-info btn-sm mb-0 detail-btn"
                                    data-judul="{{ $item->judul }}"
                                    data-tanggal="{{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}"
                                    data-lokasi="{{ $item->lokasi }}"
                                    data-jenis="{{ $item->jenis_kegiatan }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    data-file="{{ $item->file_dokumentasi }}"
                                    data-pembuat="{{ $item->user->name ?? 'Admin' }}">
                                    <i class="fas fa-info-circle"></i> Detail
                                </button>

                                <a href="{{ route('admin.dokumentasi-kegiatan.edit', $item->id) }}" class="mx-2"><i class="fas fa-edit text-dark"></i></a>

                                <button type="button" class="border-0 bg-transparent delete-btn" data-id="{{ $item->id }}" data-nama="{{ $item->judul }}">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5>Detail Informasi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <p><strong>Judul:</strong> <span id="detail-judul"></span></p>
                <p><strong>Tanggal:</strong> <span id="detail-tanggal"></span></p>
                <p><strong>Lokasi:</strong> <span id="detail-lokasi"></span></p>
                <p><strong>Jenis:</strong> <span id="detail-jenis"></span></p>
                <p><strong>Deskripsi:</strong> <span id="detail-deskripsi"></span></p>
                <p><strong>Pembuat:</strong> <span id="detail-pembuat"></span></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailKegiatanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div class="row justify-content-center" id="container-detail-visual">
                    </div>
                <div class="text-center mt-3"><button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Tutup</button></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body text-center">
                    <h5 class="mt-3">Hapus Data?</h5>
                    <p>Anda akan menghapus: <strong id="equipmentName"></strong></p>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-body text-center"><h5>Berhasil!</h5><p>{{ session('success') }}</p><button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button></div></div></div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // === 1. LIHAT DETAIL (TEXT) ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-btn')) {
            const btn = e.target.closest('.detail-btn');
            document.getElementById('detail-judul').textContent = btn.getAttribute('data-judul');
            document.getElementById('detail-tanggal').textContent = btn.getAttribute('data-tanggal');
            document.getElementById('detail-lokasi').textContent = btn.getAttribute('data-lokasi');
            document.getElementById('detail-jenis').textContent = btn.getAttribute('data-jenis');
            document.getElementById('detail-deskripsi').textContent = btn.getAttribute('data-deskripsi');
            document.getElementById('detail-pembuat').textContent = btn.getAttribute('data-pembuat');

            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    });

    // === 2. LIHAT DETAIL VISUAL (GAMBAR ALA LAPORAN) ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.detail-visual-btn')) {
            const btn = e.target.closest('.detail-visual-btn');
            
            const data = {
                judul: btn.getAttribute('data-judul'),
                tanggal: btn.getAttribute('data-tanggal'),
                lokasi: btn.getAttribute('data-lokasi'),
                jenis: btn.getAttribute('data-jenis'),
                file: btn.getAttribute('data-file'),
            };

            const container = document.getElementById('container-detail-visual');
            
            container.innerHTML = `
                <div class="col-md-11">
                    <div class="nka-card shadow-lg">
                        <div class="nka-image-container">
                            <img src="${data.file !== 'Tidak ada' ? data.file : 'https://via.placeholder.com/400x250?text=No+Image'}" alt="Foto Kegiatan">
                            <div class="nka-logo-watermark">
                                <img src="{{ asset('assets/img/logoperusahaan.png') }}" style="width:100%; border:none;">
                            </div>
                        </div>
                        <div class="nka-header-box">
                            <p class="mb-1"><span class="nka-footer-label">Kegiatan:</span> ${data.judul}</p>
                            <p class="mb-1"><strong>Unit / Jenis:</strong> ${data.jenis}</p>
                            <p class="mb-0"><strong>Lokasi:</strong> ${data.lokasi}</p>
                            <p class="text-end small opacity-7" style="font-size: 10px; margin-top:5px;">${data.tanggal}</p>
                        </div>
                    </div>
                </div>
            `;

            new bootstrap.Modal(document.getElementById('detailKegiatanModal')).show();
        }
    });

    // === 3. HAPUS DATA ===
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            document.getElementById('equipmentName').textContent = button.getAttribute('data-nama');
            document.getElementById('deleteForm').action = '/admin/dokumentasi-kegiatan/' + button.getAttribute('data-id');
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });

    // === 4. TAMPILKAN MODAL SUKSES ===
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