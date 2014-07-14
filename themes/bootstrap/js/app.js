$(document).ready(function(){
});

/*
 * Показывает или скрывает пароль при клике
 */
function revealPassword(el) {

	if ($('.eye').attr('type') == 'password') {
		$(el).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
		$('.eye').attr('type', 'text');
	} else {
		$(el).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
		$('.eye').attr('type', 'password');
	}
}
