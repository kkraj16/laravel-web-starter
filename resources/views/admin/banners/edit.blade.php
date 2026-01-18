@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Banner</h3>
        <div class="card-tools">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    
    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('admin.banners.fields', ['banner' => $banner])
        </div>
        <div class="card-footer text-end">
             <button type="submit" class="btn btn-primary px-4">Update Banner</button>
        </div>
    </form>
</div>
@endsection
