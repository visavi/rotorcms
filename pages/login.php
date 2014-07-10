<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
require_once ('../includes/start.php');
require_once ('../includes/functions.php');
require_once ('../includes/header.php');
include_once ('../themes/header.php');

$cooklog = (isset($_COOKIE['cooklog'])) ? check($_COOKIE['cooklog']): '';

show_title('Авторизация');

if (!is_user()){
	render('pages/login', compact('cooklog'));
} else {
	redirect('/index.php');
}

include_once ('../themes/footer.php');
?>
