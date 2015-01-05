<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
require_once (__DIR__.'/../includes/start.php');
require_once (__DIR__.'/../includes/functions.php');

$migrate = '201412262226_add_test_to_socials';

if (!Migration::exists($migrate)) {

	Migration::query("ALTER TABLE `socials` ADD `test` int(11) NULL DEFAULT NULL AFTER `uid`;");
	Migration::migrate($migrate);
}

Migration::result();
