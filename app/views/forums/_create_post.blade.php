@if (User::check())
	@if(!$topic->closed)

		<div class="well well-sm clearfix col-sm-10">
			<form action="/topic/{{ $topic->id }}/create" method="post">
				<input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

				<div class="form-group{{ App::hasError('text') }}">
					<textarea class="form-control" id="markItUp" rows="5" name="text" required>{{ App::getInput('text') }}</textarea>
					{!! App::textError('text') !!}
				</div>
				<button type="submit" class="btn btn-primary pull-right">Написать</button>

		<?php /*if ($udata['users_point'] >= $config['forumloadpoints']): ?>
			<span class="imgright">
				<a href="topic.php?act=addfile&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>">Загрузить файл</a>
			</span>
		<?php endif;*/ ?>
			</form>
		</div>

	@else
		<div class="alert alert-danger">Данная тема закрыта для обсуждения!</div>
	@endif
@else
	<div class="alert alert-danger">Авторизуйтесь или зарегистрируйтесь для добавления сообщения</div>
@endif
