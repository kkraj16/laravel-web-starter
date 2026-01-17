@extends('admin.layouts.app')

@section('title', 'Admin Users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title fw-bold">System Administrators</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-info text-white btn-sm">
                        <i class="bi bi-person-plus-fill"></i> New Admin
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial rounded-circle bg-secondary text-white fw-bold d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="fw-bold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}', 'Delete this user?')" title="Delete">
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
