@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-12">
             <!-- Tabs -->
            <div class="card card-warning card-outline card-tabs mb-4">
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
                                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="2">{{ $product->short_description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Full Description</label>
                                        <textarea name="description" class="form-control" rows="5">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Material</label>
                                            <select name="material" class="form-select">
                                                <option value="">Select Material</option>
                                                @foreach(\App\Enums\ProductMaterial::cases() as $material)
                                                    <option value="{{ $material->value }}" {{ $product->material === $material || (is_string($product->material) && $product->material == $material->value) ? 'selected' : '' }}>{{ $material->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Purity</label>
                                            <select name="purity" class="form-select">
                                                <option value="">Select Purity</option>
                                                @foreach(\App\Enums\ProductPurity::cases() as $purity)
                                                    <option value="{{ $purity->value }}" {{ $product->purity === $purity || (is_string($product->purity) && $product->purity == $purity->value) ? 'selected' : '' }}>{{ $purity->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Weight (g)</label>
                                            <input type="number" name="weight" class="form-control" step="0.01" value="{{ $product->weight }}" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                     <div class="mb-3">
                                        <label class="form-label">Product Type</label>
                                        <select name="product_type" class="form-select">
                                            <option value="simple" {{ $product->product_type == 'simple' ? 'selected' : '' }}>Simple Product</option>
                                            <option value="digital" {{ $product->product_type == 'digital' ? 'selected' : '' }}>Digital Product</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status & Visibility</label>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isActive">Active / Published</label>
                                        </div>
                                         <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" role="switch" id="isTrending" name="is_trending" {{ $product->is_trending ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isTrending">Mark as Trending</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Categories</label>
                                        <select name="categories[]" class="form-select" multiple size="5">
                                            @php $selectedCats = $product->categories->pluck('id')->toArray(); @endphp
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @foreach($cat->children as $child)
                                                    <option value="{{ $child->id }}" {{ in_array($child->id, $selectedCats) ? 'selected' : '' }}>-- {{ $child->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hold Cmd/Ctrl to select multiple</small>
                                    </div>
                                     <div class="mb-3">
                                        <label class="form-label">Thumbnail</label>
                                        <div class="image-upload-zone p-4 border border-2 border-dashed rounded text-center position-relative" id="dropZone">
                                            <div class="default-view {{ $product->thumbnail ? 'd-none' : '' }}" id="defaultView">
                                                <i class="bi bi-cloud-arrow-up fs-1 text-secondary"></i>
                                                <p class="mb-1">Drag & drop image here or click to upload</p>
                                                <input type="file" name="image" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" id="imageInput" accept="image/*" style="cursor: pointer;">
                                            </div>
                                            <div class="preview-view {{ $product->thumbnail ? '' : 'd-none' }}" id="previewView">
                                                <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : '' }}" id="imagePreview" class="img-fluid rounded border mb-2" style="max-height: 200px;">
                                                <br>
                                                <button type="button" class="btn btn-sm btn-danger" id="removeImageBtn">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const dropZone = document.getElementById('dropZone');
                                            const imageInput = document.getElementById('imageInput');
                                            const defaultView = document.getElementById('defaultView');
                                            const previewView = document.getElementById('previewView');
                                            const imagePreview = document.getElementById('imagePreview');
                                            const removeImageBtn = document.getElementById('removeImageBtn');

                                            // Handle file selection
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
                                            
                                            // Handle Existing Image case (if any logic needed)

                                            // Highlight drop zone
                                            dropZone.addEventListener('dragover', (e) => {
                                                e.preventDefault();
                                                dropZone.classList.add('bg-light');
                                            });
                                            
                                            dropZone.addEventListener('dragleave', (e) => {
                                                dropZone.classList.remove('bg-light');
                                            });
                                            
                                            dropZone.addEventListener('drop', (e) => {
                                                e.preventDefault();
                                                dropZone.classList.remove('bg-light');
                                            });

                                            // Remove image
                                            removeImageBtn.addEventListener('click', function() {
                                                imageInput.value = ''; // clear input
                                                // If there was an existing image, clearing this input won't delete it from server unless we handle that.
                                                // For now, it just clears the selection/preview.
                                                // If we want to delete existing, we might need a hidden input 'remove_image' = 1.
                                                
                                                defaultView.classList.remove('d-none');
                                                previewView.classList.add('d-none');
                                                imagePreview.src = '';
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing Tab -->
                        <div class="tab-pane fade" id="pricing" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                     <label class="form-label">Regular Price <span class="text-danger">*</span></label>
                                     <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Sale Price</label>
                                     <input type="number" name="sale_price" class="form-control" step="0.01" value="{{ $product->sale_price }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sale Start Date</label>
                                    <input type="datetime-local" name="sale_start" class="form-control" value="{{ $product->sale_start }}">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Sale End Date</label>
                                    <input type="datetime-local" name="sale_end" class="form-control" value="{{ $product->sale_end }}">
                                </div>
                                <div class="col-12"><hr></div>
                                <div class="col-md-6">
                                     <label class="form-label">SKU</label>
                                     <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Stock Quantity</label>
                                     <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}">
                                </div>
                            </div>
                        </div>

                        <!-- SEO Tab -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                             <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ $product->meta_title }}">
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" value="{{ $product->meta_keywords }}">
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3">{{ $product->meta_description }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning btn-lg"><i class="bi bi-save"></i> Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg ms-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
