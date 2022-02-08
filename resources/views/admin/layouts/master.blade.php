<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/overlayScrollbars/css/OverlayScrollbars.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layouts/css/master.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,400,600">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quattrocento&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <link rel="shortcut icon" href="{{{ asset('admin/images/painel/Trevo.png') }}}">

    @livewireStyles

    <style>
        body, * {
            font-family: "Exo", sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="font-family: Montserrat, sans-serif;">
@if (session('success'))
    @push('scripts')
        <script>
            toastr["success"]("{{ session('success') }}")
        </script>
    @endpush
@endif
@if (session('error'))
    @push('scripts')
        <script>
            toastr["error"]("{{ session('error') }}")
        </script>
    @endpush
@endif
<div class="wrapper">
    @include('admin.layouts.navbar')
    @include('admin.layouts.sidebar')

    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.assets.footer')

</div>

<div class="modal fade text-center py-5"  id="offerModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="top-strip"></div>
                <div class="h2">
                    <img class="img-circle img-fluid" src="http://lotogiro.pc/admin/images/painel/Trevo.png"
                         alt="" style="max-height: 15vh;">
                </div>
                <h2 class="pb-1 text-muted">Sem Saldo? Que tal fazer uma recarga agora?</h2>

                <div class="row">
                    <div class="col-sm-6">
                        <a class="btn btn-warning btn-block text-bold pointer-event closeOffer">Não quero jogar
                            ainda.</a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.dashboards.wallet.recharge') }}" class="btn btn-primary btn-block
                        text-bold closeOffer">Vamos lá!</a>
                    </div>
                </div>
                <div class="bottom-strip"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('admin/layouts/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/overlayScrollbars/js/OverlayScrollbars.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/layouts/js/master.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>

<script>
    $(document).on('click', '.closeOffer', function () {
        console.log(Cookies.get('offerNegative'));
        Cookies.set("offerNegative", "close");
        $('#offerModal').modal('hide');
        console.log(Cookies.get('offerNegative'));
    });

    $(document).ready(function () {
        if (document.cookie.indexOf("offerNegative") >= 0) {
            if (Cookies.get("offerNegative") === 'open') {
                $('#offerModal').modal('show');
            }
        }
        bsCustomFileInput.init();
    });
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

@livewireScripts
@stack('scripts')

</body>

</html>
