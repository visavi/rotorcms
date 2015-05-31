{!! '<'.'?'.'xml version="1.0" encoding="utf-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>{{ Setting::get('sitetitle') }} News</title>
		<link>{{ Setting::get('sitelink') }}</link>
		<description>Новости RSS - {{ Setting::get('sitetitle') }}</description>
		<language>ru</language>
		<copyright>{{ Setting::get('sitetitle') }}</copyright>
		<managingEditor>email (author)</managingEditor>
		<webMaster>email (author)</webMaster>
		<lastBuildDate>{{ date("r") }}</lastBuildDate>

		@foreach($news_list as $news)
			<?php
				$news->text = App::bbCode($news->text);
				$news->text = preg_replace('/\r\n|\r|\n|\s+/u', ' ', $news->text);
				$news->text = str_replace('<img src="', '<img src="http://'.Setting::get('sitelink'), $news->text);
			?>
			<item>
				<title>{{ $news->title }}</title>
				<link>http://{{ Setting::get('sitelink') }}/news/{{ $news->id }}</link>
				<description>{{ str_replace('&nbsp;', ' ', $news->text) }}</description>
				<author>{{ $news->user()->getLogin() }}</author>
				<pubDate>{{ Carbon::parse($news->created_at)->format('r') }}</pubDate>
				<category>Новости</category>
				<guid>http://{{ Setting::get('sitelink') }}/news/{{ $news->id }}</guid>
			</item>
		@endforeach

	</channel>
</rss>
