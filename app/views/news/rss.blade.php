{!! '<'.'?'.'xml version="1.0" encoding="utf-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>{{ Setting::get('sitetitle') }} News</title>
		<link>{{ Setting::get('sitelink') }}</link>
		<description>Новости RSS - {{ Setting::get('sitetitle') }}</description>
		<image>
			<url>/assets/img/images/icon.png</url>
			<title>{{ Setting::get('sitetitle') }} News</title>
			<link>{{ Setting::get('sitelink') }}</link>
		</image>
		<language>ru</language>
		<copyright>{{ Setting::get('sitetitle') }}</copyright>
		<managingEditor>email (author)</managingEditor>
		<webMaster>email (author)</webMaster>
		<lastBuildDate>{{ date("r") }}</lastBuildDate>



		@foreach($news_list as $news)

{{-- 	$data['news_text'] = bb_code($data['news_text']);
	$data['news_text'] = str_replace(array('/images/smiles', '[cut]'), array($config['home'].'/images/smiles', ''), $data['news_text']);
	$data['news_text'] = htmlspecialchars($data['news_text']); --}}

			<item>
				<title>{{ $news->title }}</title>
				<link>http://{{ Setting::get('sitelink') }}/news/{{ $news->id }}</link>
				<description>{{ $news->text }}</description>
				<author>{{ $news->user()->getLogin() }}</author>
				<pubDate>{{ Carbon::parse($news->created_at)->format('r') }}</pubDate>
				<category>Новости</category>
				<guid>http://{{ Setting::get('sitelink') }}/news/{{ $news->id }}</guid>
			</item>

		@endforeach

	</channel>
</rss>
