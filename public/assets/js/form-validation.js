/**
 * Real-time Form Validation Script
 * File: public/js/form-validation.js
 * 
 * Usage: Tambahkan attribute data-validate="true" di tag <form>
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // FORM SUBMIT VALIDATION
    // ============================================
    
    const forms = document.querySelectorAll('form[data-validate="true"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            let firstError = null;
            
            // Validate all required fields
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                    if (!firstError) {
                        firstError = field;
                    }
                }
            });
            
            // Validate email fields
            const emailFields = form.querySelectorAll('input[type="email"]');
            emailFields.forEach(field => {
                if (field.value && !validateEmail(field.value)) {
                    isValid = false;
                    showError(field, 'Format email tidak valid');
                    if (!firstError) firstError = field;
                }
            });
            
            // Validate number fields
            const numberFields = form.querySelectorAll('input[type="number"]');
            numberFields.forEach(field => {
                if (!validateNumber(field)) {
                    isValid = false;
                    if (!firstError) firstError = field;
                }
            });
            
            // Validate file fields
            const fileFields = form.querySelectorAll('input[type="file"][required]');
            fileFields.forEach(field => {
                if (!validateFile(field)) {
                    isValid = false;
                    if (!firstError) firstError = field;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error
                if (firstError) {
                    firstError.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    
                    // Focus field
                    setTimeout(() => {
                        firstError.focus();
                    }, 500);
                }
                
                // Show alert
                showValidationAlert('Mohon lengkapi semua field yang wajib diisi!');
                
                return false;
            }
        });
    });
    
    // ============================================
    // REAL-TIME VALIDATION (ON BLUR)
    // ============================================
    
    const allFields = document.querySelectorAll('input, textarea, select');
    
    allFields.forEach(field => {
        // Validate on blur
        field.addEventListener('blur', function() {
            if (this.hasAttribute('required') || this.value) {
                validateField(this);
            }
        });
        
        // Clear error on input
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    // ============================================
    // VALIDATION FUNCTIONS
    // ============================================
    
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = getFieldLabel(field);
        const fieldType = field.type;
        
        // Required validation
        if (field.hasAttribute('required')) {
            if (!value || (fieldType === 'file' && field.files.length === 0)) {
                showError(field, fieldName + ' wajib diisi');
                return false;
            }
        }
        
        // Email validation
        if (fieldType === 'email' && value) {
            if (!validateEmail(value)) {
                showError(field, 'Format email tidak valid (contoh: nama@email.com)');
                return false;
            }
        }
        
        // Number validation
        if (fieldType === 'number' && value) {
            if (!validateNumber(field)) {
                return false;
            }
        }
        
        // File validation
        if (fieldType === 'file' && field.files.length > 0) {
            if (!validateFile(field)) {
                return false;
            }
        }
        
        // Password confirmation
        if (field.name === 'password_confirmation') {
            const password = document.querySelector('input[name="password"]');
            if (password && password.value !== value) {
                showError(field, 'Konfirmasi password tidak cocok');
                return false;
            }
        }
        
        clearError(field);
        return true;
    }
    
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    function validateNumber(field) {
        const value = parseFloat(field.value);
        const min = field.getAttribute('min');
        const max = field.getAttribute('max');
        const fieldName = getFieldLabel(field);
        
        if (isNaN(value)) {
            showError(field, fieldName + ' harus berupa angka');
            return false;
        }
        
        if (min !== null && value < parseFloat(min)) {
            showError(field, fieldName + ' tidak boleh kurang dari ' + min);
            return false;
        }
        
        if (max !== null && value > parseFloat(max)) {
            showError(field, fieldName + ' tidak boleh lebih dari ' + max);
            return false;
        }
        
        return true;
    }
    
    function validateFile(field) {
        const files = field.files;
        const fieldName = getFieldLabel(field);
        
        if (files.length === 0 && field.hasAttribute('required')) {
            showError(field, fieldName + ' wajib diupload');
            return false;
        }
        
        // Check file size and type
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const maxSize = 2048 * 1024; // 2MB default
            
            // Get allowed types from accept attribute
            const accept = field.getAttribute('accept');
            if (accept) {
                const allowedTypes = accept.split(',').map(t => t.trim());
                const fileType = file.type;
                const fileExt = '.' + file.name.split('.').pop().toLowerCase();
                
                let isValidType = false;
                allowedTypes.forEach(type => {
                    if (type.includes('*') || type === fileType || type === fileExt) {
                        isValidType = true;
                    }
                });
                
                if (!isValidType) {
                    showError(field, 'Format file tidak didukung. Gunakan: ' + accept);
                    field.value = '';
                    return false;
                }
            }
            
            // Check file size
            if (file.size > maxSize) {
                showError(field, 'Ukuran file ' + file.name + ' terlalu besar! Maksimal 2MB');
                field.value = '';
                return false;
            }
        }
        
        return true;
    }
    
    // ============================================
    // UI HELPER FUNCTIONS
    // ============================================
    
    function showError(field, message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        
        // Remove old error message
        const parent = field.closest('.mb-3') || field.parentElement;
        const oldError = parent.querySelector('.invalid-feedback');
        if (oldError && !oldError.hasAttribute('data-server-error')) {
            oldError.remove();
        }
        
        // Add new error message (only if not from server)
        if (!parent.querySelector('.invalid-feedback[data-server-error]')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback d-block';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + message;
            field.parentElement.appendChild(errorDiv);
        }
    }
    
    function clearError(field) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        
        // Remove client-side errors only
        const parent = field.closest('.mb-3') || field.parentElement;
        const errors = parent.querySelectorAll('.invalid-feedback:not([data-server-error])');
        errors.forEach(error => error.remove());
    }
    
    function getFieldLabel(field) {
        // Try to get label text
        const label = field.closest('.mb-3')?.querySelector('label');
        if (label) {
            return label.textContent.replace(/\*/g, '').trim();
        }
        
        // Fallback to placeholder or name
        return field.getAttribute('placeholder') || field.name || 'Field ini';
    }
    
    function showValidationAlert(message) {
        // Create alert if not exists
        let alert = document.querySelector('.validation-alert');
        if (!alert) {
            alert = document.createElement('div');
            alert.className = 'alert alert-danger validation-alert position-fixed top-0 start-50 translate-middle-x mt-3';
            alert.style.zIndex = '9999';
            alert.style.minWidth = '300px';
            document.body.appendChild(alert);
        }
        
        alert.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Validasi Error:</strong> ${message}
        `;
        alert.style.display = 'block';
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    }
    
    // ============================================
    // SPECIAL VALIDATIONS
    // ============================================
    
    // Discount price validation
    document.querySelectorAll('input[name="discount_price"]').forEach(field => {
        field.addEventListener('blur', function() {
            const priceField = document.querySelector('input[name="price"]');
            if (priceField) {
                const price = parseFloat(priceField.value || 0);
                const discount = parseFloat(this.value || 0);
                
                if (discount > 0 && discount >= price) {
                    showError(this, 'Harga diskon harus lebih kecil dari harga normal');
                    return;
                }
            }
            
            if (this.value) {
                clearError(this);
            }
        });
    });
    
    // Phone number validation
    document.querySelectorAll('input[name="phone"], input[name="customer_phone"]').forEach(field => {
        field.addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        field.addEventListener('blur', function() {
            const value = this.value;
            if (value && (value.length < 10 || value.length > 15)) {
                showError(this, 'Nomor telepon harus 10-15 digit');
            }
        });
    });
    
    // Postal code validation
    document.querySelectorAll('input[name="postal_code"]').forEach(field => {
        field.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        field.addEventListener('blur', function() {
            if (this.value && this.value.length !== 5) {
                showError(this, 'Kode pos harus 5 digit');
            }
        });
    });
    
    // Prevent multiple form submissions
    forms.forEach(form => {
        let isSubmitting = false;
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            
            // If validation passes
            if (!form.querySelector('.is-invalid')) {
                isSubmitting = true;
                
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                    
                    // Reset after 10 seconds (in case of error)
                    setTimeout(() => {
                        isSubmitting = false;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 10000);
                }
            }
        });
    });
});

// ============================================
// MARK SERVER-SIDE ERRORS
// ============================================

// Mark Laravel validation errors as server errors
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.invalid-feedback').forEach(error => {
        error.setAttribute('data-server-error', 'true');
    });
});