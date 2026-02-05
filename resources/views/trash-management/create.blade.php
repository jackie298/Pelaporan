@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Data Pengelolaan Sampah</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Data Pengelolaan Sampah</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('trash-management.store') }}"
                          method="POST"
                          id="trashForm">
                        @csrf

                        <div class="row g-3">

                            {{-- TANGGAL --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date"
                                       name="tanggal"
                                       value="{{ old('tanggal', date('Y-m-d')) }}"
                                       class="form-control @error('tanggal') is-invalid @enderror"
                                       required>

                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SUMBER SAMPAH --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sumber Sampah <span class="text-danger">*</span></label>
                                <select name="sumber_sampah"
                                        class="form-select @error('sumber_sampah') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Sumber Sampah --</option>
                                    @foreach($sumberOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('sumber_sampah') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('sumber_sampah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SAMPAH ORGANIK TERPILAH --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sampah Organik Terpilah (kg)</label>
                                <input type="number"
                                       step="1"
                                       name="sampah_organik_terpilah"
                                       value="{{ old('sampah_organik_terpilah', '0') }}"
                                       class="form-control @error('sampah_organik_terpilah') is-invalid @enderror"
                                       placeholder="Contoh: 50">

                                @error('sampah_organik_terpilah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SAMPAH ANORGANIK TERPILAH --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sampah Anorganik Terpilah (kg)</label>
                                <input type="number"
                                       step="1"
                                       name="sampah_anorganik_terpilah"
                                       value="{{ old('sampah_anorganik_terpilah', '0') }}"
                                       class="form-control @error('sampah_anorganik_terpilah') is-invalid @enderror"
                                       placeholder="Contoh: 30">

                                @error('sampah_anorganik_terpilah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SAMPAH LAINNYA DAN/ATAU RESIDU --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sampah Lainnya/Residu (kg)</label>
                                <input type="number"
                                       step="1"
                                       name="sampah_lainnya_dan_atau_residu"
                                       value="{{ old('sampah_lainnya_dan_atau_residu', '0') }}"
                                       class="form-control @error('sampah_lainnya_dan_atau_residu') is-invalid @enderror"
                                       placeholder="Contoh: 20">

                                @error('sampah_lainnya_dan_atau_residu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TOTAL (READONLY) --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Total Sampah (kg) <span class="text-muted">(Otomatis Terhitung)</span></label>
                                <input type="number"
                                       name="total"
                                       value="{{ old('sampah_organik_terpilah', 0) + old('sampah_anorganik_terpilah', 0) + old('sampah_lainnya_dan_atau_residu', 0) }}"
                                       class="form-control bg-light"
                                       readonly
                                       placeholder="0">

                                <small class="text-muted">
                                    Total = Sampah Organik + Sampah Anorganik + Sampah Residu
                                </small>
                            </div>

                            {{-- CATATAN --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan"
                                          rows="3"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Catatan khusus atau keterangan tambahan">{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('trash-management') }}"
                               class="btn btn-light me-2">
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

{{-- MODAL ERROR VALIDASI - VERSI DIPERBAGUS --}}
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            
            {{-- MODAL HEADER --}}
            <div class="modal-header bg-gradient-danger border-0 py-4">
                <div class="d-flex align-items-center">
                    <div class="bg-white rounded-circle p-3 me-3">
                        <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold" id="errorModalLabel">
                            <i class="fas fa-times-circle me-2"></i>Validasi Gagal
                        </h5>
                        <p class="mb-0 text-white-50 small">Mohon perbaiki kesalahan berikut</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- MODAL BODY --}}
            <div class="modal-body p-4">
                <div class="alert alert-danger border border-danger rounded-3 p-4 mb-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <i class="fas fa-info-circle fa-lg text-danger"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading fw-bold mb-3">Daftar Kesalahan:</h6>
                            <div class="list-group list-group-flush">
                                @foreach ($errors->all() as $error)
                                    <div class="list-group-item list-group-item-action border-0 bg-transparent text-danger p-2 ps-0">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-times-circle me-2 mt-1 text-danger"></i>
                                            <span class="fw-medium">{{ $error }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MODAL FOOTER --}}
            <div class="modal-footer bg-light border-0 py-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-lightbulb me-2 text-warning"></i>
                                <span>Periksa kembali data yang Anda masukkan sebelum menyimpan.</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Form
                            </button>
                            <button type="button" class="btn btn-danger px-4 ms-2" onclick="window.location.reload()">
                                <i class="fas fa-redo me-1"></i>Reset Form
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show modal with animation
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'), {
        backdrop: 'static',
        keyboard: false
    });
    
    // Add fade-in animation
    document.getElementById('errorModal').addEventListener('shown.bs.modal', function () {
        const modalContent = this.querySelector('.modal-content');
        modalContent.style.animation = 'fadeInUp 0.3s ease-out';
    });
    
    errorModal.show();
});
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.list-group-item-action:hover {
    background-color: rgba(220, 53, 69, 0.05);
}

.modal-content {
    border-radius: 12px !important;
}

.btn-close-white:hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
}
</style>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('trashForm');
    const organikInput = document.querySelector('input[name="sampah_organik_terpilah"]');
    const anorganikInput = document.querySelector('input[name="sampah_anorganik_terpilah"]');
    const residuInput = document.querySelector('input[name="sampah_lainnya_dan_atau_residu"]');
    const totalInput = document.querySelector('input[name="total"]');

    // Fungsi kalkulasi total
    function hitungTotal() {
        const organik = parseInt(organikInput.value) || 0;
        const anorganik = parseInt(anorganikInput.value) || 0;
        const residu = parseInt(residuInput.value) || 0;
        
        const total = organik + anorganik + residu;
        totalInput.value = total;
    }

    // Event listeners untuk kalkulasi otomatis
    organikInput?.addEventListener('input', hitungTotal);
    anorganikInput?.addEventListener('input', hitungTotal);
    residuInput?.addEventListener('input', hitungTotal);

    // Hitung saat halaman dimuat
    setTimeout(hitungTotal, 100);

    // Validasi sebelum submit
    form?.addEventListener('submit', function(e) {
        const organik = parseInt(organikInput.value) || 0;
        const anorganik = parseInt(anorganikInput.value) || 0;
        const residu = parseInt(residuInput.value) || 0;
        const total = organik + anorganik + residu;

        // Validasi minimal satu jenis sampah harus diisi
        if (total === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Minimal satu jenis sampah harus diisi!',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
            return false;
        }

        // Konfirmasi sebelum submit
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Data',
            html: `
                <div class="text-start">
                    <p class="mb-2"><strong>Tanggal:</strong> ${document.querySelector('input[name="tanggal"]').value}</p>
                    <p class="mb-2"><strong>Sumber:</strong> ${document.querySelector('select[name="sumber_sampah"]').value}</p>
                    <p class="mb-2"><strong>Sampah Organik:</strong> ${organik} kg</p>
                    <p class="mb-2"><strong>Sampah Anorganik:</strong> ${anorganik} kg</p>
                    <p class="mb-3"><strong>Sampah Residu:</strong> ${residu} kg</p>
                    <hr>
                    <p class="mb-0"><strong>Total:</strong> ${total} kg</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan Data',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@endsection