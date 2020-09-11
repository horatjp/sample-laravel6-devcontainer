<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="referrer" content="no-referrer">
<title>@yield('title') {{ config('app.name') }}</title>

<link href="{{ asset('_backend/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('_backend/css/style.css') }}" rel="stylesheet">

@yield('head')
</head>
@section('body')
<body class="hold-transition layout-top-nav">

<div class="wrapper" id="app">

    <nav class="main-header navbar navbar-expand-md navbar-dark">

        <div class="container-fluid">

            <a href="{{ route('backend.index') }}" class="navbar-brand">
                <h3 class="m-0 text-white">{{ config('app.name') }}</h3>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a href="{{ route('backend.article.index') }}" class="nav-link">記事</a>
                    </li>

                </ul>

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown">

                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" class="nav-link dropdown-toggle">設定</a>

                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu dropdown-menu-right shadow">

                            <li><a href="{{ url('/') }}" class="dropdown-item">サイト</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ route('backend.logout') }}" class="dropdown-item">ログアウト</a></li>
                        </ul>

                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
    @yield('content')
    </div>



    <footer class="main-footer text-sm">

        <div class="float-right d-none d-sm-inline">

        </div>

        <strong>&copy; {{ config('app.name') }}</strong>
    </footer>


</div>

<script src="{{ asset('_backend/js/app.js') }}"></script>
<script src="{{ asset('_backend/js/script.js') }}"></script>


@yield('foot')
</body>
@show
</html>
