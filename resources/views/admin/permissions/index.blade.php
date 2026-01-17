@extends('admin.layouts.app')

@section('title', 'Permissions Matrix')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('admin.permissions.updateMatrix') }}" method="POST">
            @csrf
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title fw-bold">System Permissions Matrix</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.permissions.create') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="bi bi-plus-lg"></i> New Permission
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-save"></i> Save Changes
                        </button>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-start p-3" style="min-width: 200px;">Permission Name</th>
                                @foreach($roles as $role)
                                    <th style="min-width: 100px;">
                                        <div class="d-flex flex-column align-items-center">
                                            <span>{{ $role->name }}</span>
                                            <small class="text-muted fw-normal" style="font-size: 0.65rem;">ID: {{ $role->id }}</small>
                                        </div>
                                    </th>
                                @endforeach
                                <th style="width: 50px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $group => $groupPermissions)
                                <tr class="table-secondary text-start">
                                    <td colspan="{{ $roles->count() + 2 }}" class="fw-bold text-uppercase px-3 py-2 small">
                                        <i class="bi bi-folder2-open me-1"></i> {{ ucwords($group) }} Group
                                    </td>
                                </tr>
                                @foreach($groupPermissions as $permission)
                                    <tr>
                                        <td class="text-start px-3 font-monospace small">
                                            {{ $permission->name }}
                                        </td>
                                        @foreach($roles as $role)
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="matrix[{{ $role->id }}][]" 
                                                           value="{{ $permission->id }}" 
                                                           {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                        @endforeach
                                        <td>
                                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="text-info" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end sticky-bottom bg-white border-top shadow-sm">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Update Permissions
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
