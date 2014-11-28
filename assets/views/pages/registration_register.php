<div class="alert alert-success" role="alert">Вы успешно зарегистрированы!</div>

<p>Логин: <b><?= $login ?></b></p>
<p>Пароль: <b><?= $password ?></b></p>

<form method="post" action="login.php">
	<input type="hidden" name="login" value="<?= $login ?>" />
	<input type="hidden" name="password" value="<?= $password ?>" />
	<button type="submit" class="btn btn-success btn-lg">Вход на сайт</button>
</form>

<span class="help-block">Сохраните пароль в надежном месте</p>
