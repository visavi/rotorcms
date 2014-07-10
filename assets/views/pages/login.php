<div class="form">
	<form method="post" action="/input.php">
		Логин или ник:<br /><input name="login" value="<?= $cooklog ?>" maxlength="20" /><br />
		Пароль:<br /><input name="pass" type="password" maxlength="20" /><br />
		Запомнить меня:
		<input name="cookietrue" type="checkbox" value="1" checked="checked" /><br />

		<input value="Войти" type="submit" />
	</form>
</div><br />

<a href="registration.php">Регистрация</a><br />
<a href="/mail/lostpassword.php">Забыли пароль?</a><br /><br />

Вы можете сделать закладку для быстрого входа, она будет иметь вид:<br />
<span style="color:#ff0000"><?= $config['home'] ?>/input.php?login=ВАШ_ЛОГИН&amp;pass=ВАШ_ПАРОЛЬ</span><br /><br />
