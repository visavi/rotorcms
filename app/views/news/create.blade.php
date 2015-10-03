@extends('layout')

@section('title', 'Создание новости - @parent')
@section('breadcrumbs', App::breadcrumbs(['/news' => 'Новости сайта', 'Создание новости']))

@section('content')

	<h1>Создание новости</h1>

	<p class="bg-info padding">Поля отмеченные <span class="required">*</span> обязательны для заполнения</p>

	<form class="well form-horizontal" role="form" method="post" id="uploadProfile" enctype="multipart/form-data">

		<div class="form-group{{ App::hasError('title') }}">
			<label for="inputTitle" class="col-sm-2 control-label">Заголовок <span class="required">*</span></label>
			<div class="col-sm-6">
				<input name="title" type="text" class="form-control" id="inputTitle"  maxlength="50" placeholder="Заголовок новости" value="{{ App::getInput('title') }}">
				{!! App::textError('title') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('text') }}">
			<label for="markItUp" class="col-sm-2 control-label">Текст <span class="required">*</span></label>
			<div class="col-sm-10">
				<textarea name="text" class="form-control" rows="5" id="markItUp" placeholder="Текст новости">{{ App::getInput('text') }}</textarea>
				{!! App::textError('text') !!}
			</div>
		</div>
<br />
<font size='1'><table class='xdebug-error xe-warning' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Warning: imagejpeg(uploads/photos/1435339692560ff7eb9803c.jpg): failed to open stream: No such file or directory in /home/visavi/Sites/rotorcms.ll/vendor/abeautifulsite/simpleimage/src/abeautifulsite/SimpleImage.php on line <i>895</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0001</td><td bgcolor='#eeeeec' align='right'>236024</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='/home/visavi/Sites/rotorcms.ll/public/index.php' bgcolor='#eeeeec'>../index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.0204</td><td bgcolor='#eeeeec' align='right'>1061624</td><td bgcolor='#eeeeec'><a href='http://www.php.net/function.call-user-func-array:{/home/visavi/Sites/rotorcms.ll/public/index.php:23}' target='_new'>call_user_func_array:{/home/visavi/Sites/rotorcms.ll/public/index.php:23}</a>
(  )</td><td title='/home/visavi/Sites/rotorcms.ll/public/index.php' bgcolor='#eeeeec'>../index.php<b>:</b>23</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.0204</td><td bgcolor='#eeeeec' align='right'>1062088</td><td bgcolor='#eeeeec'>UserController->image(  )</td><td title='/home/visavi/Sites/rotorcms.ll/public/index.php' bgcolor='#eeeeec'>../index.php<b>:</b>23</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.0295</td><td bgcolor='#eeeeec' align='right'>1276328</td><td bgcolor='#eeeeec'>abeautifulsite\SimpleImage->save(  )</td><td title='/home/visavi/Sites/rotorcms.ll/app/controllers/UserController.php' bgcolor='#eeeeec'>../UserController.php<b>:</b>334</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.0296</td><td bgcolor='#eeeeec' align='right'>1276688</td><td bgcolor='#eeeeec'><a href='http://www.php.net/function.imagejpeg' target='_new'>imagejpeg</a>
(  )</td><td title='/home/visavi/Sites/rotorcms.ll/vendor/abeautifulsite/simpleimage/src/abeautifulsite/SimpleImage.php' bgcolor='#eeeeec'>../SimpleImage.php<b>:</b>895</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-uncaught-exception' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Fatal error: Uncaught exception 'Exception' with message 'Unable to save image: uploads/photos/1435339692560ff7eb9803c.jpg' in /home/visavi/Sites/rotorcms.ll/vendor/abeautifulsite/simpleimage/src/abeautifulsite/SimpleImage.php on line <i>905</i></th></tr>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Exception: Unable to save image: uploads/photos/1435339692560ff7eb9803c.jpg in /home/visavi/Sites/rotorcms.ll/vendor/abeautifulsite/simpleimage/src/abeautifulsite/SimpleImage.php on line <i>905</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0001</td><td bgcolor='#eeeeec' align='right'>236024</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='/home/visavi/Sites/rotorcms.ll/public/index.php' bgcolor='#eeeeec'>../index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.0204</td><td bgcolor='#eeeeec' align='right'>1061624</td><td bgcolor='#eeeeec'><a href='http://www.php.net/function.call-user-func-array:{/home/visavi/Sites/rotorcms.ll/public/index.php:23}' target='_new'>call_user_func_array:{/home/visavi/Sites/rotorcms.ll/public/index.php:23}</a>
(  )</td><td title='/home/visavi/Sites/rotorcms.ll/public/index.php' bgcolor='#eeeeec'>../index.php<b>:</b>23</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.0204</td><td bgcolor='#eeeeec' align='right'>1062088</td><td bgcolor='#eeeeec'>UserController->image(  )</td><td title='/home/visavi/Sites/rotorcms.ll/public/index.php' bgcolor='#eeeeec'>../index.php<b>:</b>23</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.0295</td><td bgcolor='#eeeeec' align='right'>1276328</td><td bgcolor='#eeeeec'>abeautifulsite\SimpleImage->save(  )</td><td title='/home/visavi/Sites/rotorcms.ll/app/controllers/UserController.php' bgcolor='#eeeeec'>../UserController.php<b>:</b>334</td></tr>
</table></font>

		<div class="form-group">
			<label for="inputImage" class="col-sm-2 control-label">Картинка</label>
			<div class="col-sm-10">
				<input type="file" name="image" accept="image/*" id="inputImage" title="Выберите файл">
				<span class="fa fa-spinner fa-spin" id="spiner" style="display:none;"></span>
				<div id="result"></div>
				<p class="help-block">Разрешены файлы jpg, jpeg, gif, png</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button type="submit" class="btn btn-primary pull-right">Сохранить</button>
			</div>
		</div>
	</form>
@stop
