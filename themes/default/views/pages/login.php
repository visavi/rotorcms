<script src="//ulogin.ru/js/ulogin.js"></script>
<div class="col-sm-offset-2" id="uLogin" data-ulogin="display=panel;fields=first_name,last_name,nickname,sex,email;providers=vkontakte,odnoklassniki,mailru,facebook,twitter,google,yandex;redirect_uri=http%3A%2F%2Frotorcms.ll%2Fpages%2Flogin.php"></div>

<?php

                    $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&amp;host=' . $_SERVER['HTTP_HOST']);
                    $user = json_decode($s, true);


                    var_dump($user, $_REQUEST);

?>


<form class="form-horizontal" role="form" method="post" action="login.php">
	<div class="form-group">
		<label for="inputLogin" class="col-sm-2 control-label">Email / Логин</label>
		<div class="col-sm-5">
			<input name="login" type="text" class="form-control" id="inputLogin"  maxlength="50" placeholder="Email или Логин">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword" class="col-sm-2 control-label">Пароль</label>
		<div class="col-sm-5">
			<input name="password" type="password" class="form-control" id="inputPassword" maxlength="30" placeholder="Пароль">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-5">
			<div class="checkbox">
				<label>
					<input name="haunter" type="checkbox"> Чужой компьютер
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-5">
			<button type="submit" class="btn btn-default">Войти</button>
			<a class="btn btn-info col-lg-offset-2 pull-right" href="/mail/lostpassword.php">Напомнить пароль</a>
		</div>
	</div>
</form>
