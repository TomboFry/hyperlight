<?php

function post($entry, $full) {
	$root = Config::Root;

	echo "<article class='entry" . ($full === true ? " single" : "") . "'>";

	if ($full === true) {
		if ($entry->has_image()) {
			echo "<img class='featured' src='{$entry->image}' />";
		}
		echo "<h2>{$entry->title}</h2>";
		echo "<div class='content'>{$entry->content}</div>";
	} else {
		echo "<h2><a href='{$root}{$entry->slug}'>{$entry->title}</a></h2>";
		echo "<div class='content'><p>{$entry->summary}</p></div>";
	}

	// Post Metadata, including date posted and tags
	echo "<div class='metadata'>";
	echo "<time datetime={$entry->date_datetime()}>Posted on {$entry->date_pretty()}</time>";
	if ($entry->has_tags()) {
		echo "<div class='tags'>Tags: ";
		foreach ($entry->tags as $tag) {
			echo "<a href='{$root}tag/{$tag}'>{$tag}</a>";
		}
		echo "</div>";
	}
	echo "</div>";
	echo "</article>";
}
