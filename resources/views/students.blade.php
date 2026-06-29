@extends('layouts.app')

@section('content')

    <style>
        .page-header {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .table-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .table thead {
            background: #212529;
            color: #fff;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .badge-age {
            font-size: 14px;
            padding: 7px 12px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold mb-1">
                Student Management
            </h2>

            <p class="mb-0">
                Records inserted using Laravel Tinker
            </p>

        </div>



    </div>

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card stat-card bg-primary text-white">

                <div class="card-body">

                    <h6>Total Students</h6>

                    <h2>{{ $students->count() }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stat-card bg-success text-white">

                <div class="card-body">

                    <h6>Database</h6>

                    <h3>MySQL</h3>

                </div>

            </div>

        </div>



    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    <div class="card table-card">

        <div class="card-header bg-dark text-white d-flex justify-content-between">

            <h5 class="mb-0">
                Student Records
            </h5>

            <span class="badge bg-warning text-dark">
                {{ $students->count() }} Records
            </span>

        </div>

        <div class="card-body">

            @if($students->count())

                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <form action="{{ route('students') }}" method="GET">

                            <div class="row">

                                <div class="col-md-10">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by Name, Email, City or Age..." value="{{ request('search') }}">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100">
                                        Search
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Student</th>

                                <th>Email</th>

                                <th>City</th>

                                <th>Age</th>

                                <th>Created</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($students as $student)

                                <tr>

                                    <td>

                                        {{ $student->id }}

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="avatar me-3">

                                                {{ strtoupper(substr($student->name, 0, 1)) }}

                                            </div>

                                            <strong>

                                                {{ $student->name }}

                                            </strong>

                                        </div>

                                    </td>

                                    <td>

                                        {{ $student->email }}

                                    </td>

                                    <td>

                                        <span class="badge bg-info">

                                            {{ $student->city }}

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge bg-success badge-age">

                                            {{ $student->age }} Years

                                        </span>

                                    </td>

                                    <td>

                                        @if($student->created_at)

                                            {{ $student->created_at->format('d M Y') }}

                                        @else

                                            <span class="text-muted">N/A</span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="120" class="mb-3">

                    <h4>No Student Records</h4>

                    <p class="text-muted">

                        Insert students using Laravel Tinker.

                    </p>

                    <code>php artisan tinker</code>

                </div>

            @endif

        </div>

    </div>

@endsection