@extends('admin.layouts.app')

@section('title', 'Create Banner')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Banner</h3>
        <div class="card-tools">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @include('admin.banners.fields', ['banner' => null])
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary px-4">Create Banner</button>
        </div>
    </form>
</div>
@endsection
