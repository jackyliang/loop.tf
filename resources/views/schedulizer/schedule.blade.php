@extends('app_sched')

@section('title')
    Schedule
@stop

@section('content')
    <div class="page-heading-results">
        <h1>Your Schedule

        </h1>

        @include('schedulizer.cart-fixed-button')
    </div>

    <div class="col-md-4">
        @include('schedulizer.classes-panel')
        @include('schedulizer.time-span-options-panel')
        @include('schedulizer.other-options-panel')
    </div>

    <div class="col-md-8 col-centered">
        @include('schedulizer.schedule-panel')
    </div>

    @include('js.schedule-options-panel')
    @include('js.schedule-fullcalendar')
@stop
