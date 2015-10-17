@extends('app')

@section('title')
    loop.tf - Verify UGC Roster
@stop

@section('content')
    <div class="page-heading">
        <h1>Verify Server UGC Roster</h1>
        <div class="text-center">
            <button
                    type="button"
                    class="btn btn-link"
                    data-toggle="popover"
                    data-trigger="focus"
                    title="{{ $popoverTitle }}"
                    data-content="{{ $popoverText }}"
                    >
                What is this?
            </button>
        </div>

        <a class="btn btn-link" href="http://www.ugcleague.com/rankings_tf2h_all.cfm">What is my team?</a>

    </div>


    {!! Form::open(['method' => 'POST', 'action' => 'UGCController@verify']) !!}

    <div class="form-group">
        {!! Form::label('our_team_link', 'Your team\'s UGC profile link'); !!}
        {!! Form::text('our_team_link', null, ['class' => 'form-control',
                                               'placeholder' => $ourTeamURL]); !!}
    </div>

    <div class="form-group">
        {!! Form::label('their_team_link', 'Opposing team\'s UGC profile link'); !!}
        {!! Form::text('their_team_link', null, ['class' => 'form-control',
                                                'placeholder' => $theirTeamURL]); !!}
    </div>

    <div class="form-group">
        {!! Form::label('status_text', 'Status text'); !!}
        {!! Form::textarea('status_text', null, ['class' => 'form-control',
                                                 'placeholder' => $sampleStatus]); !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Verify', ['class' => 'btn btn-success form-control']) !!}
    </div>

    @include('errors.list')

    {!! Form::close() !!}

    @include('js.popup')

@stop

