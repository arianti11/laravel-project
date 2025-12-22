<footer class="footer px-4 border-top">
    <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
        <div class="col-md-4 d-flex align-items-center">
            <span class="text-body-secondary">
                © {{ date('Y') }} 
                <a href="{{ url('/') }}" class="text-decoration-none text-body-secondary">KraftiQu</a>
            </span>
        </div>

        <div class="col-md-4 text-center">
            <span class="text-body-secondary">
                Made with <i class="fas fa-heart text-danger"></i> in Indonesia
            </span>
        </div>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item">
                <a href="#" class="nav-link px-2 text-body-secondary">
                    <i class="fas fa-question-circle me-1"></i>Bantuan
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link px-2 text-body-secondary">
                    <i class="fas fa-book me-1"></i>Dokumentasi
                </a>
            </li>
        </ul>
    </div>
</footer>