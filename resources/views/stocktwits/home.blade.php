@extends('app')

@section('title')
    StockTwits Results
@stop

@section('content')
    <div class="page-heading-results">
        <h1>S&P500 vs StockTwits Emotional Sentiment</h1>
        <p
            class="text-muted">
            Is there correlation between <a href="http://stocktwits.com/symbol/SPX">StockTwits sentiment</a> vs the <a href="https://www.google.com/finance/historical?cid=626307&startdate=Aug+5%2C+2015&enddate=Sep+5%2C+2015&num=30&ei=9c_rVbm3H9bCe4mkj-gH">S&P 500 stock index?</a>
        </p>
    </div>

    <body>
        <div id="chart_div"></div>
    </body>

@stop

@include('js.amchart')
