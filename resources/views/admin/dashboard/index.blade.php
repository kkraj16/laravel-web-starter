@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Products Box -->
    <div class="col-lg-4 col-12">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ $productsCount }}</h3>
                <p>Total Products</p>
            </div>
            <i class="small-box-icon bi bi-bag"></i>
            <a href="{{ route('admin.products.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Manage Products <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Categories Box -->
    <div class="col-lg-4 col-12">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ $categoriesCount }}</h3>
                <p>Active Categories</p>
            </div>
            <i class="small-box-icon bi bi-tags"></i>
            <a href="{{ route('admin.categories.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Manage Categories <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Testimonials Box -->
    <div class="col-lg-4 col-12">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ $testimonialsCount }}</h3>
                <p>Testimonials</p>
            </div>
            <i class="small-box-icon bi bi-chat-quote"></i>
            <a href="{{ route('admin.testimonials.index') }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                Manage Testimonials <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.products.create') }}" class="btn btn-app">
                    <i class="bi bi-plus-square"></i> Add Product
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-app">
                    <i class="bi bi-folder-plus"></i> Add Category
                </a>
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-app">
                    <i class="bi bi-chat-right-quote"></i> Add Testimonial
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
