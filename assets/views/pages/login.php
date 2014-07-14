<div class="form">
	<form method="post" action="/pages/login.php">
		Email / Логин:<br /><input name="login" maxlength="20" /><br />
		Пароль:<br /><input name="password" type="password" maxlength="30" /><br />
		Чужой компьютер:
		<input name="haunter" type="checkbox" value="1" /><br />

		<input value="Войти" type="submit" />
	</form>
</div><br />

<a href="registration.php">Регистрация</a><br />
<a href="/mail/lostpassword.php">Забыли пароль?</a><br /><br />

Вы можете сделать закладку для быстрого входа, она будет иметь вид:<br />
<span style="color:#ff0000"><?= $config['home'] ?>/pages/login.php?login=ЛОГИН&amp;pass=ПАРОЛЬ</span><br /><br />
