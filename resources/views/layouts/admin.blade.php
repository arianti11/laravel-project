<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #4e73df;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
        }
        
        #wrapper {
            display: flex;
        }
        
        #sidebar {
            min-height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
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
        }
        
        .nav-item {
            margin: 0.2rem 0;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .topbar {
            height: 70px;
            background: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .user-dropdown {
            cursor: pointer;
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
            <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-gem me-2"></i>
                <span>ADMIN PANEL</span>
            </a>
            
            <!-- Nav Items -->
            <ul class="nav flex-column px-2 py-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item mt-2">
                    <div class="px-3 text-white-50 small mb-2">MANAGEMENT</div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                       href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                
                <li class="nav-item mt-2">
                    <div class="px-3 text-white-50 small mb-2">REPORTS</div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                       href="{{ route('admin.reports.sales') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Laporan Penjualan</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.activity-logs') ? 'active' : '' }}" 
                       href="{{ route('admin.activity-logs') }}">
                        <i class="fas fa-history"></i>
                        <span>Activity Logs</span>
                    </a>
                </li>
                
                <!-- <li class="nav-item mt-2">
                    <div class="px-3 text-white-50 small mb-2">SYSTEM</div>
                </li> -->
                
                <!-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                       href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li> -->
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
                    
                    <ul class="navbar-nav ms-auto">
                        <!-- User Info -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown" 
                               data-bs-toggle="dropdown">
                                <span class="me-2 d-none d-lg-inline text-gray-600">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="badge bg-danger">Admin</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <!-- <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                </li> -->
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
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="text-center py-3 bg-white mt-5">
                <span class="text-muted">Copyright © {{ date('Y') }} {{ config('app.name') }}</span>
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