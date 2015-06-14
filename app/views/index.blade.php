@extends('layout')

@section('title', 'Главная страница - @parent')

@section('content')

	<a href="/news" class="index touch-link"><span class="fa fa-circle"></span> Новости сайта <span class="badge">{{ newsCount() }}</span></a>
	<a href="/guestbook" class="index touch-link"><span class="fa fa-circle"></span> Гостевая книга <span class="badge">{{ guestbookCount() }}</span></a>

	<a href="/forum" class="index touch-link"><span class="fa fa-circle"></span> Форум <span class="badge">{{ forumCount() }}</span></a>

	<a href="/users" class="index touch-link"><span class="fa fa-circle"></span> Список пользователей <span class="badge">{{ usersCount() }}</span></a>

@stop
