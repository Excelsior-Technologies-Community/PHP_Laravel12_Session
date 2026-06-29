@extends('layouts.app')

@section('content')

    <h2 class="mb-4">

        Session List

    </h2>

    <div class="card">

        <div class="card-body">


            <table class="table table-striped table-bordered">

                <thead>

                    <tr>

                        <th>Key</th>

                        <th>Value</th>

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

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@endsection