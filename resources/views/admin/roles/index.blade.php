@extends('admin.layouts.app')

@section('title', 'Roles Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title fw-bold">System Roles</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> New Role
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Permissions Count</th>
                            <th style="width: 150px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $role->name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $role->permissions_count }} Permissions</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if($role->name !== 'Super Admin')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('admin.roles.destroy', $role) }}', 'This will delete the role and remove access from assigned users.')" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
