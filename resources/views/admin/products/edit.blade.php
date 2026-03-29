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
                    <div class="card card-outline card-warning mt-4">
                        <div class="card-header">
                            <h3 class="card-title fw-bold"><i class="bi bi-info-circle me-2"></i>Product Information</h3>
                        </div>
                        <div class="card-body">
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
                    </div>

                    <!-- Media Section -->
                    <div class="card card-outline card-warning mt-4">
                        <div class="card-header">
                            <h3 class="card-title fw-bold"><i class="bi bi-images me-2"></i>Media Gallery</h3>
                        </div>
                        <div class="card-body">
                        
                        <input type="hidden" name="primary_type" id="primaryType" value="existing">
                        <input type="hidden" name="primary_image_id" id="primaryImageId" value="{{ $product->images->where('is_primary', true)->first()->id ?? '' }}">
                        <input type="hidden" name="primary_image_index" id="primaryImageIndex" value="">

                        <!-- Existing Images -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Current Images</label>
                            @if($product->images->count() > 0)
                                <div class="row g-3" id="existingImagesContainer">
                                    @foreach($product->images as $image)
                                        <div class="col-6 col-md-3 col-lg-2">
                                            <div class="card h-100 preview-card border-0 shadow-sm position-relative overflow-hidden {{ $image->is_primary ? 'ring-primary' : '' }}" id="existing_card_{{ $image->id }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                                <div class="card-img-overlay d-flex flex-column justify-content-between p-2">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-sm {{ $image->is_primary ? 'btn-primary' : 'btn-dark opacity-75' }} primary-btn" onclick="setExistingAsPrimary({{ $image->id }}, this)">
                                                            {{ $image->is_primary ? 'Cover' : 'Make Cover' }}
                                                        </button>
                                                    </div>
                                                    <div class="text-start">
                                                        <div class="form-check">
                                                            <input class="form-check-input bg-danger border-danger" type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}" id="del_{{ $image->id }}" onchange="handleDeleteCheck({{ $image->id }}, this)">
                                                            <label class="form-check-label text-white small fw-bold" for="del_{{ $image->id }}" style="text-shadow: 0 0 3px rgba(0,0,0,0.8)">Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">No images uploaded for this product.</div>
                            @endif
                        </div>

                        <!-- Add New Images -->
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Add New Images</label>
                                <div class="image-upload-zone p-4 border border-2 border-dashed rounded text-center position-relative bg-light" id="dropZone" style="min-height: 200px;">
                                    <div class="default-view" id="defaultView">
                                        <i class="bi bi-cloud-plus fs-1 text-secondary mb-3 d-block"></i>
                                        <p class="mb-1 fw-bold">Drag & drop new images here</p>
                                        <p class="text-muted small">or click to browse</p>
                                        <input type="file" name="new_images[]" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" id="imageInput" accept="image/*" multiple style="cursor: pointer;">
                                    </div>
                                    <div class="preview-view d-none" id="previewView">
                                        <div class="row g-3 justify-content-center" id="imagePreviewContainer"></div>
                                        <div class="mt-4 pt-3 border-top text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger" id="removeImageBtn">
                                                <i class="bi bi-x-circle"></i> Clear New Selections
                                            </button>
                                            <small class="text-muted ms-3"><i class="bi bi-info-circle me-1"></i>You can also select a new image as cover</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- Pricing & Inventory Section -->
                    <div class="card card-outline card-warning mt-4">
                        <div class="card-header">
                            <h3 class="card-title fw-bold"><i class="bi bi-currency-rupee me-2"></i>Pricing & Inventory</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Regular Price (₹) <span class="text-danger">*</span></label>
                                    @if($hidePrices)
                                        <input type="number" name="price" id="regularPrice" class="form-control form-control-lg bg-light" step="0.01" value="{{ $product->price > 0 ? $product->price : 1 }}" readonly required>
                                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Price defaults to 1 because prices are globally hidden.</small>
                                    @else
                                        <input type="number" name="price" id="regularPrice" class="form-control form-control-lg" step="0.01" value="{{ $product->price }}" placeholder="0.00" required>
                                    @endif
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
                    </div>

                    <!-- Organization Section -->
                    <div class="card card-outline card-warning mt-4">
                        <div class="card-header">
                            <h3 class="card-title fw-bold"><i class="bi bi-collection me-2"></i>Organization</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Categories <span class="text-danger">*</span></label>
                                @php $selectedCategories = $product->categories->pluck('id')->toArray(); @endphp
                                <select name="categories[]" id="categorySelect" class="form-select" multiple required size="8" style="height: auto;">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->children->isNotEmpty() ? 'disabled' : '' }} class="{{ $cat->children->isNotEmpty() ? 'fw-bold text-dark' : '' }}" {{ in_array($cat->id, $selectedCategories) ? 'selected' : '' }}>
                                            {{ $cat->name }} {{ $cat->children->isNotEmpty() ? '(Parent)' : '' }}
                                        </option>
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
                    </div>

                    <!-- SEO Settings Section (Hidden for production for now) -->
                    {{-- @include('admin.partials._seo_fields', ['seoMeta' => $product->seoMeta ?? new \App\Models\SeoMeta()]) --}}

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
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const removeImageBtn = document.getElementById('removeImageBtn');

    imageInput.addEventListener('change', function(e) {
        const files = this.files;
        if(files.length > 0) {
            imagePreviewContainer.innerHTML = ''; // Clear existing
            defaultView.classList.add('d-none');
            previewView.classList.remove('d-none');

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-3 col-lg-2';
                    col.innerHTML = `
                         <div class="card h-100 preview-card-new border-0 shadow-sm position-relative overflow-hidden" data-index="${index}" onclick="setNewAsPrimary(${index}, this)">
                            <img src="${e.target.result}" class="card-img-top" style="height: 120px; object-fit: cover;">
                            <div class="card-img-overlay d-flex flex-column justify-content-between p-2">
                                <div class="text-end">
                                    <span class="badge bg-dark opacity-75 primary-badge">Make Cover</span>
                                </div>
                                <div class="text-start">
                                    <span class="badge bg-success" style="font-size: 0.6rem;">New</span>
                                </div>
                            </div>
                        </div>
                    `;
                    imagePreviewContainer.appendChild(col);
                }
                reader.readAsDataURL(file);
            });
        }
    });

    window.setExistingAsPrimary = function(id, element) {
        document.getElementById('primaryType').value = 'existing';
        document.getElementById('primaryImageId').value = id;
        document.getElementById('primaryImageIndex').value = '';

        clearAllPrimaryStates();
        
        const card = document.getElementById(`existing_card_${id}`);
        card.classList.add('ring-primary');
        const btn = card.querySelector('.primary-btn');
        btn.classList.remove('btn-dark', 'opacity-75');
        btn.classList.add('btn-primary');
        btn.innerText = 'Cover';
    };

    window.setNewAsPrimary = function(index, element) {
        document.getElementById('primaryType').value = 'new';
        document.getElementById('primaryImageId').value = '';
        document.getElementById('primaryImageIndex').value = index;

        clearAllPrimaryStates();

        element.classList.add('ring-primary');
        const badge = element.querySelector('.primary-badge');
        badge.classList.remove('bg-dark', 'opacity-75');
        badge.classList.add('bg-primary');
        badge.innerText = 'Cover';
    };

    function clearAllPrimaryStates() {
        // Clear existing
        document.querySelectorAll('#existingImagesContainer .preview-card').forEach(card => {
            card.classList.remove('ring-primary');
            const btn = card.querySelector('.primary-btn');
            if (btn) {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-dark', 'opacity-75');
                btn.innerText = 'Make Cover';
            }
        });

        // Clear new
        document.querySelectorAll('#imagePreviewContainer .preview-card-new').forEach(card => {
            card.classList.remove('ring-primary');
            const badge = card.querySelector('.primary-badge');
            if (badge) {
                badge.classList.remove('bg-primary');
                badge.classList.add('bg-dark', 'opacity-75');
                badge.innerText = 'Make Cover';
            }
        });
    }

    window.handleDeleteCheck = function(id, checkbox) {
        const card = document.getElementById(`existing_card_${id}`);
        if (checkbox.checked) {
            card.classList.add('opacity-50');
            card.style.filter = 'grayscale(1)';
        } else {
            card.classList.remove('opacity-50');
            card.style.filter = 'none';
        }
    };

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
        imagePreviewContainer.innerHTML = '';
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
