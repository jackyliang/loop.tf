@extends('app_sched')

@section('title')
    StockTwits Results
@stop

@section('content')
    <div class="page-heading-results">
        <h1>Results</h1>
        <p
            class="text-muted">
            Showing correlation between sentiment vs the S&P 500 stock index
        </p>
    </div>

    <body>
        <div id="chartdiv"></div>
    </body>

@stop

@include('js.amchart')
