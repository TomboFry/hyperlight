<?php if (!defined("HYPERLIGHT_INIT")) die();

function post($entry, $full) {
	$root = Config::Root;

	echo "<article class='entry" . ($full === true ? " single" : "") . "'>";

	if ($full === true) {
		if ($entry->has_image()) {
			echo "<img class='featured' src='{$entry->image}' />";
		}
		echo "<h2 class='entry-title'>{$entry->title}</h2>";
		echo "<div class='content'>{$entry->content}</div>";
	} else {
		echo "<h2 class='entry-title'><a href='{$root}post/{$entry->slug}'>{$entry->title}</a></h2>";
		echo "<p class='summary'>{$entry->summary}</p>";
	}

	// Post Metadata, including date posted and tags
	echo "<div class='metadata'>";
	echo "<time datetime={$entry->date_datetime()}>{$entry->date_pretty()}</time>";
	if ($entry->has_tags() && $full === true) {
		echo "<div class='tags'>Tags: ";
		foreach ($entry->tags as $tag) {
			echo "<a class='tag' href='" . get_tag_link($tag) . "'>{$tag}</a>";
		}
		echo "</div>";
	}
	echo "</div>";
	echo "</article>";
}
