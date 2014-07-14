Вы успешно зарегистрированы!<br /><br />

Логин: <b><?= $login ?></b><br />
Пароль: <b><?= $password ?></b><br /><br />

Теперь вы можете войти<br />
<br /><img src="/images/img/open.gif" alt="image" />
<b><a href="/pages/login.php?login=<?= $login ?>&amp;password=<?= $password ?>">Вход на сайт</a></b><br /><br />

Вы можете сделать закладку для быстрого входа:<br />
<span style="color:#ff0000"><?= $config['home'] ?>/pages/login.php?login=<?= $login ?>&amp;password=<?= $password ?></span><br /><br />
Cкопировать: <br /><input size="60" value="<?= $config['home'] ?>/pages/login.php?login=<?= $login ?>&amp;password=<?= $password ?>"/><br /><br />

Если у вас включены cookies, то делать такую закладку не обязательно<br /><br />
