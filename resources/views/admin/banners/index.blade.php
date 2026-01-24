@extends('admin.layouts.app')

@section('title', 'Homepage Banners')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Manage Banners</h3>
        <div class="card-tools">
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add New Banner
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th style="width: 120px">Preview</th>
                    <th>Title / Subtitle</th>
                    <th>Link</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">
                        <img src="{{ $banner->image_path }}" class="img-thumbnail" style="height: 60px; width: 100px; object-fit: cover;">
                    </td>
                    <td class="align-middle">
                        <div class="fw-bold">{{ $banner->title ?? 'No Title' }}</div>
                        <small class="text-muted">{{ $banner->subtitle ?? 'No Subtitle' }}</small>
                    </td>
                    <td class="align-middle">
                        @if($banner->button_link)
                            <a href="{{ $banner->button_link }}" target="_blank" class="text-decoration-none">
                                <span class="badge bg-light text-dark border">{{ $banner->button_text ?? 'Link' }}</span>
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <span class="badge bg-secondary">{{ $banner->sort_order }}</span>
                    </td>
                    <td class="align-middle">
                        <form action="{{ route('admin.banners.toggle-active', $banner->id) }}" method="POST">
                            @csrf
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" onchange="this.closest('form').submit()" {{ $banner->is_active ? 'checked' : '' }} style="cursor: pointer;">
                                <label class="form-check-label small" style="width: 50px;">
                                    {{ $banner->is_active ? 'Active' : 'Draft' }}
                                </label>
                            </div>
                        </form>
                    </td>
                    <td class="align-middle text-end">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-info text-white me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No banners found. Click "Add New Banner" to create one.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
