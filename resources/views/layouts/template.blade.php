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
    <!--<link rel="stylesheet" href="{{asset('/css/app.css')}}">-->
    <link rel="stylesheet" href="{{asset('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{asset('/css/chosen.css') }}">
    <link rel="stylesheet" href="{{asset('/css/jquery.auto-complete.css') }}">

    <!-- Scripts -->

    <script src="{!! asset('js/jquery-3.3.1.js') !!}"></script>
    <script src="{!! asset('js/chosen.js') !!}"></script>
    <script src="{!! asset('js/chosen.jquery.js') !!}"></script>
    <script src="{!! asset('js/bootstrap.min.js') !!}"></script>
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
                        <spanre class="sr-only">Toggle Navigation</spanre>
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
                        <li class="nav-item "><a href="{{ route('protocol') }}"> Research </a></li>

                    </ul>
                    @if(Auth::user()->isAdminOrAdmiral())
                    <ul class="nav navbar-nav navbar-left">
                        <li class="nav-item "><a href="{{ route('voyager.login')}}"> Admin </a></li>
                    </ul>
                    @endif
                    <ul class="nav navbar-nav navbar-left">
                        <li class="nav-item "><a href="{{ route('logout')}}"> Logout </a></li>
                    </ul>

                </div>
            </div>
        </nav>
        @php($path = explode('/', url()->current()))
        @if(in_array('research', $path))
            <div class="path">
                {{str_replace(url('/'), '', url()->current())}}
            </div>
            <div class="number">
                @if(Session::has('patientID'))
                    {{count(Session::get('patientID'))}}
                    remaining
                    @if(count(Session::get('patientID'))==1)
                        patient
                    @else
                        patients
                    @endif
                <br>
                    Woman % : {{Session::get('percentage')}}
                <br>
                    Man % : {{100-Session::get('percentage')}}
                @endif
            @endif
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


    <script src="{!! asset('js/input-manager.js') !!}"></script>
    @yield("script")


</body>

<footer>
    <div class="footer">
        <p>App developed by <a href="{{route('pro')}}" target="_blank">Paul CARRERE</a></p>
    </div>
</footer>


</html>