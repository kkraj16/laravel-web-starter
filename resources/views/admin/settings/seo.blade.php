@extends('admin.layouts.app')

@section('title', 'SEO & System Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-outline card-secondary mb-4">
            <div class="card-header">
                <h3 class="card-title fw-bold">SEO & System Configuration</h3>
                 <div class="card-tools">
                   <small class="text-muted">Manage search engine visibility and system-wide toggles.</small>
                </div>
            </div>
            
            <div class="card-body">
                <ul class="nav nav-pills mb-4 border-bottom pb-3" id="seoTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="global-tab" data-bs-toggle="pill" data-bs-target="#global" type="button" role="tab">Global Settings</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="home-tab" data-bs-toggle="pill" data-bs-target="#home-page" type="button" role="tab">Home Page</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="about-tab" data-bs-toggle="pill" data-bs-target="#about-page" type="button" role="tab">About Page</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact-page" type="button" role="tab">Contact Page</button>
                    </li>
                </ul>

                <div class="tab-content" id="seoTabsContent">
                    <!-- Global Settings -->
                    <div class="tab-pane fade show active" id="global" role="tabpanel">
                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Global Meta Tags (Fallbacks)</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-uppercase fs-7 fw-bold text-muted">Default Site Title</label>
                                    <input type="text" name="site_title" class="form-control" value="{{ $settings['site_title'] ?? '' }}" placeholder="Ratannam Gold | Luxury Jewellery">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-uppercase fs-7 fw-bold text-muted">Default Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3">{{ $settings['seo_description'] ?? '' }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-uppercase fs-7 fw-bold text-muted">Default Keywords</label>
                                    <input type="text" name="seo_keywords" class="form-control" value="{{ $settings['seo_keywords'] ?? '' }}">
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-secondary px-4">Save Global Settings</button>
                            </div>
                        </form>
                    </div>

                    <!-- Page Specific Tabs -->
                    @foreach(['home', 'about', 'contact'] as $page)
                    <div class="tab-pane fade" id="{{ $page }}-page" role="tabpanel">
                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="page_seo" value="{{ $page }}">
                            
                            @php
                                $seoMeta = \App\Models\SeoMeta::where('route_name', $page)->first() ?: new \App\Models\SeoMeta();
                            @endphp

                            @include('admin.partials._seo_fields', ['seoMeta' => $seoMeta])
                            
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-success px-4">Update {{ ucfirst($page) }} SEO</button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
