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
	$section = (isset($_GET['section'])) ? check($_GET['section']) : '';
	$post_id = (isset($_GET['post'])) ? abs(intval($_GET['post'])) : 0;

	if ($user->id && $token == $_SESSION['token']) {

		$spam = Spam::first(array('conditions' => array('section = ? AND post_id = ?', $section, $post_id)));

		if (!$spam) {
			$spam = new Spam;
			$spam->section = $section;
			$spam->post_id = $post_id;
			$spam->user_id = $user->id;
			$spam->count = 1;
			if ($spam->save())
				exit(json_encode(array('status' => 'added')));
		} else {
			exit(json_encode(array('status' => 'exists')));
		}
	}

	exit(json_encode(array('status' => 'error')));
} else {
	redirect('/');
}
?>
