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

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';
$start = (isset($_GET['start'])) ? abs(intval($_GET['start'])) : 0;

show_title('Кто в онлайне');
//$total_all = DB::run() -> querySingle("SELECT count(*) FROM `online`;");
//$total = DB::run() -> querySingle("SELECT count(*) FROM `online` WHERE `online_user`<>?;", array(''));

$total_all = Online::count();
$total = Online::count(array('conditions' => 'user_id IS NOT NULL'));
$page = ($act == 'index') ? 'all' : 'index';

echo 'Всего на сайте: <b>'.$total_all.'</b><br />';
echo 'Зарегистрированных:  <b>'.$total.'</b><br /><br />';

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
case 'index':

	if ($start >= $total) {
		$start = 0;
	}

	$onlines = Online::all(array('conditions' => array('user_id <> ?', ''), 'order' =>  'created_at', 'offset' => $start, 'limit' => $config['onlinelist']));

	render('pages/online', compact('onlines', 'start', 'total', 'page'));

break;

############################################################################################
##                                Список всех пользователей                               ##
############################################################################################
case 'all':


	if ($start >= $total) {
		$start = 0;
	}

	$onlines = Online::all(array('order' =>  'created_at', 'offset' => $start, 'limit' => $config['onlinelist']));

	render('pages/online', compact('onlines', 'start', 'total', 'page'));

break;

default:
	redirect('online.php');
endswitch;

include_once ('../themes/footer.php');
?>
