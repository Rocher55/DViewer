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

    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
   <!-- <link rel="stylesheet" href="{{asset('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css') }}">i
    <link rel="stylesheet" href="{{asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{asset('/css/chosen.css') }}">
    -->

    <!-- Script but before-->
    <script>
        //this is a way to pass routes to JS, as the same routes are not used in production and in dev
        //do not mind the error PHPstorm shows in that case, it's a little buggy when you're mimùpixing up PHP and JS
        const routeToExistsApi= {!!  json_encode(route('api/exists/center-protocol'),JSON_HEX_TAG) !!};
        const routeToCentersApi={!!  json_encode(route('api/centers')) !!};
        const routeToProtocolsApi={!!  json_encode(route('api/protocols')) !!};
        const routeToCidsApi={!!  json_encode(route('api/cids')) !!};
    </script>


</head>

<body>
    <div id="app">
        @yield('importSidebar')

        <div>
            @yield('importForm')
        </div>
    </div>
</body>


<!-- Scripts -->
<script src="{!! asset('js/app.js') !!}"></script>
<!-- <script src="{!! asset('js/chosen.js') !!}"></script>
     <script src="{!! asset('js/chosen.jquery.js') !!}"></script>
    <script src="{!! asset('js/bootstrap.min.js') !!}"></script>
    -->

