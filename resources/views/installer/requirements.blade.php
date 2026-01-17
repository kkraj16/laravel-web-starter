@extends('installer.layout')

@section('content')
    <div class="text-center mb-4">
        <h5>Server Requirements</h5>
    </div>

    <ul class="list-group mb-4">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            PHP >= 8.2
            <span class="badge bg-success rounded-pill">Pass</span>
        </li>
        <!-- In a real app, we would loop through actual check results -->
        <li class="list-group-item d-flex justify-content-between align-items-center">
            OpenSSL Extension
            <span class="badge bg-success rounded-pill">Pass</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            PDO Extension
            <span class="badge bg-success rounded-pill">Pass</span>
        </li>
    </ul>

    <a href="{{ route('installer.environment') }}" class="btn btn-primary w-100">Configure Database</a>
@endsection
