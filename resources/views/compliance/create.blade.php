@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Tambah Dokumen Compliance</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah Dokumen Compliance</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('compliance.store') }}"
                          method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- NAMA PELAPOR --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pelapor</label>
                                <input type="text"
                                       name="ReportedBy"
                                       value="{{ old('ReportedBy') }}"
                                       class="form-control @error('ReportedBy') is-invalid @enderror"
                                       placeholder="Nama pelapor">

                                @error('NAMA PELAPOR')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DEPARTEMEN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departemen</label>
                                <select name="Departemen"
                                        class="form-select @error('Departemen') is-invalid @enderror">
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="HSE" {{ old('Departemen') == 'HSE' ? 'selected' : '' }}>
                                        HSE
                                    </option>
                                    <option value="Produksi" {{ old('Departemen') == 'Produksi' ? 'selected' : '' }}>
                                        Produksi
                                    </option>
                                    <option value="HRD" {{ old('Departemen') == 'HRD' ? 'selected' : '' }}>
                                        HRD
                                    </option>
                                    <option value="Maintenance" {{ old('Departemen') == 'Maintenance' ? 'selected' : '' }}>
                                        Maintenance
                                    </option>
                                    <option value="Lainnya" {{ old('Departemen') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>

                                @error('Departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOKASI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">lokasi</label>
                                <input type="text"
                                       name="Location"
                                       value="{{ old('Location') }}"
                                       class="form-control @error('Location') is-invalid @enderror"
                                       placeholder="Lokasi kejadian">

                                @error('LOKASI')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TANGGAL PELAPORAN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pelaporan</label>
                                <input type="date"
                                       name="Date_reported"
                                       value="{{ old('Date_reported', date('Y-m-d')) }}"
                                       class="form-control @error('Date_reported') is-invalid @enderror">

                                @error('TANGGAL PELAPORAN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS INSIDEN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Insiden</label>
                                <input type="text"
                                       name="IncidentType"
                                       value="{{ old('IncidentType') }}"
                                       class="form-control @error('IncidentType') is-invalid @enderror"
                                       placeholder="Contoh: Kecelakaan Kerja, Tumpahan Minyak">

                                @error('JENIS INSIDEN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JENIS ISNPEKSI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Compliance Type</label>
                                <select name="ComplianceType"
                                        class="form-select @error('ComplianceType') is-invalid @enderror">
                                    <option value="">-- Pilih Tipe Inspeksi --</option>
                                    <option value="Internal" {{ old('ComplianceType') == 'Internal' ? 'selected' : '' }}>
                                        Internal
                                    </option>
                                    <option value="Eksternal/Regulasi" {{ old('ComplianceType') == 'Eksternal/Regulasi' ? 'selected' : '' }}>
                                        Eksternal / Regulasi
                                    </option>
                                    <option value="Audit" {{ old('ComplianceType') == 'Audit' ? 'selected' : '' }}>
                                        Audit
                                    </option>
                                </select>

                                @error('JENIS INSPEKSI')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TINGKAT KEPARAHAN --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tingkat Keparahan</label>
                                <select name="Severity"
                                        class="form-select @error('Severity') is-invalid @enderror">
                                    <option value="Low" {{ old('Severity') == 'Low' ? 'selected' : '' }}>
                                        Rendah
                                    </option>
                                    <option value="Medium" {{ old('Severity') == 'Medium' ? 'selected' : '' }}>
                                        Sedang
                                    </option>
                                    <option value="High" {{ old('Severity') == 'High' ? 'selected' : '' }}>
                                        Tinggi
                                    </option>
                                    <option value="Critical" {{ old('Severity') == 'Critical' ? 'selected' : '' }}>
                                        Kritis
                                    </option>
                                </select>

                                @error('TINGKAT KEPARAHAN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="Status"
                                        class="form-select @error('Status') is-invalid @enderror">
                                    <option value="Open" {{ old('Status') == 'Open' ? 'selected' : '' }}>
                                        Open
                                    </option>
                                    <option value="In Progress" {{ old('Status') == 'In Progress' ? 'selected' : '' }}>
                                        In Progress
                                    </option>
                                    <option value="Resolved" {{ old('Status') == 'Resolved' ? 'selected' : '' }}>
                                        Resolved
                                    </option>
                                    <option value="Closed" {{ old('Status') == 'Closed' ? 'selected' : '' }}>
                                        Closed
                                    </option>
                                </select>

                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- RESOLVED BY --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Resolved By</label>
                                <input type="text"
                                       name="ResolvedBy"
                                       value="{{ old('ResolvedBy') }}"
                                       class="form-control"
                                       placeholder="Nama penyelesai">
                                @error('ResolvedBy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('compliance') }}"
                               class="btn btn-light me-2">
                                Batal
                            </a>

                            <button type="submit" class="btn bg-gradient-primary">
                                Simpan
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
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Terjadi Kesalahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
});
</script>
@endpush
@endif

@endsection