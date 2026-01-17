@extends('installer.layout')

@section('content')
    <div class="text-center">
        <h4 class="text-success mb-3">Installation Successful!</h4>
        <p class="text-muted">The application has been successfully installed and configured.</p>
        
        <hr>

        <a href="{{ url('/admin') }}" class="btn btn-primary w-100">Go to Admin Panel</a>
        <br><br>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">Visit Website</a>
    </div>
@endsection
