@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <div class="col-12">
             <!-- Tabs -->
            <div class="card card-primary card-outline card-tabs mb-4">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-bs-toggle="pill" href="#general" role="tab">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pricing-tab" data-bs-toggle="pill" href="#pricing" role="tab">Pricing & Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="seo-tab" data-bs-toggle="pill" href="#seo" role="tab">SEO</a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content">
                        
                        <!-- General Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Full Description</label>
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                     <div class="mb-3">
                                        <label class="form-label">Product Type</label>
                                        <select name="product_type" class="form-select">
                                            <option value="simple">Simple Product</option>
                                            <option value="digital">Digital Product</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="is_active" checked>
                                            <label class="form-check-label" for="isActive">Active / Published</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Categories</label>
                                        <div class="card p-2" style="max-height: 200px; overflow-y: auto;">
                                            @foreach($categories as $cat)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $cat->id }}" id="cat{{ $cat->id }}">
                                                    <label class="form-check-label" for="cat{{ $cat->id }}">{{ $cat->name }}</label>
                                                </div>
                                                @foreach($cat->children as $child)
                                                     <div class="form-check ms-3">
                                                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $child->id }}" id="cat{{ $child->id }}">
                                                        <label class="form-check-label" for="cat{{ $child->id }}">-- {{ $child->name }}</label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                     <div class="mb-3">
                                        <label class="form-label">Thumbnail</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing Tab -->
                        <div class="tab-pane fade" id="pricing" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                     <label class="form-label">Regular Price <span class="text-danger">*</span></label>
                                     <input type="number" name="price" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Sale Price</label>
                                     <input type="number" name="sale_price" class="form-control" step="0.01">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sale Start Date</label>
                                    <input type="datetime-local" name="sale_start" class="form-control">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Sale End Date</label>
                                    <input type="datetime-local" name="sale_end" class="form-control">
                                </div>
                                <div class="col-12"><hr></div>
                                <div class="col-md-6">
                                     <label class="form-label">SKU</label>
                                     <input type="text" name="sku" class="form-control">
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Stock Status</label>
                                     <select name="stock_status" class="form-select">
                                         <option value="instock">In Stock</option>
                                         <option value="outofstock">Out Of Stock</option>
                                         <option value="onbackorder">On Backorder</option>
                                     </select>
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Quantity</label>
                                     <input type="number" name="stock_quantity" class="form-control" value="0">
                                </div>
                                <div class="col-md-6 pt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="manage_stock" id="manageStock" value="1" checked>
                                        <label class="form-check-label" for="manageStock">Manage Stock Level (Decrements on sale)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Tab -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                             <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control">
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" placeholder="comma, separated, keywords">
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save"></i> Publish Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg ms-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
