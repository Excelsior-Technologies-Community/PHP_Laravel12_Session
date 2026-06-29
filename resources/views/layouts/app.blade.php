<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Session Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        }

        .card-header {
            font-weight: bold;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .stat-card {
            color: #fff;
            border-radius: 12px;
            padding: 25px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: gray;
            padding: 20px;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Laravel Session
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="menu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('session.create') }}">
                            Add Session
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('session.list') }}">
                            View Sessions
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('students') }}">
                            Students
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('session.clear') }}">
                            Clear All
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <div class="container mt-4">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        @yield('content')

    </div>

    <div class="footer">

        Laravel 12 Session Management Project

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>