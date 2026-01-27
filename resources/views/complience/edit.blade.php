@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-10 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Edit Dokumen Compliance</h5>
                            <a href="{{ route('complience') }}" class="btn btn-sm btn-secondary mb-0">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Perhatikan route mengarah ke 'update' dengan parameter ID --}}
                        <form action="{{ route('complience.update', $complience->id) }}" method="POST" role="form text-left">
                            @csrf
                            @method('PUT') {{-- Wajib ada untuk proses Update --}}
                            
                            <div class="row">
                                {{-- Reported By --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ReportedBy" class="form-control-label">Reported By</label>
                                        <input class="form-control @error('ReportedBy') is-invalid @enderror" type="text" id="ReportedBy" name="ReportedBy" value="{{ old('ReportedBy', $complience->ReportedBy) }}" required>
                                        @error('ReportedBy')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Departemen --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Departemen" class="form-control-label">Departemen</label>
                                        <select class="form-control @error('Departemen') is-invalid @enderror" name="Departemen" id="Departemen" required>
                                            @foreach(['HSE', 'Produksi', 'HRD', 'Maintenance', 'Lainnya'] as $dept)
                                                <option value="{{ $dept }}" {{ old('Departemen', $complience->Departemen) == $dept ? 'selected' : '' }}>
                                                    {{ $dept }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('Departemen')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Location" class="form-control-label">Location</label>
                                        <input class="form-control @error('Location') is-invalid @enderror" type="text" id="Location" name="Location" value="{{ old('Location', $complience->Location) }}" required>
                                        @error('Location')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Date Reported --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date_reported" class="form-control-label">Date Reported</label>
                                        {{-- Memastikan format tanggal sesuai untuk input type date (Y-m-d) --}}
                                        <input class="form-control @error('Date_reported') is-invalid @enderror" type="date" id="Date_reported" name="Date_reported" value="{{ old('Date_reported', \Carbon\Carbon::parse($complience->Date_reported)->format('Y-m-d')) }}" required>
                                        @error('Date_reported')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Incident Type --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="IncidentType" class="form-control-label">Incident Type</label>
                                        <input class="form-control @error('IncidentType') is-invalid @enderror" type="text" id="IncidentType" name="IncidentType" value="{{ old('IncidentType', $complience->IncidentType) }}" required>
                                        @error('IncidentType')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Compliance Type --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ComplianceType" class="form-control-label">Compliance Type</label>
                                        <select class="form-control @error('ComplianceType') is-invalid @enderror" name="ComplianceType" id="ComplianceType" required>
                                            @foreach(['Internal', 'Eksternal/Regulasi', 'Audit'] as $type)
                                                <option value="{{ $type }}" {{ old('ComplianceType', $complience->ComplianceType) == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ComplianceType')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Severity --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Severity" class="form-control-label">Severity</label>
                                        <select class="form-control" name="Severity" id="Severity" required>
                                            @foreach(['Low', 'Medium', 'High', 'Critical'] as $sev)
                                                <option value="{{ $sev }}" {{ old('Severity', $complience->Severity) == $sev ? 'selected' : '' }}>
                                                    {{ $sev }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Status" class="form-control-label">Status</label>
                                        <select class="form-control" name="Status" id="Status" required>
                                            @foreach(['Open', 'In Progress', 'Resolved', 'Closed'] as $stat)
                                                <option value="{{ $stat }}" {{ old('Status', $complience->Status) == $stat ? 'selected' : '' }}>
                                                    {{ $stat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Resolved By --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ResolvedBy" class="form-control-label">Resolved By (Opsional)</label>
                                        <input class="form-control" type="text" id="ResolvedBy" name="ResolvedBy" value="{{ old('ResolvedBy', $complience->ResolvedBy) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn bg-gradient-info m-0">Update Dokumen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection