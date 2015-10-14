<nav class="navbar navbar-default shadow-z-1">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Jacky's Projects</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('schedulizer') ? 'active' : '' }}"><a href="http://schedulizer.me"><span class="glyphicon glyphicon-education"></span> Schedulizer</a></li>
                <li class="{{ Request::is('groupthink') ? 'active' : '' }}"><a href="{{ url('/groupthink') }}"><span class="glyphicon glyphicon-object-align-horizontal"></span> GroupThink</a></li>
                <li class="{{ Request::is('ugc') ? 'active' : '' }}"><a href="{{ url('/ugc') }}"><span class="glyphicon glyphicon-ok"></span> Verify UGC</a></li>
            </ul>
        </div>

    </div>

</nav>