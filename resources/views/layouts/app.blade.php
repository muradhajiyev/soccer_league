<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">
                    League
                </a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ url('/') }}">Home</a></li>
            </ul>

        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>
</div>
</body>
</html>
