<div class="row g-3">
    <!-- Desktop Image -->
    <div class="col-md-6">
        <label class="form-label fw-bold">Desktop Image (Required)</label>
        <input type="file" name="image_path" class="form-control" accept="image/*" {{ isset($banner) ? '' : 'required' }}>
        <div class="form-text">Recommended size: 1920x800px or higher.</div>
        @if(isset($banner) && $banner->image_path)
            <div class="mt-2">
                <img src="{{ $banner->image_path }}" class="img-thumbnail" style="max-height: 100px;">
            </div>
        @endif
        @error('image_path') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <!-- Mobile Image -->
    <div class="col-md-6">
        <label class="form-label fw-bold">Mobile Image (Optional)</label>
        <input type="file" name="mobile_image_path" class="form-control" accept="image/*">
        <div class="form-text">Recommended size: 800x1000px (Portrait).</div>
        @if(isset($banner) && $banner->mobile_image_path)
            <div class="mt-2">
                <img src="{{ $banner->mobile_image_path }}" class="img-thumbnail" style="max-height: 100px;">
            </div>
        @endif
        @error('mobile_image_path') <div class="text-danger small">{{ $message }}</div> @enderror
        @error('mobile_image_path') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <!-- Content Image -->
    <div class="col-md-6">
        <label class="form-label fw-bold">Content Image (Optional - Transparent)</label>
        <input type="file" name="content_image_path" class="form-control" accept="image/*">
        <div class="form-text">Transparent PNG recommended. Appears in foreground.</div>
        @if(isset($banner) && $banner->content_image_path)
            <div class="mt-2 p-2 bg-dark rounded d-inline-block">
                <img src="{{ $banner->content_image_path }}" class="img-thumbnail bg-transparent border-0" style="max-height: 100px;">
            </div>
        @endif
        @error('content_image_path') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label fw-bold">Content Position</label>
        <select name="content_position" class="form-select">
            <option value="left" {{ (old('content_position', $banner->content_position ?? 'center') == 'left') ? 'selected' : '' }}>Left</option>
            <option value="center" {{ (old('content_position', $banner->content_position ?? 'center') == 'center') ? 'selected' : '' }}>Center</option>
            <option value="right" {{ (old('content_position', $banner->content_position ?? 'center') == 'right') ? 'selected' : '' }}>Right</option>
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end mb-2">
         <div class="form-check form-switch">
            <input type="hidden" name="show_content_image" value="0">
            <input class="form-check-input" type="checkbox" name="show_content_image" value="1" id="showContentImage" {{ old('show_content_image', $banner->show_content_image ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold ms-2" for="showContentImage">Show Content Image</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title ?? '') }}" placeholder="e.g. The Royal Collection">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Subtitle</label>
        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle ?? '') }}" placeholder="e.g. Timeless Elegance">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-bold">Text Alignment</label>
        <select name="text_alignment" class="form-select">
            <option value="left" {{ (old('text_alignment', $banner->text_alignment ?? 'center') == 'left') ? 'selected' : '' }}>Left</option>
            <option value="center" {{ (old('text_alignment', $banner->text_alignment ?? 'center') == 'center') ? 'selected' : '' }}>Center</option>
            <option value="right" {{ (old('text_alignment', $banner->text_alignment ?? 'center') == 'right') ? 'selected' : '' }}>Right</option>
        </select>
    </div>

    <!-- Overlay Opacity -->
    <div class="col-md-3">
        <label class="form-label fw-bold">Overlay Opacity (0.0 - 1.0)</label>
        <input type="number" step="0.1" min="0" max="1" name="overlay_opacity" class="form-control" value="{{ old('overlay_opacity', $banner->overlay_opacity ?? 0.6) }}">
    </div>

    <!-- Zoom Animation -->
    <div class="col-md-3 d-flex align-items-end mb-2">
         <div class="form-check form-switch">
            <input type="hidden" name="animate_image" value="0">
            <input class="form-check-input" type="checkbox" name="animate_image" value="1" id="animateImage" {{ old('animate_image', $banner->animate_image ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold ms-2" for="animateImage">Zoom Animation</label>
        </div>
    </div>

    <!-- Button -->
    <div class="col-md-3">
        <label class="form-label fw-bold">Button Text</label>
        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $banner->button_text ?? '') }}" placeholder="e.g. Shop Now">
    </div>
    <div class="col-md-8">
        <label class="form-label fw-bold">Button Link</label>
        <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $banner->button_link ?? '') }}" placeholder="e.g. /collections/necklaces">
    </div>

    <!-- Settings -->
    <div class="col-md-6">
        <label class="form-label fw-bold">Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ old('order', $banner->order ?? 0) }}">
    </div>

     <div class="col-md-6">
         <label class="form-label fw-bold d-block">Status</label>
         <div class="form-check form-switch d-inline-block me-3">
            <input type="hidden" name="is_active" value="0">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">Active</label>
        </div>
         <div class="form-check form-switch d-inline-block">
            <input type="hidden" name="show_content" value="0">
            <input class="form-check-input" type="checkbox" name="show_content" value="1" id="showContent" {{ old('show_content', $banner->show_content ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="showContent">Show Text Content</label>
        </div>
    </div>
</div>
