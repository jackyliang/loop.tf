@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')
    <div class="page-heading-results">
        <h1>Results</h1>
        <p class="text-muted">About {{ $classCount }} result(s) </p>
    </div>

    <div class="container table-responsive">
    @if($classesByLabelAndType)
        <?php $i = 1; ?>
        @foreach ($classesByLabelAndType as $label => $classesByType)
            <h3>{{ $label }}</h3>
            @foreach ($classesByType as $type => $classes)
                <h4>{{ $type }}</h4>
                <table class="table table-striped">
                    <th>Class</th>
                    <th>Section</th>
                    <th>CRN</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Professor</th>
                    <th>Enroll</th>
                    <th>Max Enroll</th>
                    <th>Credits</th>
                    @foreach ($classes as $class)
                        {{-- Highlight class with grey if they're full --}}
                        @if(
                            $class->enroll === $class->max_enroll ||
                            $class->enroll === "CLOSED"
                        )
                            <tr data-toggle="collapse" data-target="#class{{ $i }}" class="accordion-toggle moreMuted">
                                @include('schedulizer.class-rows')
                            </tr>
                        @else
                            <tr data-toggle="collapse" data-target="#class{{ $i }}" class="accordian-toggle info">
                                @include('schedulizer.class-rows')
                            </tr>
                        @endif
                        <?php $i++; ?>
                    @endforeach
                </table>
            @endforeach
        @endforeach
    @endif
    </div>
@stop
