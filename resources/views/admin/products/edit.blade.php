@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-pencil-square me-2"></i>Edit Product</h3>
                </div>
                
                <div class="card-body">
                    
                    <!-- Product Information Section -->
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-info-circle text-warning me-2"></i>Product Information
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ $product->name }}" placeholder="e.g., Royal Kundan Necklace" required>
                                <small class="text-muted">This will be displayed on your website</small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="2" placeholder="Brief summary for product cards and previews">{{ $product->short_description }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Full Description</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Detailed product description, features, and specifications">{{ $product->description }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Material</label>
                                <select name="material" class="form-select">
                                    <option value="">Select Material</option>
                                    @foreach(\App\Enums\ProductMaterial::cases() as $material)
                                        <option value="{{ $material->value }}" {{ ($product->material === $material || (is_string($product->material) && $product->material == $material->value)) ? 'selected' : '' }}>{{ $material->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Weight (g)</label>
                                <input type="number" name="weight" class="form-control" step="0.01" value="{{ $product->weight }}" placeholder="0.00">
                                <small class="text-muted">Product weight in grams</small>
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-image text-warning me-2"></i>Media
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Thumbnail</label>
                                <div class="image-upload-zone p-4 border border-2 border-dashed rounded text-center position-relative bg-light" id="dropZone" style="min-height: 250px;">
                                    <div class="default-view {{ $product->thumbnail ? 'd-none' : '' }}" id="defaultView">
                                        <i class="bi bi-cloud-arrow-up fs-1 text-warning mb-3 d-block"></i>
                                        <p class="mb-1 fw-bold">Drag & drop image here</p>
                                        <p class="text-muted small">or click to browse</p>
                                        <p class="text-muted small">Recommended: 800x1000px, JPG or PNG</p>
                                        <input type="file" name="image" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" id="imageInput" accept="image/*" style="cursor: pointer;">
                                    </div>
                                    <div class="preview-view {{ $product->thumbnail ? '' : 'd-none' }}" id="previewView">
                                        <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : '' }}" id="imagePreview" class="img-fluid rounded border mb-3" style="max-height: 200px;">
                                        <br>
                                        <button type="button" class="btn btn-sm btn-danger" id="removeImageBtn">
                                            <i class="bi bi-trash"></i> Remove Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Inventory Section -->
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-currency-rupee text-warning me-2"></i>Pricing & Inventory
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Regular Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="regularPrice" class="form-control form-control-lg" step="0.01" value="{{ $product->price }}" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sale Discount (%)</label>
                                @php
                                    $discount = 0;
                                    if ($product->price > 0 && $product->sale_price > 0 && $product->sale_price < $product->price) {
                                        $discount = (($product->price - $product->sale_price) / $product->price) * 100;
                                    }
                                @endphp
                                <input type="number" name="sale_discount" id="saleDiscount" class="form-control form-control-lg" step="0.01" min="0" max="100" value="{{ number_format($discount, 2, '.', '') }}" placeholder="0">
                                <small class="text-muted">Enter discount percentage (0-100)</small>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="bi bi-calculator me-2"></i>
                                    <div>
                                        <strong>Sale Price:</strong> <span id="calculatedPrice" class="fs-5 ms-2">₹ {{ number_format($product->sale_price ?: $product->price, 2) }}</span>
                                        <small class="d-block text-muted">Auto-calculated based on discount</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">SKU <span class="text-danger">*</span></label>
                                <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" placeholder="e.g., RG-NK-001" required>
                                <small class="text-muted">Unique product identifier</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Stock Status</label>
                                <select name="stock_status" class="form-select">
                                    <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="outofstock" {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out Of Stock</option>
                                    <option value="onbackorder" {{ $product->stock_status == 'onbackorder' ? 'selected' : '' }}>On Backorder</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Organization Section -->
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-collection text-warning me-2"></i>Organization
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Categories <span class="text-danger">*</span></label>
                                @php $selectedCategories = $product->categories->pluck('id')->toArray(); @endphp
                                <select name="categories[]" id="categorySelect" class="form-select" multiple required size="8" style="height: auto;">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCategories) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @foreach($cat->children as $child)
                                            <option value="{{ $child->id }}" {{ in_array($child->id, $selectedCategories) ? 'selected' : '' }}>&nbsp;&nbsp;└─ {{ $child->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple categories</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status & Visibility</label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isActive">
                                                <strong>Active / Published</strong>
                                                <small class="d-block text-muted">Make this product visible on website</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" role="switch" id="isTrending" name="is_trending" {{ $product->is_trending ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isTrending">
                                                <strong>Trending Product</strong>
                                                <small class="d-block text-muted">Display in Trending Masterpieces section on homepage</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings Section -->
                    <div class="mb-3">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-search text-warning me-2"></i>SEO Settings
                            <small class="text-muted fw-normal">(Optional but recommended)</small>
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" maxlength="60" value="{{ $product->meta_title }}" placeholder="SEO-friendly title">
                                <small class="text-muted">Max 60 characters for best results</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" value="{{ $product->meta_keywords }}" placeholder="gold, necklace, jewelry">
                                <small class="text-muted">Comma-separated keywords</small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2" maxlength="160" placeholder="Brief description for search engines">{{ $product->meta_description }}</textarea>
                                <small class="text-muted">Max 160 characters recommended</small>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-warning btn-lg px-5">
                        <i class="bi bi-check-circle me-2"></i>Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg ms-2">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- JavaScript for Image Upload and Price Calculation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Upload Functionality
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const defaultView = document.getElementById('defaultView');
    const previewView = document.getElementById('previewView');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageBtn = document.getElementById('removeImageBtn');

    imageInput.addEventListener('change', function(e) {
        const file = this.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                defaultView.classList.add('d-none');
                previewView.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-warning');
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-warning');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-warning');
    });

    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        defaultView.classList.remove('d-none');
        previewView.classList.add('d-none');
        imagePreview.src = '';
    });

    // Price Calculation
    const regularPriceInput = document.getElementById('regularPrice');
    const discountInput = document.getElementById('saleDiscount');
    const calculatedPriceSpan = document.getElementById('calculatedPrice');

    function calculateSalePrice() {
        const price = parseFloat(regularPriceInput.value) || 0;
        const discount = parseFloat(discountInput.value) || 0;
        
        if (price > 0 && discount > 0 && discount <= 100) {
            const salePrice = price * (1 - discount / 100);
            calculatedPriceSpan.textContent = '₹ ' + salePrice.toFixed(2);
            calculatedPriceSpan.classList.add('text-success', 'fw-bold');
        } else {
            calculatedPriceSpan.textContent = '₹ ' + price.toFixed(2);
            calculatedPriceSpan.classList.remove('text-success', 'fw-bold');
        }
    }


    regularPriceInput.addEventListener('input', calculateSalePrice);
    discountInput.addEventListener('input', calculateSalePrice);
});
</script>
@endsection
