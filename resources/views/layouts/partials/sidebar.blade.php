<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand d-flex align-items-center justify-content-center">
            <i class="fas fa-hand-sparkles me-2"></i>
            <span>KraftiQu</span>
        </div>
    </div>

    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
               href="{{ route('admin.dashboard') }}">
                <i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <!-- Divider -->
        <li class="nav-title">Manajemen Produk</li>

        <!-- Kategori -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
               href="{{ route('admin.categories.index') }}">
                <i class="nav-icon fas fa-folder"></i> Kategori
            </a>
        </li>

        <!-- Produk -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
               href="{{ route('admin.products.index') }}">
                <i class="nav-icon fas fa-box"></i> Produk
            </a>
        </li>

        <!-- Divider -->
        <li class="nav-title">Manajemen User</li>

        <!-- Users -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
               href="{{ route('admin.users.index') }}">
                <i class="nav-icon fas fa-users"></i> Pengguna
            </a>
        </li>

        <!-- Divider -->
        <li class="nav-title">Laporan</li>

        <!-- Reports -->
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <i class="nav-icon fas fa-chart-bar"></i> Laporan
            </a>
            <ul class="nav-group-items compact">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fas fa-circle" style="font-size: 0.5rem;"></i> Produk Terlaris
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fas fa-circle" style="font-size: 0.5rem;"></i> Stok Produk
                    </a>
                </li>
            </ul>
        </li>

        <!-- Divider -->
        <li class="nav-title">Pengaturan</li>

        <!-- Settings -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-cog"></i> Pengaturan
            </a>
        </li>

        <!-- Help -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-question-circle"></i> Bantuan
            </a>
        </li>

    </ul>

    <div class="sidebar-footer border-top d-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>