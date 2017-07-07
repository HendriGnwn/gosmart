<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <title> @yield('title'){{ config('app.name', 'PromoApp Systems') }}</title>

    @section('header')
        @include('layouts.auth.header')
    @show

</head>

<body class="fixed-header">
	<div class="login-wrapper">
		<div class="bg-pic">
			<img alt="" class="lazy" data-src="{{url('img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}" data-src-retina="{{url('img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}" src="{{url('img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}">
			<div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
				<h2 class="semi-bold text-white">Promo App System</h2>
				<p class="small">Cranium &copy 2017</p>
			</div>
		</div>
		@yield("content")
	</div>


    @section('scripts')
        @include('layouts.auth.script')
    @stack('script')
</body>
</html>
