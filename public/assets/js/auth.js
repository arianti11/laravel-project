// Toggle Password Visibility
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

if (togglePassword) {
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
}

// Toggle Password Confirmation Visibility (for register page)
const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
const passwordConfirmInput = document.getElementById('password_confirmation');

if (togglePasswordConfirm) {
    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmInput.setAttribute('type', type);
        
        // Toggle icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
}

// Login Form Handler
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const remember = document.getElementById('remember').checked;
        
        // Validasi
        if (!email || !password) {
            showError('Email dan password harus diisi!');
            return;
        }
        
        // Simulasi login (nanti diganti dengan Laravel)
        console.log('Login attempt:', { email, password, remember });
        
        // Success simulation
        alert('Login berhasil! (Demo)');
        // window.location.href = 'dashboard.html'; // Redirect ke dashboard
    });
}

// Register Form Handler
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        const terms = document.getElementById('terms').checked;
        
        // Validasi
        if (!name || !email || !phone || !password || !passwordConfirm) {
            showError('Semua field harus diisi!');
            return;
        }
        
        if (password.length < 8) {
            showError('Password minimal 8 karakter!');
            return;
        }
        
        if (password !== passwordConfirm) {
            showError('Password dan konfirmasi password tidak sama!');
            return;
        }
        
        if (!terms) {
            showError('Anda harus menyetujui syarat dan ketentuan!');
            return;
        }
        
        // Validasi email format
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            showError('Format email tidak valid!');
            return;
        }
        
        // Validasi phone number (Indonesia)
        const phonePattern = /^08\d{8,11}$/;
        if (!phonePattern.test(phone)) {
            showError('Format nomor telepon tidak valid! (contoh: 08xxxxxxxxxx)');
            return;
        }
        
        // Simulasi register (nanti diganti dengan Laravel)
        console.log('Register attempt:', { name, email, phone, password });
        
        // Success simulation
        alert('Registrasi berhasil! Silakan login. (Demo)');
        window.location.href = 'login.html';
    });
}

// Show Error Alert
function showError(message) {
    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorMessage');
    
    if (errorAlert && errorMessage) {
        errorMessage.textContent = message;
        errorAlert.classList.remove('d-none');
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            errorAlert.classList.add('d-none');
        }, 5000);
    }
}

// Hide alert on input
const formInputs = document.querySelectorAll('.form-control-custom');
formInputs.forEach(input => {
    input.addEventListener('input', function() {
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert && !errorAlert.classList.contains('d-none')) {
            errorAlert.classList.add('d-none');
        }
    });
});