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


function changeBookmark(el, topic) {

	$.ajax({
		type: "GET", url: "/ajax/bookmark.php",
		data: {topic: topic, token: $(el).data('token')},
		success: function(data) {

			if (data.status == 'deleted') {
				$(el).text('В закладки');
			} else {
				$(el).text('Из закладок');
			}
		}
	});

	return false;
}
