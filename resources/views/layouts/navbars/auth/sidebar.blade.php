<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white"
    id="sidenav-main">

    {{-- HEADER --}}
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
           id="iconSidenav"></i>

        <a class="navbar-brand m-0 d-flex align-items-center"
           href="{{ url('dashboard') }}">
            <img src="{{ asset('assets/img/logoperusahaan.png') }}"
                 class="navbar-brand-img h-100" alt="logo">
            <span class="ms-2 font-weight-bold">PT NUSA KARYA ARINDO</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">

    {{-- MENU --}}
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            {{-- ================= DASHBOARD ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                   href="{{ url('dashboard') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('dashboard') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fas fa-house
                           {{ Request::is('dashboard') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- ================= MENU DOKUMENTASI ================= --}}
            <li class="nav-item">
                <a data-bs-toggle="collapse" 
                href="#dokumentasiMenu" 
                class="nav-link {{ Request::is('admin/dokumentasi-kegiatan*') ? 'active' : '' }}" 
                aria-controls="dokumentasiMenu" 
                role="button" 
                aria-expanded="{{ Request::is('admin/dokumentasi-kegiatan*') ? 'true' : 'false' }}">
                    
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Request::is('admin/dokumentasi-kegiatan*') ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fas fa-folder-open {{ Request::is('admin/dokumentasi-kegiatan*') ? 'text-white' : 'text-dark' }}" 
                        style="top: 0; font-size: 0.8rem;"></i>
                    </div>
                    
                    <span class="nav-link-text ms-1 {{ Request::is('admin/dokumentasi-kegiatan*') ? 'font-weight-bold' : '' }}">Dokumentasi</span>
                </a>

                <div class="collapse {{ Request::is('admin/dokumentasi-kegiatan*') ? 'show' : '' }}" id="dokumentasiMenu">
                    <ul class="nav ms-4 ps-3" style="border-left: 1px solid #dee2e6;">
                        
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/dokumentasi-kegiatan') ? 'active' : '' }}" 
                            href="{{ route('admin.dokumentasi-kegiatan') }}">
                                <span class="dot-indicator {{ Request::is('admin/dokumentasi-kegiatan') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> List Kegiatan </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/dokumentasi-kegiatan/gallery') ? 'active' : '' }}" 
                            href="{{ route('admin.dokumentasi-kegiatan.gallery') }}">
                                <span class="dot-indicator {{ Request::is('admin/dokumentasi-kegiatan/gallery') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Gallery Kegiatan </span>
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            {{-- ================= BUKAAN LAHAN ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('bukaan-lahan*') ? 'active' : '' }}"
                href="{{ route('bukaan-lahan') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('bukaan-lahan*') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fa-solid fa-mountain
                        {{ Request::is('bukaan-lahan*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Bukaan Lahan</span>
                </a>
            </li>

            {{-- ================= REKLAMASI ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('reklamasi*') ? 'active' : '' }}"
                href="{{ route('reklamasi') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('reklamasi*') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fa-solid fa-hill-avalanche
                        {{ Request::is('reklamasi*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Reklamasi</span>
                </a>
            </li>

            {{-- ================= REVEGETASI ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('revegetasi') ? 'active' : '' }}"
                   href="{{ url('revegetasi') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('revegetasi') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fa-solid fa-tree
                           {{ Request::is('revegetasi') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Revegetasi</span>
                </a>
            </li>

            {{-- ================= NURSERY ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('nursery*') ? 'active' : '' }}"
                href="{{ route('nursery') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('nursery*') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fa-solid fa-mountain
                        {{ Request::is('nursery*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Nursery</span>
                </a>
            </li>

            {{-- ================= Waste Water Management ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('waste-water-management') ? 'active' : '' }}"
                   href="{{ url('waste-water-management') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('waste-water-management') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fa-solid fa-water
                           {{ Request::is('waste-water-management') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Waste Water</span>
                </a>
            </li>
            {{-- ================= COMPLIANCE ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('complience*') ? 'active' : '' }}"
                href="{{ route('complience') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('complience*') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fa-solid fa-clipboard-check
                        {{ Request::is('complience*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Compliance</span>
                </a>
            </li>

            {{-- ================= ADMIN ================= --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Halaman Admin
                </h6>
            </li>

            {{-- ================= DOKUMEN KONTRAK ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/document-contract*') || Request::is('admin/add-contract') ? 'active' : '' }}"
                   href="{{ route('admin.document-contract') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('admin/document-contract*') || Request::is('admin/add-contract') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fas fa-file-contract
                            {{ Request::is('admin/document-contract*') || Request::is('admin/add-contract') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Rekap Anggaran</span>
                </a>
            </li>

            {{-- ================= DAFTAR ALAT ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/equipment-list*') ? 'active' : '' }}"
                   href="{{ route('admin.equipment-list') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('admin/equipment-list*') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-truck-monster
                            {{ Request::is('admin/equipment-list*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Daftar Alat</span>
                </a>
            </li>

            {{-- ================= JAM KERJA ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/work-hours*') ? 'active' : '' }}"
                   href="{{ route('admin.work-hours') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('admin/work-hours*') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-clock
                            {{ Request::is('admin/work-hours*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Jam Kerja</span>
                </a>
            </li>
        </ul>
    </div>
</aside>