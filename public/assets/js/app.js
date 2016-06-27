$(document).ready(function(){

	prettyPrint();
	bootbox.setDefaults({ locale: 'ru' });

	$('#markItUp').markItUp(mySettings);

	toastr.options = {
		"progressBar": true,
		"positionClass": "toast-top-full-width",
	}

	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover()

	// Стилизованная кнопка загрузки файлов
	$('input[type=file]').bootstrapFileInput();

	// Скрывает поповеры по клику в любом месте
	$('body').on('click', function (e) {
		//did not click a popover toggle or popover
		if ($(e.target).data('toggle') !== 'popover'
			&& $(e.target).parents('.popover.in').length === 0) {
			$('[data-toggle="popover"]').popover('hide');
		}
	});

	$('a.gallery').colorbox({rel: function(){
		return $(this).data('group');
	},
		current: 'Фото {current} из {total}',
	});

	// Украшения для главной страницы
	$('.index').on('mouseover', function (e) {
		$(e.target).children('.fa').removeClass('fa-circle').addClass('fa-circle-o');
	});

	$('.index').on('mouseout', function (e) {
		$(e.target).children('.fa').removeClass('fa-circle-o').addClass('fa-circle');
	});

	// Спойлер
	$('.spoiler-title').click(function(){
		var spoiler = $(this).parent();
		spoiler.toggleClass('spoiler-open');
		spoiler.find('.spoiler-text:first').slideToggle();
	});

	$('.js-post').hover(function () {
		$('.js-menu', this).show(200);
	}, function() {
		$('.js-menu', this).hide(200);
	});

	/* Автокомплит и обработка тегов */
	$('.js-autocomplete').tagsinput({
		maxTags: 10,
		maxChars: 20,
		trimValue: true,
		cancelConfirmKeysOnEmpty: false,
		typeahead: {
			minLength: 2,
			select: function () {
				var val = this.$menu.find('.active').data('value');
				this.$element.data('active', val);
				if(this.autoSelect || val) {
					var newVal = this.updater(val);
					this.$element.val('').change();
					this.afterSelect(newVal);
				}
				return this.hide();
			},

			source: function(query) {
				var result = null;
				$.ajax({
					type: 'POST', url: '/news/tags',
					data: {query: query},
					dataType: "JSON",
					async: false,
					success: function(data) {
						result = data;
					}
				});
				return result;
			},
/*			displayText: function (item) {
				return item.name + ' - ' + '<span class="text-info">'+item.count+'</span>';
			}*/
		}
	});
});

function uploadAvatar() {

	$('#uploadAvatar').ajaxSubmit({
		target:        '#result',
		beforeSubmit:  showRequest,
		success:       showResponse,
		url:       '/user/image',
		dataType:  'json',
		resetForm: true
	});

	return false;
}


function createNewsComment() {

	$('#createComment').ajaxSubmit({
		target:        '#result',
		beforeSubmit:  showRequest,
		success:       showResponse,
		url:       '/news/comment',
		dataType:  'json',
		clearForm: true
	});

	return false;
}


// pre-submit callback
function showRequest(formData, jqForm, options) {

	$('#spiner').show();
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
	return true;
}

/* Вывод уведомлений */
function notify(type, title, message, optionsOverride) {
	return toastr[type](message, title, optionsOverride);
}

/* Показывает или скрывает пароль при клике */
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
		dataType: 'JSON', type: 'POST', url: '/topic/bookmark',
		data: {id: $(el).data('id'), token: $(el).data('token')},
		success: function(data) {

			if (data.status == 'error'){
				notify('error', 'Ошибка изменения закладок!');
				return false;
			}

			if (data.status == 'deleted'){
				notify('warning', 'Удалено из закладок!');
				$(el).text('В закладки');
			}

			if (data.status == 'added'){
				notify('success', 'Добавлено в закладки!');
				$(el).text('Из закладок');
			}
		}
	});

	return false;
}

/* Отправка жалобы на спам */
function sendComplaint(el) {
	bootbox.confirm('Вы действительно хотите отправить жалобу?', function(result){
		if (result) {

			$.ajax({
				dataType: 'JSON', type: 'POST', url: '/complaint',
				data: {id: $(el).data('id'), type: $(el).data('type'), token: $(el).data('token')},
				success: function(data) {
					if (data.status == 'error'){
						notify('error', 'Ошибка отправки жалобы!');
						return false;
					}

					if (data.status == 'added'){
						notify('success', 'Жалоба успешно отправлена!');
						$(el).replaceWith('<span class="fa fa-bell-slash-o"></span>');
					}

					if (data.status == 'exists'){
						notify('warning', 'Жалоба уже была отправлена!');
						$(el).replaceWith('<span class="fa fa-bell-slash-o"></span>');

					}
				}
			});
		}
	});
	return false;
}

/* Удаление сообщения в гостевой */
function deleteRecord(el, url) {
	bootbox.confirm('Вы действительно хотите удалить запись?', function(result){
		if (result) {

			$.ajax({
				dataType: 'JSON', type: 'POST', url: url,
				data: {id: $(el).data('id'), token: $(el).data('token')},
				success: function(data) {
					if (data.status == 'error'){
						notify('error', 'Не удалось удалить запись!', data.errors);
						return false;
					}

					if (data.status == 'ok'){
						notify('success', 'Запись успешно удалена!');
						$(el).closest('.js-record').hide('slow', function(){
							$(el).remove();
						});
					}
				}
			});
		}
	});
	return false;
}

/* Переход к форме ввода */
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

/* Выход с сайта */
function logout(el) {
	if (bootbox.confirm('Вы уверены, что хотите выйти?', function(result){
		if (result) {
			window.location = $(el).attr("href");
		}
	}))

	return false;
}
