@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid">
    <div class="page-header min-height-100 border-radius-xl mt-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Preview: {{ $document->title }}</h4>
            {{-- Sesuaikan route kembali ke index --}}
            <a href="{{ route('documents') }}" class="btn bg-gradient-secondary mb-0">Kembali</a>
        </div>
    </div>

    <div class="card card-body blur shadow-blur mx-4 mt-n4 overflow-hidden">
        <div class="row gx-4">
            <div class="col-12" style="height: 80vh;">
                @php
                    $extension = strtolower($document->file_type);
                    $fileUrl = asset('storage/' . $document->file_path);
                @endphp

                @if($extension == 'pdf')
                    <iframe src="{{ $fileUrl }}" width="100%" height="100%" style="border: none;"></iframe>

                @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                    <div class="text-center overflow-auto h-100">
                        <img src="{{ $fileUrl }}" class="img-fluid border-radius-lg shadow mt-3">
                    </div>

                @elseif(in_array($extension, ['xls', 'xlsx', 'doc', 'docx']))
                    @if(app()->environment('local'))
                        {{-- Tampilan saat di Localhost --}}
                        <div class="text-center py-5">
                            <i class="fas fa-file-excel fa-5x text-success mb-3"></i>
                            <h5>Pratinjau tidak tersedia di Localhost</h5>
                            <p>Office Online Viewer memerlukan akses internet publik ke file Anda.<br>Silakan unduh untuk melihat dokumen ini.</p>
                            <a href="{{ route('documents.download', $document->id) }}" class="btn bg-gradient-info">
                                <i class="fas fa-download me-2"></i> Unduh File Excel
                            </a>
                        </div>
                    @else
                        {{-- Tampilan saat sudah Online --}}
                        <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode($fileUrl) }}" 
                                width="100%" height="100%" style="border: none;">
                        </iframe>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-archive fa-5x text-secondary mb-3"></i>
                        <h5>Format file tidak didukung untuk pratinjau</h5>
                        <a href="{{ route('documents.download', $document->id) }}" class="btn bg-gradient-dark">Unduh File</a>
                    </div>
                @endif {{-- Penutup if utama yang penting --}}
            </div>
        </div>
    </div>
</div>
@endsection