<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Shop - Belanja Produk Lokal</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .btn-custom {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: all 0.3s;
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-store"></i> UMKM Shop
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Produk</a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i> Keranjang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm ms-2" href="{{ route('register') }}">
                                Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">
                        Belanja Produk UMKM Berkualitas
                    </h1>
                    <p class="lead mb-4">
                        Dukung produk lokal Indonesia dengan berbelanja di UMKM Shop. 
                        Temukan berbagai produk berkualitas dari UMKM seluruh Indonesia.
                    </p>
                    
                    <div class="d-flex gap-3">
                        <!-- 🔥 TOMBOL MASUK - INI YANG PENTING -->
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-custom btn-lg">
                            <i class="fas fa-shopping-bag"></i> Mulai Belanja
                        </a>
                        
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-custom btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Masuk
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light btn-custom btn-lg">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
                
                <div class="col-lg-6 text-center">
                    <i class="fas fa-store fa-10x opacity-25"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Kenapa Belanja di UMKM Shop?</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Produk Berkualitas</h5>
                        <p class="text-muted">Semua produk telah diverifikasi dan berkualitas tinggi</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-truck fa-3x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Gratis Ongkir</h5>
                        <p class="text-muted">Gratis ongkir untuk pembelian minimal Rp 500.000</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-headset fa-3x text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Support 24/7</h5>
                        <p class="text-muted">Tim support siap membantu kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 UMKM Shop. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>