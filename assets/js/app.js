$(document).ready(function(){
	/* Вывод спойлера */
	$(".spoiler-body").hide();
	$(".spoiler-head").click(function(){
		$(this).toggleClass("news-open").toggleClass("news-closed").next().slideToggle();
	});

	/* Показ новостей на главной */
	$(".news-text").hide();
	$(".news-title").click(function () {
		$(this).nextAll("div.news-text:first").slideToggle();
 		//$(this).attr('src', '/images/img/ups.gif');
	});
});


/* Ответ на сообщение */
function reply(name){

	$('#markItUp').focus().val('[b]' + name + '[/b], ');

	$('html, body').animate({
		scrollTop: ($('.form').offset().top)
	}, 500);

	return false;
}

/* Цитирование сообщения */
function quote(el){
	var msg = $(el).closest('#post').find('.message').text();
	$('#markItUp').focus().val(msg);

	$('html, body').animate({
		scrollTop: ($('.form').offset().top)
	}, 500);

	return false;
}

/* Жалоба на спам */
function spam(el){

}
