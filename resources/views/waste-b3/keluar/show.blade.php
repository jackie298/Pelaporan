@extends('layouts.user_type.auth')

@section('content')
<style>
    .main-content-wrapper { padding: 1.5rem; animation: fadeIn 0.5s ease; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .custom-header {
        background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
        border-radius: 1.25rem;
        padding: 2.5rem 2rem 5rem 2rem;
        margin-bottom: -4rem;
        position: relative;
        overflow: hidden;
    }

    .detail-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .detail-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 25px 35px 0 rgba(0,0,0,0.08);
    }

    .info-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #8392ab;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #344767;
    }

    /* File Preview Box */
    .file-preview-box {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border: 2px dashed #dee2e6;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    .file-preview-box:hover {
        border-color: #7928ca;
        background: linear-gradient(145deg, #fdf2fb, #fff);
    }
    .file-preview-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        border-radius: 1rem;
        font-size: 2rem;
    }
    .file-preview-icon.pdf {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    .file-preview-icon.image {
        background: rgba(23, 173, 55, 0.1);
        color: #17ad37;
    }
    .file-preview-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #344767;
        margin-bottom: 0.25rem;
        word-break: break-all;
    }
    .file-preview-meta {
        font-size: 0.7rem;
        color: #67748e;
        margin-bottom: 1rem;
    }

    /* Vertical Timeline */
    .vertical-timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    .vertical-timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-dot {
        position: absolute;
        left: -5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #cb0c9f;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .timeline-item {
        position: relative;
        padding-left: 1.5rem;
        padding-bottom: 1.5rem;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }

    /* Stock Impact Box */
    .stock-impact-box {
        background: linear-gradient(145deg, #fff8e6, #fff);
        border-left: 4px solid #fbcf33;
        border-radius: 0 0.5rem 0.5rem 0;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    .stock-impact-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #f53939;
    }

    /* Utility */
    .text-gradient-primary {
        background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .border-soft { border-color: rgba(0,0,0,0.08) !important; }
    .btn-round { border-radius: 0.75rem; }
</style>

<div class="main-content-wrapper">
    <div class="custom-header">
        <div class="d-md-flex align-items-center justify-content-between position-relative">
            <div>
                <a href="{{ route('waste-b3-keluar') }}" class="btn btn-link text-white p-0 mb-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
                <h4 class="text-white font-weight-bolder mb-0">Detail Pengeluaran Limbah</h4>
                <p class="text-white text-xs opacity-8 mb-0">ID: #{{ $data->id }} • {{ $data->tanggal_keluar_formatted }}</p>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2">
                <a href="{{ route('waste-b3-keluar.edit', $data->id) }}" class="btn btn-white btn-round mb-0 px-4 shadow-sm">
                    <i class="fas fa-edit me-2 text-warning"></i> Edit Data
                </a>
                <button type="button" class="btn btn-outline-white btn-round mb-0 px-4 delete-btn" 
                        data-id="{{ $data->id }}" data-nama="{{ $data->limbahMasuk->jenis_limbah }}">
                    <i class="fas fa-trash me-2"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="row px-3">
        <div class="col-lg-8 mb-4">
            <div class="card detail-card p-4">
                <div class="row">
                    {{-- SECTION: Informasi Material --}}
                    <div class="col-12 mb-3">
                        <h6 class="font-weight-bolder text-gradient-primary mb-0">
                            <i class="fas fa-cube me-2"></i>Informasi Material
                        </h6>
                        <hr class="horizontal dark mt-2">
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <p class="info-label">Jenis Limbah</p>
                        <h5 class="info-value">{{ $data->limbahMasuk->jenis_limbah }}</h5>
                        <span class="badge bg-light text-dark border">{{ $data->limbahMasuk->kode_limbah }}</span>
                    </div>

                    <div class="col-md-3 mb-4">
                        <p class="info-label">Volume Keluar</p>
                        {{-- ✅ 3 Decimal Places --}}
                        <h5 class="info-value text-danger">
                            - {{ number_format($data->jumlah_keluar_ton, 3, ',', '.') }} Ton
                        </h5>
                    </div>

                    <div class="col-md-3 mb-4">
                        <p class="info-label">Sumber Limbah</p>
                        <h5 class="info-value text-sm">
                            <i class="fas fa-map-pin me-1 text-secondary"></i>
                            {{ $data->limbahMasuk->sumber_limbah }}
                        </h5>
                    </div>

                    {{-- SECTION: Tujuan & Administrasi --}}
                    <div class="col-12 mb-3 mt-2">
                        <h6 class="font-weight-bolder text-gradient-primary mb-0">
                            <i class="fas fa-file-contract me-2"></i>Tujuan & Administrasi
                        </h6>
                        <hr class="horizontal dark mt-2">
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Pihak Penerima (Tujuan)</p>
                        <h5 class="info-value">
                            <i class="fas fa-building me-2 text-secondary"></i>
                            {{ $data->tujuan_penyerahan }}
                        </h5>
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Nomor Dokumen/Manifest</p>
                        <h5 class="info-value">
                            <i class="fas fa-hashtag me-2 text-secondary"></i>
                            {{ $data->nomor_dokumen_keluar }}
                        </h5>
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Tanggal Pengeluaran</p>
                        <h5 class="info-value">
                            <i class="fas fa-calendar-check me-2 text-secondary"></i>
                            {{ $data->tanggal_keluar_formatted }}
                        </h5>
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Dibuat Oleh</p>
                        <h5 class="info-value">
                            <i class="fas fa-user me-2 text-secondary"></i>
                            {{ $data->limbahMasuk->creator?->name ?? 'System' }}
                        </h5>
                    </div>

                    {{-- SECTION: Catatan --}}
                    <div class="col-12 mb-3 mt-2">
                        <h6 class="font-weight-bolder text-gradient-primary mb-0">
                            <i class="fas fa-sticky-note me-2"></i>Catatan
                        </h6>
                        <hr class="horizontal dark mt-2">
                    </div>

                    <div class="col-12 mb-4">
                        <p class="text-sm text-secondary">
                            {{ $data->catatan ?? 'Tidak ada catatan tambahan.' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Stock Impact Info --}}
            <div class="card detail-card p-4">
                <h6 class="font-weight-bolder mb-3">
                    <i class="fas fa-scale-balanced me-2 text-info"></i>Dampak pada Stok TPS
                </h6>
                <div class="stock-impact-box">
                    <p class="text-xs text-muted mb-1">Sisa stok limbah ini di TPS setelah pengeluaran:</p>
                    <div class="d-flex align-items-center gap-3">
                        <span class="stock-impact-value">
                            {{ number_format($data->limbahMasuk->sisa_limbah, 3, ',', '.') }} Ton
                        </span>
                        <span class="text-xxs text-muted">
                            (Termasuk record ini: {{ number_format($data->jumlah_keluar_ton, 3, ',', '.') }} Ton)
                        </span>
                    </div>
                </div>
                <p class="text-xxs text-muted mt-3 mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Stok akan otomatis terupdate jika data ini diedit atau dihapus.
                </p>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- SECTION: Dokumen Lampiran (Berita Acara) --}}
            <div class="card detail-card mb-4 p-4">
                <h6 class="font-weight-bolder mb-3">
                    <i class="fas fa-file-signature me-2 text-success"></i>Berita Acara
                </h6>
                
                @if($data->berita_acara)
                    <div class="file-preview-box">
                        {{-- Dynamic Icon based on file extension --}}
                        <div class="file-preview-icon {{ pathinfo($data->berita_acara, PATHINFO_EXTENSION) == 'pdf' ? 'pdf' : 'image' }}">
                            <i class="fas fa-file-{{ pathinfo($data->berita_acara, PATHINFO_EXTENSION) == 'pdf' ? 'pdf' : 'image' }}"></i>
                        </div>
                        
                        <p class="file-preview-name">{{ $data->berita_acara }}</p>
                        <p class="file-preview-meta">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            File tersedia • {{ strtoupper(pathinfo($data->berita_acara, PATHINFO_EXTENSION)) }}
                        </p>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ Storage::url('waste-b3/berita-acara-keluar/' . $data->berita_acara) }}" 
                               target="_blank"
                               class="btn bg-gradient-success btn-sm btn-round mb-0">
                                <i class="fas fa-eye me-2"></i> Lihat File
                            </a>
                            {{-- <a href="{{ route('waste-b3-keluar.download-berita-acara', $data->id) }}" 
                               class="btn btn-outline-dark btn-sm btn-round mb-0">
                                <i class="fas fa-download me-2"></i> Download
                            </a> --}}
                        </div>
                    </div>
                @else
                    <div class="file-preview-box">
                        <div class="file-preview-icon" style="background: rgba(131, 146, 171, 0.1); color: #8392ab;">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <p class="text-xs font-weight-bold text-muted mb-0">Belum ada berita acara</p>
                        <p class="text-xxs text-secondary mt-1">Edit data untuk mengunggah dokumen.</p>
                    </div>
                @endif
            </div>

            {{-- SECTION: Ketertelusuran (Log) --}}
            <div class="card detail-card p-4">
                <h6 class="font-weight-bolder mb-3">
                    <i class="fas fa-history me-2"></i>Ketertelusuran
                </h6>
                <div class="vertical-timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <p class="info-label mb-0">Data Dibuat</p>
                        <p class="text-xs font-weight-bold mb-0 text-dark">
                            {{ $data->created_at?->format('d M Y, H:i') }} WIB
                        </p>
                        <p class="text-xxs text-muted mt-1">
                            Oleh: {{ $data->limbahMasuk->creator?->name ?? 'System' }}
                        </p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: #82d616;"></div>
                        <p class="info-label mb-0">Update Terakhir</p>
                        <p class="text-xs font-weight-bold mb-0 text-dark">
                            {{ $data->updated_at?->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                    @if($data->deleted_at)
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: #fd5c70;"></div>
                        <p class="info-label mb-0 text-danger">Dihapus (Soft)</p>
                        <p class="text-xs font-weight-bold mb-0 text-danger">
                            {{ $data->deleted_at->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            {{-- <div class="card detail-card p-4 mt-4">
                <h6 class="font-weight-bolder mb-3">Aksi Cepat</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('waste-b3.show', $data->waste_b3_masuk_id) }}" 
                       class="btn btn-outline-secondary btn-sm btn-round">
                        <i class="fas fa-cube me-2"></i>Lihat Data Limbah Masuk
                    </a>
                    <a href="javascript:window.print()" class="btn btn-outline-dark btn-sm btn-round">
                        <i class="fas fa-print me-2"></i>Cetak Halaman Ini
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
            <div class="modal-body text-center p-4">
                <div class="text-danger mb-3">
                    <i class="fas fa-exclamation-circle fa-3x"></i>
                </div>
                <h5 class="font-weight-bolder">Hapus Data?</h5>
                <p class="text-sm text-muted">
                    Data pengeluaran <b id="wasteName"></b> akan dihapus permanen.
                </p>
                <p class="text-xxs text-muted mt-2">
                    <i class="fas fa-info-circle me-1"></i>Stok limbah di TPS akan dikembalikan otomatis.
                    <br>File berita acara juga akan dihapus.
                </p>
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-light btn-round w-100 mb-0" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="w-100">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn bg-gradient-danger btn-round w-100 mb-0">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete Modal Handler
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('wasteName').textContent = this.dataset.nama;
            document.getElementById('deleteForm').action = `/waste-b3-keluar/${this.dataset.id}`;
            deleteModal.show();
        });
    });
});
</script>
@endpush
@endsection