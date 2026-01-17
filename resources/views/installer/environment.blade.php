@extends('installer.layout')

@section('content')
    <div class="text-center mb-4">
        <h5>Environment Configuration</h5>
    </div>

    <form action="{{ route('installer.environment.save') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">App Name</label>
            <input type="text" name="app_name" class="form-control" value="Ratannam Gold" required>
        </div>

        <h6 class="mt-4">Database Connection</h6>
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Database Host</label>
                    <input type="text" name="db_host" class="form-control" value="127.0.0.1" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Port</label>
                    <input type="text" name="db_port" class="form-control" value="3306" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Database Name</label>
            <input type="text" name="db_database" class="form-control" value="ratannam_gold" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Database Username</label>
            <input type="text" name="db_username" class="form-control" value="root" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Database Password</label>
            <input type="password" name="db_password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Save & Install</button>
    </form>
@endsection
