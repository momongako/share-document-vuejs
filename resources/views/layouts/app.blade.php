<!DOCTYPE html>

<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/logo/Logo_edoc_1.svg')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

    <!-- use bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    {{--Font Awesome--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    {{--    Icon Bootstrap--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    {{--BoxIcon--}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <!-- Scripts -->
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        window.Laravel = {!! json_encode(
    [
        'csrfToken' => csrf_token(),
        'baseUrl' => url('/'),
    ],
    JSON_UNESCAPED_UNICODE,
) !!};
    </script>
</head>

<body class="c-app">
<div id="app">
    <div class="c-wrapper">
        @include('layouts.header')
        <div class="c-body">
            <main class="c-main c-content-wraper">
                <div class="container-fluid">
                     @yield('content')
                </div>
            </main>
        </div>
    </div>
</div>
@yield('javascript')
</body>

</html>
