@extends('layout')

@section('title', 'Главная страница - @parent')

@section('content')

	<a href="/news" class="index touch-link"><span class="fa fa-circle"></span> Новости сайта <span class="badge">0</span></a>
	<a href="/guestbook" class="index touch-link"><span class="fa fa-circle"></span> Гостевая книга <span class="badge">{{ count_guestbook() }}</span></a>

	<a href="/forum" class="index touch-link"><span class="fa fa-circle"></span> Форум <span class="badge">{{ count_forum() }}</span></a>

	<a href="/users" class="index touch-link"><span class="fa fa-circle"></span> Список пользователей <span class="badge">{{ count_users() }}</span></a>

@stop
