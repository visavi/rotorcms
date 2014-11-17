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

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	$token = (!empty($_GET['token'])) ? check($_GET['token']) : 0;
	$topic_id = (isset($_GET['topic'])) ? abs(intval($_GET['topic'])) : 0;

	if ($token == $_SESSION['token']) {

		/* Проверка темы на существование */
		$topic = Topic::find_by_id($topic_id);
		if ($topic) {

			/* Добавление темы в закладки */
			$bookmark = Bookmark::find_by_topic_id_and_user_id($topic_id, $user->id);

			if ($bookmark) {

				if ($bookmark->delete())
					exit(json_encode(array('status' => 'deleted')));

			}	else {
				$bookmark = new Bookmark;
				$bookmark->topic_id = $topic->id;
				$bookmark->forum_id = $topic->forum_id;
				$bookmark->user_id = $user->id;
				$bookmark->posts = $topic->postCount();

				if ($bookmark->save())
					exit(json_encode(array('status' => 'added')));
			}
		}
	}

	exit(json_encode(array('status' => 'error')));

} else {
	redirect('/');
}
?>
