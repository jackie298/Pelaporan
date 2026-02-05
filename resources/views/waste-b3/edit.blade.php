@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Update Logbook Limbah B3</strong> (ID: #{{ $data->id }})
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Update Data Logbook Limbah B3</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('waste-b3.update', $data->id) }}" method="POST" id="wasteForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Hidden fields untuk data yang tidak bisa diubah --}}
                        <input type="hidden" name="jenis_limbah_masuk" value="{{ $data->jenis_limbah_masuk }}">
                        <input type="hidden" name="kode_limbah" value="{{ $data->kode_limbah }}">
                        <input type="hidden" name="tanggal_masuk" value="{{ $data->tanggal_masuk }}">
                        <input type="hidden" name="sumber_limbah" value="{{ $data->sumber_limbah }}">
                        <input type="hidden" name="jumlah_masuk_ton" value="{{ $data->jumlah_masuk_ton }}">
                        <input type="hidden" name="maksimal_penyimpanan" value="{{ $data->maksimal_penyimpanan }}">
                        
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Data Penerimaan (Masuk)</h6>
                        <div class="row g3 mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Limbah B3</label>
                                <input type="text" 
                                       value="{{ $data->jenis_limbah_masuk }}" 
                                       class="form-control bg-light"
                                       readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Kode Limbah</label>
                                <input type="text" 
                                       value="{{ $data->kode_limbah }}" 
                                       class="form-control bg-light"
                                       readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" 
                                       value="{{ $data->tanggal_masuk?->format('Y-m-d') }}" 
                                       class="form-control bg-light"
                                       readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sumber Limbah B3</label>
                                <input type="text" 
                                       value="{{ $data->sumber_limbah }}" 
                                       class="form-control bg-light"
                                       readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah Masuk (Ton)</label>
                                <input type="number" 
                                       step="0.001" 
                                       value="{{ number_format($data->jumlah_masuk_ton, 3, '.', '') }}" 
                                       class="form-control bg-light"
                                       readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Maks. Simpan S/D</label>
                                <input type="date" 
                                       value="{{ $data->maksimal_penyimpanan?->format('Y-m-d') }}" 
                                       class="form-control bg-light"
                                       readonly>
                            </div>
                        </div>

                        <hr class="horizontal dark">
                        <h6text-uppercase text-body text-xs font-weight-bolder mb-3 text-primary">Data Pengeluaran (Keluar)</h6>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-info-circle me-2"></i>Info:</strong>
                            Form ini digunakan untuk update data pengeluaran limbah B3. Data penerimaan tidak dapat diubah.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="tanggal_keluar" 
                                       value="{{ old('tanggal_keluar', $data->tanggal_keluar?->format('Y-m-d')) }}" 
                                       class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                       required>
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Keluar (Ton) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.001" 
                                       name="jumlah_keluar_ton" 
                                       value="{{ old('jumlah_keluar_ton', $data->jumlah_keluar_ton ?? '0.000') }}" 
                                       class="form-control @error('jumlah_keluar_ton') is-invalid @enderror"
                                       placeholder="0.000"
                                       required>
                                @error('jumlah_keluar_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sisa di TPS (Ton) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.001" 
                                       name="sisa_limbah_ton" 
                                       value="{{ old('sisa_limbah_ton', $data->sisa_limbah_ton ?? number_format($data->jumlah_masuk_ton, 3, '.', '')) }}" 
                                       class="form-control bg-light @error('sisa_limbah_ton') is-invalid @enderror" 
                                       readonly
                                       placeholder="0.000"
                                       required>
                                @error('sisa_limbah_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tujuan Penyerahan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="tujuan_penyerahan" 
                                       value="{{ old('tujuan_penyerahan', $data->tujuan_penyerahan) }}" 
                                       class="form-control text-uppercase @error('tujuan_penyerahan') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="NAMA TRANSPORTER/PENGOLAH"
                                       required>
                                @error('tujuan_penyerahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Dokumen/Manifest</label>
                                <input type="text" 
                                       name="nomor_dokumen" 
                                       value="{{ old('nomor_dokumen', $data->nomor_dokumen) }}" 
                                       class="form-control text-uppercase @error('nomor_dokumen') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="CONTOH: MNF-001234">
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Jumlah keluar tidak boleh lebih besar dari jumlah masuk ({{ number_format($data->jumlah_masuk_ton, 3, '.', '') }} ton)</li>
                                <li>Sisa limbah akan dihitung otomatis: Jumlah Masuk - Jumlah Keluar</li>
                                <li>Data penerimaan tidak dapat diubah setelah tersimpan</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('waste-b3') }}" class="btn btn-light me-2">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i>Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ERROR VALIDASI --}}
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title text-white"><i class="fas fa-exclamation-triangle me-2"></i>Validasi Gagal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger p-3">
                    <p class="fw-bold mb-2">Mohon perbaiki kesalahan berikut:</p>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
 <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('wasteForm');
    const masukInput = document.querySelector('input[name="jumlah_masuk_ton"]');
    const keluarInput = document.querySelector('input[name="jumlah_keluar_ton"]');
    const sisaInput = document.querySelector('input[name="sisa_limbah_ton"]');
    
    // Ambil nilai jumlah masuk dari hidden field
    let jumlahMasukValue = 0;
    if (masukInput) {
        jumlahMasukValue = parseFloat(masukInput.value) || 0;
    } else {
        // Fallback jika hidden field tidak ditemukan
        const visibleMasukInput = document.querySelector('input[readonly][value]');
        if (visibleMasukInput) {
            jumlahMasukValue = parseFloat(visibleMasukInput.value) || 0;
        }
    }

    // Fungsi kalkulasi yang sudah diperbaiki
    function hitungSisa() {
        // Pastikan semua input valid
        const masuk = jumlahMasukValue;
        const keluar = keluarInput && keluarInput.value ? parseFloat(keluarInput.value) : 0;
        
        // Validasi nilai tidak negatif
        const validKeluar = isNaN(keluar) || keluar < 0 ? 0 : keluar;
        
        // Hitung sisa
        let sisa = masuk - validKeluar;
        if (sisa < 0) sisa = 0;
        
        // Pastikan 3 desimal
        if (sisaInput) {
            sisaInput.value = sisa.toFixed(3);
        }
    }

    // Event listeners yang lebih andal
    if (keluarInput) {
        // Gunakan event delegation untuk memastikan kalkulasi berjalan
        keluarInput.addEventListener('input', function() {
            hitungSisa();
        });
        
        keluarInput.addEventListener('blur', function() {
            hitungSisa();
        });
        
        keluarInput.addEventListener('change', function() {
            hitungSisa();
        });
    }

    // Kalkulasi saat halaman dimuat
    setTimeout(hitungSisa, 100);

    // Validasi sebelum submit
    if (form) {
        form.addEventListener('submit', function(e) {
            hitungSisa();
            
            // Validasi logika bisnis
            const keluar = keluarInput && keluarInput.value ? parseFloat(keluarInput.value) : 0;
            const sisa = sisaInput ? parseFloat(sisaInput.value) : 0;
            
            if (keluar > jumlahMasukValue) {
                e.preventDefault();
                alert('❌ Jumlah keluar tidak boleh lebih besar dari jumlah masuk!');
                keluarInput.focus();
            } else if (sisa > jumlahMasukValue) {
                e.preventDefault();
                alert('❌ Sisa limbah tidak boleh lebih besar dari jumlah masuk!');
                sisaInput.focus();
            }
        });
    }

    // Tampilkan modal error
    @if ($errors->any())
    setTimeout(function() {
        const modalEl = document.getElementById('errorModal');
        if (modalEl && typeof bootstrap !== 'undefined') {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }, 300);
    @endif
});
</script>
@endpush

@push('css')
<style>
    .form-label {
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    
    .form-control[readonly] {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
        opacity: 1;
    }
    
    .text-danger {
        font-weight: bold;
    }
    
    .alert-info, .alert-warning {
        font-size: 0.875rem;
    }
    
    .alert-info ul, .alert-warning ul {
        margin-bottom: 0;
    }
    
    /* Tambahkan style khusus untuk field sisa */
    input[name="sisa_limbah_ton"] {
        font-weight: bold;
        color: #1a73e8;
    }
</style>
@endpush