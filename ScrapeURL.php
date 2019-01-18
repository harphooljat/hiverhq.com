<?php

include_once('WebScraper.php');

$url = 'https://hiverhq.com/';
$webScraper = WebScraper::getInstance();
$webScraper->setURL($url);
$words = $webScraper->scrapeURL();

echo "Most Occuring Words On $url\n";
echo "========================\n";

foreach($words as $word => $cnt) {
    echo $word . ' - ' . $cnt . PHP_EOL;
}

echo "========================\n";
