@extends('admin.layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Edit Role: {{ $role->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-tool" title="Back">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="name" class="form-label text-uppercase fs-7 fw-bold text-muted">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                    </div>

                    <label class="form-label text-uppercase fs-7 fw-bold text-muted mb-3">Assign Permissions</label>
                    
                    <div class="row">
                        @foreach($permissionGroups as $group => $permissions)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold text-uppercase">{{ ucwords($group) }}</h6>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input group-toggle" type="checkbox" data-group="{{ Str::slug($group) }}" title="Toggle Group">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach($permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input permission-checkbox group-{{ Str::slug($group) }}" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-end">
                     <a href="{{ route('admin.roles.index') }}" class="btn btn-link text-muted me-2 text-decoration-none">Cancel</a>
                    <button type="submit" class="btn btn-dark px-4">Update Role</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Script to toggle all checkboxes in a group
    document.querySelectorAll('.group-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const groupClass = this.getAttribute('data-group');
            const checkboxes = document.querySelectorAll('.group-' + groupClass);
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    });
</script>
@endpush
@endsection
