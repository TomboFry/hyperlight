<?php
// First, get these variables purely for ease later on.
$root = Config::Root;
$title = Config::Title;
$footer = Config::Footer;

// Then set up the HTML document
?>
<!DOCTYPE html>
<html lang="en">
<title><?php echo $Blog->get_title(); ?></title>

<?php

// Print the website title at the top of every page
echo "<h1><a href='{$root}'>{$title}</a></h1>";

// Check what page we're on and display the relevant content.
if ($Blog->page === Page::Error404) {
	echo "<h2>Error 404: Post Not Found</h2>";
} else if (count($Blog->entries) === 0) {
	// Only display this if there are no posts in the posts directory
	echo "<h2>No Posts Found</h2>";
} else {
	// If there wasn't an error, loop through the posts we got.
	// If we're viewing a single post, there will be one element in the array.
	foreach ($Blog->entries as $entry) {
		echo "<article style='margin-top: 32px;'>";

		// Include a link to the single post if we're viewing the archive
		if ($Blog->page === Page::Archive) {
			echo "<h2><a href='{$root}{$entry->slug}'>{$entry->title}</a></h2>";
		} else {
			// Otherwise just include the post's featured image, title and content.
			echo "<img src='{$entry->image}' />";
			echo "<h2>{$entry->title}</h2>";
			echo $entry->content;
		}
		echo "</article>";
	}
	// Include pagination if we have too many posts to display at once.
	if ($Blog->has_pagination()) {
		echo "<div style='margin-top:32px;'>";
		if ($Blog->has_page_prev()) {
			echo "<a href='{$Blog->get_page_prev()}'>< Newer</a>";

			// Don't forget to include some hard-coded
			// spacing for good measure! /s
			echo "&nbsp;&nbsp;";
		}

		if ($Blog->has_page_next()) {
			echo "<a href='{$Blog->get_page_next()}'>Older ></a>";
		}
		echo "</div>";
	}

}

// Display the footer text at the bottom of each page.
echo "<footer style='margin-top:32px;'>{$footer}</footer>";
echo "</html>";
