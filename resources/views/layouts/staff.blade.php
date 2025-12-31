<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Panel') - UMKM Shop</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --staff-color: #f59e0b;
            --staff-dark: #d97706;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, var(--staff-color) 0%, var(--staff-dark) 100%);
            color: white;
            padding-top: 20px;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h4 {
            margin: 0;
            font-weight: 700;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
        }

        .sidebar-menu li a i {
            width: 25px;
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-top {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            padding: 1rem 2rem;
            margin-bottom: 2rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Badges */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4>
                <i class="fas fa-store"></i>
                UMKM Shop
            </h4>
            <small>Staff Panel</small>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('staff.products.index') }}" class="{{ request()->routeIs('staff.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    Products
                </a>
            </li>
            <li>
                <a href="{{ route('staff.orders.index') }}" class="{{ request()->routeIs('staff.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    Orders
                </a>
            </li>
            <li>
                <a href="{{ route('staff.reports.products') }}" class="{{ request()->routeIs('staff.reports.products') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    Products Report
                </a>
            </li>
            <li>
                <a href="{{ route('staff.reports.orders') }}" class="{{ request()->routeIs('staff.reports.orders') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    Orders Report
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar-top d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <!-- User Info -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text">
                                <small class="text-muted">Logged in as</small><br>
                                <strong>{{ auth()->user()->email }}</strong>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li> -->
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="container-fluid px-4">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Auto dismiss alerts -->
    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>