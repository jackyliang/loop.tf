@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')
    <h1 class="page-heading">Results</h1>
    <div class="container">
    @if($classesByType)
        @foreach ($classesByType as $type => $classes)
            <h3>{{ $type }}</h3>
            <table class="table table-striped">
                <th>Class</th>
                <th>Section</th>
                <th>CRN</th>
                <th>Name</th>
                <th>Day</th>
                <th>Time</th>
                <th>Professor</th>
                <th>Enroll</th>
                <th>Max Enroll</th>
                <th>Credits</th>
                @foreach ($classes as $class)
                    {{-- Highlight class with red if they're full --}}
                    @if(
                    $class->enroll === $class->max_enroll ||
                    $class->enroll === "CLOSED"
                    )
                        <tr class="danger">
                            @include('schedulizer.class-rows')
                        </tr>
                    @else
                        <tr>
                            @include('schedulizer.class-rows')
                        </tr>
                    @endif
                @endforeach
            </table>
        @endforeach
    @endif
    </div>
@stop