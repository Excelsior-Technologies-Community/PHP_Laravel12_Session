<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Session Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

        .timeline {
            position: relative;
            margin: 20px;
            padding-left: 40px;
        }


        .timeline:before {

            content: "";

            position: absolute;

            left: 15px;

            top: 0;

            height: 100%;

            width: 3px;

            background: #0d6efd;

        }


        .timeline-item {

            position: relative;

            margin-bottom: 30px;

        }


        .timeline-icon {

            position: absolute;

            left: -40px;

            width: 32px;

            height: 32px;

            border-radius: 50%;

            background: #0d6efd;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .timeline-content {

            background: white;

            padding: 20px;

            border-radius: 12px;

            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);

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
                        <a class="nav-link"
                            href="{{ route('session.timeline') }}">
                            Timeline
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('flash.page') }}">
                            Flash Manager
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

        <div class="alert alert-success alert-dismissible fade show auto-hide">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

            <button class="btn-close"
                data-bs-dismiss="alert"></button>

        </div>

        @endif


        @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show auto-hide">

            <i class="bi bi-x-circle"></i>

            {{ session('error') }}

            <button class="btn-close"
                data-bs-dismiss="alert"></button>

        </div>

        @endif


        @if(session('warning'))

        <div class="alert alert-warning alert-dismissible fade show auto-hide">

            <i class="bi bi-exclamation-triangle"></i>

            {{ session('warning') }}

            <button class="btn-close"
                data-bs-dismiss="alert"></button>

        </div>

        @endif


        @if(session('info'))

        <div class="alert alert-info alert-dismissible fade show auto-hide">

            <i class="bi bi-info-circle"></i>

            {{ session('info') }}

            <button class="btn-close"
                data-bs-dismiss="alert"></button>

        </div>

        @endif

        @yield('content')

    </div>

    <div class="footer">

        Laravel 12 Session Management Project

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        setTimeout(function() {

            let alerts = document.querySelectorAll('.auto-hide');

            alerts.forEach(function(alert) {

                let bsAlert = new bootstrap.Alert(alert);

                bsAlert.close();

            });

        }, 4000);
    </script>


</body>

</html>