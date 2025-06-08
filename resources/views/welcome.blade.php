<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="{{ asset('design/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .card {
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(28, 122, 75, 0.1);
            text-align: center;
        }
        .btn {
            min-width: 180px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3 class="mb-4">Welcome to Leave Management System</h3>
        <div class="d-flex justify-content-center">
            <a href="{{ route('login') }}" class="btn btn-primary mr-3">Login as Employee</a>
            <a href="{{ route('admin.login') }}" class="btn btn-success">Login as Admin </a>
        </div>
    </div>
</body>
</html>
