<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KraftiQu</title>
    
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
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-white mb-3">Bergabung Bersama Kami</h3>
                    <p class="text-white-50">Daftar sekarang dan kelola produk kerajinan Anda dengan mudah</p>
                </div>
            </div>

            <!-- Right Side - Register Form -->
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

                        <h2 class="auth-title">Buat Akun Baru 🎨</h2>
                        <p class="auth-subtitle">Isi data diri Anda untuk mendaftar</p>

                        <!-- Alert (Hidden by default) -->
                        <div class="alert alert-danger d-none" id="errorAlert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <span id="errorMessage"></span>
                        </div>

                        <!-- Register Form -->
                        <form id="registerForm">
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-custom" id="name" 
                                           placeholder="Nama lengkap Anda" required>
                                </div>
                            </div>

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

                            <!-- No. Telepon -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel" class="form-control form-control-custom" id="phone" 
                                           placeholder="08xxxxxxxxxx" required>
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
                                           placeholder="Minimal 8 karakter" required>
                                    <button class="btn-toggle-password" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Password minimal 8 karakter</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-custom" id="password_confirmation" 
                                           placeholder="Ulangi password" required>
                                    <button class="btn-toggle-password" type="button" id="togglePasswordConfirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya setuju dengan <a href="#" style="color: var(--primary);">Syarat & Ketentuan</a> 
                                    dan <a href="#" style="color: var(--primary);">Kebijakan Privasi</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                            </button>

                            <!-- Divider -->
                            <div class="divider">
                                <span>atau</span>
                            </div>

                            <!-- Social Register -->
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

                            <!-- Login Link -->
                            <p class="text-center mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: var(--primary);">
                                    Masuk Sekarang
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