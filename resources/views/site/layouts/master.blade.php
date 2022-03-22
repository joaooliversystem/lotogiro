<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('site/layouts/css/master.css')}}">
    <link rel="shortcut icon" href="{{{ asset('admin/images/painel/rodafortuna.png') }}}">
    @stack('style')
    @livewireStyles

</head>
<body class="layout-top-nav">

<div class="wrapper">
    @include('site.layouts.navbar')

    <div class="content-wrapper bg-white">
        @yield('content')
    </div>

</div>
<script src="{{asset('site/layouts/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('site/layouts/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('site/layouts/js/master.js')}}"></script>

@stack('scripts')
@livewireScripts


</body>

</html>
