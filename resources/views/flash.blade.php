@extends('layouts.app')


@section('content')


<div class="container">


    <div class="card shadow">


        <div class="card-header bg-primary text-white">

            <h3>

                <i class="bi bi-chat-square-text"></i>

                Flash Message Manager

            </h3>

        </div>


        <div class="card-body">


            <h5>
                Test Flash Messages
            </h5>


            <div class="row mt-4">


                <div class="col-md-3">

                    <a href="{{ route('flash','success') }}"
                        class="btn btn-success w-100">

                        Success

                    </a>

                </div>



                <div class="col-md-3">

                    <a href="{{ route('flash','error') }}"
                        class="btn btn-danger w-100">

                        Error

                    </a>

                </div>




                <div class="col-md-3">

                    <a href="{{ route('flash','warning') }}"
                        class="btn btn-warning w-100">

                        Warning

                    </a>

                </div>




                <div class="col-md-3">

                    <a href="{{ route('flash','info') }}"
                        class="btn btn-info w-100">

                        Info

                    </a>

                </div>


            </div>


            <hr>


            <div class="mt-4">


                <h5>
                    Preview
                </h5>


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



                @if(session('warning'))

                <div class="alert alert-warning">

                    {{ session('warning') }}

                </div>

                @endif



                @if(session('info'))

                <div class="alert alert-info">

                    {{ session('info') }}

                </div>

                @endif



            </div>


        </div>


    </div>


</div>


@endsection