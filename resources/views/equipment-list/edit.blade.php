@extends('layouts.user_type.auth')

@section('content')
<style>
    /* ===== MODERN SOFT UI ENHANCEMENTS ===== */
    :root {
        --primary-gradient: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
        --surface-color: #f8f9fa;
    }

    .main-content-wrapper { padding: 1.5rem; }

    .custom-header {
        background: var(--primary-gradient);
        border-radius: 1rem;
        padding: 2.5rem 2rem 5rem 2rem;
        margin-bottom: -4rem;
        position: relative;
        box-shadow: 0 4px 20px 0 rgba(0,0,0,0.1);
    }

    .form-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        background: white;
        overflow: hidden;
    }

    .form-section {
        background: #fafbfc;
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .form-section-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
        color: #8392ab;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .input-group-custom {
        position: relative;
    }

    .input-group-custom .form-control {
        padding-left: 2.5rem;
        border-radius: 0.5rem;
        border: 1px solid #d2d6da;
        transition: all 0.2s ease;
    }

    .input-group-custom .form-control:focus {
        border-color: #e293d3;
        box-shadow: 0 0 0 3px rgba(234, 106, 206, 0.15);
    }

    .input-group-custom .input-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #8392ab;
        z-index: 10;
        font-size: 0.875rem;
    }

    .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #344767;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-label .required {
        color: #ea580c;
    }

    .btn-round {
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .btn-round:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-outline-secondary {
        border-color: #d2d6da;
        color: #67748e;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        color: #344767;
    }

    /* Status badge preview */
    .status-preview {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-top: 0.25rem;
    }

    /* Character counter */
    .char-counter {
        font-size: 0.65rem;
        color: #8392ab;
        text-align: right;
        margin-top: 0.25rem;
    }

    /* Form animation */
    .form-control {
        animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Error state enhancement */
    .is-invalid {
        border-color: #ea580c !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23ea580c' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ea580c' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem 1rem;
    }

    .invalid-feedback {
        font-size: 0.7rem;
        color: #ea580c;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .invalid-feedback::before {
        content: "⚠";
        font-size: 0.8rem;
    }
</style>

<div class="main-content-wrapper">
    <!-- Header Section -->
    <div class="custom-header">
        <div class="d-md-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar bg-white rounded-circle p-2 shadow">
                    <i class="fas fa-edit text-primary fa-lg"></i>
                </div>
                <div>
                    <h4 class="text-white font-weight-bolder mb-0">Edit Equipment</h4>
                    <p class="text-white opacity-8 text-sm">Perbarui informasi peralatan dan alat berat</p>
                </div>
            </div>
            <a href="{{ route('admin.equipment-list') }}" class="btn btn-white btn-round mb-0 mt-3 mt-md-0 shadow-sm">
                <i class="fas fa-arrow-left text-primary me-2 text-xs"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card form-card mx-3 mb-4">
        <div class="card-header border-bottom-0 pb-0 pt-4 px-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-clipboard-list text-primary"></i>
                <h6 class="mb-0 font-weight-bold text-dark">Form Data Equipment</h6>
            </div>
            <p class="text-sm text-muted mb-0 mt-1">Lengkapi informasi berikut untuk memperbarui data equipment</p>
        </div>

        <div class="card-body px-4 pb-4">
            <form action="{{ route('admin.equipment-list.update', $equipment->id) }}" method="POST" id="equipmentForm">
                @csrf
                @method('PUT')

                <!-- Section: Identitas Utama -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-id-card"></i> Identitas Utama
                    </div>
                    <div class="row g-3">
                        {{-- NAMA --}}
                        <div class="col-md-6">
                            <label class="form-label">Nama Equipment <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="fas fa-tag input-icon"></i>
                                <input type="text" name="nama"
                                       value="{{ old('nama', $equipment->nama) }}"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       placeholder="Contoh: Excavator PC200" required>
                            </div>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KODE --}}
                        <div class="col-md-6">
                            <label class="form-label">Kode Equipment <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="fas fa-barcode input-icon"></i>
                                <input type="text" name="kode"
                                       value="{{ old('kode', $equipment->kode) }}"
                                       class="form-control @error('kode') is-invalid @enderror"
                                       placeholder="Contoh: EQ-EXC-001" required>
                            </div>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted text-xs mt-1 d-block">Kode unik untuk identifikasi sistem</small>
                        </div>
                    </div>
                </div>

                <!-- Section: Spesifikasi Teknis -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-cogs"></i> Spesifikasi Teknis
                    </div>
                    <div class="row g-3">
                        {{-- JENIS --}}
                        <div class="col-md-4">
                            <label class="form-label">Jenis Alat <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="fas fa-layer-group input-icon"></i>
                                <input type="text" name="jenis" list="jenisList"
                                       value="{{ old('jenis', $equipment->jenis) }}"
                                       class="form-control @error('jenis') is-invalid @enderror"
                                       placeholder="Pilih atau ketik jenis">
                                <datalist id="jenisList">
                                    @foreach($jenisList ?? [] as $j)
                                        <option value="{{ $j }}">
                                    @endforeach
                                </datalist>
                            </div>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- MERK --}}
                        <div class="col-md-4">
                            <label class="form-label">Merk / Brand</label>
                            <div class="input-group-custom">
                                <i class="fas fa-industry input-icon"></i>
                                <input type="text" name="merk"
                                       value="{{ old('merk', $equipment->merk) }}"
                                       class="form-control @error('merk') is-invalid @enderror"
                                       placeholder="Contoh: Komatsu, Caterpillar">
                            </div>
                            @error('merk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TAHUN --}}
                        <div class="col-md-4">
                            <label class="form-label">Tahun Pembuatan</label>
                            <div class="input-group-custom">
                                <i class="far fa-calendar input-icon"></i>
                                <input type="number" name="tahun" min="1900" max="{{ date('Y') }}"
                                       value="{{ old('tahun', $equipment->tahun) }}"
                                       class="form-control @error('tahun') is-invalid @enderror"
                                       placeholder="{{ date('Y') }}">
                            </div>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NO. POLISI --}}
                        <div class="col-md-6">
                            <label class="form-label">Nomor Polisi</label>
                            <div class="input-group-custom">
                                <i class="fas fa-car input-icon"></i>
                                <input type="text" name="no_polisi"
                                       value="{{ old('no_polisi', $equipment->no_polisi ?? '') }}"
                                       class="form-control @error('no_polisi') is-invalid @enderror"
                                       placeholder="Contoh: B 1234 XYZ"
                                       style="text-transform: uppercase;"
                                       oninput="this.value = this.value.toUpperCase()">
                            </div>
                            @error('no_polisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NO. MESIN --}}
                        <div class="col-md-6">
                            <label class="form-label">Nomor Mesin / Serial</label>
                            <div class="input-group-custom">
                                <i class="fas fa-fingerprint input-icon"></i>
                                <input type="text" name="no_mesin"
                                       value="{{ old('no_mesin', $equipment->no_mesin) }}"
                                       class="form-control @error('no_mesin') is-invalid @enderror"
                                       placeholder="Nomor identifikasi mesin">
                            </div>
                            @error('no_mesin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Status & Lokasi -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-map-marker-alt"></i> Status & Lokasi
                    </div>
                    <div class="row g-3">
                        {{-- STATUS --}}
                        <div class="col-md-6">
                            <label class="form-label">Status Equipment <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="fas fa-info-circle input-icon"></i>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" id="statusSelect">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="tersedia" {{ old('status', $equipment->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="dipakai" {{ old('status', $equipment->status) == 'dipakai' ? 'selected' : '' }}>Sedang Dipakai</option>
                                    <option value="perawatan" {{ old('status', $equipment->status) == 'perawatan' ? 'selected' : '' }}>Dalam Perawatan</option>
                                    <option value="rusak" {{ old('status', $equipment->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="tidak_aktif" {{ old('status', $equipment->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- Status Preview Badge -->
                            <div id="statusPreview" class="status-preview bg-secondary text-white" style="display: none;">
                                <i class="fas fa-circle fa-xs"></i>
                                <span id="statusPreviewText"></span>
                            </div>
                        </div>

                        {{-- LOKASI SEKARANG --}}
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Saat Ini</label>
                            <div class="input-group-custom">
                                <i class="fas fa-map-pin input-icon"></i>
                                <input type="text" name="lokasi_sekarang"
                                       value="{{ old('lokasi_sekarang', $equipment->lokasi_sekarang) }}"
                                       class="form-control @error('lokasi_sekarang') is-invalid @enderror"
                                       placeholder="Contoh: Site A, Warehouse 2">
                            </div>
                            @error('lokasi_sekarang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Catatan Tambahan -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-sticky-note"></i> Informasi Tambahan
                    </div>
                    <div class="row g-3">
                        {{-- CATATAN --}}
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" rows="4"
                                      class="form-control @error('catatan') is-invalid @enderror"
                                      placeholder="Tambahkan catatan penting mengenai equipment ini...">{{ old('catatan', $equipment->catatan) }}</textarea>
                            <div class="char-counter"><span id="charCount">0</span>/500 karakter</div>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                    <a href="{{ route('admin.equipment-list') }}" class="btn btn-outline-secondary btn-round mb-0">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn bg-gradient-primary btn-round mb-0">
                        <i class="fas fa-save me-1"></i> Update Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ✅ Toast Notification -->
@if(session('success') || session('error'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div class="toast align-items-center text-white {{ session('success') ? 'bg-success' : 'bg-danger' }} border-0 show" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas {{ session('success') ? 'fa-check-circle' : 'fa-exclamation-circle' }} me-2"></i>
                {{ session('success') ?? session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

<!-- ⚠️ Modal Error Validasi - Enhanced -->
@if ($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-danger border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar bg-white rounded-circle p-2">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <h6 class="modal-title text-white font-weight-bold">Periksa Kembali Form</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <p class="text-sm text-muted mb-3">Terdapat {{ count($errors) }} kesalahan yang perlu diperbaiki:</p>
                <ul class="list-group list-group-flush">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item d-flex align-items-start gap-2 px-0 py-2">
                            <i class="fas fa-circle text-danger fa-xs mt-1"></i>
                            <span class="text-sm">{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i> Mengerti
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // === Status Preview Badge ===
    const statusSelect = document.getElementById('statusSelect');
    const statusPreview = document.getElementById('statusPreview');
    const statusPreviewText = document.getElementById('statusPreviewText');
    
    const statusConfig = {
        'tersedia': { label: 'Tersedia', class: 'bg-success' },
        'dipakai': { label: 'Dipakai', class: 'bg-info' },
        'perawatan': { label: 'Perawatan', class: 'bg-warning' },
        'rusak': { label: 'Rusak', class: 'bg-danger' },
        'tidak_aktif': { label: 'Non-Aktif', class: 'bg-secondary' }
    };
    
    function updateStatusPreview() {
        const value = statusSelect.value;
        if (value && statusConfig[value]) {
            statusPreviewText.textContent = statusConfig[value].label;
            statusPreview.className = `status-preview ${statusConfig[value].class} text-white`;
            statusPreview.style.display = 'inline-flex';
        } else {
            statusPreview.style.display = 'none';
        }
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatusPreview);
        updateStatusPreview(); // Initial check
    }
    
    // === Character Counter for Textarea ===
    const textarea = document.querySelector('textarea[name="catatan"]');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        function updateCount() {
            const len = textarea.value.length;
            charCount.textContent = len;
            if (len > 500) {
                charCount.style.color = '#ea580c';
                charCount.style.fontWeight = 'bold';
            } else {
                charCount.style.color = '#8392ab';
                charCount.style.fontWeight = 'normal';
            }
        }
        textarea.addEventListener('input', updateCount);
        updateCount(); // Initial count
    }
    
    // === Auto-hide Toast ===
    const toastElList = document.querySelectorAll('.toast');
    [...toastElList].map(toast => {
        const bsToast = bootstrap.Toast.getOrCreateInstance(toast, { delay: 5000 });
        bsToast.show();
    });
    
    // === Show Error Modal ===
    @if ($errors->any())
        new bootstrap.Modal(document.getElementById('errorModal')).show();
    @endif
    
    // === Form Submit Confirmation ===
    const form = document.getElementById('equipmentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Optional: Add confirmation for important updates
            // e.preventDefault();
            // if (confirm('Apakah Anda yakin ingin memperbarui data ini?')) {
            //     this.submit();
            // }
        });
    }
    
    // === Auto-focus first error field ===
    @if ($errors->any())
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    @endif
});
</script>
@endpush
@endsection