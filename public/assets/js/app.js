$(document).ready(function(){

	prettyPrint();

	$('#markItUp').markItUp(mySettings);

	$.notify.defaults({ className: "success" });

	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover()
	$('input[type=file]').bootstrapFileInput();

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

$(document).ready(function() {
	$('#inputImage').on('change', function() {
		$('#uploadProfile').ajaxSubmit({
			target:        '#result',
			beforeSubmit:  showRequest,
			success:       showResponse,
			url:       '/user/image',
			dataType:  'json'
		});
		return false;
	});
});

// pre-submit callback
function showRequest(formData, jqForm, options) {

	$(jqForm).find('#spiner').show();

	return true;
}

// post-submit callback
function showResponse(responseText, statusText, xhr, $form)  {
	// for normal html responses, the first argument to the success callback
	// is the XMLHttpRequest object's responseText property

	// if the ajaxForm method was passed an Options Object with the dataType
	// property set to 'xml' then the first argument to the success callback
	// is the XMLHttpRequest object's responseXML property

	// if the ajaxForm method was passed an Options Object with the dataType
	// property set to 'json' then the first argument to the success callback
	// is the json data object returned by the server

	$('#spiner').hide();
}

/*
 * Показывает или скрывает пароль при клике
 */
function revealPassword(el) {

	if ($(el).prev('.eye').attr('type') == 'password') {
		$(el).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
		$(el).prev('.eye').attr('type', 'text');
	} else {
		$(el).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
		$(el).prev('.eye').attr('type', 'password');
	}
}

/* Добавление темы в закладки */
function changeBookmark(el) {

	$.ajax({
		dataType: "JSON", type: "POST", url: "/topic/bookmark",
		data: {id: $(el).data('id'), token: $(el).data('token')},
		success: function(data) {

			if (data.status == 'error'){
				$.notify('Ошибка изменения закладок!', 'error');
				return false;
			}

			if (data.status == 'deleted'){
				$.notify('Удалено из закладок!', 'warn');
				$(el).text('В закладки');
			}

			if (data.status == 'added'){
				$.notify('Добавлено в закладки!');
				$(el).text('Из закладок');
			}
		}
	});

	return false;
}

/* Отправка жалобы на спам */
function sendComplaint(el) {

	if (!confirm('Вы действительно хотите отправить жалобу?')) return false;

	$.ajax({
		dataType: "JSON", type: "POST", url: "/complaint",
		data: {id: $(el).data('id'), type: $(el).data('type'), token: $(el).data('token')},
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
