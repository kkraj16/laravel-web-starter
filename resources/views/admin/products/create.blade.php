@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-plus-circle me-2"></i>Add New Product</h3>
                </div>
                
                <div class="card-body">
                    
                    <!-- Product Information Section -->
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-info-circle text-primary me-2"></i>Product Information
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="e.g., Royal Kundan Necklace" required>
                                <small class="text-muted">This will be displayed on your website</small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="2" placeholder="Brief summary for product cards and previews"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Full Description</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Detailed product description, features, and specifications"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Material</label>
                                <select name="material" class="form-select">
                                    <option value="">Select Material</option>
                                    @foreach(\App\Enums\ProductMaterial::cases() as $material)
                                        <option value="{{ $material->value }}">{{ $material->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Weight (g)</label>
                                <input type="number" name="weight" class="form-control" step="0.01" placeholder="0.00">
                                <small class="text-muted">Product weight in grams</small>
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-image text-primary me-2"></i>Media
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Thumbnail <span class="text-danger">*</span></label>
                                <div class="image-upload-zone p-4 border border-2 border-dashed rounded text-center position-relative bg-light" id="dropZone" style="min-height: 250px;">
                                    <div class="default-view" id="defaultView">
                                        <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-3 d-block"></i>
                                        <p class="mb-1 fw-bold">Drag & drop image here</p>
                                        <p class="text-muted small">or click to browse</p>
                                        <p class="text-muted small">Recommended: 800x1000px, JPG or PNG</p>
                                        <input type="file" name="image" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" id="imageInput" accept="image/*" style="cursor: pointer;" required>
                                    </div>
                                    <div class="preview-view d-none" id="previewView">
                                        <img src="" id="imagePreview" class="img-fluid rounded border mb-3" style="max-height: 200px;">
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
                            <i class="bi bi-currency-rupee text-primary me-2"></i>Pricing & Inventory
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Regular Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="regularPrice" class="form-control form-control-lg" step="0.01" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sale Discount (%)</label>
                                <input type="number" name="sale_discount" id="saleDiscount" class="form-control form-control-lg" step="0.01" min="0" max="100" placeholder="0">
                                <small class="text-muted">Enter discount percentage (0-100)</small>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="bi bi-calculator me-2"></i>
                                    <div>
                                        <strong>Sale Price:</strong> <span id="calculatedPrice" class="fs-5 ms-2">₹ 0.00</span>
                                        <small class="d-block text-muted">Auto-calculated based on discount</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">SKU <span class="text-danger">*</span></label>
                                <input type="text" name="sku" class="form-control" placeholder="e.g., RG-NK-001" required>
                                <small class="text-muted">Unique product identifier</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Stock Status</label>
                                <select name="stock_status" class="form-select">
                                    <option value="instock">In Stock</option>
                                    <option value="outofstock">Out Of Stock</option>
                                    <option value="onbackorder">On Backorder</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Organization Section -->
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="bi bi-collection text-primary me-2"></i>Organization
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Categories <span class="text-danger">*</span></label>
                                <select name="categories[]" id="categorySelect" class="form-select" multiple required size="8" style="height: auto;">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @foreach($cat->children as $child)
                                            <option value="{{ $child->id }}">&nbsp;&nbsp;└─ {{ $child->name }}</option>
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
                                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="is_active" checked>
                                            <label class="form-check-label" for="isActive">
                                                <strong>Active / Published</strong>
                                                <small class="d-block text-muted">Make this product visible on website</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" role="switch" id="isTrending" name="is_trending">
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
                            <i class="bi bi-search text-primary me-2"></i>SEO Settings
                            <small class="text-muted fw-normal">(Optional but recommended)</small>
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" maxlength="60" placeholder="SEO-friendly title">
                                <small class="text-muted">Max 60 characters for best results</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" placeholder="gold, necklace, jewelry">
                                <small class="text-muted">Comma-separated keywords</small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2" maxlength="160" placeholder="Brief description for search engines"></textarea>
                                <small class="text-muted">Max 160 characters recommended</small>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-check-circle me-2"></i>Publish Product
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
        dropZone.classList.add('border-primary');
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-primary');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary');
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
