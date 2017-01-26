<?php
/**
 * Created by PhpStorm.
 * User: eantaya
 * Date: 2017-01-26
 * Time: 11:13
 */

$directories = scandir("./article");
$articles = array_filter($directories, function ($directory) {
    return $directory != '.' && $directory != '..';
});

$rssItems = array_map(function ($article) {
    $articleFilename = './article/' . $article . '/index.html';
    if (!file_exists($articleFilename)) {
        throw new RuntimeException("invalid article");
    }

    return '        <item>
            <title>' . $article . '</title>
            <link>http://floverdevel.github.io/article/' . $article . '/index.html</link>
            <description>An article</description>
            <content:encoded><![CDATA[' . file_get_contents($articleFilename) . ']]></content:encoded>
        </item>';
}, $articles);


echo '<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
        <title>floverdevel</title>
        <link>http://floverdevel.github.io</link>
        <description>Make the web free again</description>';
echo PHP_EOL;
echo join('', $rssItems);
echo PHP_EOL;
echo '    </channel>

</rss>';
echo PHP_EOL;
