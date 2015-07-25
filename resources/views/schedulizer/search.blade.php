@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="form-group">

        <div class="page-heading">
            <h1>Search for a Class</h1>
        </div>

        <div class="container half-page">

            <div class="form-group">
                {!! Form::open(['action' => ['SchedulizerController@results'], 'method' => 'GET']) !!}
                {!! Form::text('q', '', [
                'class' => 'form-control error',
                'id' =>  'q',
                'placeholder' =>  'i.e. ECE 201, Digital Logic, Kandasamy, or 41045'
                ]) !!}
            </div>

            @include('errors.list')

            <div class="text-center">
                {!! Form::submit('Search', array('class' => 'btn btn-success')) !!}
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@include('js.classes-autocomplete')

@stop

