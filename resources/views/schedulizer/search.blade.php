@extends('app_sched')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="page-heading">
        <h1>Search for a Class</h1>
    </div>

    @include('schedulizer.cart-fixed-button')

    <form
        method="GET"
        action="{{ URL('schedulizer/results') }}"
        accept-charset="UTF-8"
        class="form-inline global-search" role="form">
        <div class="form-group">
            <input
                type="search"
                class="form-control floating-label"
                id="q"
                name="q"
                placeholder="i.e. ECE 201, Digital Logic, Kandasamy, or 41045"
            >
        </div>
        <button type="submit" class="btn btn-material-teal">
            <span class="glyphicon glyphicon-search"></span>
        </button>
    </form>

    @include('errors.list')
    @include('js.classes-autocomplete')
    @include('js.cart-quantity')
    @include('js.select-all')

@stop

