@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="card mb-4 card-outline card-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
             <h3 class="card-title"><i class="bi bi-box-seam me-2"></i>All Products</h3>
             <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Product
            </a>
        </div>
        
        <!-- Filters -->
        <form action="{{ route('admin.products.index') }}" method="GET" class="mt-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Name or SKU..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                         @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary btn-sm me-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">Image</th>
                    <th>Product</th>
                    <th style="width: 120px;">Material</th>
                    <th style="width: 150px;">Price</th>
                    <th style="width: 130px;" class="text-center">Stock</th>
                    <th style="width: 100px;" class="text-center">Status</th>
                    <th style="width: 120px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->primary_image }}" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $product->name }}">
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ Str::limit($product->name, 40) }}</div>
                        <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                    </td>
                    <td>
                        @if($product->material)
                            <span class="badge bg-secondary">{{ $product->material }}</span>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <div class="text-success fw-bold">₹{{ number_format($product->sale_price, 0) }}</div>
                            <small class="text-decoration-line-through text-muted">₹{{ number_format($product->price, 0) }}</small>
                        @else
                             <div class="fw-bold">₹{{ number_format($product->price, 0) }}</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($product->stock_status == 'instock')
                            <span class="badge text-bg-success">In Stock</span>
                        @elseif($product->stock_status == 'outofstock')
                            <span class="badge text-bg-danger">Out of Stock</span>
                        @else
                            <span class="badge text-bg-warning">Backorder</span>
                        @endif
                    </td>
                    <td class="text-center">
                         @if($product->is_active)
                            <span class="badge text-bg-success"><i class="bi bi-check-circle"></i> Active</span>
                        @else
                            <span class="badge text-bg-secondary"><i class="bi bi-x-circle"></i> Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-info" href="{{ route('admin.products.edit', $product->id) }}" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-danger" title="Delete"
                                onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}', 'Delete this product?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted mb-0">No products found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
