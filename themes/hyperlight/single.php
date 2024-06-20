<?php if (!defined("HYPERLIGHT_INIT")) die();

function post($entry, $full) {
	global $Blog;

	echo "<article class='entry" . ($full === true ? " single" : "") . "'>";

	if ($full === true) {
		if ($entry->has_image()) {
			echo "<img class='featured' src='{$entry->image}' />";
		}
		echo "<h2 class='entry-title'>{$entry->title}</h2>";
		echo "<div class='content'>{$entry->content}</div>";
	} else {
		echo "<h2 class='entry-title'><a href='{$entry->get_url()}'>{$entry->title}</a></h2>";
		echo "<p class='summary'>{$entry->summary}</p>";
	}

	// Post Metadata, including date posted and tags
	echo "<div class='metadata'>";
	echo "<time datetime={$entry->date_datetime()}>{$entry->date_pretty()}</time>";
	if ($entry->has_tags() && $full === true) {
		echo "<div class='tags'>Tags: ";
		foreach ($entry->tags as $tag) {
			echo "<a class='tag' href='" . $Blog->get_tag_url($tag) . "'>{$tag}</a>";
		}
		echo "</div>";
	}
	echo "</div>";
	echo "</article>";
}
