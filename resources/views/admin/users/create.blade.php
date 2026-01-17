@extends('admin.layouts.app')

@section('title', 'Create Admin User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title fw-bold">User Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-tool" title="Back">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fs-7 fw-bold text-muted">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">Active Account</label>
                        </div>
                    </div>

                    <div class="mb-3">
                         <label class="form-label text-uppercase fs-7 fw-bold text-muted">Assign Roles</label>
                         <div class="border rounded p-3 bg-light">
                             <div class="row">
                                 @foreach($roles as $role)
                                     <div class="col-md-4 mb-2">
                                         <div class="form-check">
                                             <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}">
                                             <label class="form-check-label" for="role_{{ $role->id }}">
                                                 {{ $role->name }}
                                             </label>
                                         </div>
                                     </div>
                                 @endforeach
                             </div>
                         </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-link text-muted me-2 text-decoration-none">Cancel</a>
                    <button type="submit" class="btn btn-info text-white px-4">Create User</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
