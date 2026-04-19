<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center w-100">
            
            <!-- Breadcrumb & Page Title -->
            <nav aria-label="breadcrumb">
                @php
                    $segments = request()->segments();
                @endphp

                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm">
                        <a class="opacity-5 text-dark" href="{{ url('/') }}">Pages</a>
                    </li>

                    @foreach ($segments as $index => $segment)
                        @if ($loop->last)
                            <li class="breadcrumb-item text-sm text-dark text-capitalize active" aria-current="page">
                                {{ str_replace('-', ' ', $segment) }}
                            </li>
                        @else
                            <li class="breadcrumb-item text-sm">
                                <a class="text-dark" href="{{ url(implode('/', array_slice($segments, 0, $index + 1))) }}">
                                    {{ str_replace('-', ' ', $segment) }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ol>

                <h6 class="font-weight-bolder mb-0 mt-1 text-capitalize">
                    {{ str_replace('-', ' ', last($segments)) }}
                </h6>
            </nav>

            <!-- User Actions & Mobile Toggler -->
            <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
                <!-- User Dropdown -->
                <div class="dropdown">
                    <a class="nav-link text-body font-weight-bold px-0 dropdown-toggle d-flex align-items-center" 
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-sm-inline d-none me-1">{{ Auth::user()->name ?? 'User' }}</span>
                        <i class="fa fa-user me-sm-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li class="px-3 py-2">
                            <div class="text-center text-muted" style="font-size: 0.85rem; line-height: 1.4; cursor: default;">
                                <i class="far fa-calendar-alt me-1"></i><span id="nav-date">{{ now()->format('d M Y') }}</span><br>
                                <i class="far fa-clock me-1"></i><span id="nav-time" class="fw-semibold text-dark">{{ now()->format('H:i:s') }}</span>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- Sidenav Toggler (Mobile Only) -->
                <a href="javascript:;" class="nav-link text-body p-0 d-xl-none" id="iconNavbarSidenav" aria-label="Toggle Sidebar">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </div>

        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateDateTime = () => {
            const now = new Date();
            // Format: Bahasa Indonesia (ubah 'id-ID' sesuai locale yang diinginkan)
            document.getElementById('nav-date').textContent = now.toLocaleDateString('id-ID', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
            document.getElementById('nav-time').textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        };

        updateDateTime(); // Update langsung saat load
        setInterval(updateDateTime, 1000); // Update setiap 1 detik
    });
</script>
<!-- End Navbar -->