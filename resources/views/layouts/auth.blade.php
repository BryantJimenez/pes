<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}"/>
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('/favicon.ico') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('/favicon.ico') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('/favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <!-- Google Fonts -->

    <link href="{{ asset('/admins/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/web/css/template/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/web/css/template/order-sign_up.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
</head>
<body id="register_bg">

    @yield('content')

    <!-- JQuery -->
    <script type="text/javascript" src="{{ asset('/web/js/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ asset('/web/js/popper.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ asset('/web/js/bootstrap.min.js') }}"></script>  

    <script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
    <script src="{{ asset('/admins/js/validate.js') }}"></script>
    <script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
    @include('admin.partials.notifications')
</body>
</html>