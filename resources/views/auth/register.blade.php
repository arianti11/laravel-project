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
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="row g-0 h-100">
            <!-- Left Side - Image/Illustration -->
            <div class="col-lg-6 d-none d-lg-block auth-left">
                <div class="auth-left-content">
                    <div class="logo-container">
                        <a href="{{ url('/') }}" class="text-white text-decoration-none">
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
                            <a href="{{ url('/') }}" class="text-decoration-none">
                                <h3 style="color: var(--primary);">
                                    <i class="fas fa-hand-sparkles"></i> KraftiQu
                                </h3>
                            </a>
                        </div>

                        <h2 class="auth-title">Buat Akun Baru 🎨</h2>
                        <p class="auth-subtitle">Isi data diri Anda untuk mendaftar</p>

                        <!-- Alert Error -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                        @endif

                        <!-- Register Form -->
                        <form action="{{ route('register') }}" method="POST" data-validate="true"> 
                            @csrf
                            
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-custom @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Nama lengkap Anda" 
                                           required>
                                </div>
                                @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control form-control-custom @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="nama@email.com" 
                                           required>
                                </div>
                                @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No. Telepon -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel" 
                                           class="form-control form-control-custom @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           placeholder="08xxxxxxxxxx" 
                                           required>
                                </div>
                                @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Contoh: 08123456789</small>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group position-relative">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control form-control-custom @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password"
                                           placeholder="Minimal 8 karakter" 
                                           required>
                                    <button class="btn-toggle-password" type="button" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Password minimal 8 karakter</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group position-relative">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control form-control-custom" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           placeholder="Ulangi password" 
                                           required>
                                    <button class="btn-toggle-password" type="button" onclick="togglePasswordConfirm()">
                                        <i class="fas fa-eye" id="toggleIconConfirm"></i>
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
    <script src="{{ asset('js/form-validation.js') }}"></script>
    
    <!-- Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function togglePasswordConfirm() {
            const passwordInput = document.getElementById('password_confirmation');
            const toggleIcon = document.getElementById('toggleIconConfirm');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>