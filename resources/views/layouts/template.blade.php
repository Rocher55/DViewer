<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Paul CARRERE">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}"/>


    <title>Data Viewer</title>


    <!--Feuilles CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/css/style.css') }}">
    <link rel="stylesheet" href="https://harvesthq.github.io/chosen/chosen.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="{!! asset('js/chosen.js') !!}"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{!! asset('js/ajax-previous.js') !!}"></script>



</head>

<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <!--Nom du site-->
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Data Viewer') }}
                </a>
            </div>
            <!--Contenu de la navBar-->
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!--A gauche-->
                <ul class="nav navbar-nav navbar-left">
                    <li class="nav-item "><a href="{{ url('/research/protocol') }}"> Research </a></li>
                    <li class="nav-item "><a href="{{ url('/import') }}"> Import </a></li>

                </ul>

            </div>
        </div>
    </nav>
    <div class="path">
        {{str_replace(url('/'), '', url()->current())}}
    </div>

    @if(session('success'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
    @endif
    @if(session('nothing'))
        <div class="container text-center">
            <div class="alert alert-danger">
                {{ session('nothing') }}
            </div>
        </div>
    @endif
    @yield("content")
</div>


@yield("script")
</body>


</html>