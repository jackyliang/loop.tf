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
                <th>Name</th>
                <th>CRN</th>
                <th>Day</th>
                <th>Time</th>
                <th>Instructor</th>
                <th>Max Enroll</th>
                <th>Enroll</th>
                @foreach ($classes as $class)
                    <tr>
                        <td> {{ $class->subject_code . ' ' . $class->course_no}} </td>
                        <td> {{ $class->section}} </td>
                        <td> {{ $class->course_title}} </td>
                        <td> {{ $class->crn}} </td>
                        <td> {{ $class->day}} </td>
                        <td> {{ $class->time}} </td>
                        <td> {{ $class->instructor}} </td>
                        <td> {{ $class->max_enroll}} </td>
                        <td> {{ $class->enroll}} </td>
                    </tr>
                @endforeach
            </table>
        @endforeach
    @endif
    </div>
@stop