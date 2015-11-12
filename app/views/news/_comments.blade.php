<h4>Все комментарии {{ $news->commentCount() }}</h4>

@if (User::check())
	<div class="well well-sm clearfix col-sm-10">
		<form action="/news/comment" method="post" id="createComment">
			<input type="hidden" name="token" value="{{ $_SESSION['token'] }}">
			<div class="form-group{{ App::hasError('text') }}">
				<textarea class="form-control" id="markItUp" rows="3" name="text" placeholder="Комментарий" required>{{ App::getInput('text') }}</textarea>
				{!! App::textError('text') !!}
			</div>
			<button type="submit" class="btn btn-primary pull-right"  onclick="return createNewsComment();">Написать</button>
		</form>
	</div>

@else
	<div class="alert alert-danger">Авторизуйтесь или зарегистрируйтесь для добавления комментария</div>
@endif
