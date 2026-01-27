@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-10 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tambah Dokumen Compliance</h5>
                            <a href="{{ route('complience') }}" class="btn btn-sm btn-secondary mb-0">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('complience.store') }}" method="POST" role="form text-left">
                            @csrf
                            <div class="row">
                                {{-- Reported By --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ReportedBy" class="form-control-label">Reported By</label>
                                        <input class="form-control @error('ReportedBy') is-invalid @enderror" type="text" placeholder="Nama pelapor" id="ReportedBy" name="ReportedBy" value="{{ old('ReportedBy') }}" required>
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
                                            <option value="" selected disabled>Pilih Departemen</option>
                                            <option value="HSE">HSE</option>
                                            <option value="Produksi">Produksi</option>
                                            <option value="HRD">HRD</option>
                                            <option value="Maintenance">Maintenance</option>
                                            <option value="Lainnya">Lainnya</option>
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
                                        <input class="form-control @error('Location') is-invalid @enderror" type="text" placeholder="Lokasi kejadian" id="Location" name="Location" value="{{ old('Location') }}" required>
                                        @error('Location')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Date Reported --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date_reported" class="form-control-label">Date Reported</label>
                                        <input class="form-control @error('Date_reported') is-invalid @enderror" type="date" id="Date_reported" name="Date_reported" value="{{ old('Date_reported', date('Y-m-d')) }}" required>
                                        @error('Date_reported')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Incident Type --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="IncidentType" class="form-control-label">Incident Type</label>
                                        <input class="form-control @error('IncidentType') is-invalid @enderror" type="text" placeholder="Contoh: Kecelakaan Kerja, Tumpahan Minyak" id="IncidentType" name="IncidentType" value="{{ old('IncidentType') }}" required>
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
                                            <option value="" selected disabled>Pilih Tipe Kepatuhan</option>
                                            <option value="Internal">Internal</option>
                                            <option value="Eksternal/Regulasi">Eksternal / Regulasi</option>
                                            <option value="Audit">Audit</option>
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
                                        <select class="form-control @error('Severity') is-invalid @enderror" name="Severity" id="Severity" required>
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                            <option value="Critical">Critical</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Status" class="form-control-label">Status</label>
                                        <select class="form-control @error('Status') is-invalid @enderror" name="Status" id="Status" required>
                                            <option value="Open">Open</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Resolved">Resolved</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Resolved By --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ResolvedBy" class="form-control-label">Resolved By (Opsional)</label>
                                        <input class="form-control" type="text" placeholder="Nama penyelesai" id="ResolvedBy" name="ResolvedBy" value="{{ old('ResolvedBy') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn bg-gradient-primary m-0">Simpan Dokumen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection