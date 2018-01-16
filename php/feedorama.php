<?php
date_default_timezone_set('America/New_York');
# require_once("php/autoloader.php");
require '../vendor/autoload.php';
require("get_random_line.php");
$feedarray=file("feeds.txt");
$length = 4;
$feednumber=count($feedarray);
$style=file_get_contents("rdf.css");
$useragent=$_SERVER['HTTP_USER_AGENT'];
echo "<!DOCTYPE HTML><html><head><title>Usual RSS Feeds</title><link href='https://feedreader-bigbenaugust.apps.unc.edu/php/favicon.ico' rel='icon' type='image/x-icon' /><style>$style</style></head><body>";
echo "<div>Weather: <a href='http://mobile.weather.gov/index.php?lat=35.9101438&lon=-79.0752895' target='_blank'>NWS</a> - <a href='http://www.wral.com/weather/' target='_blank'>WRAL</a> - <a href='http://www.nhc.noaa.gov/' target='_blank'>NHC</a> - Last loaded: " . date('r') . " <br> ";
echo rand_line("fortunes.txt");
echo " - <a href='fortunes.txt'>list</a>";
echo "</div>";

        if (preg_match('/Android/i', $useragent)) {
                echo '<br><hr><br>';
        }

foreach ($feedarray as $key => $url) {
	$feed = new SimplePie();
	$feed->set_feed_url($url);
	$feed->enable_cache(true);	
	$feed->set_cache_duration(3600);
	$feed->init();
	$feed->handle_content_type();
	# index for column layout
	$foo = $key+1;
	# if you are on my phone, go one-column
	if (preg_match('/Android/i', $useragent)) {
                echo '<div class="mobile">';
                $mobile="mobile";
	}
	# go two column
        else {
		if (fmod(($foo),2 == 0)) {
			echo '<div class="left">';
		}
		else {
			echo '<div class="right">';
		}
                $mobile="";
	}
	# then display the rest
	echo '<p><span class="title">' . $foo . '. <a href="' . $feed->get_permalink() . '" target="_blank">' . $feed->get_title() . '</a><br>';
	echo '<ul>';
	foreach ($feed->get_items(0,$length) as $key=>$item) {
		echo '<li class="' . $mobile . '"><a href="' . $item->get_permalink() . '" target="_blank">' . $item->get_title() . '</a> : ' . $item->get_date() . '</li>';
	}
	echo '</ul></div>';
	$feed->__destruct();
	unset($item);
	unset($feed);
        if (preg_match('/Android/i', $useragent)) {
                echo '<br><hr><br>';
        }
	}
# Draw a footer
# echo "\n\n" . $_SERVER['HTTP_USER_AGENT'] . "\n\n";
echo "</body></html>";
?>
