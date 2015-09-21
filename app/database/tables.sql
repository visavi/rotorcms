CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `point` mediumint(8) unsigned NOT NULL,
  `topoint` mediumint(8) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(10) NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `guest` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NULL DEFAULT NULL,
  `text` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `brow` varchar(25) NOT NULL,
  `reply` text NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` enum('male', 'female') NOT NULL,
  `level` enum('banned', 'guest', 'user', 'moder', 'admin') NOT NULL DEFAULT 'guest',
  `reset_code` varchar(50) NULL DEFAULT NULL,
  `name` varchar(20) NULL DEFAULT NULL,
  `country` varchar(30) NULL DEFAULT NULL,
  `city` varchar(50) NULL DEFAULT NULL,
  `info` text NOT NULL,
  `site` varchar(50) NULL DEFAULT NULL,
  `icq` varchar(10) NULL DEFAULT NULL,
  `skype` varchar(32) NULL DEFAULT NULL,
  `jabber` varchar(50) NULL DEFAULT NULL,
  `birthday` varchar(10) NULL DEFAULT NULL,
  `newprivat` smallint(4) unsigned NOT NULL DEFAULT '0',
  `allforum` int(11) unsigned NOT NULL DEFAULT '0',
  `allguest` int(11) unsigned NOT NULL DEFAULT '0',
  `allcomments` int(11) unsigned NOT NULL DEFAULT '0',
  `themes` varchar(20) NULL DEFAULT NULL,
  `postguest` smallint(4) unsigned NOT NULL DEFAULT '0',
  `postnews` smallint(4) unsigned NOT NULL DEFAULT '0',
  `postprivat` smallint(4) unsigned NOT NULL DEFAULT '0',
  `postforum` smallint(4) unsigned NOT NULL DEFAULT '0',
  `themesforum` smallint(4) unsigned NOT NULL DEFAULT '0',
  `timezone` varchar(3) NOT NULL DEFAULT '0',
  `point` int(11) unsigned NOT NULL DEFAULT '0',
  `money` int(11) unsigned NOT NULL DEFAULT '0',
  `ban` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `timeban` datetime NULL DEFAULT NULL,
  `timelastban` datetime NULL DEFAULT NULL,
  `reasonban` text NOT NULL,
  `loginsendban` varchar(20) NULL DEFAULT NULL,
  `totalban` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `explainban` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` varchar(50) NULL DEFAULT NULL,
  `avatar` varchar(50) NULL DEFAULT NULL,
  `picture` varchar(50) NULL DEFAULT NULL,
  `rating` mediumint(8) NOT NULL DEFAULT '0',
  `posrating` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `negrating` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `keypasswd` varchar(20) NULL DEFAULT NULL,
  `timepasswd` datetime NULL DEFAULT NULL,
  `timebonus` datetime NULL DEFAULT NULL,
  `confirmreg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `confirmregkey` varchar(30) NULL DEFAULT NULL,
  `secquest` varchar(50) NULL DEFAULT NULL,
  `secanswer` varchar(40) NULL DEFAULT NULL,
  `ipbinding` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `newchat` int(11) unsigned NOT NULL DEFAULT '0',
  `privacy` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `apikey` varchar(32) NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`),
  KEY `level` (`level`),
  KEY `point` (`point`),
  KEY `money` (`money`),
  KEY `rating` (`rating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(25) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*('addbansend', '1'),
('advertpoint', '2000'),
('allowextload', 'zip,rar,txt,jpg,jpeg,gif,png,mp3,mp4,3gp,wav,mmf,mid,midi,sis,jar,jad'),
('avatarpoints', '150'),
('avatarsize', '32'),
('avatarupload', '1000'),
('avatarweight', '1024'),
('avlist', '10'),
('avtorlist', '10'),
('banlist', '10'),
('blacklist', '10'),
('blogcomm', '10'),
('blogexprated', '72'),
('blogexpread', '72'),
('bloggroup', '10'),
('blogpost', '10'),
('blogvotepoint', '50'),
('boarddays', '30'),
('boardspost', '5'),
('bonusmoney', '500'),
('bookadds', '1'),
('bookpost', '10'),
('cache', '1'),
('captcha_amplitude', '4'),
('captcha_credits', '0'),
('captcha_maxlength', '5'),
('captcha_noise', '1'),
('captcha_spaces', '0'),
('captcha_symbols', '0123456789'),
('chatpost', '10'),
('closedsite', '0'),
('copy', '© RotorCMS'),
('copyfoto', '1'),
('description', 'Краткое описани вашего сайта на движке RotorCMS'),
('downcomm', '10'),
('downlist', '10'),
('downupload', '1'),
('editfiles', '10'),
('editforumpoint', '500'),
('editnickpoint', '300'),
('editratingpoint', '150'),
('editstatus', '0'),
('editstatusmoney', '3000'),
('editstatuspoint', '1000'),
('email', 'visavi.net@mail.ru'),
('errorlog', '1'),
('expiresloads', '72'),
('expiresmail', '3'),
('expiresrated', '72'),
('filesize', '5242880'),
('fileupfoto', '3000'),
('fileupload', '5242880'),
('floodstime', '30'),
('forumextload', 'zip,rar,txt,jpg,jpeg,gif,png,mp3,mp4,3gp,wav,pdf'),
('forumloadpoints', '150'),
('forumloadsize', '1048576'),
('forumpost', '10'),
('forumtem', '10'),
('forumtextlength', '3000'),
('fotolist', '5'),
('guestsuser', 'Гость'),
('guesttextlength', '1000'),
('gzip', '0'),
('headlines', '20'),
('includenick', '1'),
('incount', '5'),
('invite', '0'),
('ipbanlist', '10'),
('keypass', ''),
('keywords', 'Ключевые слова вашего сайта на движке RotorCMS'),
('lastnews', '1'),
('lastusers', '100'),
('lifelist', '10'),
('limitmail', '300'),
('limitoutmail', '100'),
('loglist', '10'),
('logotip', ''),
('maxbantime', '43200'),
('maxblogcomm', '300'),
('maxblogpost', '50000'),
('maxdowncomm', '300'),
('maxkommnews', '500'),
('maxlogdat', '100'),
('maxpostbook', '500'),
('maxpostchat', '500'),
('maxpostgallery', '100'),
('moneyname', 'рублей,рубля,рубль'),
('nickname', ''),
('nocheck', 'txt,dat,gif,jpg,jpeg,png,zip'),
('onlinelist', '10'),
('onlines', '1'),
('openreg', '1'),
('performance', '1'),
('photoexprated', '72'),
('photogroup', '10'),
('postchanges', '10'),
('postgallery', '10'),
('postnews', '10'),
('previewsize', '150'),
('privatpost', '10'),
('privatprotect', '50'),
('proxy', ''),
('referer', '300'),
('registermoney', '1000'),
('regkeys', '0'),
('reglist', '10'),
('regmail', '1'),
('rekuseroptprice', '100'),
('rekuserpost', '10'),
('rekuserprice', '1000'),
('rekusershow', '1'),
('rekusertime', '12'),
('rekusertotal', '50'),
('rotorversion', '5.0.0'),
('scorename', 'баллов,балла,балл'),
('screensize', '500'),
('screenupload', '2097152'),
('screenupsize', '5000'),
('sendmail', '0'),
('sendmoneypoint', '150'),
('session', '1'),
('showlink', '10'),
('showref', '10'),
('showuser', '10'),
('smilelist', '10'),
('statusdef', 'Дух'),
('statusname', 'Суперадмин,Админ,Старший модер,Модератор,Пользователь'),
('themes', 'default'),
('timezone', 'Europe/Moscow'),
('title', 'RotorCMS 5.0'),
('touchthemes', '0'),
('userlist', '10'),
('webthemes', 'default'),
('ziplist', '20');*/

/*CREATE TABLE IF NOT EXISTS `blacklist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL,
  `value` varchar(100) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/


/*CREATE TABLE IF NOT EXISTS `invite` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite` varchar(20) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `invited_user_id` int(11) unsigned DEFAULT NULL,
  `used` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `used` (`used`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

/*
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `request` varchar(255) NULL DEFAULT NULL,
  `referer` varchar(255) NULL DEFAULT NULL,
  `ip` varchar(15) NULL DEFAULT NULL,
  `brow` varchar(25) NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/


CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(50) NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*CREATE TABLE IF NOT EXISTS `photo` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `link` varchar(30) NOT NULL,
  `rating` mediumint(8) NOT NULL DEFAULT '0',
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comments` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/


CREATE TABLE IF NOT EXISTS `forums` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `sort` smallint(4) unsigned NOT NULL DEFAULT '0',
  `parent_id` smallint(4) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NULL DEFAULT NULL,
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `topics` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint(4) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mods` varchar(100) NULL DEFAULT NULL,
  `note` varchar(255) NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `locked` (`locked`),
  KEY `created_at` (`created_at`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` smallint(4) unsigned NOT NULL,
  `topic_id` mediumint(8) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `brow` varchar(25) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`,`created_at`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



/*CREATE TABLE IF NOT EXISTS `downs` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cats_id` smallint(4) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `link` varchar(50) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `author` varchar(50) NOT NULL,
  `site` varchar(50) NULL DEFAULT NULL,
  `screen` varchar(50) NULL DEFAULT NULL,
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `raiting` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rated` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `load` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `loaded_at` datetime NULL DEFAULT NULL,
  `app` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `notice` text NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cats_id` (`cats_id`),
  KEY `created_at` (`created_at`),
  FULLTEXT KEY `text` (`text`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/


/*CREATE TABLE IF NOT EXISTS `blogs_categories` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `order` smallint(4) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/


/*CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cats_id` smallint(4) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `tags` varchar(100) NOT NULL,
  `rating` mediumint(8) NOT NULL DEFAULT '0',
  `read` int(11) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cats_id` (`cats_id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

/*CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `brow` varchar(25) NOT NULL,
  `edit_user_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/
/*
CREATE TABLE IF NOT EXISTS `visit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `self` varchar(100) NULL DEFAULT NULL,
  `page` varchar(100) NULL DEFAULT NULL,
  `ip` varchar(15) NULL DEFAULT NULL,
  `count` int(11) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

CREATE TABLE IF NOT EXISTS `spam` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `relate_type` enum('guest', 'forum') NOT NULL,
  `relate_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `relate_type` (`relate_type`, `relate_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*CREATE TABLE IF NOT EXISTS `ban` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `user_id` int(11) unsigned NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

CREATE TABLE IF NOT EXISTS `smiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*CREATE TABLE IF NOT EXISTS `online` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `brow` varchar(25) NOT NULL,
  `user_id` int(11) unsigned NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

/*CREATE TABLE IF NOT EXISTS `counter` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `hours` mediumint(8) unsigned NOT NULL,
  `days` mediumint(8) unsigned NOT NULL,
  `allhosts` int(11) unsigned NOT NULL,
  `allhits` int(11) unsigned NOT NULL,
  `dayhosts` mediumint(8) unsigned NOT NULL,
  `dayhits` mediumint(8) unsigned NOT NULL,
  `hosts24` mediumint(8) unsigned NOT NULL,
  `hits24` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

REPLACE INTO `counter` (`id`, `hours`, `days`, `allhosts`, `allhits`, `dayhosts`, `dayhits`, `hosts24`, `hits24`) VALUES (1, '0', '0', '0', '0', '0', '0', '0', '0');*/


/*CREATE TABLE IF NOT EXISTS `counter24` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hour` mediumint(8) unsigned NOT NULL,
  `hosts` mediumint(8) unsigned NOT NULL,
  `hits` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hour` (`hour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

/*CREATE TABLE IF NOT EXISTS `counter31` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `day` mediumint(8) unsigned NOT NULL,
  `hosts` mediumint(8) unsigned NOT NULL,
  `hits` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `day` (`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/

/*CREATE TABLE IF NOT EXISTS `antimat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `string` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/


/*CREATE TABLE IF NOT EXISTS `inbox` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

/*CREATE TABLE IF NOT EXISTS `error` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `num` smallint(4) unsigned NOT NULL,
  `request` varchar(255) NULL DEFAULT NULL,
  `referer` varchar(255) NULL DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `ip` varchar(15) NULL DEFAULT NULL,
  `brow` varchar(25) NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `num` (`num`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

/*CREATE TABLE IF NOT EXISTS `notice` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `protect` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `notice` (`id`, `name`, `text`, `user_id`, `protect`) VALUES
(1, 'Приветствие при регистрации в приват', 'Добро пожаловать, %USERNAME%!<br />Теперь Вы полноправный пользователь сайта, сохраните ваш пароль и логин в надежном месте, они пригодятся вам для входа на наш сайт.<br />Перед посещением сайта рекомендуем вам ознакомиться с [url=%SITENAME%/pages/rules.php]правилами сайта[/url], это поможет Вам избежать неприятных ситуаций.<br />Желаем приятно провести время.<br />С уважением, администрация сайта!', 1, 1);*/


CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `topic_id` mediumint(8) unsigned NOT NULL,
  `forum_id` smallint(4) unsigned NOT NULL,
  `posts` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `socials` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `network` varchar(255) NOT NULL,
  `uid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*CREATE TABLE IF NOT EXISTS `floods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `page` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;*/

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `relate_type` enum('news', 'blog', 'down', 'gallery') NOT NULL,
  `relate_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `brow` varchar(25) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `relate_type` (`relate_type`, `relate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
