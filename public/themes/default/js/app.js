$(document).ready(function(){

	prettyPrint();

	$('#markItUp').markItUp(mySettings);

	$.notify.defaults({ className: "success" });

	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover()

	// Скрывает поповеры по клику в любом месте
	$('body').on('click', function (e) {
		//did not click a popover toggle or popover
		if ($(e.target).data('toggle') !== 'popover'
			&& $(e.target).parents('.popover.in').length === 0) {
			$('[data-toggle="popover"]').popover('hide');
		}
	});

	// Украшения для главной страницы
	$('.index').on('mouseover', function (e) {
		$(e.target).children('.fa').removeClass("fa-circle").addClass("fa-circle-o");
	});

	$('.index').on('mouseout', function (e) {
		$(e.target).children('.fa').removeClass("fa-circle-o").addClass("fa-circle");
	});

	// Спойлер
	$(".spoiler-title").click(function(){
		var spoiler = $(this).parent();
		spoiler.toggleClass("spoiler-open");
		spoiler.find('.spoiler-text:first').slideToggle();
	});

});

/*
 * Показывает или скрывает пароль при клике
 */
function revealPassword(el) {

	if ($('.eye').attr('type') == 'password') {
		$(el).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
		$('.eye').attr('type', 'text');
	} else {
		$(el).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
		$('.eye').attr('type', 'password');
	}
}

/* Добавление темы в закладки */
function changeBookmark(el, topic) {

	$.ajax({
		dataType: "JSON", type: "GET", url: "/ajax/bookmark.php",
		data: {topic: topic, token: $(el).data('token')},
		success: function(data) {

			if (data.status == 'error'){
				$.notify("Ошибка изменения закладок!", "error");
				return false;
			}

			if (data.status == 'deleted'){
				$.notify("Удалено из закладок!");
				$(el).text('В закладки');
			}

			if (data.status == 'added'){
				$.notify("Добавлено в закладки!");
				$(el).text('Из закладок');
			}
		}
	});

	return false;
}

/* Отправка жалобы на спам */
function sendComplaint(el, section, post) {

	if (!confirm('Вы действительно хотите отправить жалобу?')) return false;

	$.ajax({
		dataType: "JSON", type: "GET", url: "/ajax/complaint.php",
		data: {post: post, section: section, token: $(el).data('token')},
		success: function(data) {
			if (data.status == 'error'){
				$.notify("Ошибка отправки жалобы!", "error");
				return false;
			}

			if (data.status == 'added'){
				$.notify("Жалоба успешно отправлена!");
				$(el).replaceWith('<span class="fa fa-bell-slash-o"></span>');
			}

			if (data.status == 'exists'){
				$.notify("Жалоба уже была отправлена!", "info");
				$(el).replaceWith('<span class="fa fa-bell-slash-o"></span>');

			}
		}
	});

	return false;
}

function postJump() {

	$('html, body').animate({
		scrollTop: ($('.well').offset().top)
	}, 500);
}

/* Ответ на сообщение */
function postReply(name){

	postJump();

	$('#markItUp').focus().val('[b]' + name + '[/b], ');

	return false;
}

/* Цитирование сообщения  */
function postQuote(el){

	postJump();

	var post = $(el).closest('.media-body');
	var author = post.find('.author').text();
	var date = post.find('.date').text();
	var message = post.find('.message').text();

	$('#markItUp').focus().val('[quote=' + author + ' (' + date + ')]' + message + '[/quote]\n');

	return false;
}
