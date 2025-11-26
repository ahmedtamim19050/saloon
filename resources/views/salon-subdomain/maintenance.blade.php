<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Under Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .maintenance-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="maintenance-card mx-auto">
            <i class="bi bi-tools fs-1 mb-4 d-block" style="font-size: 5rem;"></i>
            <h1 class="mb-3">Salon Under Maintenance</h1>
            <p class="lead mb-4">{{ $salon->name }} is currently {{ $salon->status }}.</p>
            <p>We'll be back soon! Please check back later.</p>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.3);">
            <p class="mb-0">
                <i class="bi bi-envelope"></i> Contact: {{ $salon->email }}<br>
                <i class="bi bi-telephone"></i> Phone: {{ $salon->phone }}
            </p>
        </div>
    </div>
</body>
</html>
