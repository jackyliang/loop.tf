@extends('app_sched')

@section('title')
    loop.tf - {{ $term }}
@stop

@section('content')
    <div class="page-heading-results">
        <h1>Results</h1>
        <p class="text-muted">About {{ $classCount }} result(s) last updated {{ $lastUpdated }}</p>
    </div>

    <div class="container table-responsive">
    @if($classesByLabelAndType)
        <?php $i = 1; ?>
        @foreach ($classesByLabelAndType as $label => $classesByType)
            <h3
                style="margin: 50px 0px 0px 0px;">
                {{ $label }}
            </h3>
            @foreach ($classesByType as $type => $classes)
                <div style="margin: 0px 0px 0px 30px;">
                    <h4>{{ $type }}
                        <a
                            href="javascript:void(0)"
                            class="btn btn-primary btn-xs btn-raised mdi-content-add"
                            style="margin: 10px 20px;">
                            Add This!
                        </a>
                    </h4>
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
                </div>
            @endforeach
        @endforeach
    @endif
    </div>
    <button class="btn btn-fab btn-raised btn-material-red"><i class="mdi-navigation-arrow-forward"></i></button>
@stop
