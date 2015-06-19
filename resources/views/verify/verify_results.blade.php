@extends('app')

@section('title')
    loop.tf - Verification Results
@stop


@section('content')
    <h1 class="page-heading">Results</h1>

    {!! $ourTeamName !!}

    @include('errors.list')
@stop