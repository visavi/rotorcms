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

show_title('Список смайлов');

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
case "index":

	//$total = DB::run() -> querySingle("SELECT count(*) FROM `smiles`;");
	$total = Smile::count();

	if ($total > 0 && $start >= $total) {
		$start = last_page($total, $config['smilelist']);
	}

	$smiles = Smile::all(array('offset' => $start, 'limit' => $config['smilelist'], 'order' => 'LENGTH(code)'));

	render('pages/smiles', compact('smiles', 'start', 'total'));

break;

default:
	redirect("smiles.php");
endswitch;

include_once ('../themes/footer.php');
?>
