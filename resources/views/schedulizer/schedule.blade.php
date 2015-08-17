@extends('app_sched')

@section('title')

@stop

@section('content')
    <div class="page-heading-results">
        <h1>Schedule</h1>
        <p
            class="text-muted">
            This many schedules were generated
        </p>
    </div>

    <div class="col-md-4">
        @include('schedulizer.cart-panel')
    </div>

    @include('js.time-slider')
@stop
