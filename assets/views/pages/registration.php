Регистрация на сайте означает что вы ознакомлены и согласны с <b><a href="/pages/rules.php">правилами</a></b> нашего сайта<br />
Длина логина или пароля должна быть от 3 до 20 символов<br />
В поле логин разрешено использовать только знаки латинского алфавита и цифры, а также знак дефис!<br />

<?php if ($config['regkeys'] == 1 && !empty($config['regmail'])): ?>
	<img src="/images/img/warning.gif" alt="image" /> <span style="color:#ff0000"><b>Включено подтверждение регистрации!</b> Вам на почтовый ящик будет выслан мастер-ключ, который необходим для подтверждения регистрации!</span><br />
<?php endif; ?>

<?php if ($config['regkeys'] == 2): ?>
	<img src="/images/img/warning.gif" alt="image" /> <span style="color:#ff0000"><b>Включена модерация регистрации!</b> Ваш аккаунт будет активирован только после проверки администрацией!</span><br />
<?php endif; ?>

<?php if ($config['karantin'] > 0): ?>
	<img src="/images/img/warning.gif" alt="image" /> <span style="color:#ff0000"><b>Включен карантин!</b> Новые пользователи не могут писать сообщения в течении <?= round($config['karantin'] / 3600) ?> час. после регистрации!</span><br />
<?php endif; ?>

<?php if (!empty($config['invite'])): ?>
	<img src="/images/img/warning.gif" alt="image" /> <span style="color:#ff0000"><b>Включена регистрация по приглашениям!</b> Регистрация пользователей возможна только по специальным пригласительным ключам</span><br />
<?php endif; ?>

<br />
<div class="form">
	<form action="registration.php?act=register" method="post">
		Логин:<br /><input name="login" maxlength="20" /><br />
		Пароль:<br /><input name="password" type="password" maxlength="30" /><br />

		<?php if (!empty($config['regmail'])): ?>
			Ваш e-mail: <br /><input name="email" maxlength="50" /><br />
		<?php endif; ?>

		<?php if (!empty($config['invite'])): ?>
			Пригласительный ключ: <br /><input name="invite" maxlength="32" /><br />
		<?php endif; ?>

		Пол:<br />
		<select name="gender">';
			<option value="1">Мужской</option>
			<option value="2">Женский</option>
		</select><br />

		Проверочный код:<br />
		<img src="/gallery/protect.php" alt="" /><br />
		<input name="captcha" size="6" maxlength="6" /><br />

		<br /><input value="Регистрация" type="submit" />
	</form>
</div><br />

Обновите страницу если вы не видите проверочный код!<br />
Все поля обязательны для заполнения, более полную информацию о себе вы можете добавить в своем профиле после регистрации<br />
Указывайте верный е-мэйл, на него будут высланы регистрационные данные<br /><br />
