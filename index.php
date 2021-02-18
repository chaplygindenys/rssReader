<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
const RSS_URL = "https://chaplygindenys.github.io/NewsLine/rss.xml";
const FILE_NAME = "news.xml";
const RSS_TTL = 3600;
function downloadRss($url, $filename)
{
    $file = file_get_contents($url);
    if ($file) file_put_contents($filename, $file);
}

if (!is_file(FILE_NAME))
    downloadRss(RSS_URL, FILE_NAME);
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Line News
    </title>
    <meta charset="utf-8"/>
</head>
<body>
<h1>
    Last News
</h1>
<?php
//use simplexml
$xml = simplexml_load_file(FILE_NAME);
foreach ($xml->channel->item as $item) {
            echo <<<ITEM
        <h3>{$item->title}</h3>
                   <p>
                    {$item->description}<br/>
                    Category:{$item->category}
                    PubDate:{$item->pubDate}
                   </p>
          <p aling="right">
          <a href="{$item->link}">Continue...</a>
        </p>
        ITEM;
}
if(time() > filemtime(FILE_NAME)+RSS_TTL)
    downloadRss(RSS_URL, FILE_NAME);
?>
</body>
</html>
