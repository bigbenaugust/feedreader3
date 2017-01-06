<?php
require_once("php/autoloader.php");
$feedarray=file("feeds.txt");
$length = 4;
echo "<!DOCTYPE HTML><html><head>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
echo "<title>Usual RSS Feeds</title>";
echo "<link href='https://feedreader-bigbenaugust.apps.unc.edu/favicon.ico' rel='icon' type='image/x-icon' />";
echo "<link rel='stylesheet' href='https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css'>";
echo "<script src='https://code.jquery.com/jquery-1.11.2.min.js'></script>";
echo "<script src='https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js'></script>";
echo "</head><body>";
echo "<div data-role='page' id='page' data-theme='b'><div data-role='header'>Ben's Stuff</div>";
echo "<ul data-role='listview' data-inset='true' class='ui-mini'>";
echo "<li data-role='list-divider' class='ui-mini'><a href='http://mobile.weather.gov/index.php?lat=35.9101438&lon=-79.0752895' target='_blank'>Carrboro Weather (NWS)</a>";

foreach ($feedarray as $key => $url) {
	$feed = new SimplePie();
	$feed->set_feed_url($url);
	$feed->enable_cache(true);	
	$feed->set_cache_duration(3600);
	$feed->init();
	$feed->handle_content_type();
# 	echo "<div data-role='main' class='ui-mini'>";
	echo '<li data-role="list-divider" class="ui-mini"><a href="' . $feed->get_permalink() . '" target="_blank">' . $feed->get_title() . '</a>';
#	echo '<ul data-role="listview" data-inset="true" class="ui-mini">';
	foreach ($feed->get_items(0,$length) as $key=>$item) {
		echo '<li class="ui-mini"><a href="' . $item->get_permalink() . '" target="_blank">' . $item->get_title() . ' : ' . $item->get_date() . '</a></li>';
	}
#	echo '</ul></div>';
	$feed->__destruct();
	unset($item);
	unset($feed);
	}
echo "</ul></div></body></html>";
?>
