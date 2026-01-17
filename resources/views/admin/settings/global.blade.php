@extends('admin.layouts.app')

@section('title', 'Global Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-primary mb-4">
            <div class="card-header">
                <h3 class="card-title fw-bold">Global Configuration</h3>
                 <div class="card-tools">
                   <small class="text-muted">Manage site identity and global assets.</small>
                </div>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Site Name</label>
                            <input type="text" name="app_name" class="form-control" value="{{ $settings['app_name'] ?? config('app.name') }}" placeholder="Ratannam Gold">
                            <div class="form-text">This name appears in emails, dashboard title, and copyright footer.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Site Logo</label>
                            @if(!empty($settings['site_logo_url']))
                                <div class="mb-2 p-2 border rounded bg-light d-inline-block">
                                    <img src="{{ asset($settings['site_logo_url']) }}" alt="Current Logo" style="height: 50px; max-width: 200px; object-fit: contain;">
                                </div>
                            @endif
                            <input type="file" name="site_logo" class="form-control" accept="image/png, image/jpeg, image/jpg, image/svg+xml">
                            <div class="form-text">Upload a new logo to replace the existing one. Recommended: PNG or SVG. Max: 2MB.</div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Favicon</label>
                            @if(!empty($settings['site_favicon_url']))
                                <div class="mb-2 p-2 border rounded bg-light d-inline-block">
                                    <img src="{{ asset($settings['site_favicon_url']) }}" alt="Current Favicon" style="height: 32px; width: 32px; object-fit: contain;">
                                </div>
                            @endif
                            <input type="file" name="site_favicon" class="form-control" accept="image/x-icon, image/png, image/jpeg, image/svg+xml">
                            <div class="form-text">Upload a favicon (Icon). Recommended: 32x32 ICO or PNG. Max: 1MB.</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary px-4">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
