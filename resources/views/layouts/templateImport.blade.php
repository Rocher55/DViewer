<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}"/>


    <title>Data Viewer</title>


    <!--Feuilles CSS-->
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


</head>

<body>
    @yield('importSidebar')

    <div>
        @yield('importForm')
    </div>
</body>