@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="form-group">

        {!! Form::label('search_class', 'Search for a class (like the instructor name or the class name)!'); !!}
        {!! Form::open(['action' => ['SchedulizerController@search'], 'method' => 'GET']) !!}
        {!! Form::text('q', '', ['class' => 'form-control', 'id' =>  'q', 'placeholder' =>  'i.e. ECE 201 or Kandasamy']) !!}
        {!! Form::submit('Search', array('class' => 'btn btn-success form-control')) !!}
        {!! Form::close() !!}
    </div>

    @include('js.classes-autocomplete')

@stop

