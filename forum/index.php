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

show_title('Форум '.$config['title']);
$config['newtitle'] = 'Форум - Список разделов';

include_once (DATADIR.'/advert/forum.dat');

$forums = Forum::all(array('conditions' => array('parent_id = ?', 0), 'order' => 'sort', 'include' => array('children', 'topics')));

render('forum/index', compact('forums'));

include_once ('../themes/footer.php');
?>
