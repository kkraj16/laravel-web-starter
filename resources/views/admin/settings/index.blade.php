@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="row">
    <!-- Main Configuration Column -->
    <div class="col-md-9">
        <!-- Contact Information Section -->
        <div class="card card-outline card-warning mb-4">
            <div class="card-header">
                <h3 class="card-title fw-bold">Contact Information</h3>
                <div class="card-tools">
                   <small class="text-muted">Manage your physical and digital contact details.</small>
                </div>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Store Phone</label>
                            <input type="text" name="store_phone" class="form-control" value="{{ $settings['store_phone'] ?? '' }}" placeholder="+91 ...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Whatsapp (Number Only)</label>
                            <input type="text" name="contact_whatsapp" class="form-control" value="{{ $settings['contact_whatsapp'] ?? '' }}" placeholder="9199...">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Email Address</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}" placeholder="info@...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Map Coordinates</label>
                            <input type="text" name="map_coordinates" class="form-control" value="{{ $settings['map_coordinates'] ?? '' }}" placeholder="25.777, 73.243">
                        </div>

                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Full Boutique Address</label>
                            <textarea name="contact_address" class="form-control" rows="2">{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Google Map Embed URL</label>
                            <textarea name="google_map_embed" class="form-control font-monospace fs-7" rows="3">{{ $settings['google_map_embed'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-dark px-4">Save Contact Info</button>
                </div>
            </form>
        </div>

        <!-- SEO & System Section -->
        <div class="card card-outline card-secondary mb-4">
            <div class="card-header">
                <h3 class="card-title fw-bold">SEO & System Configuration</h3>
                 <div class="card-tools">
                   <small class="text-muted">Manage search engine visibility and system-wide toggles.</small>
                </div>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-4">
                        <div class="form-check form-switch p-3 bg-light rounded border">
                            <input class="form-check-input ms-0 me-2" type="checkbox" id="hidePrices" name="hide_prices" value="1" {{ ($settings['hide_prices'] ?? 0) ? 'checked' : '' }} style="margin-left: -2em;">
                            <label class="form-check-label fw-bold" for="hidePrices">&nbsp;&nbsp;&nbsp;Hide All Prices Globally</label>
                            <div class="form-text mt-1 ms-4">If enabled, all product prices will be hidden from the public store.</div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 border-bottom pb-2">Meta Tags</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Site Title</label>
                            <input type="text" name="site_title" class="form-control" value="{{ $settings['site_title'] ?? '' }}" placeholder="Ratannam Gold | Luxury Jewellery">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Site Description</label>
                            <textarea name="seo_description" class="form-control" rows="3">{{ $settings['seo_description'] ?? '' }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Keywords (Comma Separated)</label>
                            <input type="text" name="seo_keywords" class="form-control" value="{{ $settings['seo_keywords'] ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-secondary px-4">Save SEO Settings</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Rates & Sidebar -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Live Rates</h5>
                <form action="{{ route('admin.settings.update-rates') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Gold 24K (Per 10g)</label>
                        <input type="number" step="0.01" name="rate_gold_24k" class="form-control" value="{{ $settings['rate_gold_24k'] ?? '' }}" placeholder="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Gold 22K (Per 10g)</label>
                        <input type="number" step="0.01" name="rate_gold_22k" class="form-control" value="{{ $settings['rate_gold_22k'] ?? '' }}" placeholder="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Silver (Per 1kg)</label>
                        <input type="number" step="0.01" name="rate_silver" class="form-control" value="{{ $settings['rate_silver'] ?? '' }}" placeholder="0.00">
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Update Market Rates</button>
                    <div class="text-center mt-2">
                        <small class="text-muted fst-italic" style="font-size: 0.75rem;">Rates update globally across the ticker in real-time.</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
