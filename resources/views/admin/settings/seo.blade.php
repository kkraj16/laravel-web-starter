@extends('admin.layouts.app')

@section('title', 'SEO & System Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
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
</div>
@endsection
