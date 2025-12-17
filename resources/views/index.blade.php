<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerajinan Tangan UMKM - Handmade with Love</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hand-sparkles"></i> KraftiQu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#produk">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="login.html" class="btn btn-primary-custom">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Kerajinan Tangan<br>Dibuat dengan <span style="color: var(--primary);">❤️ Cinta</span></h1>
                    <p>Temukan koleksi kerajinan tangan unik dan berkualitas dari pengrajin lokal Indonesia. Setiap produk dibuat dengan penuh perhatian dan dedikasi.</p>
                    <a href="#produk" class="btn btn-primary-custom me-3">
                        <i class="fas fa-shopping-bag me-2"></i>Lihat Produk
                    </a>
                    <a href="#tentang" class="btn btn-outline-dark" style="border-radius: 50px; padding: 0.7rem 2rem;">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-image">
                        <i class="fas fa-hand-holding-heart" style="font-size: 15rem; color: var(--secondary); opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="tentang">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Mengapa Memilih Kami?</h2>
                <p class="text-muted">Komitmen kami untuk kualitas dan kepuasan pelanggan</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-hands"></i>
                        </div>
                        <h4>100% Handmade</h4>
                        <p>Setiap produk dibuat dengan tangan oleh pengrajin berpengalaman, menjamin kualitas dan keunikan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4>Ramah Lingkungan</h4>
                        <p>Menggunakan bahan-bahan alami dan ramah lingkungan untuk produk yang berkelanjutan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Kualitas Premium</h4>
                        <p>Standar kualitas tinggi dengan kontrol kualitas ketat untuk setiap produk yang kami jual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="products" id="produk">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Produk Unggulan</h2>
                <p class="text-muted">Koleksi terbaik dari pengrajin kami</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-tshirt" style="font-size: 5rem; color: white;"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">Batik Tulis Premium</h5>
                            <p class="text-muted small">Kain batik tulis dengan motif tradisional</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">Rp 350.000</span>
                                <button class="btn btn-sm btn-primary-custom">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-gem" style="font-size: 5rem; color: white;"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">Perhiasan Etnik</h5>
                            <p class="text-muted small">Kalung handmade dengan desain etnik</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">Rp 150.000</span>
                                <button class="btn btn-sm btn-primary-custom">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-paint-brush" style="font-size: 5rem; color: white;"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">Lukisan Kanvas</h5>
                            <p class="text-muted small">Lukisan abstrak dengan cat akrilik</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">Rp 500.000</span>
                                <button class="btn btn-sm btn-primary-custom">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-vase" style="font-size: 5rem; color: white;"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">Vas Keramik</h5>
                            <p class="text-muted small">Vas keramik dengan glasir natural</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">Rp 200.000</span>
                                <button class="btn btn-sm btn-primary-custom">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-shopping-basket" style="font-size: 5rem; color: white;"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">Tas Anyaman</h5>
                            <p class="text-muted small">Tas rotan anyaman tangan berkualitas</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">Rp 275.000</span>
                                <button class="btn btn-sm btn-primary-custom">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-couch" style="font-size: 5rem; color: white;"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">Bantal Dekoratif</h5>
                            <p class="text-muted small">Bantal dengan bordir tangan yang indah</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">Rp 125.000</span>
                                <button class="btn btn-sm btn-primary-custom">Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <h2>Siap Memulai Bisnis Kerajinan Anda?</h2>
            <p class="mb-4">Bergabunglah dengan komunitas pengrajin kami dan mulai jual produk Anda hari ini!</p>
            <a href="register.html" class="btn btn-light-custom">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">KraftiQu</h5>
                    <p class="text-muted">Platform manajemen produk untuk UMKM kerajinan tangan Indonesia.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4 footer-links">
                    <h5 class="mb-3">Menu</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#beranda">Beranda</a></li>
                        <li class="mb-2"><a href="#produk">Produk</a></li>
                        <li class="mb-2"><a href="#tentang">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#kontak">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Kontak</h5>
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt me-2"></i>Pekanbaru, Riau<br>
                        <i class="fas fa-phone me-2"></i>+62 812-3456-7890<br>
                        <i class="fas fa-envelope me-2"></i>info@kraftiqu.com
                    </p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-muted">
                <p class="mb-0">&copy; 2024 KraftiQu. Made with ❤️ in Indonesia</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>