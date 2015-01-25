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

show_title('Гостевая книга', 'Общение без ограничений');

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
case 'index':

	$total = Guest::count();

	if ($total > 0 && $start >= $total) {
		$start = last_page($total, $config['bookpost']);
	}

	$page = floor(1 + $start / $config['bookpost']);
	$config['newtitle'] = 'Гостевая книга (Стр. '.$page.')';

	$posts = Guest::all(array('offset' => $start, 'limit' => $config['bookpost'], 'order' => 'created_at desc', 'include' => array('user')));

	App::render('book/index', compact('posts', 'start', 'total'));

break;

############################################################################################
##                                    Добавление сообщения                                ##
############################################################################################
case 'add':

	$msg = check($_POST['msg']);
	$token = check($_GET['token']);

	if (is_user()) {
		if (is_flood($log)) {

			$user = User::find_by_id($current_user->id);
			$user->allguest = $user->allguest + 1;
			$user->point = $user->point + 1;
			$user->money = $user->money + 20;
			$user->save();

			$post = new Guest;
			$post->token = $token;
			$post->user_id = $current_user->id;
			$post->text = $msg;
			$post->ip = $ip;
			$post->brow = $brow;

			if ($post->save()) {

				// Удаляем старые сообщения
				//$posts = Guest::all(array('offset' => $config['maxpostbook'], 'limit' => 10, 'order' => 'created_at desc'));
				//$delete = ActiveRecord\collect($posts, 'id');
				//Guest::table()->delete(array('id' => array($delete)));

				notice('Сообщение успешно добавлено!');
				redirect("index.php");
			} else {
				show_error($post->getErrors());
			}
		} else {
			show_error('Антифлуд! Разрешается отправлять сообщения раз в '.flood_period().' секунд!');
		}

		############################################################################################
		##                                   Добавление для гостей                                ##
		############################################################################################
	} elseif ($config['bookadds'] == 1) {
		$provkod = check(strtolower($_POST['provkod']));

		if ($provkod == $_SESSION['protect']) {
			if (is_flood($log)) {

				$post = new Guest;
				$post->user_id = 0;
				$post->text = $msg;
				$post->ip = $ip;
				$post->brow = $brow;

				if ($post->save()) {
					notice('Сообщение успешно добавлено!');
					redirect("index.php");
				} else {
					show_error($post->getErrors());
				}
			} else {
				show_error('Антифлуд! Разрешается отправлять сообщения раз в '.flood_period().' секунд!');
			}
		} else {
			show_error('Ошибка! Проверочное число не совпало с данными на картинке!');
		}
	} else {
		show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо');
	}

	App::render('includes/back', array('link' => 'index.php', 'title' => 'Вернуться'));
break;

############################################################################################
##                                   Подготовка к редактированию                          ##
############################################################################################
case 'edit':
	show_title('Редактирование сообщения');

	$id = (isset($_GET['id'])) ? abs(intval($_GET['id'])) : 0;

	if (is_user()) {
		$post = Guest::find_by_id_and_user_id($id, $current_user->id);

		if ($post) {
			if ($post->created_at->getTimestamp() > time() - 600) {

				$post->text = $post->text;

				App::render('book/edit', compact('post', 'id', 'start'));

			} else {
				show_error('Ошибка! Редактирование невозможно, прошло более 10 минут!!');
			}
		} else {
			show_error('Ошибка! Сообщение удалено или вы не автор этого сообщения!');
		}
	} else {
		show_login('Вы не авторизованы, чтобы редактировать сообщения, необходимо');
	}

	App::render('includes/back', array('link' => 'index.php?start='.$start, 'title' => 'Вернуться'));
break;

############################################################################################
##                                    Редактирование сообщения                            ##
############################################################################################
case 'editpost':

	$token = check($_GET['token']);
	$id = abs(intval($_GET['id']));
	$msg = check($_POST['msg']);

	if (is_user()) {

		$post = Guest::find_by_id_and_user_id($id, $current_user->id);

		if ($post) {
			if ($post->created_at->getTimestamp() > time() - 600) {

				$post->token = $token;
				$post->text = $msg;
				if ($post->save()) {
					notice('Сообщение успешно отредактировано!');
					redirect("index.php?start=$start");
				} else {
					show_error($post->getErrors());
				}

			} else {
				show_error('Ошибка! Редактирование невозможно, прошло более 10 минут!!');
			}
		} else {
			show_error('Ошибка! Сообщение удалено или вы не автор этого сообщения!');
		}
	} else {
		show_login('Вы не авторизованы, чтобы редактировать сообщения, необходимо');
	}

	App::render('includes/back', array('link' => 'index.php?act=edit&amp;id='.$id.'&amp;start='.$start, 'title' => 'Вернуться'));
	App::render('includes/back', array('link' => 'index.php?start='.$start, 'title' => 'В гостевую', 'icon' => 'fa-arrow-circle-up'));
break;

default:
	redirect("index.php");
endswitch;

include_once ('../themes/footer.php');
?>
