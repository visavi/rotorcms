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
