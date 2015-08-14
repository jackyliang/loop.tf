<nav class="navbar navbar-default shadow-z-1">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Loop's TF2 Apps</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                <li class="{{ Request::is('ugc') ? 'active' : '' }}"><a href="{{ url('/ugc') }}">Verify UGC</a></li>
                <li class="{{ Request::is('schedulizer') ? 'active' : '' }}"><a href="{{ url('/schedulizer') }}">Schedulizer</a></li>
            </ul>
        </div>

    </div>

</nav>