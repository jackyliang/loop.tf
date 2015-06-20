@extends('app')

@section('title')
    loop.tf - Results
@stop


@section('content')
    <div class="alert alert-success" roll="alert">
        <strong>Click on the name!</strong> You will be linked to their Steam profile.
    </div>
    <h1 class="page-heading">Results</h1>
    <div class="container">
        <h3># of Unrostered Players:
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
                    <th>Name</th>
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
        @endif

        <h3># of Players on <a href="{{ $ourRosterURL }}">{{ $ourRosterName }}</a>:

            @if($ourRosterSize == 9)
                <span class="label label-success">{{ $ourRosterSize }}</span>
            @else
                <span class="label label-warning">{{ $ourRosterSize }}</span>
            @endif
        </h3>

        @if($ourTeamProfile)
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ourTeamProfile as $name => $profile)
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
        @endif

        <h3># of Players on <a href="{{ $theirRosterURL }}">{{ $theirRosterName }}</a>:

            @if($theirRosterSize == 9)
                <span class="label label-success">{{ $theirRosterSize }}</span>
            @else
                <span class="label label-warning">{{ $theirRosterSize }}</span>
            @endif
        </h3>

        @if($theirTeamProfile)
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($theirTeamProfile as $name => $profile)
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
        @endif

    </div>
    @include('errors.list')
@stop