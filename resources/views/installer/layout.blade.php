<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratannam Gold - Installer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .installer-card { max-width: 600px; margin: 50px auto; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .step-indicator { margin-bottom: 20px; font-weight: bold; color: #6c757d; }
        .step-indicator.active { color: #0d6efd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card installer-card">
            <div class="card-header bg-white text-center py-4">
                <h4>Ratannam Gold CMS Installer</h4>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
