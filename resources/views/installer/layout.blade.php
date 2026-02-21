<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratannam Gold — Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f8f5f0 0%, #ebe4d8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .installer-card { 
            max-width: 560px; 
            margin: 40px auto; 
            border-radius: 12px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            border: none;
        }
        .installer-card .card-header {
            background: #1a1a1a;
            color: #d4af37;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.5rem;
        }
        .installer-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .installer-card .card-header small {
            color: #999;
        }
        .btn-primary {
            background: #1a1a1a;
            border-color: #1a1a1a;
        }
        .btn-primary:hover {
            background: #d4af37;
            border-color: #d4af37;
            color: #1a1a1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card installer-card">
            <div class="card-header text-center">
                <h4>✦ Ratannam Gold</h4>
                <small>Installation Wizard</small>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
