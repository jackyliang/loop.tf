@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="form-group">

        {!! Form::label('search_class', 'Search for a class!'); !!}
        {!! Form::open(['action' => ['SchedulizerController@result'], 'method' => 'GET']) !!}
        {!! Form::text('q', '', ['class' => 'form-control', 'id' =>  'q', 'placeholder' =>  'i.e. ECE 201 or Digital Logic Design']) !!}
        {!! Form::submit('Search', array('class' => 'btn btn-success form-control')) !!}
        {!! Form::close() !!}
    </div>

    @include('js.classes-autocomplete')

@stop

