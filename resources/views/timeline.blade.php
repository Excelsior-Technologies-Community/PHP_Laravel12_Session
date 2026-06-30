@extends('layouts.app')

@section('content')


<div class="container">


    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <h3>
                <i class="bi bi-clock-history"></i>
                Session Activity Timeline
            </h3>

        </div>


        <div class="card-body">


            @if(count($timeline))


            <div class="timeline">


                @foreach($timeline as $item)


                <div class="timeline-item">


                    <div class="timeline-icon">

                        <i class="bi bi-check-circle"></i>

                    </div>


                    <div class="timeline-content">


                        <h5>
                            {{ $item['title'] }}
                        </h5>


                        <p>
                            {{ $item['description'] }}
                        </p>


                        <small class="text-muted">

                            <i class="bi bi-calendar"></i>

                            {{ $item['time'] }}

                        </small>


                    </div>


                </div>


                @endforeach


            </div>


            @else

            <div class="text-center p-5">

                <i class="bi bi-clock-history"
                    style="font-size:60px">
                </i>


                <h4>
                    No Activity Yet
                </h4>


                <p class="text-muted">
                    Session actions will appear here.
                </p>


            </div>

            @endif


        </div>

    </div>


</div>


@endsection