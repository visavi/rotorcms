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

if (!Migration::exists($migrate = '201501181614_create_floods_table')) {

	Migration::query("
	CREATE TABLE IF NOT EXISTS `floods` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `user_id` int(11) unsigned NOT NULL,
	  `page` varchar(30) NOT NULL,
	  `created_at` timestamp NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	");

	Migration::migrate($migrate);
}
	//Migration::query("ALTER TABLE `socials` ADD `test` int(11) NULL DEFAULT NULL AFTER `uid`;");

Migration::result();
