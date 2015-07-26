<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/schedulizer') }}">Schedulizer</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/schedulizer') }}">Home</a></li>
                <li><a href="{{ url('/schedulizer/search') }}">Search</a></li>
            </ul>

            {{-- Show search bar if we're in the results page --}}
            <ul class="nav navbar-nav navbar-right">
                @if(Request::url() === URL('schedulizer/results'))
                    @include('search.form')
                @endif
            </ul>
        </div>

    </div>

</nav>