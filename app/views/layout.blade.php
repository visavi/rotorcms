<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="%KEYWORDS%" />
	<meta name="description" content="%DESCRIPTION%" />
	<meta name="generator" content="RotorCMS {{{ Setting::get('rotorversion') }}}" />
	<title>
		@section('title')
			{{{ Setting::get('title') }}}
		@show
	</title>

	@section('styles')
		<link href="/themes/default/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/themes/default/css/bootstrap-theme.min.css" rel="stylesheet" />
		<link href="/themes/default/css/font-awesome.min.css" rel="stylesheet" />
		<link href="/themes/default/css/prettify.css" rel="stylesheet">
		<link href="/themes/default/css/opensans.css" rel="stylesheet" />
		<link href="/assets/markitup/markitup.css" rel="stylesheet" />
		<link href="/themes/default/css/app.css" rel="stylesheet" />
	@show

	<link rel="image_src" href="/images/img/icon.png" />
	<link rel="alternate" href="/news/rss" title="RSS News" type="application/rss+xml" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
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
				<a class="navbar-brand" href="/">{{{ Setting::get('title') }}}</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
				<li<?= (strstr(App::requestURI(), '/guestbook') ? ' class="active"' : '') ?>><a href="/guestbook">Гостевая</a></li>
				<li<?= (strstr(App::requestURI(), '/forum') ? ' class="active"' : '') ?>><a href="/forum">Форум</a></li>
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

					<?php if (User::check()): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= User::get()->getLogin() ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">

								<?php if (is_admin()): ?>
									<li><a href="/admin">Админ-панель</a></li>
								<?php endif; ?>
								<li><a href="/user/<?= User::get()->id ?>">Профиль</a></li>
								<li><a href="/logout">Выход</a></li>
							</ul>
						</li>

					<?php else: ?>
						<li<?= (App::requestURI() == '/login') ? ' class="active"' : '' ?>><a href="/login">Вход</a></li>
						<li<?= (App::requestURI() == '/register') ? ' class="active"' : '' ?>><a href="/register">Регистрация</a></li>
					<?php endif; ?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>

	<!-- Begin page content -->
	<div class="container">
		<div class="row main">
		<?php /*App::render('includes/note', compact('php_self')); */?>
			<div class="col-lg-9">
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
			<div class="pull-right"><?= show_counter() ?></div> */?>
				{{ perfomance() }}
		</div>
	</div>

	@section('scripts')
		<script src="/themes/default/js/jquery-1.11.2.min.js"></script>
		<script src="/themes/default/js/bootstrap.min.js"></script>
		<script src="/themes/default/js/notify.min.js"></script>
		<script src="/themes/default/js/prettify.js"></script>
		<script src="/assets/markitup/jquery.markitup.js"></script>
		<script src="/assets/markitup/markitup.set.js"></script>
		<script src="/themes/default/js/app.js"></script>
	@show
</body>
</html>


