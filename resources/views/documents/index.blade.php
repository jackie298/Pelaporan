@extends('layouts.user_type.auth')

@section('content')
<style>
    /* Custom Styling untuk mempercantik UI */
    .folder-card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    .folder-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .icon-folder {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #fbcf33; /* Warna folder emas/kuning */
    }
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        margin: 0 2px;
    }
    .btn-action:hover {
        transform: scale(1.1);
    }
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .file-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f5f5f1;
    }
</style>

<div class="container-fluid py-4">
    <div class="d-md-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold mb-1">Penyimpanan Dokumen</h3>
            <p class="text-muted mb-0">Kelola berkas Anda secara aman dan terorganisir.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <button class="btn btn-white shadow-sm mb-0 me-2" data-bs-toggle="modal" data-bs-target="#folderModal">
                <i class="fas fa-folder-plus me-2 text-primary"></i>Folder Baru
            </button>
            <button class="btn bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-upload me-2"></i>Unggah Berkas
            </button>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light shadow-sm px-3 py-2 rounded-3 mb-4">
            <li class="breadcrumb-item"><a href="{{ route('documents') }}"><i class="fas fa-home me-1"></i> Home</a></li>
            @if($currentFolder)
                @if($currentFolder->parent)
                    <li class="breadcrumb-item">
                        <a href="{{ route('documents', ['folder_id' => $currentFolder->parent->id]) }}">
                            {{ $currentFolder->parent->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active text-dark font-weight-bold" aria-current="page">{{ $currentFolder->name }}</li>
            @endif
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <h6 class="mb-0 font-weight-bold text-secondary text-uppercase">Folder Saya</h6>
                <hr class="flex-grow-1 ms-3 opacity-1">
            </div>
            <div class="d-flex overflow-auto pb-3" style="gap: 1.2rem; scrollbar-width: thin;">
                @forelse($folders as $folder)
                <div class="card folder-card border shadow-sm h-100 {{ $currentFolderId == $folder->id ? 'border-primary bg-light' : '' }}" style="min-width: 200px; position: relative;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-folder shadow-sm bg-gradient-warning text-white border-0">
                                <i class="fas fa-folder fa-lg"></i>
                            </div>
                            <div class="dropdown" style="z-index: 20;">
                                <button class="btn btn-link text-secondary mb-0 py-0 px-2" id="drop{{ $folder->id }}" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="drop{{ $folder->id }}">
                                    <li>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteFolderModal{{ $folder->id }}">
                                            <i class="fas fa-trash-alt me-2 text-xs"></i> Hapus Folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{ route('documents', ['folder_id' => $folder->id]) }}" class="stretched-link">
                            <h6 class="mb-1 text-dark font-weight-bold text-truncate" title="{{ $folder->name }}">{{ $folder->name }}</h6>
                        </a>
                        <span class="badge bg-secondary-soft text-xxs text-secondary">
                            <i class="fas fa-file-alt me-1"></i> {{ $folder->documents_count ?? 0 }} Berkas
                        </span>
                    </div>
                </div>

                <div class="modal fade" id="deleteFolderModal{{ $folder->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-body text-center py-5">
                                <div class="icon-shape bg-light-danger text-danger rounded-circle mb-4 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                                </div>
                                <h4 class="font-weight-bold">Hapus Folder?</h4>
                                <p class="text-muted px-4">Folder <strong>"{{ $folder->name }}"</strong> dan semua isinya akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
                                <div class="d-flex justify-content-center mt-4" style="gap: 10px;">
                                    <button type="button" class="btn btn-light px-4 mb-0" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('documents.destroyFolder', $folder->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger px-4 mb-0 shadow-sm">Ya, Hapus Semua</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center w-100 py-4 bg-light rounded-3 border-dashed border-2">
                    <p class="text-muted mb-0"><i class="fas fa-folder-open me-2"></i> Belum ada folder di sini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 border-radius-xl">
        <div class="card-header pb-0 p-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-list me-2 text-primary"></i>Daftar Berkas</h5>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="fileSearch" class="form-control bg-light border-start-0" placeholder="Cari dokumen...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2 mt-3">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="fileTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Nama Berkas</th>
                            <th class="ps-2">Lokasi</th>
                            <th class="ps-2">Ukuran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td>
                                <div class="d-flex px-4 py-2 align-items-center">
                                    @php
                                        $iconData = match(strtolower($doc->file_type)) {
                                            'pdf' => ['icon' => 'fa-file-pdf', 'color' => 'text-danger'],
                                            'xls', 'xlsx' => ['icon' => 'fa-file-excel', 'color' => 'text-success'],
                                            'doc', 'docx' => ['icon' => 'fa-file-word', 'color' => 'text-info'],
                                            'png', 'jpg', 'jpeg' => ['icon' => 'fa-file-image', 'color' => 'text-warning'],
                                            default => ['icon' => 'fa-file', 'color' => 'text-secondary']
                                        };
                                    @endphp
                                    <div class="file-icon me-3 shadow-sm">
                                        <i class="fas {{ $iconData['icon'] }} {{ $iconData['color'] }} fa-lg"></i>
                                    </div>
                                    <div class="d-flex flex-column text-truncate" style="max-width: 300px;">
                                        <h6 class="mb-0 text-sm font-weight-bold">{{ $doc->title }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $doc->original_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs font-weight-bold bg-light px-2 py-1 rounded-2 text-dark">/{{ Str::limit($doc->file_path, 12) }}</span>
                            </td>
                            <td>
                                <span class="text-xs text-dark font-weight-bold">
                                    {{ $doc->file_size > 1024*1024 ? number_format($doc->file_size / (1024*1024), 2) . ' MB' : number_format($doc->file_size / 1024, 2) . ' KB' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('documents.preview', $doc->id) }}" class="btn-action bg-light-primary text-primary" title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('documents.download', $doc->id) }}" class="btn-action bg-light-info text-info" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button class="btn-action bg-light-warning text-warning border-0" data-bs-toggle="modal" data-bs-target="#moveModal{{ $doc->id }}" title="Pindahkan">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button class="btn-action bg-light-danger text-danger border-0" data-bs-toggle="modal" data-bs-target="#deleteDocModal{{ $doc->id }}" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteDocModal{{ $doc->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-body text-center py-5">
                                        <div class="icon-shape bg-light-danger text-danger rounded-circle mb-4 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-excel fa-3x" style="opacity: 0.5; position: absolute;"></i>
                                            <i class="fas fa-times fa-2x" style="z-index: 1;"></i>
                                        </div>
                                        <h4 class="font-weight-bold">Hapus Berkas?</h4>
                                        <p class="text-muted px-4">Apakah Anda yakin ingin menghapus berkas <br><strong>"{{ $doc->title }}"</strong>?</p>
                                        <div class="d-flex justify-content-center mt-4" style="gap: 10px;">
                                            <button type="button" class="btn btn-light px-4 mb-0" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('documents.destroy', $doc->id) }}" method="POST">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4 mb-0 shadow-sm">Ya, Hapus Berkas</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="moveModal{{ $doc->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg border-0">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title font-weight-bold"><i class="fas fa-exchange-alt text-warning me-2"></i>Pindah Lokasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('documents.move', $doc->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body py-4 text-start">
                                            <label class="text-xs text-uppercase text-secondary font-weight-bolder opacity-7">Pindahkan Berkas "{{ $doc->title }}" Ke:</label>
                                            <select name="folder_id" class="form-select border-radius-md py-2 mt-2">
                                                <option value="">Home</option>
                                                @foreach($allFolders as $f) 
                                                    <option value="{{ $f->id }}" {{ $doc->folder_id == $f->id ? 'selected' : '' }}>
                                                        📁 {{ $f->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-white px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn bg-gradient-warning px-4 shadow-sm">Pindahkan Sekarang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/folder-is-empty.svg" style="width: 150px;" class="mb-3 opacity-5">
                                <p class="text-muted">Folder ini masih kosong.</p>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Unggah Berkas Pertama</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="folderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold">Buat Folder Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('documents.storeFolder') }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <input type="hidden" name="parent_id" value="{{ $currentFolderId }}">
                    <div class="form-group">
                        <label class="form-control-label text-xs">Nama Folder</label>
                        <input type="text" name="name" class="form-control shadow-none" placeholder="Masukkan nama folder..." required autofocus>
                        <p class="text-xxs text-muted mt-2 px-1">
                            <i class="fas fa-info-circle me-1"></i> Lokasi: <strong>{{ $currentFolder ? $currentFolder->name : 'Semua Berkas' }}</strong>
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-white px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary px-4 shadow-sm">Simpan Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold">Unggah Berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-4 text-start">
                    <input type="hidden" name="folder_id" value="{{ $currentFolderId }}">
                    <div class="form-group mb-3">
                        <label class="form-control-label text-xs">Judul Tampilan</label>
                        <input type="text" name="title" class="form-control shadow-none" placeholder="Contoh: Invoice PT. ABC" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-control-label text-xs">Pilih File</label>
                        <input type="file" name="file" class="form-control shadow-none" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn bg-gradient-primary w-100 shadow-sm">
                        Unggah ke {{ $currentFolder ? $currentFolder->name : 'Semua Berkas' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search Functionality
        const searchInput = document.getElementById('fileSearch');
        const tableRows = document.querySelectorAll('#fileTable tbody tr');

        searchInput.addEventListener('keyup', function() {
            const query = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });
</script>
@endsection