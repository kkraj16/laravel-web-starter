@extends('installer.layout')

@section('content')
    <div class="text-center">
        <h5>Welcome</h5>
        <p class="text-muted">This wizard will guide you through the installation process.</p>
        
        <hr>

        <a href="{{ route('installer.requirements') }}" class="btn btn-primary w-100">Check Requirements</a>
    </div>
@endsection
