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

if (isset($_POST['link'])) {
	redirect('/'.check($_POST['link']));
}

if (!empty($_GET['act'])){

	$act = check($_GET['act']);

	if (preg_match('|^[a-z0-9_\-]+$|i', $act) && $act!='index'){

		if (file_exists(STORAGE.'/main/'.$act.'.dat') && (is_user() || $act!='menu')){

			include (STORAGE.'/main/'.$act.'.dat');

		} else {
			$_SESSION['note'] = 'Ошибка! Данной страницы не существует!';
			redirect("index.php");
		}
	} else {
		$_SESSION['note'] = 'Ошибка! Недопустимое название страницы!';
		redirect("index.php");
	}
} else {
	include_once (STORAGE.'/main/pages.dat');
}

include_once ('../themes/footer.php');
?>
