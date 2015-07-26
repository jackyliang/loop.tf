@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="page-heading">
        <h1>Search for a Class</h1>
    </div>


    </form>
    <form
        method="GET"
        action="{{ URL('schedulizer/results') }}"
        accept-charset="UTF-8"
        class="form-inline global-search" role="form">
        <div class="form-group">
            <input type="search" class="form-control" id="q" name="q" placeholder="i.e. ECE 201, Digital Logic, Kandasamy, or 41045">
        </div>
        <button type="submit" id="s" class="btn btn-success">
            <span class="glyphicon glyphicon-search"></span>
        </button>
    </form>

@include('errors.list')
@include('js.classes-autocomplete')

@stop

