<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Shop - Belanja Produk Lokal Berkualitas</title>
    
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
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="none"/><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
            opacity: 0.5;
        }
        
        .btn-custom {
            padding: 14px 35px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .category-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 15px;
            padding: 2rem;
            color: white;
            transition: transform 0.3s;
            cursor: pointer;
        }

        .category-card:hover {
            transform: scale(1.05);
        }

        .stats-section {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 60px 0;
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        footer {
            background: #1a1a2e;
            color: white;
            padding: 60px 0 20px;
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
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    
                    @guest
                        <li class="nav-item ms-3">
                            <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-light btn-sm" href="{{ route('register') }}">
                                Daftar
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i> Cart
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary btn-sm" href="{{ route('user.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInLeft">
                        Belanja Produk UMKM Berkualitas
                    </h1>
                    <p class="lead mb-4">
                        Dukung produk lokal Indonesia dengan berbelanja di UMKM Shop. 
                        Ribuan produk berkualitas dari pengrajin dan produsen lokal.
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-custom">
                            <i class="fas fa-shopping-bag"></i> Mulai Belanja
                        </a>
                        
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-custom">
                                <i class="fas fa-user-plus"></i> Daftar Gratis
                            </a>
                        @endguest
                    </div>
                </div>
                
                <div class="col-lg-6 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" 
                         alt="Shopping" 
                         class="img-fluid" 
                         style="max-width: 400px; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.3));">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <h2 class="fw-bold mb-0">1000+</h2>
                    <p class="mb-0">Produk Berkualitas</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h2 class="fw-bold mb-0">500+</h2>
                    <p class="mb-0">UMKM Partner</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h2 class="fw-bold mb-0">10K+</h2>
                    <p class="mb-0">Customer Puas</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h2 class="fw-bold mb-0">50K+</h2>
                    <p class="mb-0">Transaksi Sukses</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Kenapa Belanja di UMKM Shop?</h2>
                <p class="text-muted">Kami memberikan pengalaman belanja terbaik untuk Anda</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary mx-auto">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3">100% Original</h5>
                        <p class="text-muted">Semua produk dijamin asli dari produsen lokal terpercaya</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-success bg-opacity-10 text-success mx-auto">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Gratis Ongkir</h5>
                        <p class="text-muted">Free shipping untuk pembelian minimal Rp 500.000</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-warning bg-opacity-10 text-warning mx-auto">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Support 24/7</h5>
                        <p class="text-muted">Tim support siap membantu Anda kapan saja</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-danger bg-opacity-10 text-danger mx-auto">
                            <i class="fas fa-undo"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Garansi Return</h5>
                        <p class="text-muted">Kemudahan return barang dalam 7 hari</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-info bg-opacity-10 text-info mx-auto">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Transaksi Aman</h5>
                        <p class="text-muted">Sistem pembayaran yang aman dan terenkripsi</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="feature-icon bg-purple bg-opacity-10 text-purple mx-auto">
                            <i class="fas fa-tag"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Harga Terjangkau</h5>
                        <p class="text-muted">Harga langsung dari produsen, tanpa markup</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Siap Berbelanja?</h2>
            <p class="lead mb-4">Daftar sekarang dan dapatkan voucher diskon 50rb untuk pembelian pertama!</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-custom">
                <i class="fas fa-gift"></i> Daftar & Dapatkan Voucher
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://cdn-icons-png.flaticon.com/512/4882/4882451.png" 
                         alt="About Us" 
                         class="img-fluid">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Tentang UMKM Shop</h2>
                    <p class="mb-3">
                        UMKM Shop adalah platform e-commerce yang didedikasikan untuk mendukung 
                        produk-produk lokal Indonesia. Kami menghubungkan UMKM dengan konsumen 
                        di seluruh Indonesia.
                    </p>
                    <p class="mb-4">
                        Dengan berbelanja di UMKM Shop, Anda tidak hanya mendapatkan produk 
                        berkualitas, tapi juga membantu menggerakkan ekonomi lokal Indonesia.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3 fw-bold">
                        <i class="fas fa-store"></i> UMKM Shop
                    </h5>
                    <p class="text-white-50">
                        Platform belanja online untuk produk UMKM berkualitas dari seluruh Indonesia.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-white fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="mb-3 fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none">Products</a></li>
                        <li class="mb-2"><a href="#about" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="mb-3 fw-bold">Contact Info</h6>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-envelope me-2"></i> support@umkmshop.com
                    </p>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-phone me-2"></i> 0812-3456-7890
                    </p>
                    <p class="text-white-50 mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i> Jakarta, Indonesia
                    </p>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; 2025 UMKM Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>