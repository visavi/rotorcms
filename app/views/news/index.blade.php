@extends('layout')

@section('title', 'Новости сайта - @parent')
@section('breadcrumbs', App::breadcrumbs(['Новости сайта']))

@section('content')

	@if (User::isAdmin())
		<div class="pull-right">
			<a class="btn btn-sm btn-success" href="/news/create">Добавить новость</a>
		</div>
	@endif

	<h1>Новости сайта</h1>

	@if ($news_list)
		@foreach ($news_list as $news)

<article>
	<div class="post-image">
		<div class="post-heading">
			<h3><a href="/{{ $news->category->slug }}/{{ $news->slug }}">{{ $news->title }}</a></h3>
		</div>
		@if ($news->image)
			<img src="/uploads/news/images/{{ $news->image }}" alt="" class="img-responsive" />
		@endif
	</div>
	<p>
		 {!! App::bbCode(str_limit(e($news->text))) !!}
	</p>
	<div class="bottom-article">
		<ul class="meta-post">
			<li><i class="fa fa-calendar"></i><a href="#">{{ Carbon::parse($news->created_at)->format('d.m.y / H:i') }}</a></li>
			<li><i class="fa fa-user"></i><a href="/user/{{ $news->user()->getLogin() }}">{{ $news->user()->getLogin() }}</a></li>
			<li><i class="fa fa-folder-open"></i><a href="/{{ $news->category->slug }}">{{ $news->category->name }}</a></li>
			<li><i class="fa fa-comments"></i><a href="#">{{ App::plural($news->commentCount(), ['комментарий', 'комментария', 'комментариев']) }}</a></li>
		</ul>
		<a href="/{{ $news->category->slug }}/{{ $news->slug }}" class="readmore pull-right">Читать польностью <i class="fa fa-angle-right"></i></a>
	</div>
</article>



<!-- 			<div class="media">
				@if ($news->image)
					<div class="media-left">
						<a href="/uploads/news/{{ $news->image }}">картинка</a>
					</div>
				@endif
				<div class="media-body">
					<div class="media-heading">
						<h3 class="author"><a href="/news/{{ $news->id }}">{{ $news->title }}</a></h3>
						<span class="pull-right text-muted small date">{{ Carbon::parse($news->created_at)->format('d.m.y / H:i') }}</span>
					</div>

					<div>{!! App::bbCode(str_limit(e($news->text))) !!}</div>
				</div>
				<div>
					<span class="fa fa-user"></span> <a href="/user/{{ $news->user()->getLogin() }}">{{ $news->user()->getLogin() }}</a>, <span class="fa fa-comment"></span> <a href="/news/{{ $news->id }}#comments">{{ App::plural($news->commentCount(), ['комментарий', 'комментария', 'комментариев']) }}</a>
				</div>
			</div> -->
		@endforeach

		{{ App::pagination($page) }}

	@else
		<div class="alert alert-danger">Новостей еще нет!</div>
	@endif

	<p><span class="fa fa-rss"></span> <a href="/news/rss">RSS</a></p>
@stop
