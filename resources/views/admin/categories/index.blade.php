@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
             <h3 class="card-title">All Categories</h3>
             <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Category
            </a>
        </div>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 80px">Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Parent</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center rounded" style="width: 50px; height: 50px;">
                                <i class="bi bi-image text-secondary"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $category->name }}</td>
                    <td class="text-secondary">{{ $category->slug }}</td>
                    <td>
                        @if($category->parent)
                             <span class="badge text-bg-info">{{ $category->parent->name }}</span>
                        @else
                            <span class="text-secondary">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($category->is_active)
                            <span class="badge text-bg-success">Active</span>
                        @else
                            <span class="badge text-bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-info" href="{{ route('admin.categories.edit', $category->id) }}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-danger rounded-start-0" 
                                onclick="confirmDelete('{{ route('admin.categories.destroy', $category->id) }}', 'Warning: Deleting this category will affect navigation and SEO.')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
