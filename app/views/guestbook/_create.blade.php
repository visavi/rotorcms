@if (User::check())
	<div class="well clearfix">
		<form action="/guestbook/create" method="post">
			<input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

			<label for="markItUp">Сообщение:</label>
			<div class="form-group{{ App::hasError('text') }}">
				<textarea class="form-control" id="markItUp" rows="5" name="text" required>{{ App::getInput('text') }}</textarea>
				{!! App::textError('text') !!}
			</div>
			<button type="submit" class="btn btn-primary pull-right">Написать</button>
		</form>
	</div>

@else
	<div class="well">
		<form action="/guestbook/create" method="post">
			<input type="hidden" name="token" value="{{ $_SESSION['token'] }}" />
			<div class="form-group{{ App::hasError('text') }}">
				<label for="inputText">Сообщение:</label>
				<textarea class="form-control" id="inputText" rows="5" name="text" placeholder="Текст сообщения" required>{{ App::getInput('text') }}</textarea>
				{!! App::textError('text') !!}
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4{{ App::hasError('captcha') }}">
					<input name="captcha" type="text" class="form-control" id="inputCaptcha" maxlength="6" placeholder="Проверочный код" required>
					{!! App::textError('captcha') !!}
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<img src="/captcha" id="captcha" onclick="this.src='/captcha?'+Math.random()" class="img-rounded" alt="" style="cursor: pointer;">
				</div>

				<div class="col-lg-5">
					<button type="submit" class="btn btn-primary pull-right">Написать</button>
				</div>
			</div>
		</form>
	</div>

@endif
