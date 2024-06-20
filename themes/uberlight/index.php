<?php
// This check is to make sure the user is actually running on hyperlight and not trying to access the file purposely
if (!defined("HYPERLIGHT_INIT")) die();

// First, get these variables purely for ease later on.
$root = Config::Root;
$title = Config::Title;
$footer = Config::Footer;

// Then set up the HTML document
?>
<!DOCTYPE html>
<html lang="en">
<link rel="alternate" type="application/rss+xml" href="<?php echo Config::get_base_url() ?>rss.xml">
<title><?php echo $Blog->get_title(); ?></title>
<?php
// Print the website title at the top of every page
echo "<h1><a href='{$root}'>{$title}</a></h1>";

// Print a list of pages
echo "<nav>";
echo "<a href='{$root}'>Home</a> ";
foreach($Blog->pages as $page) {
	echo "<a href='{$page->get_url()}'>{$page->title}</a> ";
}
echo "</nav>";

// Check what page we're on and display the relevant content.
if ($Blog->url === Url::Error404) {
	echo "<h2>Error 404: Post Not Found</h2>";
} else if (count($Blog->posts) === 0) {
	// Only display this if there are no posts in the posts directory
	echo "<h2>No Posts Found</h2>";
} else {
	// If there wasn't an error, loop through the posts we got.
	// If we're viewing a single post, there will be one element in the array.
	foreach ($Blog->posts as $entry) {
		echo "<article style='margin-top: 32px;'>";

		// Include a link to the single post if we're viewing the archive
		if ($Blog->url === Url::Archive) {
			echo "<h2><a href='" . $entry->get_url() . "'>{$entry->title}</a></h2>";
			echo "<p>" . $entry->summary . "</p>";
		} else {
			// Otherwise just include the post's featured image, title and content.
			if ($entry->has_image()) {
				echo "<img src='{$entry->image}' />";
			}
			echo "<h2>{$entry->title}</h2>";
			echo $entry->content;
			if ($entry->has_tags()) {
				echo "<div class='tags'>Tags: ";
				foreach ($entry->tags as $tag) {
					echo "<a href='{$Blog->get_tag_url($tag)}'>{$tag}</a>; ";
				}
				echo "</div>";
			}
		}
		echo "</article>";
	}

	// Include pagination if we have too many posts to display at once.
	if ($Blog->has_pagination()) {
		echo "<div style='margin-top:32px;'>";
		if ($Blog->has_page_prev()) {
			echo "<a style='margin-right:8px;' href='{$Blog->get_page_prev()}'>< Newer</a>";
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
