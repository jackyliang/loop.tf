@extends('app')

@section('title')
    loop.tf - Verify UGC Roster
@stop

@section('content')
    <h1 class="page-heading">Verify Server UGC Roster</h1>

    {!! Form::open(['method' => 'POST', 'action' => 'UGCController@verify']) !!}

    <div class="form-group">
        {!! Form::label('our_team_link', 'Your team\'s UGC profile link'); !!}
        {!! Form::text('our_team_link', null, ['class' => 'form-control',
                                               'placeholder' => $ourTeamURL]); !!}
    </div>

    <div class="form-group">
        {!! Form::label('their_team_link', 'Enemy team\'s UGC Profile Link'); !!}
        {!! Form::text('their_team_link', null, ['class' => 'form-control',
                                                'placeholder' => $theirTeamURL]); !!}
    </div>

    <div class="form-group">
        {!! Form::label('status_text', ''); !!}
        {!! Form::textarea('status_text', null, ['class' => 'form-control',
                                                 'placeholder' => $sampleStatus]); !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Verify UGC Roster', ['class' => 'btn btn-primary form-control']) !!}
    </div>


    @include('errors.list')

    {!! Form::close() !!}
@stop