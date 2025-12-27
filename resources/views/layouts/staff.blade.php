<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Panel') - {{ config('app.name') }}</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }
        
        #wrapper {
            display: flex;
        }
        
        #sidebar {
            min-height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        #content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }
        
        .nav-item {
            margin: 0.3rem 0.8rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s;
            font-size: 0.95rem;
        }
        
        .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.15);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.2);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .nav-section {
            padding: 0.5rem 1.5rem 0.3rem;
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .topbar {
            height: 70px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .user-dropdown {
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(var(--sidebar-width) * -1);
            }
            
            #sidebar.show {
                margin-left: 0;
            }
            
            #content-wrapper {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <!-- Brand -->
            <a class="sidebar-brand" href="{{ route('staff.dashboard') }}">
                <i class="fas fa-user-tie me-2"></i>
                <span>STAFF PANEL</span>
            </a>
            
            <!-- Nav Items -->
            <ul class="nav flex-column py-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}" 
                       href="{{ route('staff.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-section">KELOLA DATA</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.products.*') ? 'active' : '' }}" 
                       href="{{ route('staff.products.index') }}">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                        <span class="badge bg-warning ms-auto">3</span>
                    </a>
                </li>
                
                <li class="nav-section">LAPORAN</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.reports.products') ? 'active' : '' }}" 
                       href="{{ route('staff.reports.products') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan Produk</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.reports.orders') ? 'active' : '' }}" 
                       href="{{ route('staff.reports.orders') }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Laporan Order</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Content Wrapper -->
        <div id="content-wrapper">
            <!-- Topbar -->
            <nav class="topbar navbar navbar-expand navbar-light">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Breadcrumb or Title -->
                    <div class="d-none d-md-block">
                        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
                    </div>
                    
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Notifications -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" data-bs-toggle="dropdown">
                                <i class="fas fa-bell fa-lg text-muted"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Notifications</h6></li>
                                <li><a class="dropdown-item" href="#">New order received</a></li>
                                <li><a class="dropdown-item" href="#">Product stock low</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="#">View All</a></li>
                            </ul>
                        </li>
                        
                        <!-- User Info -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown d-flex align-items-center" 
                               data-bs-toggle="dropdown">
                                <div class="user-avatar me-2">
                                    {{ auth()->user()->initials }}
                                </div>
                                <div class="d-none d-lg-block text-start">
                                    <div class="fw-bold" style="font-size: 0.9rem;">
                                        {{ auth()->user()->name }}
                                    </div>
                                    <small class="text-muted">Staff</small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                        Profile Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cog fa-sm fa-fw me-2 text-gray-400"></i>
                                        Settings
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid py-4">
                <!-- Alert Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="text-center py-4 bg-white mt-5 border-top">
                <span class="text-muted">© {{ date('Y') }} {{ config('app.name') }} - Staff Panel</span>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    
    @stack('scripts')
</body>
</html>