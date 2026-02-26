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
    }

    .info-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #8392ab;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #344767;
    }

    .document-preview-box {
        background: #f8f9fa;
        border-radius: 1rem;
        border: 2px dashed #dee2e6;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s;
    }

    .document-preview-box:hover {
        background: #f1f3f5;
        border-color: #cb0c9f;
    }

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
    }
</style>

<div class="main-content-wrapper">
    <div class="custom-header">
        <div class="d-md-flex align-items-center justify-content-between position-relative">
            <div>
                <a href="{{ route('waste-b3-keluar') }}" class="btn btn-link text-white p-0 mb-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
                <h4 class="text-white font-weight-bolder mb-0">Detail Pengeluaran Limbah</h4>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('waste-b3-keluar.edit', $data->id) }}" class="btn btn-white btn-round mb-0 px-4">
                    <i class="fas fa-edit me-2 text-warning"></i> Edit Data
                </a>
            </div>
        </div>
    </div>

    <div class="row px-3">
        <div class="col-lg-8 mb-4">
            <div class="card detail-card p-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <h6 class="font-weight-bolder text-gradient-primary mb-0">Informasi Material</h6>
                        <hr class="horizontal dark mt-2">
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <p class="info-label">Jenis Limbah</p>
                        <h5 class="info-value">{{ $data->limbahMasuk->jenis_limbah }}</h5>
                        <span class="badge bg-light text-dark">{{ $data->limbahMasuk->kode_limbah }}</span>
                    </div>

                    <div class="col-md-3 mb-4">
                        <p class="info-label">Volume Keluar</p>
                        <h5 class="info-value text-danger">- {{ $data->jumlah_keluar_ton_formatted }}</h5>
                    </div>

                    <div class="col-md-3 mb-4">
                        <p class="info-label">Satuan</p>
                        <h5 class="info-value">Ton</h5>
                    </div>

                    <div class="col-12 mb-4 mt-2">
                        <h6 class="font-weight-bolder text-gradient-primary mb-0">Tujuan & Administrasi</h6>
                        <hr class="horizontal dark mt-2">
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Pihak Penerima (Tujuan)</p>
                        <h5 class="info-value"><i class="fas fa-building me-2 text-secondary"></i>{{ $data->tujuan_penyerahan }}</h5>
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Nomor Dokumen/Manifest</p>
                        <h5 class="info-value"><i class="fas fa-file-contract me-2 text-secondary"></i>{{ $data->nomor_dokumen_keluar }}</h5>
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Tanggal Pengeluaran</p>
                        <h5 class="info-value"><i class="fas fa-calendar-check me-2 text-secondary"></i>{{ $data->tanggal_keluar_formatted }}</h5>
                    </div>

                    <div class="col-md-6 mb-4">
                        <p class="info-label">Catatan</p>
                        <p class="text-sm text-secondary">{{ $data->catatan ?? 'Tidak ada catatan tambahan.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card detail-card mb-4 p-4">
                <h6 class="font-weight-bolder mb-3">Dokumen Lampiran</h6>
                
                @if($data->file_dokumen_exists)
                    <div class="document-preview-box">
                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                        <p class="text-xs font-weight-bold text-uppercase text-muted mb-3">Dokumen Tersedia</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('waste-b3-keluar.download', $data->id) }}" class="btn bg-gradient-dark btn-sm btn-round mb-0">
                                <i class="fas fa-download me-2"></i> Download File
                            </a>
                        </div>
                    </div>
                @else
                    <div class="document-preview-box">
                        <i class="fas fa-file-upload fa-3x text-secondary mb-3 opacity-5"></i>
                        <p class="text-xs font-weight-bold text-muted mb-0">Belum ada dokumen yang diunggah.</p>
                        <p class="text-xxs text-secondary">Silahkan edit data untuk mengunggah manifest.</p>
                    </div>
                @endif
            </div>

            <div class="card detail-card p-4">
                <h6 class="font-weight-bolder mb-3">Ketertelusuran (Log)</h6>
                <div class="vertical-timeline">
                    <div class="mb-4">
                        <div class="timeline-dot"></div>
                        <p class="info-label mb-0">Data Dibuat</p>
                        <p class="text-xs font-weight-bold mb-0 text-dark">{{ $data->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="mb-0">
                        <div class="timeline-dot" style="background: #82d616;"></div>
                        <p class="info-label mb-0">Update Terakhir</p>
                        <p class="text-xs font-weight-bold mb-0 text-dark">{{ $data->updated_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection