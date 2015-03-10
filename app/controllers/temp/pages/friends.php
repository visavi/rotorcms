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
//$user = (isset($_GET['user'])) ? check($_GET['user']) : check($log);

$config['friendlist'] = 10;

show_title('Список друзей');

if (is_user()){

$total['friends'] = DB::run() -> querySingle("SELECT count(*) FROM `friends` WHERE `user`=? AND `status`=?;", array($log, 1)); // Друзья
$total['offers'] = DB::run() -> querySingle("SELECT count(*) FROM `friends` WHERE `friend`=? AND `status`=?;", array($log, 0)); // Заявки
$total['invitations'] = DB::run() -> querySingle("SELECT count(*) FROM `friends` WHERE `user`=? AND `status`=?;", array($log, 0)); // Приглашения

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
case 'index':
	$config['header'] = 'Друзья '.nickname($log);
	$friends = array();

	if ($total['friends'] > 0) {

		if ($start >= $total['friends']) {
			$start = last_page($total['friends'], $config['friendlist']);
		}

		$query = DB::run() -> query("SELECT * FROM `friends` WHERE `user`=? AND `status`=? ORDER BY `time` DESC LIMIT ".$start.", ".$config['friendlist'].";", array($log, 1));
		$friends = $query->fetchAll();
	}

	render('pages/friends', compact('friends', 'start', 'total'));
break;


############################################################################################
##                                    Заявки                                              ##
############################################################################################
case 'offers':
	$config['header'] = 'Заявки в друзья';
	$offers = array();

	if ($total['offers'] > 0) {

		if ($start >= $total['offers']) {
			$start = last_page($total['offers'], $config['friendlist']);
		}

		$query = DB::run() -> query("SELECT * FROM `friends` WHERE `friend`=? AND `status`=? ORDER BY `time` DESC LIMIT ".$start.", ".$config['friendlist'].";", array($log, 0));
		$offers = $query->fetchAll();
	}

	render('pages/friends_offers', compact('offers', 'start', 'total'));
break;

############################################################################################
##                                  Приглашения                                           ##
############################################################################################
case 'invitations':
	$config['header'] = 'Мои приглашения';
break;

default:
	redirect("friends.php");
endswitch;

} else {
	show_login('Для просмотра данной страницы, необходимо');
}

include_once ('../themes/footer.php');
?>
