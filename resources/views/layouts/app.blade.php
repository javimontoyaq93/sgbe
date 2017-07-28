<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
            <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                    <!-- CSRF Token -->
                    <meta content="{{ csrf_token() }}" name="csrf-token">
                        <title>
                            sgbe
                        </title>
                        <!-- Styles -->
                        <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
                            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
                                <!-- Scripts -->
                                <script>
                                    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
                                </script>
                            </link>
                            <link href="{{ asset('css/style.css') }}" media="screen" rel="stylesheet">
                                <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" media="screen" rel="stylesheet">
                                </link>
                                <link href="{{ asset('css/prettify.css') }}" media="screen" rel="stylesheet">
                                </link>
                                <link href="{{ asset('css/wysiwyg-color.css') }}" media="screen" rel="stylesheet">
                                </link>
                                <link href="{{ asset('css/bootstrap-wysihtml5.css') }}" media="screen" rel="stylesheet">
                                </link>
                            </link>
                        </link>
                    </meta>
                </meta>
            </meta>
        </meta>
    </head>
</html>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button class="navbar-toggle collapsed" data-target="#app-navbar-collapse" data-toggle="collapse" type="button">
                        <span class="sr-only">
                            Toggle Navigation
                        </span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        SGBE
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav pull-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li class="dropdown">
                            <a href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('crear-empleador') }}">
                                Registrar Empleador
                            </a>
                        </li>
                        @else
                        <li class="dropdown">
                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                {{ Auth::user()->name }}
                            </a>
                            <li>
                                <a href="{{ route('cambiar-clave') }}">
                                    Cambiar Clave
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="header" id="page-header">
            <div class="container">
                <div class="row-fluid">
                    <div class="pull-left">
                        <img height="100px" src="/imagenes/principal.jpg" width="160px">
                        </img>
                    </div>
                    <h2 style="color: #7A0303">
                        Bolsa de Empleo
                    </h2>
                </div>
            </div>
        </div>
        <center>
            <div class="carousel slide" data-ride="carousel" id="myCarousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li class="active" data-slide-to="0" data-target="#myCarousel">
                    </li>
                    <li data-slide-to="1" data-target="#myCarousel">
                    </li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img height="100px" src="/imagenes/turismo.jpg" width="500px">
                        </img>
                    </div>
                    <div class="item">
                        <img height="100px" src="/imagenes/agroecologia.jpg" width="500px">
                        </img>
                    </div>
                </div>
                <!-- Left and right controls -->
                <a class="left carousel-control" data-slide="prev" href="#myCarousel">
                    <span class="glyphicon glyphicon-chevron-left">
                    </span>
                    <span class="sr-only">
                        Previous
                    </span>
                </a>
                <a class="right carousel-control" data-slide="next" href="#myCarousel">
                    <span class="glyphicon glyphicon-chevron-right">
                    </span>
                    <span class="sr-only">
                        Next
                    </span>
                </a>
            </div>
        </center>
        <br>
            <div class="container-fluid">
                @yield('content')
            </div>
        </br>
    </div>
</body>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}">
</script>
<script charset="UTF-8" src="{{ asset('jquery/jquery-1.8.3.min.js' )}}" type="text/javascript">
</script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript">
</script>
<script charset="UTF-8" src="{{ asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript">
</script>
<script charset="UTF-8" src="{{ asset('js/locales/bootstrap-datetimepicker.es.js') }}" type="text/javascript">
</script>
<script charset="UTF-8" src="{{ asset('js/wysihtml5-0.3.0.js') }}" type="text/javascript">
</script>
<script charset="UTF-8" src="{{ asset('js/prettify.js') }}" type="text/javascript">
</script>
<script charset="UTF-8" src="{{ asset('js/bootstrap-wysihtml5.js') }}" type="text/javascript">
</script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
</script>
<script>
    $('.textarea').wysihtml5();
</script>
<script charset="utf-8" type="text/javascript">
    $(prettyPrint);
</script>
