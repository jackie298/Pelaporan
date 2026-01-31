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
                    <form action="{{ route('trash-management.store') }}" method="POST">
                        @csrf
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Data Penerimaan (Masuk)</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Limbah B3</label>
                                <input type="text" 
                                       name="jenis_limbah_masuk" 
                                       value="{{ old('jenis_limbah_masuk') }}" 
                                       class="form-control text-uppercase @error('jenis_limbah_masuk') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="Contoh: OLI BEKAS, FILTER BEKAS">
                                @error('jenis_limbah_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Kode Limbah</label>
                                <input type="text" 
                                       name="kode_limbah" 
                                       value="{{ old('kode_limbah') }}" 
                                       class="form-control text-uppercase @error('kode_limbah') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="Contoh: B105D">
                                @error('kode_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" 
                                       name="tanggal_masuk" 
                                       value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                                       class="form-control @error('tanggal_masuk') is-invalid @enderror">
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sumber Limbah B3</label>
                                <input type="text" 
                                       name="sumber_limbah" 
                                       value="{{ old('sumber_limbah') }}" 
                                       class="form-control text-uppercase @error('sumber_limbah') is-invalid @enderror"
                                       style="text-transform: uppercase;"
                                       placeholder="Contoh: WORKSHOP, PRODUKSI">
                                @error('sumber_limbah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah Masuk (Ton)</label>
                                <input type="number" 
                                       step="0.001" 
                                       name="jumlah_masuk_ton" 
                                       value="{{ old('jumlah_masuk_ton') }}" 
                                       class="form-control @error('jumlah_masuk_ton') is-invalid @enderror"
                                       placeholder="0.000">
                                @error('jumlah_masuk_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Maks. Simpan S/D</label>
                                <input type="date" 
                                       name="maksimal_penyimpanan" 
                                       value="{{ old('maksimal_penyimpanan') }}" 
                                       class="form-control @error('maksimal_penyimpanan') is-invalid @enderror">
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
                                       value="{{ old('jumlah_keluar_ton') }}" 
                                       class="form-control @error('jumlah_keluar_ton') is-invalid @enderror"
                                       placeholder="0.000">
                                @error('jumlah_keluar_ton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sisa di TPS (Ton)</label>
                                <input type="number" 
                                       step="0.001" 
                                       name="sisa_limbah_ton" 
                                       value="{{ old('sisa_limbah_ton') }}" 
                                       class="form-control bg-light @error('sisa_limbah_ton') is-invalid @enderror" 
                                       readonly
                                       placeholder="0.000">
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
                            <a href="{{ route('trash-management') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary">Simpan Data</button>
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
                <h5 class="modal-title text-white">Validasi Gagal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger p-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === KAPITALISASI OTOMATIS ===
    const uppercaseFields = [
        'jenis_limbah_masuk',
        'kode_limbah',
        'sumber_limbah',
        'tujuan_penyerahan',
        'nomor_dokumen'
    ];

    // Force uppercase saat input & saat load
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

        // Pastikan saat submit juga uppercase (safety net)
        field.addEventListener('blur', function () {
            this.value = this.value.toUpperCase();
        });
    });

    // === KALKULASI SISA LIMBAH ===
    const masukInput = document.querySelector('input[name="jumlah_masuk_ton"]');
    const keluarInput = document.querySelector('input[name="jumlah_keluar_ton"]');
    const sisaInput = document.querySelector('input[name="sisa_limbah_ton"]');

    function hitungSisa() {
        if (!masukInput || !keluarInput || !sisaInput) return;
        
        const masuk = parseFloat(masukInput.value) || 0;
        const keluar = parseFloat(keluarInput.value) || 0;
        let sisa = masuk - keluar;
        
        // Hindari nilai negatif
        if (sisa < 0) sisa = 0;
        
        sisaInput.value = sisa.toFixed(3);
    }

    masukInput?.addEventListener('input', hitungSisa);
    keluarInput?.addEventListener('input', hitungSisa);
    
    // Hitung ulang saat halaman dimuat
    setTimeout(hitungSisa, 100);

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