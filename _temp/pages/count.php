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
header('Content-Type: image/png');
// -------------------- Вывод статистики ------------------------------//
// ----------------------------------------------------------------------//
$img = imageCreateFromPNG($_SERVER['DOCUMENT_ROOT'].'/images/img/counter.png');


ImagePNG($img, $_SERVER['DOCUMENT_ROOT'].'/uploads/counters/counter.png');
ImageDestroy($img);
?>
