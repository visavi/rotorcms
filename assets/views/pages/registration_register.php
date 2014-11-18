<div class="alert alert-success" role="alert">Вы успешно зарегистрированы!</div>

<p>Логин: <b><?= $login ?></b></p>
<p>Пароль: <b><?= $password ?></b></p>

<h2><a href="/pages/login.php?login=<?= $login ?>&amp;password=<?= $password ?>">Вход на сайт</a></h2>

<span class="help-block">
	Вы можете сделать закладку для быстрого входа:<br />
	<p class="text-danger"><?= $config['home'] ?>/pages/login.php?login=<?= $login ?>&amp;password=<?= $password ?></p>
</span>

Cкопировать: <br />
<input class="form-control" value="<?= $config['home'] ?>/pages/login.php?login=<?= $login ?>&amp;password=<?= $password ?>"/>

<span class="help-block">Если у вас включены cookies, то делать такую закладку не обязательно</p>
