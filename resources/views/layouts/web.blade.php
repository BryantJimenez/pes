<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>

	{{-- <meta name="robots" content="index,follow" /> --}}
	{{-- <meta property="og:url" content="{{ url()->current() }}" />
	<meta property="og:type" content="@yield('ogtype', 'website')" />
	<meta property="og:title" content="@yield('title')" />
	<meta property="og:description" content="@yield('ogdescription', 'Texto descriptivo de la página.')" />
	<meta property="og:image" content="@yield('ogimage', asset('/web/img/logo.png'))" />
	<meta name="description" content="@yield('ogdescription', 'Texto descriptivo de la página.')">
	<meta name="twitter:card" content="summary" /> --}}
	{{-- <meta name="twitter:site" content="" />
	<meta name="twitter:creator" content="" /> --}}

	<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

	<!-- Google Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('/web/css/fontawesome/all.min.css') }}">
	<!-- Bootstrap core CSS -->
	<link href="{{ asset('/web/css/bootstrap.css') }}" rel="stylesheet">

	<!-- BASE CSS -->
	<link href="{{ asset('/web/css/template/style.css') }}" rel="stylesheet">
	<!-- BASE CSS -->
	
	<!-- SPECIFIC CSS -->
	@yield('links')
	<!-- SPECIFIC CSS -->

	<!-- Custom Style CSS -->
	<link href="{{ asset('/web/css/style.css') }}" rel="stylesheet">
	<!-- Custom Style CSS -->
</head>
<body class="goto-here bg-white">

	@yield('content')
	
	@include('web.partials.loader')

	<!-- JQuery -->
	<script type="text/javascript" src="{{ asset('/web/js/jquery-3.4.1.min.js') }}"></script>
	<!-- Bootstrap tooltips -->
	<script type="text/javascript" src="{{ asset('/web/js/popper.min.js') }}"></script>
	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="{{ asset('/web/js/bootstrap.min.js') }}"></script>

	@yield('scripts')

	<!-- Scripts -->
	<script type="text/javascript" src="{{ asset('/web/js/script.js') }}"></script>
	@include('web.partials.notifications')
</body>
</html>