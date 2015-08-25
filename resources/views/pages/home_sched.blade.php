@extends('app_sched')

@section('title')
    Schedulizer
@stop

@section('content')
    <div class="jumbotron">
        <h1>Schedulizer is back, baby.</h1>
        <p class="lead">The Drexel Schedulizer allows you to find classes and generate the perfect schedule for each term.</p>
        <p><a class="btn btn-lg btn-success" href="{{ URL('schedulizer/search') }}" role="button">Search for classes now!</a></p>
    </div>

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">It's fast. <span class="text-muted">Find the perfect schedule in under a minute.</span></h2>
            <p class="lead">Everything from searching for a class, to generating a schedule, Schedulizer is ridiculously fast. With RateMyProfessor integration, you can do on-the-fly comparisons between different sections of a class. Generated too many schedules? Find the one you like by telling Schedulizer the days you don't want classes, show only non-full classes, and way more.</p>
        </div>
        <div class="col-md-5">
            <img class="featurette-image img-responsive center-block" src="{{ URL('images/1.jpg') }}" alt="Generic placeholder image">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
            <h2 class="featurette-heading">It's beautiful. <span class="text-muted">See for yourself.</span></h2>
            <p class="lead">Gone are the days of squinting your eyes to find the CRN from the Drexel Term Master Schedule. Schedulizer is easy to use, beautiful, but also doesn't lack any information.</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
            <img class="featurette-image img-responsive center-block" src="{{ URL('images/3.jpg') }}" alt="Generic placeholder image">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">It's accurate. <span class="text-muted">Synchronized every half an hour.</span></h2>
            <p class="lead">We know how fast classes fill up during registration time. So all class information is synchronized with the Term Master Schedule every half an hour, making sure you are getting only the must up-to-date information.</p>
        </div>
        <div class="col-md-5">
            <img class="featurette-image img-responsive center-block" src="{{ URL('images/2.jpg') }}"  alt="Generic placeholder image">
        </div>
    </div>

    <hr class="featurette-divider">
@stop

