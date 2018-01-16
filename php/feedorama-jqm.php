<?php
date_default_timezone_set('America/New_York');
require '../vendor/autoload.php';
# require_once("php/autoloader.php");
require("get_random_line.php");
$feedarray=file("feeds.txt");
$weatherarray=file("weather.txt");
$linkarray=file("links.txt");
$length = $_POST["length"];
if ( !$length ) {
	$length = 4;
}
$days = $_POST["days"]; 
if ( !$days ) {
	$days = 2;
}
$now = date('U');
$age = 3600*24*$days; 

## HEADERS

echo "<!DOCTYPE HTML><html><head>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
echo "<title>Usual RSS Feeds</title>";
echo "<link href='https://feedreader-bigbenaugust.apps.unc.edu/php/favicon.ico' rel='icon' type='image/x-icon' />";
echo "<link rel='stylesheet' href='https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css'>";
echo "<script src='https://code.jquery.com/jquery-1.11.2.min.js'></script>";
echo "<script src='https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js'></script>";
echo "</head><body>";

## PAGE STARTS HERE

echo "<div data-role='page' id='page' class='type-interior' data-theme='b'><div data-role='header'>Ben's Stuff - Last loaded: " . date('r') . " - Local Time: <strong id='localtime'></strong><script language='javascript'>document.getElementById('localtime').innerHTML = Date();</script></div>";
echo "<small>";
echo rand_line("fortunes.txt");
echo " - <a href='fortunes.txt'>list</a></small><br>";

## SETTINGS

echo "<div class='ui-grid-b' data-mini='true'>";
echo "<div class='ui-block-a'>";
echo "<div data-role='collapsible' data-inset='true' class='ui-mini' data-expanded-icon='gear' data-collapsed-icon='gear'>";
echo "<h4>Settings</h4>";
echo "<ul data-role='listview' class='ui-mini'>";
echo "<li class='ui-mini'><form action='feedorama-jqm.php' method='post'><fieldset data-mini='true'><input type='number' name='length' id='length' min='1' max='9' value='' data-mini='true' placeholder='headlines'><input type='number' name='days' id='days' min='1' max='9' value='' data-mini='true' placeholder='days'><input type='submit' value='go' data-mini='true' data-icon='refresh'></fieldset></form></li>";
echo "</ul></div></div>";

## LINKS / BOOKMARKS

echo "<div class='ui-block-b'>";
echo "<div data-role='collapsible' data-inset='true' class='ui-mini' data-expanded-icon='cloud' data-collapsed-icon='cloud'>";
echo "<h4>Weather</h4>";
echo "<ul data-role='listview' class='ui-mini' data-icon='cloud'>";
foreach ($weatherarray as $key => $weather) {
	$info = explode(",", $weather);
	echo '<li class="ui-mini"><a href="' . $info[1] . '" target="_blank">' . $info[0] . '</a></li>';
}
echo "</ul></div></div>";
echo "<div class='ui-block-c'>";
echo "<div data-role='collapsible' data-inset='true' class='ui-mini' data-expanded-icon='tag' data-collapsed-icon='tag'>";
echo "<h4>Bookmarks</h4>";
echo "<ul data-role='listview' class='ui-mini' data-icon='tag'>";
foreach ($linkarray as $key => $link) {
	$info2 = explode(",", $link);
	echo '<li class="ui-mini"><a href="' . $info2[1] . '" target="_blank">' . $info2[0] . '</a></li>';
}
echo "</ul></div></div></div>";

## FEEDS

echo "<ul data-role='listview' data-inset='true' class='ui-mini'>";
foreach ($feedarray as $key => $url) {
	$feed = new SimplePie();
	$feed->set_feed_url($url);
	$feed->enable_cache(true);	
	$feed->set_cache_duration(3600);
	$feed->init();
	$feed->handle_content_type();
	echo '<li data-role="list-divider" class="ui-mini"><a href="' . $feed->get_permalink() . '" target="_blank">' . $feed->get_title() . '</a>';
#	echo '<ul data-role="listview" data-inset="true" class="ui-mini">';
	foreach ($feed->get_items(0,$length) as $key=>$item) {
		if ( $now - strtotime($item->get_date()) <= $age ) {
			echo '<li class="ui-mini"><a href="' . $item->get_permalink() . '" target="_blank">' . $item->get_title() . ' : ' . $item->get_date() . '</a></li>';
		}
	}
	$feed->__destruct();
	unset($item);
	unset($feed);
	}

## FOOTERS

echo "</ul></div></body></html>";
?>
