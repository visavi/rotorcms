<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
require_once ('includes/start.php');
require_once ('includes/functions.php');
require_once ('includes/header.php');
include_once ('includes/routes.php');
include_once ('themes/header.php');

if ($current_router) {
	include_once BASEDIR.'/includes/controllers/'.$current_router['target'];
} else {
	echo 'Route not found';
  //header("HTTP/1.0 404 Not Found");
  //require '404.html';
}

include_once ('themes/footer.php');
?>
