@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Data Logbook Limbah B3 (Masuk)</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Input Limbah Masuk</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('waste-b3.store') }}" method="POST" id="wasteForm">
                        @csrf
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Data Penerimaan (Masuk)</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Limbah B3 <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="jenis_limbah_masuk" 
                                       value="{{ old('jenis_limbah_masuk') }}" 
                                       class="form-control text-uppercase @error('jenis_limbah_masuk') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="Contoh: OLI BEKAS, FILTER BEKAS"
                                       required>
                                @error('jenis_limbah_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Kode Limbah <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="kode_limbah" 
                                       value="{{ old('kode_limbah') }}" 
                                       class="form-control text-uppercase @error('kode_limbah') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="Contoh: B105D"
                                       required>
                                @error('kode_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="tanggal_masuk" 
                                       value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                                       class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                       required>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sumber Limbah B3 <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="sumber_limbah" 
                                       value="{{ old('sumber_limbah') }}" 
                                       class="form-control text-uppercase @error('sumber_limbah') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="Contoh: WORKSHOP, PRODUKSI"
                                       required>
                                @error('sumber_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah Masuk (Ton) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.001" 
                                       name="jumlah_masuk_ton" 
                                       value="{{ old('jumlah_masuk_ton', '0.000') }}" 
                                       class="form-control @error('jumlah_masuk_ton') is-invalid @enderror"
                                       placeholder="0.000"
                                       required>
                                @error('jumlah_masuk_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Maks. Simpan S/D <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="maksimal_penyimpanan" 
                                       value="{{ old('maksimal_penyimpanan') }}" 
                                       class="form-control @error('maksimal_penyimpanan') is-invalid @enderror"
                                       required>
                                @error('maksimal_penyimpanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="horizontal dark">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3 text-primary">Data Pengeluaran (Keluar)</h6>
                        <div class="row g-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Keluar</label>
                                <input type="date" 
                                       name="tanggal_keluar" 
                                       value="{{ old('tanggal_keluar') }}" 
                                       class="form-control @error('tanggal_keluar') is-invalid @enderror">
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Keluar (Ton)</label>
                                <input type="number" 
                                       step="0.001" 
                                       name="jumlah_keluar_ton" 
                                       value="{{ old('jumlah_keluar_ton', '0.000') }}" 
                                       class="form-control @error('jumlah_keluar_ton') is-invalid @enderror"
                                       placeholder="0.000">
                                @error('jumlah_keluar_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sisa di TPS (Ton) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.001" 
                                       name="sisa_limbah_ton" 
                                       value="{{ old('sisa_limbah_ton', '0.000') }}" 
                                       class="form-control bg-light @error('sisa_limbah_ton') is-invalid @enderror" 
                                       readonly
                                       placeholder="0.000"
                                       required>
                                @error('sisa_limbah_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tujuan Penyerahan</label>
                                <input type="text" 
                                       name="tujuan_penyerahan" 
                                       value="{{ old('tujuan_penyerahan') }}" 
                                       class="form-control text-uppercase @error('tujuan_penyerahan') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="NAMA TRANSPORTER/PENGOLAH">
                                @error('tujuan_penyerahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Dokumen/Manifest</label>
                                <input type="text" 
                                       name="nomor_dokumen" 
                                       value="{{ old('nomor_dokumen') }}" 
                                       class="form-control text-uppercase @error('nomor_dokumen') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="CONTOH: MNF-001234">
                                @error('nomor_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('waste-b3') }}" class="btn btn-light me-2">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-save me-1"></i>Simpan Data
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
    const tanggalMasuk = document.querySelector('input[name="tanggal_masuk"]');
    const maksimalSimpan = document.querySelector('input[name="maksimal_penyimpanan"]');

    // === KAPITALISASI OTOMATIS ===
    const uppercaseFields = [
        'jenis_limbah_masuk', 'kode_limbah', 'sumber_limbah',
        'tujuan_penyerahan', 'nomor_dokumen'
    ];

    uppercaseFields.forEach(fieldName => {
        const field = document.querySelector(`input[name="${fieldName}"]`);
        if (!field) return;

        // Konversi nilai existing ke uppercase
        if (field.value) {
            field.value = field.value.toUpperCase();
        }

        // Force uppercase saat user mengetik
        field.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
        });

        // Pastikan saat blur juga uppercase
        field.addEventListener('blur', function () {
            this.value = this.value.toUpperCase();
        });
    });

    // === FORMAT NUMBER 3 DESIMAL ===
    function formatNumberInput(input) {
        if (!input) return;
        
        // Format saat blur
        input.addEventListener('blur', function() {
            if (this.value && !isNaN(this.value)) {
                const num = parseFloat(this.value);
                this.value = num.toFixed(3);
            }
        });
        
        // Hilangkan leading zeros saat input
        input.addEventListener('input', function() {
            if (this.value.startsWith('0') && this.value.length > 1 && !this.value.startsWith('0.')) {
                this.value = this.value.replace(/^0+/, '');
                if (this.value === '') this.value = '0';
            }
        });
    }

    formatNumberInput(masukInput);
    formatNumberInput(keluarInput);
    formatNumberInput(sisaInput);

    function hitungSisa() {
        // Pastikan semua input valid
        const masuk = parseFloat(masukInput.value) || 0;
        const keluar = parseFloat(keluarInput.value) || 0;
        
        // Jika nilai tidak valid, reset ke 0
        if (isNaN(masuk) || masuk < 0) masuk = 0;
        if (isNaN(keluar) || keluar < 0) keluar = 0;
        
        // Hitung sisa
        let sisa = masuk - keluar;
        if (sisa < 0) sisa = 0;
        
        // Pastikan 3 desimal
        sisaInput.value = sisa.toFixed(3);
    }

    masukInput?.addEventListener('input', hitungSisa);
    keluarInput?.addEventListener('input', hitungSisa);
    
    // Hitung ulang saat halaman dimuat
    setTimeout(hitungSisa, 100);

    // === VALIDASI TANGGAL ===
    function validateTanggal() {
        if (!tanggalMasuk || !maksimalSimpan) return true;
        
        if (tanggalMasuk.value && maksimalSimpan.value) {
            const tglMasuk = new Date(tanggalMasuk.value);
            const tglMax = new Date(maksimalSimpan.value);
            
            if (tglMax < tglMasuk) {
                alert('❌ Maksimal penyimpanan tidak boleh kurang dari tanggal masuk!');
                maksimalSimpan.value = '';
                maksimalSimpan.focus();
                return false;
            }
        }
        return true;
    }

    maksimalSimpan?.addEventListener('change', validateTanggal);

    // === VALIDASI PENGELOLUARAN ===
    function validatePengeluaran() {
        const tglKeluar = document.querySelector('input[name="tanggal_keluar"]')?.value;
        const jmlKeluar = document.querySelector('input[name="jumlah_keluar_ton"]')?.value;
        const tujuan = document.querySelector('input[name="tujuan_penyerahan"]')?.value;
        
        // Jika salah satu field pengeluaran diisi, pastikan semua wajib diisi
        if (tglKeluar || jmlKeluar || tujuan) {
            if (!tglKeluar) {
                alert('⚠️ Tanggal keluar harus diisi jika ada data pengeluaran!');
                document.querySelector('input[name="tanggal_keluar"]').focus();
                return false;
            }
            if (!jmlKeluar || parseFloat(jmlKeluar) === 0) {
                alert('⚠️ Jumlah keluar harus diisi jika ada data pengeluaran!');
                document.querySelector('input[name="jumlah_keluar_ton"]').focus();
                return false;
            }
            if (!tujuan || tujuan.trim() === '') {
                alert('⚠️ Tujuan penyerahan harus diisi jika ada data pengeluaran!');
                document.querySelector('input[name="tujuan_penyerahan"]').focus();
                return false;
            }
        }
        return true;
    }

    // === VALIDASI SUBMIT ===
    form.addEventListener('submit', function(e) {
        // 1. Pastikan kalkulasi terakhir
        hitungSisa();
        
        // 2. Validasi sisa harus sesuai perhitungan
        const masuk = parseFloat(masukInput.value) || 0;
        const keluar = parseFloat(keluarInput.value) || 0;
        const sisa = parseFloat(sisaInput.value) || 0;
        const sisaCalculated = masuk - keluar;
        
        if (Math.abs(sisa - sisaCalculated) > 0.001) {
            e.preventDefault();
            alert('⚠️ Kesalahan kalkulasi!\n\nPerhitungan: ' + masuk + ' - ' + keluar + ' = ' + sisaCalculated.toFixed(3));
            sisaInput.focus();
            return false;
        }
        
        // 3. Validasi logika bisnis
        if (keluar > masuk) {
            e.preventDefault();
            alert('❌ Jumlah keluar tidak boleh lebih besar dari jumlah masuk!');
            return false;
        }
    });
        
        // Tampilkan konfirmasi
        const confirmed = confirm('Apakah data sudah benar?\n\nJumlah Masuk: ' + masuk + ' ton\nJumlah Keluar: ' + keluar + ' ton\nSisa: ' + sisa + ' ton');
        
        if (!confirmed) {
            e.preventDefault();
            return false;
        }
    });

    // === TAMPILKAN MODAL ERROR ===
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
    }
    
    .text-danger {
        font-weight: bold;
    }
</style>
@endpush