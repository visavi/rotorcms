<?= '<?xml version="1.0" encoding="utf-8"?>' ?>
<rss version="2.0">
<channel>
	<title>{{ Setting::get('sitetitle') }} Новости</title>
	<link>http://{{ Setting::get('sitelink') }}</link>
	<description>Новости RSS - {{ Setting::get('sitetitle') }}</description>
	<language>ru</language>
	<copyright>{{ Setting::get('sitetitle') }}</copyright>
	<managingEditor>{{ Setting::get('email') }} ({{ Setting::get('admin') }})</managingEditor>
	<pubDate>{{ Carbon::now()->toRssString() }}</pubDate>

	@foreach($news_list as $news)

		<item>
			<title>{{ $news->title }}</title>
			<link>http://{{ Setting::get('sitelink') }}/news/{{ $news->id }}</link>
			<description>{{ $news->textRssFormat() }}</description>
			<author>{{ $news->user()->getLogin() }}</author>
			<pubDate>{{ Carbon::parse($news->created_at)->toRssString() }}</pubDate>
			<category>Новости</category>
			<guid>http://{{ Setting::get('sitelink') }}/news/{{ $news->id }}</guid>
		</item>
	@endforeach

</channel>
</rss>
