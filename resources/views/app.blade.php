<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>

    <!-- CSS -->
	<link href="/css/all.css" rel="stylesheet">
    <!-- Scripts -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js'></script>
    <script type="text/javascript"></script>

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

</head>
<body>
    @include('partials.nav')

    <div class="container">
	    @yield('content')
    </div>

    <div class="panel-footer navbar-bottom">
        @include('partials.footer')
    </div>

    @include('google.analytics');

</body>
</html>
