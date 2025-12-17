<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KraftiQu</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="assets/css/auth.css" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="row g-0 h-100">
            <!-- Left Side - Image/Illustration -->
            <div class="col-lg-6 d-none d-lg-block auth-left">
                <div class="auth-left-content">
                    <div class="logo-container">
                        <a href="index.html" class="text-white text-decoration-none">
                            <h2><i class="fas fa-hand-sparkles"></i> KraftiQu</h2>
                        </a>
                    </div>
                    <div class="auth-illustration">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3 class="text-white mb-3">Kelola Produk Kerajinan Anda</h3>
                    <p class="text-white-50">Platform manajemen produk UMKM untuk pengrajin Indonesia</p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="col-lg-6">
                <div class="auth-right">
                    <div class="auth-form-container">
                        <!-- Mobile Logo -->
                        <div class="d-lg-none text-center mb-4">
                            <a href="index.html" class="text-decoration-none">
                                <h3 style="color: var(--primary);">
                                    <i class="fas fa-hand-sparkles"></i> KraftiQu
                                </h3>
                            </a>
                        </div>

                        <h2 class="auth-title">Selamat Datang! 👋</h2>
                        <p class="auth-subtitle">Masuk ke akun Anda untuk melanjutkan</p>

                        <!-- Alert (Hidden by default) -->
                        <div class="alert alert-danger d-none" id="errorAlert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <span id="errorMessage"></span>
                        </div>

                        <!-- Login Form -->
                        <form id="loginForm">
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control form-control-custom" id="email" 
                                           placeholder="nama@email.com" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-custom" id="password" 
                                           placeholder="Masukkan password" required>
                                    <button class="btn-toggle-password" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat Saya
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none" style="color: var(--primary);">
                                    Lupa Password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                                
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                            </button>

                            <!-- Divider -->
                            <div class="divider">
                                <span>atau</span>
                            </div>

                            <!-- Social Login -->
                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <button type="button" class="btn btn-social w-100">
                                        <i class="fab fa-google me-2"></i>Google
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-social w-100">
                                        <i class="fab fa-facebook-f me-2"></i>Facebook
                                    </button>
                                </div>
                            </div>

                            <!-- Register Link -->
                            <p class="text-center mb-0">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: var(--primary);">
                                    Daftar Sekarang
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/auth.js"></script>
</body>
</html>