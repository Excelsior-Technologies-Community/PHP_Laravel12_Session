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