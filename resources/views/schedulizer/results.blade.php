@extends('app_sched')

@section('title')
    loop.tf - {{ $term }}
@stop

@section('content')
    <div class="page-heading-results">
        <h1>Results</h1>
        <p
            class="text-muted">
            About {{ $classCount }} results last updated {{ $lastUpdated }}
        </p>
    </div>

    <button
        id="fixed-button"
        class="btn btn-fab btn-raised btn-material-yellow-600 mdi-action-list">
        <span id="jewel" class="jewel"></span>
    </button>

    <div class="container table-responsive">
    @if($classesByLabelAndType)
        <?php $i = 1; ?>
        @foreach ($classesByLabelAndType as $label => $classesByType)
            <h3
                class="margin-class-name"
            >
                {{ $label }}
            </h3>
            @foreach ($classesByType as $type => $classes)
                <div
                    class="margin-class-type"
                >
                    <h4>
                        <div class="title-container">{{ $type }}
                            <a
                                data-class-name="{{ $label }} {{ $type}}"
                                class="btn btn-material-yellow-600 btn-xs btn-raised cart-button mdi-content-add-circle-outline">
                                I want this!
                            </a>
                        </div>
                    </h4>
                    <table
                        class="table table-striped"
                    >
                        <th>Class</th>
                        <th>Section</th>
                        <th>CRN</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Professor</th>
                        <th>Enrolled</th>
                        <th>Max Enroll</th>
                        <th>Credits</th>
                        @foreach ($classes as $class)
                            {{-- Highlight class with grey if they're full --}}
                            @if(
                                $class->enroll === $class->max_enroll ||
                                $class->enroll === "FULL"
                            )
                                <tr
                                    data-toggle="collapse"
                                    data-target="#class{{ $i }}"
                                    class="accordion-toggle moreMuted"
                                >
                                    @include('schedulizer.class-rows')
                                </tr>
                            @else
                                <tr
                                    data-toggle="collapse"
                                    data-target="#class{{ $i }}"
                                    class="accordian-toggle info"
                                >
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
@stop

