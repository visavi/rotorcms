$(document).ready(function(){
	/* Вывод спойлера */
	$(".spoiler-body").hide();
	$(".spoiler-head").click(function(){
		$(this).toggleClass("open").toggleClass("closed").next().slideToggle();
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
	alert($(el).closest('.right').find('.message').text());
	$('#markItUp').focus().val(data);

	$('html, body').animate({
		scrollTop: ($('.form').offset().top)
	}, 500);

	return false;
}
