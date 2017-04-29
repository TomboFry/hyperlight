<?php

function post($entry, $full) {
	echo "<article class='entry" . ($full === true ? " single" : "") . "'>";

	if ($full === true) {
		if ($entry->has_image()) {
			echo "<img class='featured' src='{$entry->image}' />";
		}
		echo "<h2>{$entry->title}</h2>";
		echo "<div class='content'>{$entry->content}</div>";
	} else {
		$root = Config::Root;
		echo "<h2><a href='{$root}{$entry->slug}'>{$entry->title}</a></h2>";
		echo "<div class='content'><p>{$entry->summary}</p></div>";
	}
	$date_pretty = gmdate("l, jS F o, H:i:s", $entry->timestamp);
	$date_datetime = gmdate("Y-m-d\TH:i:s", $entry->timestamp);
	echo "<time datetime={$date_datetime}>Posted on {$date_pretty}</time>";
	echo "</article>";
}
