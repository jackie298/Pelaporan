@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">

    
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Tambah User</strong>
        </span>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Form Tambah User</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.add-user.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- NAME --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nama lengkap"
                                       required>    
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- EMAIL --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Alamat email"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- ROLE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select name="role"
                                        class="form-select @error('role') is-invalid @enderror"
                                        required>
                                    <option value="" disabled selected>Pilih role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- PASSWORD --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       name="password"
                                       value="{{ old('password') }}"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Password"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- PASSWORD CONFIRMATION --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       name="password_confirmation"
                                       value="{{ old('password_confirmation') }}"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       placeholder="Konfirmasi Password"
                                       required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- Nomor Telepon --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Nomor Telepon">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.user') }}"
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
@endsection
