<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="@yield('description', Setting::get('description'))">
	<meta name="keywords" content="@yield('keywords', Setting::get('keywords'))">
	<meta name="author" content="Vantuz (visavi.net@mail.ru)">
	<meta name="generator" content="RotorCMS {{{ Setting::get('version') }}}">
	<title>
		@section('title')
			{{ Setting::get('sitetitle') }}
		@show
	</title>

	@section('styles')
		<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- <link href="/assets/css/bootstrap-theme.min.css" rel="stylesheet"> -->
		<link href="/assets/css/font-awesome.min.css" rel="stylesheet">
		<link href="/assets/css/prettify.css" rel="stylesheet">
		<link href="/assets/css/colorbox.css" rel="stylesheet">
		<link href="/assets/markitup/markitup.css" rel="stylesheet">
		<link href="/assets/css/toastr.min.css" rel="stylesheet">
		<link href="/assets/css/bootstrap-tagsinput.css" rel="stylesheet">
		<link href="/assets/css/app.css" rel="stylesheet">
		<link href="/assets/css/style.css" rel="stylesheet" />

		<!-- Theme skin -->
		<link id="t-colors" href="/assets/css/skins/default.css" rel="stylesheet" />
	@show
	@stack('styles')

	<link rel="image_src" href="/assets/img/images/icon.png">
	<link rel="alternate" href="/news/rss" title="RSS News" type="application/rss+xml">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<div id="wrapper">
	<!-- start header -->
	<header>
		<div class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/"><img src="/assets/img/logo.png" alt="" /></a>
				</div>
				<div class="navbar-collapse collapse ">
					<ul class="nav navbar-nav">
						<li class="{{ Request::is('news*') ? ' active' : '' }}"><a href="/news">Новости</a></li>
						<li class="{{ Request::is('guestbook*') ? ' active' : '' }}"><a href="/guestbook">Гостевая</a></li>
						<li class="{{ Request::is('forum*') ? ' active' : '' }}"><a href="/forum">Форум</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">Features <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="typography.html">Typography</a></li>
								<li><a href="components.html">Components</a></li>
								<li><a href="pricing-box.html">Pricing box</a></li>
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown">Pages</a>
									<ul class="dropdown-menu">
										<li><a href="fullwidth.html">Full width</a></li>
										<li><a href="right-sidebar.html">Right sidebar</a></li>
										<li><a href="left-sidebar.html">Left sidebar</a></li>
										<li><a href="comingsoon.html">Coming soon</a></li>
										<li><a href="search-result.html">Search result</a></li>
										<li><a href="404.html">404</a></li>
										<li><a href="register.html">Register</a></li>
										<li><a href="login.html">Login</a></li>
									</ul>
								</li>
							</ul>
						</li>

						@if (User::check())
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">{{ User::get('login') }} <i class="fa fa-angle-down"></i></a>
								<ul class="dropdown-menu">

									@if (User::isAdmin())
										<li><a href="/admin">Админ-панель</a></li>
									@endif
									<li><a href="/user/{{ User::get('login') }}">Профиль</a></li>
									<li><a href="/logout" onclick="return logout(this);">Выход</a></li>
								</ul>
							</li>

						@else
							<li class="{{ Request::is('login*') ? ' active' : '' }}"><a href="/login?{{ App::returnUrl() }}">Вход</a></li>
							<li class="{{ Request::is('register*') ? ' active' : '' }}"><a href="/register">Регистрация</a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</header>
	<!-- end header -->
	<section id="inner-headline">
		@yield('breadcrumbs')
	</section>

	<section id="content">
	<div class="container">
		<div class="row">

			<div class="col-lg-12">
				{{ App::getFlash() }}
			</div>

			<div class="col-lg-8">
				@yield('content')
			</div>
			<div class="col-lg-4">
				@include('right')
			</div>
		</div>
	</div>
	</section>
	<footer>
		@include('footer')
	</footer>
</div>

	@section('scripts')
		<script src="/assets/js/jquery-1.11.3.min.js"></script>
		<script src="/assets/js/jquery.form.min.js"></script>
		<script src="/assets/js/jquery.colorbox-min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
		<script src="/assets/js/bootstrap.file-input.js"></script>
		<script src="/assets/js/bootbox.min.js"></script>
		<script src="/assets/js/toastr.min.js"></script>
		<script src="/assets/js/bootstrap-tagsinput.min.js"></script>
		<script src="/assets/js/prettify.js"></script>
		<script src="/assets/markitup/jquery.markitup.js"></script>
		<script src="/assets/markitup/markitup.set.js"></script>
		<script src="/assets/js/app.js"></script>
	@show
	@stack('scripts')
</body>
</html>


