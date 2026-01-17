@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="card mb-4 card-outline card-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
             <h3 class="card-title">All Products</h3>
             <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Product
            </a>
        </div>
        
        <!-- Filters -->
        <form action="{{ route('admin.products.index') }}" method="GET" class="mt-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Name or SKU" value="{{ request('search') }}">
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
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary btn-sm w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 80px">Image</th>
                    <th>Name / SKU</th>
                    <th>Type</th>
                    <th>Categories</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <img src="{{ $product->primary_image }}" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>
                        <div class="fw-bold">{{ $product->name }}</div>
                        <small class="text-secondary">{{ $product->sku ?? 'N/A' }}</small>
                    </td>
                    <td>
                        @if($product->product_type == 'variable')
                            <span class="badge text-bg-info">Variable</span>
                        @elseif($product->product_type == 'digital')
                            <span class="badge text-bg-warning">Digital</span>
                        @else
                            <span class="badge text-bg-secondary">Simple</span>
                        @endif
                    </td>
                    <td>
                        @foreach($product->categories as $cat)
                            <span class="badge bg-light text-dark border">{{ $cat->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($product->sale_price)
                            <span class="text-danger fw-bold">₹{{ $product->sale_price }}</span>
                            <small class="text-decoration-line-through text-muted ms-1">₹{{ $product->price }}</small>
                        @else
                             <span class="fw-bold">₹{{ $product->price }}</span>
                        @endif
                    </td>
                    <td>
                        @if($product->manage_stock)
                             {{ $product->stock_quantity }}
                        @else
                             <span class="text-muted">Unmanaged</span>
                        @endif
                    </td>
                    <td class="text-center">
                         @if($product->is_active)
                            <span class="badge text-bg-success">Active</span>
                        @else
                            <span class="badge text-bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-info" href="{{ route('admin.products.edit', $product->id) }}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-danger rounded-start-0" 
                                onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}', 'Warning: This product may appear in past orders & reports.')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-secondary">No products found.</td>
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
