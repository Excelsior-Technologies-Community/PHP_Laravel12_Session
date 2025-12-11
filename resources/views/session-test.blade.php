<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Session Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Laravel 12 Session Management Demo</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <a href="/session/set" class="btn btn-success w-100 mb-2">Set Session Data</a>
                                <p class="text-muted small">Stores: my_name = "Virat Gandhi"</p>
                            </div>
                            <div class="col-md-4">
                                <a href="/session/get" class="btn btn-info w-100 mb-2 text-white">Get Session Data</a>
                                <p class="text-muted small">Retrieves value of 'my_name'</p>
                            </div>
                            <div class="col-md-4">
                                <a href="/session/remove" class="btn btn-danger w-100 mb-2">Remove Session Data</a>
                                <p class="text-muted small">Deletes 'my_name' from session</p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="mt-4">
                            <h5>Current Session Status:</h5>
                            <div class="alert alert-info">
                                @if(session()->has('my_name'))
                                    <strong>Session Key 'my_name' exists with value:</strong> {{ session('my_name') }}
                                @else
                                    <strong>No session data for 'my_name'</strong>
                                @endif
                            </div>
                            
                            <h5>All Session Data:</h5>
                            <pre class="bg-dark text-white p-3 rounded">{{ print_r(session()->all(), true) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>