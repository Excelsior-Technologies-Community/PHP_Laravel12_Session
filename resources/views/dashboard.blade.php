@extends('layouts.app')

@section('content')

<h2 class="mb-4">

    Session Dashboard

</h2>

<div class="row">

    <div class="col-md-4">

        <div class="stat-card bg-primary">

            <h5>Total Session Keys</h5>

            <h2>{{ $totalKeys }}</h2>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card bg-success">

            <h5>Session ID</h5>

            <p>{{ $sessionId }}</p>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card bg-warning">

            <h5>Current Time</h5>

            <h5>{{ now() }}</h5>

        </div>

    </div>

</div>

{{-- ADD HERE --}}
<div class="row mt-4">
    <div class="col-md-6 mb-3">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <h4>
                    <i class="fa-solid fa-user-shield text-info me-2"></i>
                    Sessions Inspector & Benchmark
                </h4>
                <p class="text-muted">
                    Scan active device sessions, revoke remote tokens & benchmark session driver latency.
                </p>
                <a href="{{ route('session_inspector.index') }}" class="btn btn-info text-white fw-bold">
                    Open Inspector Radar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <h4>
                    <i class="fa-solid fa-cart-shopping text-warning me-2"></i>
                    Cart & Checkout Wizard
                </h4>
                <p class="text-muted">
                    Session-driven shopping cart manager, 3-step checkout wizard & JSON backup/restore.
                </p>
                <a href="{{ route('cart.index') }}" class="btn btn-warning text-dark fw-bold">
                    Open Cart Wizard
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">

        <div class="card shadow">

            <div class="card-body">

                <h4>
                    <i class="bi bi-clock-history"></i>
                    Activity Timeline
                </h4>

                <p class="text-muted">
                    View all session activities.
                </p>

                <a href="{{ route('session.timeline') }}"
                    class="btn btn-primary">

                    Open Timeline

                </a>

            </div>

        </div>

    </div>


    <div class="col-md-6 mb-3">

        <div class="card shadow">

            <div class="card-body">

                <h4>
                    <i class="bi bi-chat-square-text"></i>
                    Flash Manager
                </h4>

                <p class="text-muted">
                    Test Laravel flash session messages.
                </p>


                <a href="{{ route('flash.page') }}"
                    class="btn btn-success">

                    Open Flash Manager

                </a>

            </div>

        </div>

    </div>

</div>


<div class="card mt-4">

    <div class="card-header bg-dark text-white">

        All Session Data

    </div>

    <div class="card-body">

        @if(count($sessionData))

        <table class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th>Key</th>

                    <th>Value</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($sessionData as $key => $value)

                <tr>

                    <td>{{ $key }}</td>

                    <td>

                        @if(is_array($value))

                        <pre>{{ print_r($value, true) }}</pre>

                        @else

                        {{ $value }}

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('session.remove', $key) }}" class="btn btn-danger btn-sm">

                            Delete

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        @else

        <div class="alert alert-warning">

            No Session Found

        </div>

        @endif

    </div>

</div>

@endsection