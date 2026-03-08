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

    .input-group-custom .form-control,
    .input-group-custom .form-select {
        padding-left: 2.5rem;
        border-radius: 0.5rem;
        border: 1px solid #d2d6da;
        transition: all 0.2s ease;
    }

    .input-group-custom .form-control:focus,
    .input-group-custom .form-select:focus {
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
        pointer-events: none;
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

    /* Hours badge preview */
    .badge-hours-preview {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        margin-top: 0.5rem;
        transition: opacity 0.2s ease;
    }
    .badge-hours-preview.invalid {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        opacity: 0.9;
    }

    /* Time input styling */
    input[type="time"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        filter: invert(0.5);
    }

    /* Character counter */
    .char-counter {
        font-size: 0.65rem;
        color: #8392ab;
        text-align: right;
        margin-top: 0.25rem;
    }

    /* Equipment selector preview */
    .equipment-preview {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.8rem;
    }
    .equipment-preview .badge {
        font-size: 0.65rem;
        padding: 0.2rem 0.5rem;
    }

    /* Form animation */
    .form-control, .form-select {
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

    /* Readonly field styling */
    .form-control[readonly] {
        background-color: #f8f9fa;
        cursor: not-allowed;
        opacity: 0.8;
    }
</style>

<div class="main-content-wrapper">
    <!-- Header Section -->
    <div class="custom-header">
        <div class="d-md-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar bg-white rounded-circle p-2 shadow">
                    <i class="fas fa-clock text-primary fa-lg"></i>
                </div>
                <div>
                    <h4 class="text-white font-weight-bolder mb-0">Edit Jam Kerja</h4>
                    <p class="text-white opacity-8 text-sm">Perbarui catatan operasional peralatan</p>
                </div>
            </div>
            <a href="{{ route('admin.work-hours') }}" class="btn btn-white btn-round mb-0 mt-3 mt-md-0 shadow-sm">
                <i class="fas fa-arrow-left text-primary me-2 text-xs"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card form-card mx-3 mb-4">
        <div class="card-header border-bottom-0 pb-0 pt-4 px-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-clipboard-check text-primary"></i>
                <h6 class="mb-0 font-weight-bold text-dark">Form Data Jam Kerja</h6>
            </div>
            <p class="text-sm text-muted mb-0 mt-1">Lengkapi informasi berikut untuk memperbarui data jam kerja</p>
        </div>

        <div class="card-body px-4 pb-4">
            <form action="{{ route('admin.work-hours.update', $workHour->id) }}" method="POST" id="workHourForm">
                @csrf
                @method('PUT')

                <!-- Section: Equipment & Tanggal -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-calendar-alt"></i> Equipment & Tanggal
                    </div>
                    <div class="row g-3">
                        {{-- ALAT --}}
                        <div class="col-md-6">
                            <label class="form-label">Pilih Equipment <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="fas fa-tools input-icon"></i>
                                <select name="alat_id" class="form-select @error('alat_id') is-invalid @enderror" id="equipmentSelect" required>
                                    <option value="">-- Pilih Equipment --</option>
                                    @foreach ($equipments as $eq)
                                        <option value="{{ $eq->id }}" {{ old('alat_id', $workHour->alat_id) == $eq->id ? 'selected' : '' }}>
                                            {{ $eq->kode }} - {{ $eq->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('alat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- Equipment Preview -->
                            <div id="equipmentPreview" class="equipment-preview" style="display: none;">
                                <i class="fas fa-check-circle text-success"></i>
                                <span id="equipmentPreviewText"></span>
                                <span class="badge bg-secondary" id="equipmentPreviewKode"></span>
                            </div>
                        </div>

                        {{-- TANGGAL --}}
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kerja <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="far fa-calendar input-icon"></i>
                                <input type="date" name="tanggal"
                                       value="{{ old('tanggal', $workHour->tanggal?->format('Y-m-d')) }}"
                                       class="form-control @error('tanggal') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}" required>
                            </div>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted text-xs mt-1 d-block">Tanggal tidak boleh melebihi hari ini</small>
                        </div>
                    </div>
                </div>

                <!-- Section: Waktu Operasional -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-stopwatch"></i> Waktu Operasional
                    </div>
                    <div class="row g-3">
                        {{-- JAM MULAI --}}
                        <div class="col-md-4">
                            <label class="form-label">Jam Mulai <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="fas fa-play-circle input-icon"></i>
                                <input type="time" name="jam_mulai" id="jamMulai" step="60"
                                       value="{{ old('jam_mulai', $workHour->jam_mulai) }}"
                                       class="form-control @error('jam_mulai') is-invalid @enderror" required>
                            </div>
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- JAM SELESAI --}}
                        <div class="col-md-4">
                            <label class="form-label">Jam Selesai <span class="required">*</span></label>
                            <div class="input-group-custom">
                                <i class="fas fa-stop-circle input-icon"></i>
                                <input type="time" name="jam_selesai" id="jamSelesai"
                                       value="{{ old('jam_selesai', $workHour->jam_selesai) }}"
                                       class="form-control @error('jam_selesai') is-invalid @enderror" required>
                            </div>
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- JAM ISTIRAHAT --}}
                        <div class="col-md-4">
                            <label class="form-label">Istirahat (jam)</label>
                            <div class="input-group-custom">
                                <i class="fas fa-coffee input-icon"></i>
                                <input type="number" step="0.1" min="0" max="24" name="jam_istirahat" id="jamIstirahat"
                                       value="{{ old('jam_istirahat', $workHour->jam_istirahat) }}"
                                       class="form-control @error('jam_istirahat') is-invalid @enderror"
                                       placeholder="0 atau 1">
                            </div>
                            @error('jam_istirahat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TOTAL JAM (Auto Calculated) --}}
                        <div class="col-12">
                            <label class="form-label">Total Jam Kerja <small class="text-muted">(Otomatis)</small></label>
                            <div class="input-group-custom">
                                <i class="fas fa-calculator input-icon"></i>
                                <input type="number" step="0.01" name="total_jam" id="totalJam"
                                       value="{{ old('total_jam', $workHour->total_jam) }}"
                                       class="form-control @error('total_jam') is-invalid @enderror"
                                       readonly placeholder="Akan dihitung otomatis">
                            </div>
                            @error('total_jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- Hours Preview Badge -->
                            <div id="hoursPreview" class="badge-hours-preview" style="display: none;">
                                <i class="fas fa-stopwatch fa-xs"></i>
                                <span id="hoursPreviewText"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Lokasi & Aktivitas -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-map-marked-alt"></i> Lokasi & Aktivitas
                    </div>
                    <div class="row g-3">
                        {{-- LOKASI --}}
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Operasional</label>
                            <div class="input-group-custom">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" name="lokasi"
                                       value="{{ old('lokasi', $workHour->lokasi) }}"
                                       class="form-control @error('lokasi') is-invalid @enderror"
                                       placeholder="Contoh: Site A, Area Tambang">
                            </div>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- AKTIVITAS --}}
                        <div class="col-md-6">
                            <label class="form-label">Deskripsi Aktivitas</label>
                            <div class="input-group-custom">
                                <i class="fas fa-tasks input-icon"></i>
                                <textarea name="aktivitas" rows="2"
                                          class="form-control @error('aktivitas') is-invalid @enderror"
                                          placeholder="Contoh: Excavating, Loading, Hauling">{{ old('aktivitas', $workHour->aktivitas) }}</textarea>
                            </div>
                            <div class="char-counter"><span id="aktivitasCount">0</span>/500 karakter</div>
                            @error('aktivitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Catatan Tambahan -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-sticky-note"></i> Catatan Tambahan
                    </div>
                    <div class="row g-3">
                        {{-- CATATAN --}}
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" rows="3"
                                      class="form-control @error('catatan') is-invalid @enderror"
                                      placeholder="Tambahkan informasi penting lainnya...">{{ old('catatan', $workHour->catatan) }}</textarea>
                            <div class="char-counter"><span id="catatanCount">0</span>/500 karakter</div>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                    <a href="{{ route('admin.work-hours') }}" class="btn btn-outline-secondary btn-round mb-0">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn bg-gradient-primary btn-round mb-0" id="submitBtn">
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
    
    // === Equipment Preview ===
    const equipmentSelect = document.getElementById('equipmentSelect');
    const equipmentPreview = document.getElementById('equipmentPreview');
    const equipmentPreviewText = document.getElementById('equipmentPreviewText');
    const equipmentPreviewKode = document.getElementById('equipmentPreviewKode');
    
    function updateEquipmentPreview() {
        const selectedOption = equipmentSelect?.options[equipmentSelect?.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const text = selectedOption.text;
            const parts = text.split(' - ');
            equipmentPreviewKode.textContent = parts[0] || '';
            equipmentPreviewText.textContent = parts.slice(1).join(' - ') || '';
            equipmentPreview.style.display = 'flex';
        } else {
            equipmentPreview.style.display = 'none';
        }
    }
    
    if (equipmentSelect) {
        equipmentSelect.addEventListener('change', updateEquipmentPreview);
        updateEquipmentPreview(); // Initial check
    }
    
    // === Time Calculation ===
    const jamMulai = document.getElementById('jamMulai');
    const jamSelesai = document.getElementById('jamSelesai');
    const jamIstirahat = document.getElementById('jamIstirahat');
    const totalJam = document.getElementById('totalJam');
    const hoursPreview = document.getElementById('hoursPreview');
    const hoursPreviewText = document.getElementById('hoursPreviewText');
    
    function calculateTotalJam() {
        if (!jamMulai?.value || !jamSelesai?.value) {
            totalJam.value = '';
            hoursPreview.style.display = 'none';
            return;
        }

        // Parse time values
        const [startH, startM] = jamMulai.value.split(':').map(Number);
        const [endH, endM] = jamSelesai.value.split(':').map(Number);

        // Convert to minutes
        let startMin = startH * 60 + startM;
        let endMin = endH * 60 + endM;

        // Handle overnight shift (e.g., 22:00 - 06:00)
        if (endMin <= startMin) {
            endMin += 24 * 60;
        }

        // Calculate duration in hours
        const durationHours = (endMin - startMin) / 60;
        const breakHours = parseFloat(jamIstirahat?.value) || 0;
        const total = Math.max(0, durationHours - breakHours);

        // Update total field
        totalJam.value = total.toFixed(2);
        
        // Update preview badge
        hoursPreviewText.textContent = `${total.toFixed(2)} Jam`;
        
        // Visual feedback for invalid values
        if (total <= 0) {
            hoursPreview.classList.add('invalid');
            hoursPreview.querySelector('i').className = 'fas fa-exclamation-circle fa-xs';
        } else {
            hoursPreview.classList.remove('invalid');
            hoursPreview.querySelector('i').className = 'fas fa-stopwatch fa-xs';
        }
        
        hoursPreview.style.display = 'inline-flex';
    }
    
    // Attach event listeners
    jamMulai?.addEventListener('change', calculateTotalJam);
    jamSelesai?.addEventListener('change', calculateTotalJam);
    jamIstirahat?.addEventListener('input', calculateTotalJam);
    
    // Initial calculation on load
    setTimeout(calculateTotalJam, 100);
    
    // === Character Counters ===
    function setupCharCounter(textarea, counterId, max = 500) {
        const counter = document.getElementById(counterId);
        if (textarea && counter) {
            function updateCount() {
                const len = textarea.value.length;
                counter.textContent = len;
                if (len > max) {
                    counter.style.color = '#ea580c';
                    counter.style.fontWeight = 'bold';
                } else {
                    counter.style.color = '#8392ab';
                    counter.style.fontWeight = 'normal';
                }
            }
            textarea.addEventListener('input', updateCount);
            updateCount(); // Initial count
        }
    }
    
    setupCharCounter(document.querySelector('textarea[name="aktivitas"]'), 'aktivitasCount');
    setupCharCounter(document.querySelector('textarea[name="catatan"]'), 'catatanCount');
    
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
    
    // === Auto-focus first error field ===
    @if ($errors->any())
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    @endif
    
    // === Submit Button Loading State ===
    const form = document.getElementById('workHourForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        });
    }
    
    // === Date Validation: Cannot be in future ===
    const tanggalInput = document.querySelector('input[name="tanggal"]');
    if (tanggalInput) {
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.max = today;
        
        // Visual feedback if date is in future
        tanggalInput.addEventListener('change', function() {
            if (this.value > today) {
                this.classList.add('is-invalid');
                // Create or update feedback message
                let feedback = this.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.innerHTML = '⚠ Tanggal tidak boleh di masa depan';
                    this.parentNode.appendChild(feedback);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback && feedback.textContent.includes('masa depan')) {
                    feedback.remove();
                }
            }
        });
    }
});
</script>
@endpush
@endsection