<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputLogin" class="col-sm-2 control-label">Email / Логин</label>
    <div class="col-sm-5">
      <input type="email" class="form-control" id="inputLogin" placeholder="Email или Логин" value="<?= $cooklog ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-sm-2 control-label">Пароль</label>
    <div class="col-sm-5">
      <input type="password" class="form-control" id="inputPassword" placeholder="Пароль">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Запомнить меня
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
      <button type="submit" class="btn btn-default">Войти</button>
    </div>
  </div>
</form>


<a href="registration.php">Регистрация</a><br />
<a href="/mail/lostpassword.php">Забыли пароль?</a><br /><br />

Вы можете сделать закладку для быстрого входа, она будет иметь вид:<br />
<span style="color:#ff0000"><?= $config['home'] ?>/input.php?login=ВАШ_ЛОГИН&amp;pass=ВАШ_ПАРОЛЬ</span><br /><br />
