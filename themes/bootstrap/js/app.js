$(document).ready(function(){

	$.notify.defaults({ className: "success" });

	// Скрывает поповеры по клику в любом месте
	$('body').on('click', function (e) {
		//did not click a popover toggle or popover
		if ($(e.target).data('toggle') !== 'popover'
			&& $(e.target).parents('.popover.in').length === 0) {
			$('[data-toggle="popover"]').popover('hide');
		}
	});
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
		dataType: "JSON", type: "GET", url: "/ajax/bookmark.php",
		data: {topic: topic, token: $(el).data('token')},
		success: function(data) {

			if (data.status == 'error'){
				$.notify("Ошибка изменения закладок", "error");
				return false;
			}

			if (data.status == 'deleted'){
				$.notify("Удалено из закладок");
				$(el).text('В закладки');
			}

			if (data.status == 'added'){
				$.notify("Добавлено в закладки");
				$(el).text('Из закладок');
			}
		}
	});

	return false;
}
