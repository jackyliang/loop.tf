@extends('app_sched')

@section('title')
    Schedule
@stop

@section('content')
    <div class="page-heading-results">
        <h1>Schedule
            <a id="refresh" class="btn btn-xs btn-flat btn-primary">
                <span
                        class="mdi-notification-sync"
                        >
                </span>
            </a>
        </h1>
        <p
            id="num-results" class="text-muted">
        </p>
    </div>

    <div class="col-md-4">
        @include('schedulizer.classes-panel')
        @include('schedulizer.time-span-options-panel')
        @include('schedulizer.other-options-panel')
    </div>

    <div class="col-md-8">
        @include('schedulizer.schedule-panel')
    </div>

    @include('js.schedule-options-panel')
    @include('js.schedule-fullcalendar')
@stop
