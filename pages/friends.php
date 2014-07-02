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
$user = (isset($_GET['user'])) ? check($_GET['user']) : check($log);

$config['friendlist'] = 10;

show_title('Друзья '.nickname($user));

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
case 'index':

	$friends = array();
	$total = DB::run() -> querySingle("SELECT count(*) FROM `friends` WHERE `user`=? AND `status`=?;", array($user, 1)); // Друзья
	$offers = DB::run() -> querySingle("SELECT count(*) FROM `friends` WHERE `user`=? AND `status`=?;", array($user, 0)); // Заявки
	$invitations = DB::run() -> querySingle("SELECT count(*) FROM `friends` WHERE `friend`=? AND `status`=?;", array($user, 0)); // Приглашения

	if ($total > 0) {

		if ($start >= $total) {
			$start = last_page($total, $config['friendlist']);
		}

		$query = DB::run() -> query("SELECT * FROM `friends` WHERE `user`=? AND `status`=? ORDER BY `time` DESC LIMIT ".$start.", ".$config['friendlist'].";", array($user, 1));
		$friends = $query->fetchAll();
	}

	render('pages/friends', compact('friends', 'start', 'total', 'offers', 'invitations', 'user'));
break;

default:
	redirect("friends.php");
endswitch;

include_once ('../themes/footer.php');
?>
