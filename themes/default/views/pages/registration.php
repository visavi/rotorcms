<div class="bg-info">Регистрация на сайте означает что вы ознакомлены и согласны с <b><a href="/pages/rules.php">правилами</a></b> нашего сайта</div>
<div class="bg-info">Длина логина или пароля должна быть от 3 до 20 символов</div>
<div class="bg-info">В поле логин разрешено использовать только знаки латинского алфавита и цифры, а также знак дефис!</div>

<?php if ($config['regkeys'] == 1 && !empty($config['regmail'])): ?>
	<p class="bg-danger"><span class="glyphicon glyphicon-warning-sign"></span> <b>Включено подтверждение регистрации!</b> Вам на почтовый ящик будет выслан мастер-ключ, который необходим для подтверждения регистрации!</p>
<?php endif; ?>

<?php if ($config['regkeys'] == 2): ?>
	<p class="bg-danger"><span class="glyphicon glyphicon-warning-sign"></span> <b>Включена модерация регистрации!</b> Ваш аккаунт будет активирован только после проверки администрацией!</p>
<?php endif; ?>

<?php if ($config['karantin'] > 0): ?>
	<p class="bg-danger"><span class="glyphicon glyphicon-warning-sign"></span> <b>Включен карантин!</b> Новые пользователи не могут писать сообщения в течении <?= round($config['karantin'] / 3600) ?> час. после регистрации!</p>
<?php endif; ?>

<?php if (!empty($config['invite'])): ?>
	<p class="bg-danger"><span class="glyphicon glyphicon-warning-sign"></span> <b>Включена регистрация по приглашениям!</b> Регистрация пользователей возможна только по специальным пригласительным ключам</p>
<?php endif; ?>


<script src="//ulogin.ru/js/ulogin.js"></script>
<div class="col-sm-offset-2" style="padding: 10px 5px;" id="uLogin" data-ulogin="display=panel;fields=first_name,last_name,nickname,sex,email;providers=vkontakte,odnoklassniki,mailru,facebook,twitter,google,yandex;redirect_uri=http%3A%2F%2F<?= $config['home'] ?>%2Fpages%2Fregistration.php">
</div>

<form class="form-horizontal" role="form" method="post" action="registration.php?act=register">
	<div class="form-group">
		<label for="inputLogin" class="col-sm-2 control-label">Логин</label>
		<div class="col-sm-5">
			<input name="login" type="text" class="form-control" id="inputLogin" maxlength="20" placeholder="Логин">
		</div>
	</div>

	<div class="form-group has-feedback">
		<label for="inputPassword" class="col-sm-2 control-label">Пароль</label>
		<div class="col-sm-5">
			<input name="password" type="password" class="form-control eye" id="inputPassword" maxlength="30" placeholder="Пароль">
			<span class="glyphicon glyphicon-eye-open form-control-feedback reveal" style="cursor: pointer;" onclick="revealPassword(this);"></span>
		</div>
	</div>

<?php if (!empty($config['regmail'])): ?>
	<div class="form-group">
		<label for="inputEmail" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-5">
			<input name="email" type="text" class="form-control" id="inputEmail" maxlength="50" placeholder="Email">
		</div>
	</div>
<?php endif; ?>

<?php if (!empty($config['invite'])): ?>
	<div class="form-group">
		<label for="inputInvite" class="col-sm-2 control-label">Пригласительный ключ</label>
		<div class="col-sm-5">
			<input name="invite" type="text" class="form-control" id="inputInvite" maxlength="32" placeholder="Ключ">
		</div>
	</div>
<?php endif; ?>


	<div class="form-group">
		<label for="inputGender" class="col-sm-2 control-label">Пол</label>
		<div class="col-sm-5">
			<input type="radio" name="gender" id="inputGender1" value="1" checked="checked">
			<label for="inputGender1">Мужской</label>
			<input type="radio" name="gender" id="inputGender2" value="2">
			<label for="inputGender2">Женский</label>
		</div>
	</div>


	<div class="form-group">
		<label for="inputProvkod" class="col-sm-2 control-label">Проверочный код</label>
		<div class="col-sm-5">
			<img src="/gallery/protect.php" alt="" /><br />
			<input name="captcha" type="text" class="form-control" id="inputProvkod" maxlength="6" placeholder="Проверочный код">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-5">
			<button type="submit" class="btn btn-default">Регистрация</button>
		</div>
	</div>
</form>


<div class="bg-info">Обновите страницу если вы не видите проверочный код!</div>
<div class="bg-info">Все поля обязательны для заполнения, более полную информацию о себе вы можете добавить в своем профиле после регистрации</div>
<div class="bg-info">Указывайте верный е-мэйл, на него будут высланы регистрационные данные</div>
