@extends('admin.layouts.app')

@section('title', 'Create New Role')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Role Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-tool" title="Back">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="name" class="form-label text-uppercase fs-7 fw-bold text-muted">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Sales Manager" required>
                    </div>

                    <label class="form-label text-uppercase fs-7 fw-bold text-muted mb-3">Assign Permissions</label>
                    
                    <div class="row">
                        @foreach($permissionGroups as $group => $permissions)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-bold text-uppercase">{{ ucwords($group) }}</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}">
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
                    <button type="submit" class="btn btn-success px-4">Create Role</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
