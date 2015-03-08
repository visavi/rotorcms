<ul class="breadcrumb">
	<li><a href="/">Главная</a></li>
	<li><a href="/<?= key($link) ?>"><?= current($link) ?></a></li>
	<li class="active">Теги</li>
</ul>

BB-теги - это набор кодов, основанных на языке HTML и разработанных специально для использования в текстовых сообщениях сайта. Они позволяют выполнять форматирование текста гораздо проще, чем в HTML, причём не нарушая целостность страницы.<br /><br />

Ниже приведены примеры использования BB-тегов.<br /><br />

<i class="fa fa-bold"></i> - [b]<?= bb_code('[b]Жирный шрифт[/b]') ?>[/b]<br />
<i class="fa fa-italic"></i> [i]<?= bb_code('[i]Наклонный шрифт[/i]') ?>[/i]<br />
<i class="fa fa-underline"></i> [u]<?= bb_code('[u]Подчеркнутый шрифт[/u]') ?>[/u]<br />
<i class="fa fa-strikethrough"></i> [s]<?= bb_code('[s]Зачеркнутый шрифт[/s]') ?>[/s]<br />

<i class="fa fa-link"></i> Для обычной ссылки [url]Название[/url]<br />
<i class="fa fa-link"></i> Для ссылки с названием: [url=http://адрес_cсылки]Название[/url]<br />

<i class="fa fa-font"></i> [size=5]<?= bb_code('[size=5]Самый большой шрифт[/size]') ?>[/size]<br />
<i class="fa fa-font"></i> [size=3]<?= bb_code('[size=3]Средний шрифт[/size]') ?>[/size]<br />
<i class="fa fa-font"></i> [size=1]<?= bb_code('[size=1]Самый маленький шрифт[/size]') ?>[/size]<br />

<i class="fa fa-th"></i> [color=код цвета]Любой цвет шрифта[/color]<br />
<i class="fa fa-th"></i> [color=#ff0000]<?= bb_code('[color=#ff0000]Красный шрифт[/color]') ?>[/color]<br />

<i class="fa fa-youtube-play"></i> [youtube]Код видео с youtube[/youtube]<br /><?= bb_code('[youtube]yf_YWiqqv34[/youtube]') ?><br />


<i class="fa fa-align-center"></i> [center]Текст по центру[/center]<br />
<i class="fa fa-text-height"></i> [spoiler=Название]Спойлер с названием[/spoiler]<br />
<i class="fa fa-text-height"></i> [spoiler]Выпадающий текст[/spoiler] <?= bb_code('[spoiler]Текст который показывается при нажатии[/spoiler]') ?><br />

<i class="fa fa-eye-slash"></i> [hide]Скрытый текст[/hide] <?= bb_code('[hide]Для вставки скрытого текста[/hide]') ?><br />

<i class="fa fa-quote-right"></i> [quote]Цитата[/quote]<br />
<i class="fa fa-quote-right"></i> [quote=Админ]Цитата с именем[/quote] <?= bb_code('[quote=Админ]Для вставки цитат[/quote]') ?><br />
<i class="fa fa-code"></i> [code]Форматированный код[/code] <?= bb_code('[code]&lt;? echo "Для вставки php-кода"; ?&gt;[/code]') ?><br />


<i class="fa fa-eraser"></i> Очистка выделенного текста от bb-кода<br />
<i class="fa fa-smile-o"></i> Вставка смайла из готового набора<br /><br />
