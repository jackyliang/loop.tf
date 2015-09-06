@extends('app_sched')

@section('title')
    StockTwits Results
@stop

@section('content')
    <div class="page-heading-results">
        <h1>S&P500 vs StockTwits Emotional Sentiment</h1>
        <p
            class="text-muted">
            Showing correlation between sentiment vs the S&P 500 stock index
        </p>
    </div>

    <body>
        <div id="chart_div"></div>
    </body>

@stop

@include('js.amchart')
