<!DOCTYPE html>
<html lang="id">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') - KraftiQu Admin</title>
    
    <!-- CoreUI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.0/dist/css/coreui.min.css" rel="stylesheet">
    
    <!-- CoreUI Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/icons@3.0.1/css/all.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
=    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">
        <!-- Header/Navbar -->
        @include('layouts.partials.navbar')

        <!-- Main Content -->
        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                
                <!-- Breadcrumb -->
                @if(isset($breadcrumbs))
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
                @endif

                <!-- Alert Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-coreui-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-coreui-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-coreui-dismiss="alert"></button>
                </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>

    <!-- CoreUI JS -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.0/dist/js/coreui.bundle.min.js"></script>
    
    <!-- jQuery (optional, for some features) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new coreui.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // CSRF Token untuk AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 