@extends('layouts.user_type.auth')

@section('auth')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 mx-auto">

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Import Data Users</h5>
                </div>

                <div class="card-body">

                    {{-- Success --}}
                    @if (session('success'))
                        <div class="alert alert-success text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger text-white">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('import.user') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">File Excel (.xlsx / .csv)</label>
                            <input type="file"
                                   name="file"
                                   class="form-control"
                                   accept=".xlsx,.csv"
                                   required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Import Users
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
