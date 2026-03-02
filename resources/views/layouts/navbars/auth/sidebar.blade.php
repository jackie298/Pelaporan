<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white shadow-sm" id="sidenav-main">

    {{-- HEADER --}}
    <div class="sidenav-header mb-4">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" id="iconSidenav"></i>
        
        <a class="navbar-brand m-0 d-flex flex-column align-items-center text-center" href="{{ route('dashboard') }}">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <img src="{{ asset('assets/img/logoperusahaan.png') }}" class="navbar-brand-img mb-1" style="max-height: 40px;" alt="logo">
                <span class="ms-2 font-weight-bolder text-success h5 mb-0">E-ROCS</span>
            </div>
            <div class="text-wrap px-3">
                <p class="text-xs font-weight-bold text-dark text-uppercase mb-0 tracking-tight" style="line-height: 1.2;">
                    Environment Reporting & <br> Compliance System
                </p>
            </div>
        </a>
    </div>

    <hr class="horizontal dark mt-0"> 

    {{-- MENU CONTAINER --}}
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            {{-- DASHBOARD --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Route::is('dashboard') ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fas fa-house text-xs {{ Route::is('dashboard') ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- SECTION: OPERASIONAL --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Operasional</h6>
            </li>

            {{-- DOKUMENTASI --}}
            <li class="nav-item">
                @php $isDokActive = Request::is('admin/dokumentasi-kegiatan*'); @endphp
                <a data-bs-toggle="collapse" href="#dokumentasiMenu" 
                   class="nav-link {{ $isDokActive ? 'active' : '' }}" role="button" aria-expanded="{{ $isDokActive ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ $isDokActive ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fas fa-folder-open text-xs {{ $isDokActive ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dokumentasi</span>
                </a>
                <div class="collapse {{ $isDokActive ? 'show' : '' }}" id="dokumentasiMenu">
                    <ul class="nav ms-4 ps-3" style="border-left: 1px solid #f1f1f1;">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.dokumentasi-kegiatan') ? 'active' : '' }}" href="{{ route('admin.dokumentasi-kegiatan') }}">
                                <span class="dot-indicator {{ Route::is('admin.dokumentasi-kegiatan') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> List Kegiatan </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.dokumentasi-kegiatan.gallery') ? 'active' : '' }}" href="{{ route('admin.dokumentasi-kegiatan.gallery') }}">
                                <span class="dot-indicator {{ Route::is('admin.dokumentasi-kegiatan.gallery') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Gallery Kegiatan </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- BUKAAN LAHAN --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::is('bukaan-lahan*') ? 'active' : '' }}" href="{{ route('bukaan-lahan') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Route::is('bukaan-lahan*') ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-mountain text-xs {{ Route::is('bukaan-lahan*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bukaan Lahan</span>
                </a>
            </li>

            {{-- REKLAMASI --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::is('reklamasi*') ? 'active' : '' }}" href="{{ route('reklamasi') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Route::is('reklamasi*') ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-hill-avalanche text-xs {{ Route::is('reklamasi*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Reklamasi</span>
                </a>
            </li>

            {{-- REVEGETASI --}}
            <li class="nav-item">
                @php $isRevActive = Request::is('revegetasi*') || Request::is('rencana-revegetasi*') || Request::is('monitoring-vegetasi*'); @endphp
                <a data-bs-toggle="collapse" href="#revegetasiMenu" class="nav-link {{ $isRevActive ? 'active' : '' }}" role="button">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ $isRevActive ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-tree text-xs {{ $isRevActive ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Revegetasi</span>
                </a>
                <div class="collapse {{ $isRevActive ? 'show' : '' }}" id="revegetasiMenu">
                    <ul class="nav ms-4 ps-3" style="border-left: 1px solid #f1f1f1;">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('revegetasi*') ? 'active' : '' }}" href="{{ route('revegetasi') }}">
                                <span class="dot-indicator {{ Request::is('revegetasi*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Realisasi Lapangan </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('rencana-revegetasi') ? 'active' : '' }}" href="{{ route('rencana-revegetasi') }}">
                                <span class="dot-indicator {{ Route::is('rencana-revegetasi') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Rencana Bulanan </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('monitoring-vegetasi') ? 'active' : '' }}" href="{{ route('monitoring-vegetasi') }}">
                                <span class="dot-indicator {{ Route::is('monitoring-vegetasi') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Monitoring Vegetasi </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- NURSERY & INSPEKSI --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::is('nursery*') ? 'active' : '' }}" href="{{ route('nursery') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Route::is('nursery*') ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-seedling text-xs {{ Route::is('nursery*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Nursery</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('compliance*') ? 'active' : '' }}" href="{{ route('compliance') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Route::is('compliance*') ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-clipboard-check text-xs {{ Route::is('compliance*') ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Inspeksi</span>
                </a>
            </li>

            {{-- SECTION: LIMBAH --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen Limbah</h6>
            </li>

            {{-- AIR & SAMPAH --}}
            <li class="nav-item">
                @php $isWasteActive = Request::is('waste-water-management*') || Request::is('trash-management*'); @endphp
                <a data-bs-toggle="collapse" href="#limbahMenu" class="nav-link {{ $isWasteActive ? 'active' : '' }}" role="button">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ $isWasteActive ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fa-solid fa-droplet text-xs {{ $isWasteActive ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Air & Sampah</span>
                </a>
                <div class="collapse {{ $isWasteActive ? 'show' : '' }}" id="limbahMenu">
                    <ul class="nav ms-4 ps-3" style="border-left: 1px solid #f1f1f1;">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('waste-water-management*') ? 'active' : '' }}" href="{{ url('waste-water-management') }}">
                                <span class="dot-indicator {{ Request::is('waste-water-management*') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Air Limbah </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('trash-management') ? 'active' : '' }}" href="{{ route('trash-management') }}">
                                <span class="dot-indicator {{ Route::is('trash-management') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Pengelolaan Sampah </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- LIMBAH B3 --}}
            <li class="nav-item">
                @php $isB3Active = Request::is('waste-b3*'); @endphp
                <a data-bs-toggle="collapse" href="#wasteB3Menu" class="nav-link {{ $isB3Active ? 'active' : '' }}" role="button">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ $isB3Active ? 'bg-gradient-primary' : 'bg-white' }}">
                        <i class="fas fa-biohazard text-xs {{ $isB3Active ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Limbah B3</span>
                </a>
                <div class="collapse {{ $isB3Active ? 'show' : '' }}" id="wasteB3Menu">
                    <ul class="nav ms-4 ps-3" style="border-left: 1px solid #f1f1f1;">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('waste-b3') ? 'active' : '' }}" href="{{ route('waste-b3') }}">
                                <span class="dot-indicator {{ Route::is('waste-b3') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Masuk </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('waste-b3-keluar') ? 'active' : '' }}" href="{{ route('waste-b3-keluar') }}">
                                <span class="dot-indicator {{ Route::is('waste-b3-keluar') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                <span class="sidenav-normal text-xs ps-2"> Keluar </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- SECTION: ADMIN --}}
            @if(auth()->user()->role !== 'employee')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Administrator</h6>
                </li>

                {{-- REKAP ANGGARAN --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/rekap-anggaran*') ? 'active' : '' }}" href="{{ route('admin.rekap-anggaran') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Request::is('admin/rekap-anggaran*') ? 'bg-gradient-primary' : 'bg-white' }}">
                            <i class="fas fa-file-invoice-dollar text-xs {{ Request::is('admin/rekap-anggaran*') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Rekap Anggaran</span>
                    </a>
                </li>

                {{-- DOKUMEN --}}
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('documents') ? 'active' : '' }}" href="{{ route('documents') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Route::is('documents') ? 'bg-gradient-primary' : 'bg-white' }}">
                            <i class="fas fa-file-pdf text-xs {{ Route::is('documents') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Penyimpanan Dokumen</span>
                    </a>
                </li>

                {{-- MANAJEMEN ALAT --}}
                <li class="nav-item">
                    @php $isAlatActive = Request::is('admin/equipment-list*', 'admin/work-hours*'); @endphp
                    <a data-bs-toggle="collapse" href="#alatMenu" class="nav-link {{ $isAlatActive ? 'active' : '' }}" role="button">
                        <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ $isAlatActive ? 'bg-gradient-primary' : 'bg-white' }}">
                            <i class="fa-solid fa-screwdriver-wrench text-xs {{ $isAlatActive ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Manajemen Alat</span>
                    </a>
                    <div class="collapse {{ $isAlatActive ? 'show' : '' }}" id="alatMenu">
                        <ul class="nav ms-4 ps-3" style="border-left: 1px solid #f1f1f1;">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.equipment-list') ? 'active' : '' }}" href="{{ route('admin.equipment-list') }}">
                                    <span class="dot-indicator {{ Route::is('admin.equipment-list') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                    <span class="sidenav-normal text-xs ps-2"> Daftar Alat </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.work-hours') ? 'active' : '' }}" href="{{ route('admin.work-hours') }}">
                                    <span class="dot-indicator {{ Route::is('admin.work-hours') ? 'bg-primary' : 'bg-secondary' }}"></span>
                                    <span class="sidenav-normal text-xs ps-2"> Jam Kerja </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- USER MANAGEMENT --}}
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.user*') ? 'active' : '' }}" href="{{ route('admin.user') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ Route::is('admin.user*') ? 'bg-gradient-primary' : 'bg-white' }}">
                            <i class="fas fa-user-gear text-xs {{ Route::is('admin.user*') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Manajemen User</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</aside>