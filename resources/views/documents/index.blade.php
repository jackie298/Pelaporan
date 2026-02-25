@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="alert alert-secondary mx-4 d-flex justify-content-between align-items-center" role="alert">
        <span class="text-white">
            <strong>Manajemen Dokumen</strong>
        </span>
        <button class="btn bg-gradient-secondary btn-sm mb-0" disabled>Export PDF</button>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Semua Dokumen</h5>
                        </div>
                        {{-- Tombol untuk membuka Modal Upload (lebih praktis daripada halaman terpisah) --}}
                        <button type="button" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            +&nbsp; Unggah Dokumen Baru
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul Dokumen</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Format</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ukuran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Unggah</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $documents as $index => $doc )
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <i class="fas fa-file-alt me-3"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $doc->title }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $doc->original_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-secondary">{{ strtoupper($doc->file_type) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $doc->formatted_size }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs mb-0">{{ $doc->category ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $doc->created_at->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{-- Tombol Preview --}}
                                        <a href="{{ route('documents.preview', $doc->id) }}" class="mx-2" title="Preview">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                        {{-- Download --}}
                                        <a href="{{ route('documents.download', $doc->id) }}" class="mx-2" title="Download">
                                            <i class="fas fa-download text-info"></i>
                                        </a>
                                        {{-- Hapus --}}
                                        <button type="button" class="cursor-pointer border-0 bg-transparent delete-btn" 
                                                data-id="{{ $doc->id }}" 
                                                data-nama="{{ $doc->title }}">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada dokumen yang diunggah.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL UPLOAD --}}
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Dokumen</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul Dokumen</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Laporan Tahunan" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Kategori (Opsional)</label>
                        <input type="text" name="category" class="form-control" placeholder="Contoh: Keuangan">
                    </div>
                    <div class="form-group">
                        <label for="file">Pilih File (PDF, DOCX, JPG, PNG - Max 5MB)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary">Mulai Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p>Apakah Anda yakin ingin menghapus dokumen <strong id="docName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-gradient-danger">Hapus Dokumen</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SUKSES --}}
@if (session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                <h5>Berhasil!</h5>
                <p>{{ session('success') }}</p>
                <button type="button" class="btn bg-gradient-success mb-0" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tombol Hapus Logic
    const deleteBtns = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');
    const docName = document.getElementById('docName');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            
            docName.textContent = nama;
            // Pastikan route ini sesuai dengan Route::resource atau Route::delete Anda
            deleteForm.action = `documents/${id}`; 
            
            deleteModal.show();
        });
    });

    // Auto show modal sukses
    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif
});
</script>
@endpush

@endsection