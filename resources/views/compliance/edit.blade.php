@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    {{-- ALERT HEADER --}}
    <div class="alert alert-secondary mx-4" role="alert">
        <span class="text-white">
            <strong>Edit Dokumen Compliance</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Edit Dokumen Compliance</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('compliance.update', $data->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- REPORTED BY --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Reported By</label>
                                <input type="text"
                                       name="ReportedBy"
                                       value="{{ old('ReportedBy', $data->ReportedBy) }}"
                                       class="form-control @error('ReportedBy') is-invalid @enderror"
                                       placeholder="Nama pelapor">

                                @error('ReportedBy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DEPARTEMEN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departemen</label>
                                <select name="Departemen"
                                        class="form-select @error('Departemen') is-invalid @enderror">
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="HSE" {{ old('Departemen', $data->Departemen) == 'HSE' ? 'selected' : '' }}>
                                        HSE
                                    </option>
                                    <option value="Produksi" {{ old('Departemen', $data->Departemen) == 'Produksi' ? 'selected' : '' }}>
                                        Produksi
                                    </option>
                                    <option value="HRD" {{ old('Departemen', $data->Departemen) == 'HRD' ? 'selected' : '' }}>
                                        HRD
                                    </option>
                                    <option value="Maintenance" {{ old('Departemen', $data->Departemen) == 'Maintenance' ? 'selected' : '' }}>
                                        Maintenance
                                    </option>
                                    <option value="Lainnya" {{ old('Departemen', $data->Departemen) == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>

                                @error('Departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOCATION --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text"
                                       name="Location"
                                       value="{{ old('Location', $data->Location) }}"
                                       class="form-control @error('Location') is-invalid @enderror"
                                       placeholder="Lokasi kejadian">

                                @error('Location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- INCIDENT TYPE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Incident Type</label>
                                <input type="text"
                                       name="IncidentType"
                                       value="{{ old('IncidentType', $data->IncidentType) }}"
                                       class="form-control @error('IncidentType') is-invalid @enderror"
                                       placeholder="Contoh: Kecelakaan Kerja, Tumpahan Minyak">

                                @error('IncidentType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- COMPLIANCE TYPE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Compliance Type</label>
                                <select name="ComplianceType"
                                        class="form-select @error('ComplianceType') is-invalid @enderror">
                                    <option value="">-- Pilih Tipe Kepatuhan --</option>
                                    <option value="Internal" {{ old('ComplianceType', $data->ComplianceType) == 'Internal' ? 'selected' : '' }}>
                                        Internal
                                    </option>
                                    <option value="Eksternal/Regulasi" {{ old('ComplianceType', $data->ComplianceType) == 'Eksternal/Regulasi' ? 'selected' : '' }}>
                                        Eksternal / Regulasi
                                    </option>
                                    <option value="Audit" {{ old('ComplianceType', $data->ComplianceType) == 'Audit' ? 'selected' : '' }}>
                                        Audit
                                    </option>
                                </select>

                                @error('ComplianceType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DATE REPORTED --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date Reported</label>
                                <input type="date"
                                       name="Date_reported"
                                       value="{{ old('Date_reported', $data->Date_reported?->format('Y-m-d')) }}"
                                       class="form-control @error('Date_reported') is-invalid @enderror">

                                @error('Date_reported')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="Status"
                                        class="form-select @error('Status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Open" {{ old('Status', $data->Status) == 'Open' ? 'selected' : '' }}>
                                        Open
                                    </option>
                                    <option value="Pending" {{ old('Status', $data->Status) == 'Pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="Resolved" {{ old('Status', $data->Status) == 'Resolved' ? 'selected' : '' }}>
                                        Resolved
                                    </option>
                                    <option value="Escalated" {{ old('Status', $data->Status) == 'Escalated' ? 'selected' : '' }}>
                                        Escalated
                                    </option>
                                </select>

                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SEVERITY --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Severity</label>
                                <select name="Severity"
                                        class="form-select @error('Severity') is-invalid @enderror">
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Low" {{ old('Severity', $data->Severity) == 'Low' ? 'selected' : '' }}>
                                        Low
                                    </option>
                                    <option value="Medium" {{ old('Severity', $data->Severity) == 'Medium' ? 'selected' : '' }}>
                                        Medium
                                    </option>
                                    <option value="High" {{ old('Severity', $data->Severity) == 'High' ? 'selected' : '' }}>
                                        High
                                    </option>
                                    <option value="Critical" {{ old('Severity', $data->Severity) == 'Critical' ? 'selected' : '' }}>
                                        Critical
                                    </option>
                                </select>

                                @error('Severity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- RESOLVED BY --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Resolved By (Opsional)</label>
                                <input type="text"
                                       name="ResolvedBy"
                                       value="{{ old('ResolvedBy', $data->ResolvedBy) }}"
                                       class="form-control @error('ResolvedBy') is-invalid @enderror"
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
                                Update
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