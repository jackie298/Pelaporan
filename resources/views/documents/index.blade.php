@extends('layouts.user_type.auth')

@section('content')
<style>
    /* 1. Global Modernization */
    .main-content { background-color: #f8f9fa; }
    
    /* 2. Folder Card Enhancements */
    .folder-card {
        border: 1px solid #ebedef;
        background: #fff;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 16px;
        cursor: pointer;
    }
    .folder-card:hover {
        border-color: #5e72e4;
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    .folder-icon-wrapper {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: linear-gradient(135deg, #ff9a00 0%, #ffc107 100%);
        color: white;
    }

    /* 3. Table Modernization */
    .table-responsive { border-radius: 16px; }
    #fileTable tbody tr {
        transition: background-color 0.2s;
    }
    #fileTable tbody tr:hover {
        background-color: #fcfdfe !important;
    }
    .file-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* 4. Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 3px;
        border: none;
        transition: all 0.2s;
    }
    .btn-action:hover { transform: scale(1.15); }

    /* 5. Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar { height: 6px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

<div class="container-fluid py-4">
    <div class="d-md-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bolder mb-0">Penyimpanan Dokumen</h3>
            <p class="text-sm text-muted mb-0">Organisir berkas dan folder proyek Anda dalam satu tempat.</p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <button class="btn btn-outline-primary btn-sm mb-0 rounded-pill" data-bs-toggle="modal" data-bs-target="#folderModal">
                <i class="fas fa-folder-plus me-2"></i>Folder Baru
            </button>
            <button class="btn bg-gradient-primary btn-sm mb-0 rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-cloud-upload-alt me-2"></i>Unggah Berkas
            </button>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white shadow-sm border px-3 py-2 rounded-pill mb-4">
            <li class="breadcrumb-item"><a href="{{ route('documents') }}" class="text-primary"><i class="fas fa-home"></i></a></li>
            @if($currentFolder)
                @if($currentFolder->parent)
                    <li class="breadcrumb-item text-sm">
                        <a href="{{ route('documents', ['folder_id' => $currentFolder->parent->id]) }}" class="text-muted">
                            {{ $currentFolder->parent->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active text-sm font-weight-bold" aria-current="page">{{ $currentFolder->name }}</li>
            @endif
        </ol>
    </nav>

    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h6 class="mb-0 text-sm font-weight-bolder text-uppercase opacity-7">Folder Saya</h6>
            <div class="ms-3 flex-grow-1 border-top opacity-1"></div>
        </div>
        
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
            @forelse($folders as $folder)
            <div class="col">
                <div class="card folder-card h-100 shadow-none position-relative">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start menu-container">
                            <div class="folder-icon-wrapper shadow-sm">
                                <i class="fas fa-folder fa-lg text-white"></i>
                            </div>
                            
                            <div class="dropdown" style="z-index: 5;">
                                <button class="btn btn-link text-secondary mb-0 py-0 px-2 shadow-none" 
                                        type="button" 
                                        id="dropFolder{{ $folder->id }}" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" aria-labelledby="dropFolder{{ $folder->id }}">
                                    <li>
                                        <button class="dropdown-item text-danger d-flex align-items-center" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteFolderModal{{ $folder->id }}">
                                            <i class="fas fa-trash-alt me-2 text-xs"></i> Hapus Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('documents', ['folder_id' => $folder->id]) }}" class="stretched-link">
                                <h6 class="text-sm font-weight-bold mb-1 text-dark text-truncate">{{ $folder->name }}</h6>
                            </a>
                            <p class="text-xxs text-muted mb-0 font-weight-bold">
                                {{ $folder->documents_count ?? 0 }} File • {{ $folder->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 pb-0">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-0 font-weight-bolder">Berkas Terbaru</h6>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text border-0 bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" id="fileSearch" class="form-control border-0 bg-light shadow-none" placeholder="Cari berkas...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2 mt-3">
            <div class="table-responsive">
                <table class="table align-items-center mb-0" id="fileTable">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Nama</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Informasi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ukuran</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @php
                                        $style = match(strtolower($doc->file_type)) {
                                            'pdf' => ['icon' => 'fa-file-pdf', 'bg' => 'bg-light-danger', 'text' => 'text-danger'],
                                            'xls', 'xlsx' => ['icon' => 'fa-file-excel', 'bg' => 'bg-light-success', 'text' => 'text-success'],
                                            'doc', 'docx' => ['icon' => 'fa-file-word', 'bg' => 'bg-light-info', 'text' => 'text-info'],
                                            'png', 'jpg', 'jpeg' => ['icon' => 'fa-file-image', 'bg' => 'bg-light-warning', 'text' => 'text-warning'],
                                            default => ['icon' => 'fa-file', 'bg' => 'bg-light-secondary', 'text' => 'text-secondary']
                                        };
                                    @endphp
                                    <div class="file-icon-box {{ $style['bg'] }} {{ $style['text'] }} me-3">
                                        <i class="fas {{ $style['icon'] }}"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-sm font-weight-bold">{{ $doc->title }}</h6>
                                        <p class="text-xxs text-muted mb-0">{{ $doc->original_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">/{{ Str::limit($doc->file_path, 15) }}</p>
                                <p class="text-xxs text-muted mb-0">{{ $doc->created_at->format('d M Y') }}</p>
                            </td>
                            <td>
                                <span class="text-xs font-weight-bold">
                                    {{ $doc->file_size > 1048576 ? number_format($doc->file_size / 1048576, 2) . ' MB' : number_format($doc->file_size / 1024, 1) . ' KB' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('documents.preview', $doc->id) }}" class="btn-action bg-light text-primary" title="Preview">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('documents.download', $doc->id) }}" class="btn-action bg-light text-info" title="Download">
                                    <i class="fas fa-download text-xs"></i>
                                </a>
                                <button class="btn-action bg-light text-warning" data-bs-toggle="modal" data-bs-target="#moveModal{{ $doc->id }}">
                                    <i class="fas fa-exchange-alt text-xs"></i>
                                </button>
                                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn-action bg-light text-danger" onclick="return confirm('Hapus file ini?')">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="opacity-3 mb-3">
                                    <i class="fas fa-folder-open fa-4x text-secondary"></i>
                                </div>
                                <h6 class="text-secondary font-weight-normal">Belum ada berkas tersimpan</h6>
                                <button class="btn btn-sm btn-link text-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Mulai unggah berkas</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection