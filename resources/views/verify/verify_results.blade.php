@extends('app')

@section('title')
    loop.tf - Verification Results
@stop


@section('content')
    <h1 class="page-heading">Results</h1>
    <div class="container">
        <h3>Number of Unrostered Players:
            @if($unrosteredNumber == 0)
                <span class="label label-success">{{ $unrosteredNumber }}</span>
            @elseif($unrosteredNumber > 0 && $unrosteredNumber < 3)
                <span class="label label-warning">{{ $unrosteredNumber }}</span>
            @else
                <span class="label label-danger">{{ $unrosteredNumber }}</span>
            @endif
        </h3>

        @if($unrostered)
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Steam Name</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($unrostered as $name => $profile)
                        <tr>
                            <td>
                                <a
                                    href="{{ $profile }}">{{ $name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No unrostered players!</p>
        @endif
    </div>
    @include('errors.list')
@stop