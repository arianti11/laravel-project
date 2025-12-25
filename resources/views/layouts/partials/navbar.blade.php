<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button" 
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
                style="margin-inline-start: -14px;">
            <i class="fas fa-bars"></i>
        </button>

        <!-- <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home me-1"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}" target="_blank">
                    <i class="fas fa-globe me-1"></i> Lihat Website
                </a>
            </li>
        </ul> -->

        <ul class="header-nav ms-auto">
            <!-- Notifications -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <span class="badge rounded-pill position-absolute top-0 end-0 bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                        Notifikasi Baru (3)
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-box text-warning me-2"></i>
                        <div class="small">
                            <div>Stok produk "Batik Tulis" hampir habis</div>
                            <div class="text-body-secondary">2 menit yang lalu</div>
                        </div>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user text-info me-2"></i>
                        <div class="small">
                            <div>User baru mendaftar</div>
                            <div class="text-body-secondary">1 jam yang lalu</div>
                        </div>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-shopping-cart text-success me-2"></i>
                        <div class="small">
                            <div>Pesanan baru #12345</div>
                            <div class="text-body-secondary">3 jam yang lalu</div>
                        </div>
                    </a>
                    <a class="dropdown-item text-center border-top" href="#">
                        <strong>Lihat Semua Notifikasi</strong>
                    </a>
                </div>
            </li>

            <!-- User Profile -->
            <li class="nav-item dropdown">
                <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        @if(auth()->user()->avatar)
                            <img class="avatar-img" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="avatar-img bg-primary text-white d-flex align-items-center justify-content-center">
                                {{ auth()->user()->initials }}
                            </div>
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                        Account
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>

    <!-- Breadcrumb (optional) -->
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                <li class="breadcrumb-item active">
                    <span>@yield('page-title', 'Dashboard')</span>
                </li>
            </ol>
        </nav>
    </div>
</header>