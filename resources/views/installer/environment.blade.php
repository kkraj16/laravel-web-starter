@extends('installer.layout')

@section('content')
    <div class="text-center mb-4">
        <h5>Environment Configuration</h5>
    </div>

    <form action="{{ route('installer.environment.save') }}" method="POST">
        @csrf

        <h6 class="mt-2 mb-3 text-muted">Application</h6>
        <div class="mb-3">
            <label class="form-label">App Name</label>
            <input type="text" name="app_name" class="form-control" value="{{ old('app_name', 'Ratannam Gold') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Site URL</label>
            <input type="url" name="app_url" class="form-control" value="{{ old('app_url', 'https://') }}" placeholder="https://yourdomain.com" required>
            <small class="text-muted">Your website address (with https://)</small>
        </div>

        <hr>

        <h6 class="mt-2 mb-3 text-muted">Database Connection</h6>
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Database Host</label>
                    <input type="text" name="db_host" class="form-control" value="{{ old('db_host', '127.0.0.1') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Port</label>
                    <input type="text" name="db_port" class="form-control" value="{{ old('db_port', '3306') }}" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Database Name</label>
            <input type="text" name="db_database" class="form-control" value="{{ old('db_database', 'ratannam_db') }}" required>
            <small class="text-muted">The database must already exist on the server.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Database Username</label>
            <input type="text" name="db_username" class="form-control" value="{{ old('db_username') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Database Password</label>
            <input type="password" name="db_password" class="form-control" value="{{ old('db_password') }}">
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Test Connection & Install →</button>
    </form>
@endsection
