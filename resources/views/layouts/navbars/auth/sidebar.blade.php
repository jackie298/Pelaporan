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

            {{-- ================= MENU REVEGETASI (COLLAPSE) ================= --}}
            <li class="nav-item">
                <a data-bs-toggle="collapse" 
                   href="#revegetasiMenu" 
                   class="nav-link {{ Request::is('revegetasi*') || Request::is('rencana-revegetasi*') ? 'active' : '' }}" 
                   aria-controls="revegetasiMenu" 
                   role="button" 
                   aria-expanded="{{ Request::is('revegetasi*') || Request::is('rencana-revegetasi*') ? 'true' : 'false' }}">
                    
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Request::is('revegetasi*') || Request::is('rencana-revegetasi*') ? 'bg-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-tree {{ Request::is('revegetasi*') || Request::is('rencana-revegetasi*') ? 'text-white' : 'text-dark' }}" 
                           style="top: 0; font-size: 0.8rem;"></i>
                    </div>
                    
                    <span class="nav-link-text ms-1 {{ Request::is('revegetasi*') || Request::is('rencana-revegetasi*') ? 'font-weight-bold' : '' }}">Revegetasi</span>
                </a>

                <div class="collapse {{ Request::is('revegetasi*') || Request::is('rencana-revegetasi*') ? 'show' : '' }}" id="revegetasiMenu">
                    <ul class="nav ms-4 ps-3" style="border-left: 1px solid #dee2e6;">
                        
                        {{-- SUBMENU: REALISASI --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('revegetasi') || Request::is('revegetasi/create') || Request::is('revegetasi/*/edit') ? 'active' : '' }}" 
                               href="{{ route('revegetasi') }}">
                                <span class="dot-indicator {{ Request::is('revegetasi') || Request::is('revegetasi/create') || Request::is('revegetasi/*/edit') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Realisasi Lapangan </span>
                            </a>
                        </li>

                        {{-- SUBMENU: RENCANA --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('rencana-revegetasi*') ? 'active' : '' }}" 
                               href="{{ route('rencana-revegetasi') }}">
                                <span class="dot-indicator {{ Request::is('rencana-revegetasi*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Rencana Bulanan </span>
                            </a>
                        </li>

                        {{-- SUBMENU: MONITORING VEGETASI --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('monitoring-vegetasi*') ? 'active' : '' }}" 
                               href="{{ route('monitoring-vegetasi') }}">
                                <span class="dot-indicator {{ Request::is('monitoring-vegetasi*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Monitoring Vegetasi </span>
                            </a>
                        </li>
                        
                    </ul>
                </div>
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

            {{-- ================= MENU MANAJEMEN LIMBAH (COLLAPSE) ================= --}}
            <li class="nav-item">
                <a data-bs-toggle="collapse" 
                href="#limbahMenu" 
                class="nav-link {{ Request::is('waste-water-management*') || Request::is('trash-management*') ? 'active' : '' }}" 
                aria-controls="limbahMenu" 
                role="button" 
                aria-expanded="{{ Request::is('waste-water-management*') || Request::is('trash-management*') ? 'true' : 'false' }}">
                    
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Request::is('waste-water-management*') || Request::is('trash-management*') ? 'bg-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-recycle {{ Request::is('waste-water-management*') || Request::is('trash-management*') ? 'text-white' : 'text-dark' }}" 
                        style="top: 0; font-size: 0.8rem;"></i>
                    </div>
                    
                    <span class="nav-link-text ms-1 {{ Request::is('waste-water-management*') || Request::is('trash-management*') ? 'font-weight-bold' : '' }}">Manajemen Limbah</span>
                </a>

                <div class="collapse {{ Request::is('waste-water-management*') || Request::is('trash-management*') ? 'show' : '' }}" id="limbahMenu">
                    <ul class="nav ms-4 ps-3" style="border-left: 1px solid #dee2e6;">
                        
                        {{-- SUBMENU: WASTE WATER --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('waste-water-management*') ? 'active' : '' }}" 
                            href="{{ url('waste-water-management') }}">
                                <span class="dot-indicator {{ Request::is('waste-water-management*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Air Limbah </span>
                            </a>
                        </li>

                        {{-- SUBMENU: LIMBAH B3 --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('waste-b3*') ? 'active' : '' }}" 
                            href="{{ route('waste-b3') }}">
                                <span class="dot-indicator {{ Request::is('waste-b3*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Limbah B3 </span>
                            </a>
                        </li>

                        {{-- SUBMENU: TRASH MANAGEMENT --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('trash-management*') ? 'active' : '' }}" 
                            href="{{ route('trash-management') }}">
                                <span class="dot-indicator {{ Request::is('trash-management*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Pengelolaan Sampah </span>
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </li>

            {{-- ================= COMPLIANCE ================= --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('compliance*') ? 'active' : '' }}"
                href="{{ route('compliance') }}">

                    <div class="icon icon-shape icon-sm shadow
                        {{ Request::is('compliance*') ? 'bg-primary' : 'bg-white' }}
                        text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fa-solid fa-clipboard-check
                        {{ Request::is('compliance*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Inspeksi</span>
                </a>
            </li>
{{-- Cek apakah user yang login BUKAN employee --}}
@if(auth()->user()->role !== 'employee')

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
            <div class="icon icon-shape icon-sm shadow {{ Request::is('admin/document-contract*') || Request::is('admin/add-contract') ? 'bg-primary' : 'bg-white' }} text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-file-contract {{ Request::is('admin/document-contract*') || Request::is('admin/add-contract') ? 'text-white' : 'text-dark' }}"></i>
            </div>
            <span class="nav-link-text ms-1">Rekap Anggaran</span>
        </a>
    </li>

    {{-- ================= MENU MANAJEMEN ALAT ================= --}}
    <li class="nav-item">
        <a data-bs-toggle="collapse" 
           href="#alatMenu" 
           class="nav-link {{ Request::is('admin/equipment-list*', 'admin/work-hours*') ? 'active' : '' }}" 
           aria-controls="alatMenu" 
           role="button" 
           aria-expanded="{{ Request::is('admin/equipment-list*', 'admin/work-hours*') ? 'true' : 'false' }}">
            
            <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Request::is('admin/equipment-list*', 'admin/work-hours*') ? 'bg-gradient-primary' : 'bg-white' }}">
                <i class="fa-solid fa-screwdriver-wrench {{ Request::is('admin/equipment-list*', 'admin/work-hours*') ? 'text-white' : 'text-dark' }}" style="top: 0; font-size: 0.8rem;"></i>
            </div>
            <span class="nav-link-text ms-1 {{ Request::is('admin/equipment-list*', 'admin/work-hours*') ? 'font-weight-bold' : '' }}">Manajemen Alat</span>
        </a>

        <div class="collapse {{ Request::is('admin/equipment-list*', 'admin/work-hours*') ? 'show' : '' }}" id="alatMenu">
            <ul class="nav ms-4 ps-3" style="border-left: 1px solid #dee2e6;">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/equipment-list*') ? 'active' : '' }}" href="{{ route('admin.equipment-list') }}">
                        <span class="dot-indicator {{ Request::is('admin/equipment-list*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                        <span class="sidenav-normal text-xs ps-2"> Daftar Alat </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/work-hours*') ? 'active' : '' }}" href="{{ route('admin.work-hours') }}">
                        <span class="dot-indicator {{ Request::is('admin/work-hours*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                        <span class="sidenav-normal text-xs ps-2"> Jam Kerja </span>
                    </a>
                </li>
            </ul>
        </div>

    </li>



    <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/user*') || Request::is('admin/add-user') ? 'active' : '' }}"
           href="{{ route('admin.user') }}">
            <div class="icon icon-shape icon-sm shadow {{ Request::is('admin/user*') || Request::is('admin/add-user') ? 'bg-primary' : 'bg-white' }} text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-user {{ Request::is('admin/user*') || Request::is('admin/add-user') ? 'text-white' : 'text-dark' }}"></i>
            </div>
            <span class="nav-link-text ms-1">User</span>
        </a>
    </li>

@endif
        </ul>
    </div>
</aside>