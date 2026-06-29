@extends('layouts.app')

@section('content')

    <div class="card">

        <div class="card-header bg-primary text-white">

            Add Session Data

        </div>

        <div class="card-body">

            <form action="{{ route('session.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Name</label>

                    <input type="text" name="name" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>Email</label>

                    <input type="email" name="email" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>City</label>

                    <input type="text" name="city" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>Age</label>

                    <input type="number" name="age" class="form-control" required>

                </div>

                <button class="btn btn-success">

                    Save Session

                </button>

            </form>

        </div>

    </div>

@endsection