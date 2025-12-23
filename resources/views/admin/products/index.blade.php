@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <div>
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-box text-primary me-2"></i>Daftar Produk
                    </h5>
                    <small class="text-muted">Kelola produk kerajinan tangan</small>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Produk
                </a>
            </div>

            <div class="card-body">
                <!-- Filter & Search -->
                <form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Cari produk..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="preorder" {{ request('status') == 'preorder' ? 'selected' : '' }}>Pre-Order</option>
                                <option value="sold_out" {{ request('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="stock" class="form-select">
                                <option value="">Semua Stok</option>
                                <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Stok Rendah</option>
                                <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Produk</th>
                                <th width="15%">Kategori</th>
                                <th width="15%">Harga</th>
                                <th width="10%" class="text-center">Stok</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->image_url }}" 
                                             alt="{{ $product->name }}"
                                             class="rounded me-3"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ Str::limit($product->name, 40) }}</h6>
                                            <small class="text-muted">{{ $product->code }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-folder me-1"></i>{{ $product->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong class="text-primary">{{ $product->formatted_price }}</strong>
                                        @if($product->discount_price)
                                            <br>
                                            <small class="text-decoration-line-through text-muted">
                                                {{ $product->formatted_discount_price }}
                                            </small>
                                            <span class="badge bg-danger ms-1">-{{ $product->discount_percentage }}%</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $product->stock < 10 ? 'bg-danger' : 'bg-success' }} rounded-pill">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $product->status_badge }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                           class="btn btn-outline-info"
                                           data-bs-toggle="tooltip" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                                           class="btn btn-outline-warning"
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $product->id }}"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                                Konfirmasi Hapus
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus produk:</p>
                                            <div class="alert alert-light">
                                                <strong>{{ $product->name }}</strong><br>
                                                <small class="text-muted">{{ $product->code }}</small>
                                            </div>
                                            <p class="text-danger small mb-0">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Data yang dihapus tidak dapat dikembalikan!
                                            </p>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash me-1"></i>Hapus Produk
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Belum ada produk</h6>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} produk
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush