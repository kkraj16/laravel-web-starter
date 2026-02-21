@extends('installer.layout')

@section('content')
    <div class="text-center mb-4">
        <h5>Server Requirements</h5>
    </div>

    {{-- PHP Version --}}
    <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            PHP >= 8.2 <small class="text-muted">({{ $phpVersion }})</small>
            @if($phpOk)
                <span class="badge bg-success rounded-pill">✓ Pass</span>
            @else
                <span class="badge bg-danger rounded-pill">✗ Fail</span>
            @endif
        </li>
    </ul>

    {{-- Extensions --}}
    <h6 class="mt-3 mb-2 text-muted">PHP Extensions</h6>
    <ul class="list-group mb-3">
        @foreach($extensions as $name => $loaded)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $name }}
                @if($loaded)
                    <span class="badge bg-success rounded-pill">✓</span>
                @else
                    <span class="badge bg-danger rounded-pill">✗ Missing</span>
                @endif
            </li>
        @endforeach
    </ul>

    {{-- Writable Directories --}}
    <h6 class="mt-3 mb-2 text-muted">Writable Directories</h6>
    <ul class="list-group mb-4">
        @foreach($directories as $dir => $writable)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $dir }}
                @if($writable)
                    <span class="badge bg-success rounded-pill">✓</span>
                @else
                    <span class="badge bg-danger rounded-pill">✗ Not Writable</span>
                @endif
            </li>
        @endforeach
    </ul>

    @if($allOk)
        <a href="{{ route('installer.environment') }}" class="btn btn-primary w-100">Configure Database →</a>
    @else
        <button class="btn btn-secondary w-100" disabled>Fix the issues above to continue</button>
    @endif
@endsection
