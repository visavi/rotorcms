<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<link href="/assets/css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="/assets/css/font-awesome.min.css" rel="stylesheet">
		<link href="/assets/css/prettify.css" rel="stylesheet">
		<link href="/assets/css/colorbox.css" rel="stylesheet">
		<link href="/assets/markitup/markitup.css" rel="stylesheet">
		<link href="/assets/css/app.css" rel="stylesheet">
	@show

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

	<!-- Fixed navbar -->
	<div class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand text-uppercase" href="/">{{ Setting::get('sitetitle') }}</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
				<li class="{{ Request::is('news*') ? ' active' : '' }}"><a href="/news">Новости</a></li>
				<li class="{{ Request::is('guestbook*') ? ' active' : '' }}"><a href="/guestbook">Гостевая</a></li>
				<li class="{{ Request::is('forum*') ? ' active' : '' }}"><a href="/forum">Форум</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li class="dropdown-header">Nav header</li>
						<li><a href="#">Separated link</a></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">

					@if (User::check())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ User::getUser('login') }} <b class="caret"></b></a>
							<ul class="dropdown-menu">

								@if (User::isAdmin())
									<li><a href="/admin">Админ-панель</a></li>
								@endif
								<li><a href="/user/{{ User::getUser('login') }}">Профиль</a></li>
								<li><a href="/logout" onclick="return logout(this);">Выход</a></li>
							</ul>
						</li>

					@else
						<li class="{{ Request::is('login*') ? ' active' : '' }}"><a href="/login?{{ App::returnUrl() }}">Вход</a></li>
						<li class="{{ Request::is('register*') ? ' active' : '' }}"><a href="/register">Регистрация</a></li>
					@endif
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>

	<!-- Begin page content -->
	<div class="container">
		<div class="row main">
		<?php /*App::render('includes/note', compact('php_self')); */?>

			<div class="col-lg-12">
				{{ App::getFlash() }}
			</div>

			<div class="col-lg-9">
				@yield('breadcrumbs')
				@yield('content')
			</div>

			<div class="col-lg-3">
				@include('right')
			</div>
		</div>
	</div>

	<div class="footer">
		<div class="container">
		<?php /*
			<div class="pull-left"><?= show_online() ?></div>
			<div class="pull-right"><?= show_counter() ?></div>
				{{ perfomance() }}*/?>
		</div>
	</div>

	@section('scripts')
		<script src="/assets/js/jquery-1.11.3.min.js"></script>
		<script src="/assets/js/jquery.form.min.js"></script>
		<script src="/assets/js/jquery.colorbox-min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
		<script src="/assets/js/bootstrap.file-input.js"></script>
		<script src="/assets/js/bootbox.min.js"></script>
		<script src="/assets/js/notify.min.js"></script>
		<script src="/assets/js/prettify.js"></script>
		<script src="/assets/markitup/jquery.markitup.js"></script>
		<script src="/assets/markitup/markitup.set.js"></script>
		<script src="/assets/js/app.js"></script>
	@show
</body>
</html>


