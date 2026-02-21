@extends('installer.layout')

@section('content')
    <div class="text-center">
        <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
        <h4 class="text-success mb-3">Installation Complete!</h4>
        <p class="text-muted">Your application has been successfully installed and configured.</p>
        
        <div class="alert alert-warning text-start mt-4" style="font-size: 0.85rem;">
            <strong>Admin Login Credentials:</strong><br>
            <strong>Email:</strong> admin@ratannam.com<br>
            <strong>Password:</strong> RatannamAdmin@2026<br>
            <em>⚠️ Please change this password immediately after login.</em>
        </div>

        <hr>

        <a href="{{ url('/admin') }}" class="btn btn-primary w-100 mb-2">Go to Admin Panel</a>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">Visit Website</a>
    </div>
@endsection
