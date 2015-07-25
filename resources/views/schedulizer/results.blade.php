@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')
    <h1 class="page-heading">Results</h1>
    <div class="container half-page">
    @if($classesByType)
        @foreach ($classesByType as $type => $classes)
            <h1>{{ $type }}</h1>
            @foreach ($classes as $class)
                <p>{{ $class['subject_code'] }} {{ $class['course_code'] }} ...</p>
            @endforeach
        @endforeach
    @endif
    </div>
@stop