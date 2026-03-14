<div class="card card-outline card-info mt-4">
    <div class="card-header">
        <h3 class="card-title fw-bold"><i class="bi bi-search me-2"></i>SEO & Social Meta Tags</h3>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">Meta Title</label>
                <input type="text" name="seo[meta_title]" class="form-control" value="{{ old('seo.meta_title', $seoMeta->meta_title ?? '') }}" placeholder="Enter meta title (Recommended: 50-60 chars)">
            </div>
            
            <div class="col-md-12">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">Meta Description</label>
                <textarea name="seo[meta_description]" class="form-control" rows="3" placeholder="Enter meta description (Recommended: 150-160 chars)">{{ old('seo.meta_description', $seoMeta->meta_description ?? '') }}</textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">Keywords (Comma Separated)</label>
                <input type="text" name="seo[meta_keywords]" class="form-control" value="{{ old('seo.meta_keywords', $seoMeta->meta_keywords ?? '') }}" placeholder="gold, jewellery, authentic">
            </div>

            <div class="col-md-12">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">Canonical URL</label>
                <input type="url" name="seo[canonical_url]" class="form-control" value="{{ old('seo.canonical_url', $seoMeta->canonical_url ?? '') }}" placeholder="{{ url()->current() }}">
            </div>

            <div class="col-md-6">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">Robots Directive</label>
                <select name="seo[robots]" class="form-select">
                    <option value="index, follow" {{ (old('seo.robots', $seoMeta->robots ?? '') == 'index, follow') ? 'selected' : '' }}>Index, Follow</option>
                    <option value="noindex, follow" {{ (old('seo.robots', $seoMeta->robots ?? '') == 'noindex, follow') ? 'selected' : '' }}>No-Index, Follow</option>
                    <option value="index, nofollow" {{ (old('seo.robots', $seoMeta->robots ?? '') == 'index, nofollow') ? 'selected' : '' }}>Index, No-Follow</option>
                    <option value="noindex, nofollow" {{ (old('seo.robots', $seoMeta->robots ?? '') == 'noindex, nofollow') ? 'selected' : '' }}>No-Index, No-Follow</option>
                </select>
            </div>

            <div class="col-md-12 mt-4">
                <h6 class="fw-bold border-bottom pb-2 mb-3">Open Graph (Social Sharing)</h6>
            </div>

            <div class="col-md-12">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">OG Title</label>
                <input type="text" name="seo[og_title]" class="form-control" value="{{ old('seo.og_title', $seoMeta->og_title ?? '') }}" placeholder="Fallbacks to Meta Title if empty">
            </div>

            <div class="col-md-12">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">OG Description</label>
                <textarea name="seo[og_description]" class="form-control" rows="2" placeholder="Fallbacks to Meta Description if empty">{{ old('seo.og_description', $seoMeta->og_description ?? '') }}</textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label text-uppercase fs-7 fw-bold text-muted">OG Image URL</label>
                <input type="text" name="seo[og_image]" class="form-control" value="{{ old('seo.og_image', $seoMeta->og_image ?? '') }}" placeholder="Path to image (e.g. uploads/seo/image.jpg)">
            </div>
        </div>
    </div>
</div>
