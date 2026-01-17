@extends('admin.layouts.app')

@section('title', 'Create Permission')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Permission Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-tool" title="Back">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control font-monospace" placeholder="e.g. products.create" required>
                        <div class="form-text">Format: module.action (e.g. products.create)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-muted">Group Name <span class="text-danger">*</span></label>
                        <input type="text" name="group_name" class="form-control" placeholder="e.g. products" required>
                        <div class="form-text">Used for grouping in Role Edit page.</div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-link text-muted me-2 text-decoration-none">Cancel</a>
                    <button type="submit" class="btn btn-secondary px-4">Create Permission</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
