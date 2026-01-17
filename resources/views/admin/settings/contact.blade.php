@extends('admin.layouts.app')

@section('title', 'Contact Information')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title fw-bold">Contact Details</h3>
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
    </div>
</div>
@endsection
