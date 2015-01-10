// ----------------------------------------------------------------------------
// markItUp bb-code setting!
// ----------------------------------------------------------------------------
mySettings = {
	previewParserPath:	'', // path to your BBCode parser
	markupSet: [
		{name:'Bold', className:"bb-bold", key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Italic', className:"bb-italic", key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Underline', className:"bb-underline", key:'U', openWith:'[u]', closeWith:'[/u]'},
		{name:'Strike', className:"bb-strike", key:'S', openWith:'[s]', closeWith:'[/s]'},

		{separator:'---------------' },
		{name:'Link', className:"bb-link", key:'L', openWith:'[url=[![Ссылка:!:http://]!]]', closeWith:'[/url]', placeHolder:'Текст ссылки...'},
		{name:'Video', className:"bb-youtube", openWith:'[youtube][![Код видео с youtube]!]', closeWith:'[/youtube]'},
		{name:'Colors', className:"bb-colors", openWith:'[color=[![Код цвета]!]]', closeWith:'[/color]',
		dropMenu: [
			{name:'Yellow',	openWith:'[color=#ffd700]', closeWith:'[/color]', className:"col1-1" },
			{name:'Orange',	openWith:'[color=#ffa500]', closeWith:'[/color]', className:"col1-2" },
			{name:'Red', openWith:'[color=#ff0000]', closeWith:'[/color]', className:"col1-3" },

			{name:'Blue', openWith:'[color=#0000ff]', closeWith:'[/color]', className:"col2-1" },
			{name:'Purple', openWith:'[color=#800080]', closeWith:'[/color]', className:"col2-2" },
			{name:'Green', openWith:'[color=#00cc00]', closeWith:'[/color]', className:"col2-3" },

			{name:'Magenta', openWith:'[color=#ff00ff]', closeWith:'[/color]', className:"col3-1" },
			{name:'Gray', openWith:'[color=#808080]', closeWith:'[/color]', className:"col3-2" },
			{name:'Black', openWith:'[color=#00ffff]', closeWith:'[/color]', className:"col3-3" },
		]},

		{separator:'---------------' },
		{name:'Size', className:"bb-size",
		dropMenu :[
			{name:'x-small', openWith:'[size=1]', closeWith:'[/size]' },
			{name:'small', openWith:'[size=2]', closeWith:'[/size]' },
			{name:'medium', openWith:'[size=3]', closeWith:'[/size]' },
			{name:'large', openWith:'[size=4]', closeWith:'[/size]' },
			{name:'x-large', openWith:'[size=5]', closeWith:'[/size]' },
		]},

		{name:'Center', className:"bb-center", openWith:'[center]', closeWith:'[/center]'},
		{name:'Spoiler', className:"bb-spoiler", openWith:'[spoiler=[![Заголовок спойлера]!]]', closeWith:'[/spoiler]'},

		//{separator:'---------------' },
		//{name:'OrderedList', className:"bb-orderedlist", openWith:'[*]', multiline:true, openBlockWith:'[list=1]\n', closeBlockWith:'\n[/list]'},
		//{name:'UnorderedList', className:"bb-unorderedlist", openWith:'[*]', multiline:true, openBlockWith:'[list]\n', closeBlockWith:'\n[/list]'},
		//{name:'ListItem', className:"bb-listitem", openWith:'[*]'},

		{separator:'---------------' },
		{name:'Hide', className:"bb-hide", openWith:'[hide]', closeWith:'[/hide]'},
		{name:'Quotes', className:"bb-quotes", openWith:'[quote]', closeWith:'[/quote]'},
		{name:'Code', className:"bb-code", openWith:'[code]', closeWith:'[/code]'},

		{separator:'---------------' },
		{name:'Clean', className:"bb-clean", replaceWith:function(markitup) { return markitup.selection.replace(/\[(.*?)\]/g, "") } },
		{name:'Smiles', className:"bb-smiles",
		dropMenu: [
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
		//{name:'Picture', className:'image-upload', closeWith:function(markItUp){miu.ImageUpload.upload(markItUp,'textile');}},
		//{name:'Preview', className:'preview',  call:'preview'}
	]
}
