// ----------------------------------------------------------------------------
// markItUp bb-code setting!
// ----------------------------------------------------------------------------
mySettings = {
	previewParserPath:	'', // path to your BBCode parser
	markupSet: [
		{name:'Bold', className:"bold", key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Italic', className:"italic", key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Underline', className:"underline", key:'U', openWith:'[u]', closeWith:'[/u]'},
		{name:'Strike', className:"strike", key:'D', openWith:'[del]', closeWith:'[/del]'},
		{separator:'---------------' },
		{name:'Link', className:"link", key:'L', openWith:'[url=[![Ссылка:!:http://]!]]', closeWith:'[/url]', placeHolder:'Текст ссылки...'},
		{name:'Video', className:"youtube", openWith:'[youtube][![Код видео с youtube]!]', closeWith:'[/youtube]'},
		{name:'Colors', className:"colors",
		dropMenu: [
			{name:'Red', openWith:'[red]', closeWith:'[/red]', className:"col1-1" },
			{name:'Green', openWith:'[green]', closeWith:'[/green]', className:"col1-2" },
			{name:'Blue', openWith:'[blue]', closeWith:'[/blue]', className:"col1-3" }
		]},
		{separator:'---------------' },
		{name:'Small', className:"small", openWith:'[small]', closeWith:'[/small]' },
		{name:'Big', className:"big", openWith:'[big]', closeWith:'[/big]' },
		{name:'Spoiler', className:"spoiler", openWith:'[spoiler=[![Заголовок спойлера]!]]', closeWith:'[/spoiler]'},
		{separator:'---------------' },
		{name:'Hide', className:"hiding", openWith:'[hide]', closeWith:'[/hide]'},
		{name:'Quotes', className:"quotes", openWith:'[q]', closeWith:'[/q]'},
		{name:'Code', className:"code", openWith:'[code]', closeWith:'[/code]'},
		{separator:'---------------' },
		{name:'Clean', className:"clean", replaceWith:function(markitup) { return markitup.selection.replace(/\[(.*?)\]/g, "") } },
		{name:'Smiles', className:"smiles", dropMenu: [
			{name:':)', openWith:' :) ', className:"col1-1" },
			{name:':(', openWith:' :( ', className:"col1-2" },
			{name:':E', openWith:' :E ', className:"col1-3" },
			{name:':hello', openWith:' :hello ', className:"col2-1" },
			{name:':cry', openWith:' :cry ', className:"col2-2" },
			{name:':obana', openWith:' :obana ', className:"col2-3" },
			{name:':infat', openWith:' :infat ', className:"col3-1" },
			{name:':klass', openWith:' :klass ', className:"col3-2" },
			{name:':krut', openWith:' :krut ', className:"col3-3" }
		]},
		{name:'Nextpage', className:"nextpage", openWith:'[nextpage]'},
		{name:'Cutpage', className:"cutpage", openWith:'[cut]'},
		//{name:'Preview', className:'preview',  call:'preview'}
	]
}

$(document).ready(function()	{
	$('#markItUp').markItUp(mySettings);
});
