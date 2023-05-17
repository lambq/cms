<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
	<title><?= '网站分类目录提交_免费网站目录外链_'.env('APP_NAME').'_华劵林林_我们只推荐好网站' ?></title>
	<link><?= url('/') ?></link>
	<description><?= '林木目录给大家提供国内外网址大全，整理和收藏网站导航！华劵林林免费发布自己的网站及网站相关信息！' ?></description>
    <atom:link href="<?= url('/feed.xml') ?>" rel="self" type="application/rss+xml"/>
    <pubDate><?= date('Y-m-d H:i:s', time()) ?></pubDate>
    <lastBuildDate><?= date('Y-m-d H:i:s', time()) ?></lastBuildDate>
    <generator><?= env('APP_NAME') ?></generator>
<?php foreach ($items as $item) : ?>
	<item>
        <title><?= $item['title'] ?></title>
        <link><?= $item['loc'] ?></link>
        <description><?= $item['priority'] ?></description>
        <pubDate><?= $item['lastmod'] ?></pubDate>
        <category><?= $item['freq'] ?></category>
    </item>
<?php endforeach; ?>
</channel>
</rss>