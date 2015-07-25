@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="form-group">

        <div class="page-heading">
            <h1>Search for a Class</h1>
        </div>

        {!! Form::open(['action' => ['SchedulizerController@result'], 'method' => 'GET']) !!}
        {!! Form::text('q', '', [
            'class' => 'form-control',
            'id' =>  'q',
            'placeholder' =>  'i.e. ECE 201, Digital Logic, Kandasamy, or 41045'
        ]) !!}
        {!! Form::submit('Search', array('class' => 'btn btn-success form-control')) !!}
        {!! Form::close() !!}
    </div>

    @include('js.classes-autocomplete')

@stop

