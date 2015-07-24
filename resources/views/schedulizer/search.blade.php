@extends('app')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="form-group">
        {!! Form::open(['action' => ['SchedulizerController@search'], 'method' => 'GET']) !!}
        {!! Form::text('q', '', ['class' => 'form-control', 'id' =>  'q', 'placeholder' =>  'Enter name']) !!}
        {!! Form::submit('Search', array('class' => 'btn btn-success form-control')) !!}
        {!! Form::close() !!}
    </div>

    @include('js.classes-autocomplete')

@stop

