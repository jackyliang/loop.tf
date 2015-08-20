@extends('app_sched')

@section('title')
    Schedule
@stop

@section('schedule')
    <div class="col-md-3">
        @include('schedulizer.classes-panel')
        @include('schedulizer.time-span-options-panel')
        @include('schedulizer.other-options-panel')
    </div>

    <div class="col-md-9 col-centered">
        @include('schedulizer.schedule-panel')
    </div>

    @include('js.schedule-options-panel')
@stop
